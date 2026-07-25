<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\Candidate;
use App\Services\PythonService;

class CandidateSetupController extends Controller
{
    public function step1()
    {
        $candidate = Auth::user()->candidate ?? Auth::user()->candidate()->create();
        return view('candidate-setup.step1', compact('candidate'));
    }

    public function postStep1(Request $request)
    {
        $validated = $request->validate([
            'resume' => [
                'required',
                'file',
                'mimes:pdf',
                'mimetypes:application/pdf,application/x-pdf,application/octet-stream',
                'max:8192',
            ],
        ], [
            'resume.required' => 'Por favor, envie seu currículo em PDF.',
            'resume.mimes' => 'Apenas arquivos PDF são aceitos.',
            'resume.mimetypes' => 'Arquivo inválido: selecione um PDF verdadeiro.',
            'resume.max' => 'O arquivo PDF não pode exceder 8 MB.',
        ]);

        $userId = Auth::id();
        $candidate = Auth::user()->candidate ?? Auth::user()->candidate()->create();

        Log::channel('stack')->info('[resume] Step 1 iniciado', ['user_id' => $userId, 'candidate_id' => $candidate->id]);

        $raw = null;
        $path = null;
        $file = $request->file('resume');

        try {
            $size = $file->getSize();
            $mime = $file->getMimeType();
            $clientName = $file->getClientOriginalName();
            Log::channel('stack')->info('[resume] Arquivo recebido', [
                'user_id' => $userId,
                'original_name' => $clientName,
                'size' => $size,
                'mime' => $mime,
                'max_allowed_bytes' => 8 * 1024 * 1024,
            ]);

            if ($size <= 0 || $size > (8 * 1024 * 1024)) {
                Log::channel('stack')->warning('[resume] Arquivo com tamanho fora do permitido', [
                    'user_id' => $userId,
                    'size' => $size,
                ]);
                return back()->withErrors([
                    'resume' => 'Arquivo inválido ou maior que 8 MB.',
                ])->withInput();
            }

            $allowedMimes = ['application/pdf', 'application/x-pdf', 'application/octet-stream'];
            $ext = strtolower($file->getClientOriginalExtension() ?: pathinfo((string) $clientName, PATHINFO_EXTENSION));
            $clientMime = strtolower($mime ?? '');
            if (!in_array($clientMime, $allowedMimes, true) && $ext !== 'pdf') {
                Log::channel('stack')->warning('[resume] Arquivo não é PDF', [
                    'user_id' => $userId,
                    'mime' => $clientMime,
                    'ext' => $ext,
                ]);
                return back()->withErrors([
                    'resume' => 'Apenas arquivos PDF são aceitos.',
                ])->withInput();
            }

            $path = $file->store('resumes', 'public');
            $candidate->update(['resume_path' => $path]);
            Log::channel('stack')->info('[resume] Arquivo salvo', ['user_id' => $userId, 'storage_path' => $path]);

            $fullPath = Storage::disk('public')->path($path);
            if (!file_exists($fullPath)) {
                throw new \RuntimeException("Arquivo não encontrado após store: {$fullPath}");
            }

            $pdfContent = file_get_contents($fullPath) ?: '';
            if ($pdfContent === '') {
                throw new \RuntimeException('PDF vazio ou ilegível.');
            }

            $header = strtoupper(substr(ltrim($pdfContent), 0, 5));
            if (strpos($header, '%PDF-') !== 0) {
                Log::channel('stack')->warning('[resume] PDF inválido (cabeçalho não é %PDF)', [
                    'user_id' => $userId,
                    'header' => substr($header, 0, 8),
                ]);
                return back()->withErrors([
                    'resume' => 'Arquivo PDF corrompido ou inválido.',
                ])->withInput();
            }

            $pdfBase64 = base64_encode($pdfContent);

            Log::channel('stack')->info('[resume] PDF codificado. Chamando PythonService::processResume...', [
                'user_id' => $userId,
                'pdf_bytes' => strlen($pdfContent),
                'base64_length' => strlen($pdfBase64),
                'GEMINI_API_KEY_set' => filled(env('GEMINI_API_KEY')),
                'script_path' => base_path('app/scripts/resume.py'),
            ]);

            $startedAt = microtime(true);

            $pythonService = app(PythonService::class);
            $result = $pythonService->processResume([
                'action' => 'extract',
                'pdf_base64' => $pdfBase64,
            ]);

            $elapsed = round(microtime(true) - $startedAt, 3);
            Log::channel('stack')->info('[resume] PythonService retornou (sucesso nível processo)', [
                'user_id' => $userId,
                'elapsed_sec' => $elapsed,
                'success_flag' => $result['success'] ?? null,
                'result_keys' => array_keys($result),
                'raw_result_snippet' => is_array($result) ? json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) : $result,
            ]);

            if (($result['success'] ?? false) === true) {
                $d = $result['dados_candidato'] ?? [];

                Log::channel('stack')->info('[resume] Extração de dados retornou com sucesso=true', [
                    'user_id' => $userId,
                    'dados_candidato_keys' => array_keys($d),
                    'skills_count' => count($d['skills'] ?? []),
                    'experiencias_count' => count($d['experiencia'] ?? []),
                    'educacao_count' => count($d['educacao'] ?? []),
                    'idiomas_count' => count($d['idiomas'] ?? []),
                    'raw_dados_candidato' => $d,
                ]);

                $anos = $d['anos_experiencia'] ?? 0;
                $anosInt = is_numeric($anos) ? (int) $anos : (int) filter_var((string) $anos, FILTER_SANITIZE_NUMBER_INT);
                if ($anosInt < 0) $anosInt = null;

                $languages = collect($d['idiomas'] ?? [])
                    ->map(function ($lang) {
                        $name = is_array($lang) ? ($lang['nome'] ?? $lang['name'] ?? '') : '';
                        $level = is_array($lang) ? ($lang['nivel'] ?? $lang['level'] ?? '') : '';
                        return array_filter(['name' => trim((string) $name), 'level' => trim((string) $level)]);
                    })
                    ->filter(fn($lang) => filled($lang['name'] ?? null))
                    ->values()
                    ->all();

                $workExperience = collect($d['experiencia'] ?? [])
                    ->map(function ($exp) {
                        if (! is_array($exp)) return null;
                        return [
                            'company'    => trim((string) ($exp['empresa'] ?? $exp['company'] ?? '')),
                            'position'   => trim((string) ($exp['cargo'] ?? $exp['position'] ?? '')),
                            'start_year' => trim((string) ($exp['ano_inicio'] ?? $exp['start_year'] ?? '')),
                            'end_year'   => trim((string) ($exp['ano_fim'] ?? $exp['end_year'] ?? '')),
                        ];
                    })
                    ->filter(fn($exp) => $exp && (filled($exp['company']) || filled($exp['position'])))
                    ->values()
                    ->all();

                $education = collect($d['educacao'] ?? [])
                    ->map(function ($edu) {
                        if (! is_array($edu)) return null;
                        return [
                            'degree'     => trim((string) ($edu['grau'] ?? $edu['degree'] ?? '')),
                            'school'     => trim((string) ($edu['instituicao'] ?? $edu['school'] ?? '')),
                            'start_year' => trim((string) ($edu['ano_inicio'] ?? $edu['start_year'] ?? '')),
                            'end_year'   => trim((string) ($edu['ano_fim'] ?? $edu['end_year'] ?? '')),
                        ];
                    })
                    ->filter(fn($edu) => $edu && (filled($edu['degree']) || filled($edu['school'])))
                    ->values()
                    ->all();

                if (empty($education)) {
                    $formacaoLegacy = $d['formacao'] ?? [];
                    $instituicaoLegacy = $d['instituicao'] ?? [];
                    if (! empty($formacaoLegacy)) {
                        $education = collect($formacaoLegacy)->map(function ($degree, $i) use ($instituicaoLegacy) {
                            return [
                                'degree'     => trim((string) $degree),
                                'school'     => trim((string) ($instituicaoLegacy[$i] ?? '')),
                                'start_year' => '',
                                'end_year'   => '',
                            ];
                        })->filter(fn($edu) => filled($edu['degree']))->values()->all();
                    }
                }

                $employmentTypes = collect($d['tipo_contrato'] ?? [])
                    ->map(fn($v) => trim((string) $v))
                    ->filter(fn($v) => in_array($v, ['Full-time', 'Part-time', 'Contract', 'Internship']))
                    ->values()
                    ->all();

                $workModels = collect($d['modelo_trabalho'] ?? [])
                    ->map(fn($v) => trim((string) $v))
                    ->filter(fn($v) => in_array($v, ['Remote', 'Hybrid', 'On-site']))
                    ->values()
                    ->all();

                $availability = in_array($d['disponibilidade'] ?? '', ['Immediately', '2 weeks', '1 month', 'Custom'])
                    ? $d['disponibilidade']
                    : null;

                $salary = $d['expectativa_salarial'] ?? '';
                $salaryStr = is_numeric($salary) ? (string) $salary : trim((string) $salary);

                $currency = in_array($d['moeda_salarial'] ?? '', ['BRL', 'USD', 'EUR'])
                    ? $d['moeda_salarial']
                    : 'BRL';

                $cleanUrl = function (?string $raw): string {
                    $raw = trim((string) $raw);
                    if ($raw === '' || $raw === '0') {
                        return '';
                    }
                    $raw = preg_replace('/\s+/u', '', $raw) ?? $raw;
                    $raw = preg_replace('/[\x{FFFD}\x00-\x1F\x7F]+/u', '', $raw) ?? $raw;
                    if (filter_var($raw, FILTER_VALIDATE_URL) === false) {
                        $prot = stripos($raw, 'http') === 0 ? '' : 'https://';
                        if (filter_var($prot . ltrim($raw, '/'), FILTER_VALIDATE_URL) !== false) {
                            $raw = $prot . ltrim($raw, '/');
                        } elseif (!str_contains($raw, '.') || strlen($raw) < 8) {
                            return '';
                        }
                    }
                    if (strlen($raw) > 2048) $raw = substr($raw, 0, 2048);
                    return $raw;
                };

                $cleanStr = function (?string $raw, int $max = 65000): string {
                    $raw = (string) $raw;
                    $raw = preg_replace('/\s+/u', ' ', $raw) ?? $raw;
                    $raw = preg_replace('/[\x{FFFD}]+/u', '', $raw) ?? $raw;
                    $raw = trim($raw);
                    if ($max > 0 && strlen($raw) > $max) $raw = substr($raw, 0, $max);
                    return $raw;
                };

                $cleanItem = function (&$item, $key) use ($cleanStr): void {
                    if (is_string($item)) {
                        $item = $cleanStr($item, 500);
                    } elseif (is_array($item)) {
                        array_walk_recursive($item, function (&$v, $k) use ($cleanStr) {
                            if (is_string($v)) {
                                $v = $cleanStr($v, 500);
                            }
                        });
                    }
                };

                $currentJobTitle  = $d['cargo_atual'] ?? '';
                $currentCompany   = $d['empresa_atual'] ?? '';
                if (empty($currentJobTitle) && ! empty($workExperience)) {
                    $first = $workExperience[0];
                    if (($first['end_year'] ?? '') === '' || stripos($first['end_year'], 'Present') !== false || stripos($first['end_year'], 'Atual') !== false) {
                        $currentJobTitle = $first['position'] ?? '';
                        if (empty($currentCompany)) $currentCompany = $first['company'] ?? '';
                    }
                }

                $currentCompanySave = filled($candidate->current_company) && empty($currentCompany)
                    ? $candidate->current_company
                    : $currentCompany;

                array_walk_recursive($workExperience, $cleanItem);
                array_walk_recursive($education, $cleanItem);
                array_walk_recursive($languages, $cleanItem);

                $candidateData = [
                    'full_name'           => $cleanStr($d['nome'] ?? $candidate->full_name ?? '', 255),
                    'phone'               => $cleanStr($d['telefone'] ?? '', 50),
                    'city'                => $cleanStr($d['cidade'] ?? '', 255),
                    'country'             => $cleanStr($d['estado'] ?? '', 255),
                    'linkedin'            => $cleanUrl($d['linkedin'] ?? ''),
                    'portfolio'           => $cleanUrl($d['portfolio'] ?? ''),
                    'current_job_title'   => $cleanStr($currentJobTitle, 255),
                    'current_company'     => $cleanStr((string) $currentCompanySave, 255),
                    'years_experience'    => $anosInt,
                    'professional_summary' => $cleanStr($d['resumo_profissional'] ?? ''),
                    'skills'              => array_values(array_filter(array_map(
                        fn($s) => $cleanStr($s, 200),
                        $d['skills'] ?? []
                    ), 'strlen')),
                    'languages'           => $languages,
                    'work_experience'     => $workExperience,
                    'education'           => $education,
                    'desired_position'    => $cleanStr($d['cargo_desejado'] ?? '', 255),
                    'employment_type'     => $employmentTypes,
                    'work_model'          => $workModels,
                    'salary_expectation'  => $salaryStr === '' ? null : $salaryStr,
                    'salary_currency'     => $currency,
                    'availability'        => $availability,
                ];

                Log::channel('stack')->info('[resume] Dados finais preparados para persistência', [
                    'user_id' => $userId,
                    'will_save_fields' => array_keys($candidateData),
                    'summary' => [
                        'full_name' => $candidateData['full_name'],
                        'skills_count' => count($candidateData['skills']),
                        'languages_count' => count($candidateData['languages']),
                        'work_experience_count' => count($candidateData['work_experience']),
                        'education_count' => count($candidateData['education']),
                        'current_job_title' => $candidateData['current_job_title'],
                        'current_company' => $candidateData['current_company'],
                    ],
                    'full_payload' => $candidateData,
                ]);

                $saved = $candidate->update($candidateData);
                Log::channel('stack')->info('[resume] Persistência finalizada no banco', [
                    'user_id' => $userId,
                    'update_returned' => var_export($saved, true),
                    'fresh_model' => $candidate->fresh()->only([
                        'full_name',
                        'phone',
                        'city',
                        'country',
                        'linkedin',
                        'portfolio',
                        'current_job_title',
                        'current_company',
                        'years_experience',
                        'skills',
                        'languages',
                        'work_experience',
                        'education',
                        'desired_position',
                        'employment_type',
                        'work_model',
                        'salary_expectation',
                        'salary_currency',
                        'availability'
                    ]),
                ]);

                $request->session()->flash('resume_extract', [
                    'status' => 'success',
                    'elapsed_sec' => $elapsed,
                    'file_name' => $file->getClientOriginalName(),
                    'summary' => [
                        'Nome' => $candidateData['full_name'] ?: '(não extraído)',
                        'Telefone' => $candidateData['phone'] ?: '(não extraído)',
                        'Cidade' => $candidateData['city'] ?: '(não extraído)',
                        'LinkedIn' => $candidateData['linkedin'] ?: '(não extraído)',
                        'Cargo atual' => $candidateData['current_job_title'] ?: '(não extraído)',
                        'Empresa atual' => $candidateData['current_company'] ?: '(não extraído)',
                        'Anos de experiência' => $candidateData['years_experience'] ? $candidateData['years_experience'] . ' anos' : '(não extraído)',
                        'Skills' => count($candidateData['skills']) . ' habilidade(s)',
                        'Idiomas' => count($candidateData['languages']) . ' idioma(s)',
                        'Experiências profissionais' => count($candidateData['work_experience']) . ' registro(s)',
                        'Formação acadêmica' => count($candidateData['education']) . ' registro(s)',
                        'Cargo desejado' => $candidateData['desired_position'] ?: '(não extraído)',
                    ],
                    'raw' => $d,
                ]);
            } else {
                Log::channel('stack')->warning('[resume] Python retornou success=false ou vazio', [
                    'user_id' => $userId,
                    'result' => $result,
                ]);
                $request->session()->flash('resume_extract', [
                    'status' => 'failed',
                    'reason' => 'success flag falsa',
                    'file_name' => $file->getClientOriginalName(),
                    'result' => $result,
                ]);
            }
        } catch (\Symfony\Component\Process\Exception\ProcessFailedException $e) {
            $elapsed = round(microtime(true) - ($startedAt ?? microtime(true)), 3);
            $fname = $file?->getClientOriginalName() ?? 'n/a';
            Log::channel('stack')->error('[resume] ProcessFailedException no PythonService', [
                'user_id' => $userId,
                'elapsed_sec' => $elapsed,
                'exit_code' => $e->getProcess()->getExitCode(),
                'exit_code_text' => $e->getProcess()->getExitCodeText(),
                'stdout' => $e->getProcess()->getOutput(),
                'stderr' => $e->getProcess()->getErrorOutput(),
                'exception' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            $request->session()->flash('resume_extract', [
                'status' => 'error',
                'reason' => 'ProcessFailedException',
                'file_name' => $fname,
                'message' => $e->getMessage(),
                'stderr' => $e->getProcess()->getErrorOutput(),
            ]);
        } catch (\Throwable $e) {
            $elapsed = round(microtime(true) - ($startedAt ?? microtime(true)), 3);
            $fname = $file?->getClientOriginalName() ?? 'n/a';
            Log::channel('stack')->error('[resume] Exceção genérica durante extração', [
                'user_id' => $userId,
                'elapsed_sec' => $elapsed,
                'exception' => $e::class,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            $request->session()->flash('resume_extract', [
                'status' => 'error',
                'reason' => $e::class,
                'file_name' => $fname,
                'message' => $e->getMessage(),
            ]);
        }

        return redirect()->route('candidate-setup.step2');
    }

    public function step2()
    {
        $candidate = Auth::user()->candidate;
        return view('candidate-setup.step2', compact('candidate'));
    }

    public function postStep2(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'city' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'linkedin' => 'nullable|string|max:255',
            'portfolio' => 'nullable|string|max:255',
        ]);

        $candidate = Auth::user()->candidate;
        $candidate->update($validated);

        return redirect()->route('candidate-setup.step3');
    }

    public function step3()
    {
        $candidate = Auth::user()->candidate;
        return view('candidate-setup.step3', compact('candidate'));
    }

    public function postStep3(Request $request)
    {
        $validated = $request->validate([
            'current_job_title' => 'nullable|string|max:255',
            'years_experience' => 'nullable|integer',
            'professional_summary' => 'nullable|string',
            'skills' => 'nullable|array',
            'languages' => 'nullable|array',
            'languages.*.name' => 'nullable|string|max:255',
            'languages.*.level' => 'nullable|string|max:255',
        ]);

        $validated['languages'] = collect($validated['languages'] ?? [])
            ->filter(fn($language) => filled($language['name'] ?? null))
            ->values()
            ->all();

        $candidate = Auth::user()->candidate;
        $candidate->update($validated);

        return redirect()->route('candidate-setup.step4');
    }

    public function step4()
    {
        $candidate = Auth::user()->candidate;
        return view('candidate-setup.step4', compact('candidate'));
    }

    public function postStep4(Request $request)
    {
        $validated = $request->validate([
            'work_experience' => 'nullable|array',
        ]);

        $candidate = Auth::user()->candidate;
        $candidate->update($validated);

        return redirect()->route('candidate-setup.step5');
    }

    public function step5()
    {
        $candidate = Auth::user()->candidate;
        return view('candidate-setup.step5', compact('candidate'));
    }

    public function postStep5(Request $request)
    {
        $validated = $request->validate([
            'education' => 'nullable|array',
        ]);

        $candidate = Auth::user()->candidate;
        $candidate->update($validated);

        return redirect()->route('candidate-setup.step6');
    }

    public function step6()
    {
        $candidate = Auth::user()->candidate;
        return view('candidate-setup.step6', compact('candidate'));
    }

    public function postStep6(Request $request)
    {
        $validated = $request->validate([
            'desired_position' => 'nullable|string|max:255',
            'employment_type' => 'nullable|array',
            'work_model' => 'nullable|array',
            'salary_expectation' => 'nullable|string|max:255',
            'salary_currency' => 'nullable|string|max:10',
            'availability' => 'nullable|string|max:255',
        ]);

        $candidate = Auth::user()->candidate;
        $candidate->update($validated);

        return redirect()->route('candidate-setup.finish');
    }

    public function finish()
    {
        $candidate = Auth::user()->candidate;
        $candidate->update(['setup_completed' => true]);

        return redirect()->route('dashboard');
    }
}
