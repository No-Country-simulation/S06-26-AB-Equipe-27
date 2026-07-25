<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class PythonService
{
    private function isWindows(): bool
    {
        return PHP_OS_FAMILY === 'Windows';
    }

    private function isAbsolute(string $path): bool
    {
        return (strlen($path) >= 2 && ctype_alpha($path[0]) && $path[1] === ':')
            || str_starts_with($path, DIRECTORY_SEPARATOR)
            || str_starts_with($path, '/');
    }

    private function shellWhich(string $bin): string
    {
        if ($this->isWindows()) {
            return 'where ' . escapeshellarg($bin);
        }
        return 'command -v ' . escapeshellarg($bin);
    }

    private function buildEnv(): array
    {
        $home = getenv('HOME') ?: getenv('USERPROFILE');
        return [
            'SYSTEMROOT' => getenv('SYSTEMROOT'),
            'WINDIR' => getenv('WINDIR'),
            'PATH' => getenv('PATH'),
            'TEMP' => getenv('TEMP'),
            'TMP' => getenv('TMP'),
            'HOME' => $home,
            'USERPROFILE' => getenv('USERPROFILE'),
            'HOMEDRIVE' => getenv('HOMEDRIVE'),
            'HOMEPATH' => getenv('HOMEPATH'),
            'PYTHONIOENCODING' => 'utf-8',
            'PYTHONUTF8' => '1',
            'PYTHONWARNINGS' => 'ignore',
            'GEMINI_API_KEY' => env('GEMINI_API_KEY'),
        ];
    }

    private function moduleSpec(): array
    {
        return [
            'json' => ['json'],
            'base64' => ['base64'],
            'io' => ['io'],
            'PyPDF2' => ['PyPDF2'],
            'pandas' => ['pandas'],
            'google.genai' => ['google.genai', 'google.generativeai'],
        ];
    }

    private function resolveActualImportName(string $logicalName): string
    {
        $map = $this->moduleSpec();
        return $map[$logicalName][0] ?? $logicalName;
    }

    private function tryImportsOneLiner(array $logicalModules): string
    {
        $map = $this->moduleSpec();
        $checks = [];
        $i = 0;
        foreach ($logicalModules as $logical) {
            $variants = $map[$logical] ?? [$logical];
            $var = 'm' . $i;
            $variantsJson = json_encode($variants, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            $checks[] = "import importlib.util as _iu{$i},json as _j{$i};$var=_j{$i}.loads('" . $variantsJson . "');_r{$i}=[bool(_iu{$i}.find_spec(_v)) for _v in $var];print(_j{$i}.dumps({" . json_encode($logical) . ":any(_r{$i}) or None} ,ensure_ascii=False))";
            $i++;
        }
        $joined = implode(";", $checks);
        return "import json,sys;_out={};exec(" . json_encode($joined) . ");print(json.dumps(_out,ensure_ascii=False))";
    }

    private function preflight(string $pythonBin, string $scriptPath, array $requiredLogicalModules = []): array
    {
        $ok = true;
        $messages = [];

        if ($scriptPath !== '' && !file_exists($scriptPath)) {
            $ok = false;
            $messages[] = "Script não encontrado: {$scriptPath}";
        }

        if (!empty($requiredLogicalModules)) {
            $moduleMap = $this->moduleSpec();
            $probePhy = [];
            $byVariant = [];
            foreach ($requiredLogicalModules as $l) {
                $variants = $moduleMap[$l] ?? [$l];
                foreach ($variants as $v) {
                    $probePhy[] = $v;
                    $byVariant[$v] = $l;
                }
            }
            $phyList = array_values(array_unique($probePhy));
            $script = 'import importlib.util,sys,json' . PHP_EOL
                . 'mods=sys.argv[1].split(",")' . PHP_EOL
                . 'res={}' . PHP_EOL
                . 'for m in mods:' . PHP_EOL
                . '    m=m.strip()' . PHP_EOL
                . '    try:' . PHP_EOL
                . '        spec=importlib.util.find_spec(m)' . PHP_EOL
                . '        if spec is None:' . PHP_EOL
                . '            res[m]={"found":False}' . PHP_EOL
                . '        else:' . PHP_EOL
                . '            mod=importlib.import_module(m)' . PHP_EOL
                . '            res[m]={"found":True,"version":getattr(mod,"__version__","")}' . PHP_EOL
                . '    except Exception as e:' . PHP_EOL
                . '        res[m]={"found":False,"error":type(e).__name__+": "+str(e)}' . PHP_EOL
                . 'print(json.dumps(res,ensure_ascii=False))' . PHP_EOL;

            $checkList = implode(',', $phyList);
            try {
                $proc = new Process([$pythonBin, '-c', $script, $checkList]);
                $proc->setTimeout(12);
                $proc->run(null, $this->buildEnv());
                $stdout = trim($proc->getOutput());
                if ($proc->isSuccessful() && $stdout !== '') {
                    $phyStatus = json_decode($stdout, true);
                    if (!is_array($phyStatus)) $phyStatus = [];
                    $logicalStatus = [];
                    foreach ($requiredLogicalModules as $l) {
                        $variants = $moduleMap[$l] ?? [$l];
                        $infoFound = null;
                        $foundAny = false;
                        foreach ($variants as $v) {
                            $vinfo = $phyStatus[$v] ?? null;
                            if (is_array($vinfo) && !empty($vinfo['found'])) {
                                $foundAny = true;
                                $infoFound = ['variant' => $v, 'version' => $vinfo['version'] ?? ''];
                                break;
                            }
                        }
                        $logicalStatus[$l] = [
                            'found' => $foundAny,
                            'matched_variant' => $infoFound['variant'] ?? null,
                            'version' => $infoFound['version'] ?? null,
                            'variants_tried' => array_combine($variants, array_map(function ($v) use ($phyStatus) {
                                $s = $phyStatus[$v] ?? null;
                                return is_array($s) ? ($s['found'] ?? false) : false;
                            }, $variants)),
                        ];
                        if (!$foundAny) {
                            $ok = false;
                            $errs = [];
                            foreach ($variants as $v) {
                                $s = $phyStatus[$v] ?? null;
                                if (is_array($s) && empty($s['found'])) {
                                    $errs[] = $v . ' (' . ($s['error'] ?? 'not installed') . ')';
                                }
                            }
                            $messages[] = "Módulo Python ausente: {$l} — tentamos: " . implode('; ', $errs);
                        }
                    }
                    Log::channel('stack')->info('[python] preflight modules status', [
                        'python_bin' => $pythonBin,
                        'logical_required' => $requiredLogicalModules,
                        'logical_status' => $logicalStatus,
                        'phyton_phy_status' => $phyStatus,
                    ]);
                } else {
                    Log::channel('stack')->warning('[python] preflight não conseguiu validar módulos', [
                        'exit_code' => $proc->getExitCode(),
                        'stdout' => $stdout,
                        'stderr' => $proc->getErrorOutput(),
                    ]);
                }
            } catch (\Throwable $e) {
                Log::channel('stack')->warning('[python] preflight exception', ['exception' => $e::class, 'message' => $e->getMessage()]);
            }
        }

        return ['ok' => $ok, 'messages' => $messages];
    }

    private function resolvePythonBin(?array $requiredLogicalModules = null): string
    {
        $isWin = $this->isWindows();
        $projectBase = base_path();

        $envBin = trim((string) env('PYTHON_BIN'));
        $unixCandidates = [];
        $winCandidates = [];

        if ($envBin !== '') {
            if (!$this->isAbsolute($envBin)) {
                $winCandidates[] = $projectBase . DIRECTORY_SEPARATOR . str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $envBin);
                $unixCandidates[] = $projectBase . '/' . ltrim(str_replace('\\', '/', $envBin), '/');
            }
            $winCandidates[] = $envBin;
            $unixCandidates[] = $envBin;
        }

        $unixCandidates = array_merge($unixCandidates, [
            '/opt/venv/bin/python',
            '/opt/venv/bin/python3',
            $projectBase . '/app/scripts/.venv/bin/python',
            $projectBase . '/app/scripts/.venv/bin/python3',
            $projectBase . '/.venv/bin/python3',
            '/usr/local/bin/python3',
            '/usr/bin/python3',
            'python3',
            'python',
        ]);

        $winCandidates = array_merge($winCandidates, [
            $projectBase . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'scripts' . DIRECTORY_SEPARATOR . '.venv' . DIRECTORY_SEPARATOR . 'Scripts' . DIRECTORY_SEPARATOR . 'python.exe',
            $projectBase . DIRECTORY_SEPARATOR . '.venv' . DIRECTORY_SEPARATOR . 'Scripts' . DIRECTORY_SEPARATOR . 'python.exe',
            'C:\Program Files\Python312\python.exe',
            'C:\Users\\' . get_current_user() . '\AppData\Local\Programs\Python\Python312\python.exe',
            'py.exe',
            'python.exe',
            'python3.exe',
            'python',
            'python3',
        ]);

        if ($isWin) {
            $candidates = array_values(array_unique(array_merge($winCandidates, $unixCandidates)));
        } else {
            $candidates = array_values(array_unique(array_merge($unixCandidates, $winCandidates)));
        }

        $saneDefaultFallback = $isWin ? 'python.exe' : 'python3';
        $tried = [];
        $resolved = null;
        $resolvedFailReason = null;
        $bestPartial = null;
        $bestPartialScore = -1;
        $bestPartialReason = null;

        $needsModulesCheck = is_array($requiredLogicalModules) && !empty($requiredLogicalModules);

        foreach ($candidates as $bin) {
            $candidate = trim((string) $bin);
            if ($candidate === '') continue;

            $absolute = $this->isAbsolute($candidate);
            $skipForOs = false;
            if ($isWin && $absolute && str_starts_with(str_replace('\\', '/', $candidate), '/usr/')) {
                $skipForOs = true;
            }

            $exists = false;
            $runnable = false;
            $modulesStatus = null;
            $modulesOk = true;
            $missingCount = 0;

            if ($absolute && !$skipForOs) {
                $exists = file_exists($candidate) && is_file($candidate);
            }

            if (!$skipForOs && (!$absolute || $exists)) {
                try {
                    $checkProcess = new Process([$candidate, '--version']);
                    $checkProcess->setTimeout(5);
                    $checkProcess->run(null, $this->buildEnv());
                    $runnable = $checkProcess->isSuccessful();
                } catch (\Throwable $e) {
                    $runnable = false;
                }
            }

            if ($runnable && $needsModulesCheck) {
                $pre = $this->preflight($candidate, '', $requiredLogicalModules);
                $modulesOk = $pre['ok'] ?? true;
                $modulesStatus = $pre;
                $missingCount = count($pre['messages'] ?? []);
                if (!$modulesOk && $resolved === null && $resolvedFailReason === null) {
                    $resolvedFailReason = "candidate $candidate — " . implode(' | ', $pre['messages'] ?? []);
                }
            }

            $tried[] = [
                'bin' => $candidate,
                'absolute' => $absolute,
                'exists' => $exists,
                'skip_os' => $skipForOs,
                'runnable' => $runnable,
                'modules_ok' => $needsModulesCheck ? $modulesOk : null,
                'modules_missing_count' => $needsModulesCheck ? $missingCount : null,
            ];

            if ($runnable && (!$needsModulesCheck || $modulesOk)) {
                $resolved = $candidate;
                break;
            }

            if ($runnable) {
                $score = 1000 - $missingCount;
                if ($absolute) $score += 500;
                if ($bestPartialScore < $score) {
                    $bestPartialScore = $score;
                    $bestPartial = $candidate;
                    $msgs = $modulesStatus['messages'] ?? [];
                    $bestPartialReason = ($missingCount . ' missing modules: ' . implode(' | ', $msgs));
                }
            }
        }

        if ($resolved === null) {
            $logPayload = [
                'os_family' => PHP_OS_FAMILY,
                'is_windows' => $isWin,
                'required_modules' => $requiredLogicalModules,
                'tried' => $tried,
                'sane_default' => $saneDefaultFallback,
            ];
            if ($resolvedFailReason) $logPayload['first_fail_reason'] = $resolvedFailReason;
            if ($bestPartial) {
                $logPayload['best_partial'] = $bestPartial;
                $logPayload['best_partial_reason'] = $bestPartialReason;
                Log::channel('stack')->warning('[python] resolvePythonBin — SEM match perfeito, usando melhor parcial (tem módulos faltando)', $logPayload);
                return $bestPartial;
            }
            Log::channel('stack')->error('[python] resolvePythonBin — NENHUM interpretador Python válido encontrado, usando fallback básico', $logPayload);
            return $saneDefaultFallback;
        }

        Log::channel('stack')->info('[python] resolvePythonBin resolved', [
            'resolved' => $resolved,
            'os_family' => PHP_OS_FAMILY,
            'modules_required' => $requiredLogicalModules,
            'candidates_checked' => $tried,
        ]);
        return $resolved;
    }

    private function sanitizeUtf8(?string $value): ?string
    {
        if ($value === null || $value === '') {
            return $value;
        }
        $cleaned = $value;
        if (str_starts_with($cleaned, "\xEF\xBB\xBF")) {
            $cleaned = substr($cleaned, 3);
        }
        $cleaned = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]+/', '', (string) $cleaned) ?? $cleaned;
        if (preg_match('//u', $cleaned)) {
            return $cleaned;
        }
        if (function_exists('iconv')) {
            $from = ['Windows-1252', 'ISO-8859-1', 'CP850'];
            foreach ($from as $enc) {
                $try = @iconv($enc, 'UTF-8//IGNORE', $cleaned);
                if ($try !== false && $try !== '' && preg_match('//u', $try)) {
                    $sample = substr($try, 0, min(120, strlen($try)));
                    if (substr_count($sample, "\xEF\xBF\xBD") === 0) {
                        return $try;
                    }
                }
            }
        }
        if (function_exists('mb_convert_encoding')) {
            $try = @mb_convert_encoding($cleaned, 'UTF-8', 'UTF-8');
            if ($try !== false && $try !== '' && preg_match('//u', $try)) {
                return $try;
            }
        }
        $fallback = @iconv('UTF-8', 'UTF-8//IGNORE', $cleaned);
        if ($fallback !== false && $fallback !== '') {
            return $fallback;
        }
        return $cleaned;
    }

    private function runProcess(array $command, string $scriptLabel, array $data, int $timeout): array
    {
        $pythonBin = $command[0] ?? '';
        $scriptPath = $command[1] ?? '';

        $requirementsModules = [];
        if ($scriptLabel === 'processResume') {
            $requirementsModules = ['PyPDF2', 'google.genai', 'json', 'base64', 'io'];
        }
        $preflight = $this->preflight($pythonBin, $scriptPath, $requirementsModules);

        Log::channel('stack')->info("[python] {$scriptLabel} iniciado", [
            'python_exe' => $pythonBin,
            'script_path' => $scriptPath,
            'script_exists' => file_exists($scriptPath),
            'action' => $data['action'] ?? null,
            'payload_keys' => array_keys($data),
            'extra_preflight' => $preflight,
        ]);

        if (!$preflight['ok']) {
            $errors = implode(' | ', $preflight['messages']);
            Log::channel('stack')->error("[python] {$scriptLabel} PREFLIGHT FALHOU", [
                'preflight' => $preflight,
                'requirements_txt_path' => base_path('app/scripts/requirements.txt'),
                'install_command_suggestion' => sprintf(
                    ' "%s" -m pip install --upgrade pip && "%s" -m pip install --no-cache-dir -r "%s"',
                    $pythonBin,
                    $pythonBin,
                    base_path('app/scripts/requirements.txt')
                ),
            ]);

            $moduleMissing = false;
            foreach ($preflight['messages'] as $msg) {
                if (stripos($msg, 'Módulo Python ausente') !== false) {
                    $moduleMissing = true;
                    break;
                }
            }
            if ($moduleMissing) {
                $isVenv = stripos($pythonBin, DIRECTORY_SEPARATOR . '.venv' . DIRECTORY_SEPARATOR) !== false
                    || stripos($pythonBin, '/.venv/') !== false;
                $venvPath = $isVenv ? dirname(dirname($pythonBin)) : null;
                $cdCmd = PHP_OS_FAMILY === 'Windows' ? ('cd /d "' . base_path() . '"') : ('cd "' . base_path() . '"');
                $activateCmd = '';
                if ($isVenv) {
                    if (PHP_OS_FAMILY === 'Windows') {
                        $activateCmd = ' && "' . $venvPath . '\Scripts\activate.bat"';
                    } else {
                        $activateCmd = ' && source "' . $venvPath . '/bin/activate"';
                    }
                }
                $pipCmd = sprintf(
                    ' && "%s" -m pip install --no-cache-dir -r "%s"',
                    $pythonBin,
                    base_path('app/scripts/requirements.txt')
                );
                $hint = "Dependências Python ausentes. Para instalar execute (copie e cole no terminal):"
                    . PHP_EOL . '  ' . $cdCmd
                    . $activateCmd
                    . $pipCmd;
                throw new \RuntimeException('PREFLIGHT: ' . $errors . PHP_EOL . PHP_EOL . $hint);
            }
            throw new \RuntimeException('PREFLIGHT: ' . $errors);
        }

        $startedAt = microtime(true);

        $process = new Process($command, base_path(), $this->buildEnv());
        $process->setInput(json_encode($data, JSON_THROW_ON_ERROR));
        $process->setTimeout($timeout);
        $process->run();

        $elapsed = round(microtime(true) - $startedAt, 3);
        $output = $process->getOutput();
        $error  = $process->getErrorOutput();

        $output = $this->sanitizeUtf8((string) $output);
        $error  = $this->sanitizeUtf8((string) $error);

        if (!empty($output)) {
            $trimmedOut = trim($output);
            $firstOpen = strpos($trimmedOut, '{');
            $lastClose  = strrpos($trimmedOut, '}');
            if ($firstOpen !== false && $lastClose !== false && $lastClose > $firstOpen) {
                $extracted = substr($trimmedOut, $firstOpen, $lastClose - $firstOpen + 1);
                if ($extracted !== '' && $extracted !== $trimmedOut) {
                    Log::channel('stack')->warning("[python] {$scriptLabel} — detectado lixo ao redor do JSON, extraindo objeto", [
                        'original_length' => strlen($trimmedOut),
                        'extracted_length' => strlen($extracted),
                    ]);
                    $output = $extracted;
                }
            }
        }

        Log::channel('stack')->info("[python] {$scriptLabel} finalizado", [
            'elapsed_sec' => $elapsed,
            'exit_code' => $process->getExitCode(),
            'exit_code_text' => $process->getExitCodeText(),
            'stdout_length' => strlen($output),
            'stderr_length' => strlen($error),
            'stdout_preview' => mb_substr($output, 0, 1500),
            'stderr' => $error,
        ]);

        if (!$process->isSuccessful()) {
            Log::channel('stack')->error("[python] {$scriptLabel} FALHOU", [
                'exit_code' => $process->getExitCode(),
                'exit_code_text' => $process->getExitCodeText(),
                'stdout' => $output,
                'stderr' => $error,
            ]);
            throw new ProcessFailedException($process);
        }

        if (!empty($error)) {
            Log::channel('stack')->warning("[python] {$scriptLabel} stderr recebido (exit 0)", ['stderr' => $error]);
        }

        if (empty(trim($output))) {
            Log::channel('stack')->error("[python] {$scriptLabel} retornou stdout VAZIO", ['stderr' => $error]);
            throw new \RuntimeException('O script retornou saída vazia. Verifique os logs para detalhes.');
        }

        $decoded = null;
        $lastException = null;
        $candidates = [$output];
        $repair1 = preg_replace('/[\x00-\x1F\x7F]+/', '', (string) $output);
        if ($repair1 !== null && $repair1 !== $output) {
            $candidates[] = $repair1;
        }
        foreach ($candidates as $idx => $candidate) {
            try {
                $decoded = json_decode((string) $candidate, true, 512, JSON_THROW_ON_ERROR);
                if (!is_array($decoded)) {
                    continue;
                }
                if ($idx > 0) {
                    Log::channel('stack')->warning("[python] {$scriptLabel} — JSON reparado com sucesso no candidato #{$idx}", [
                        'repair_method' => $idx === 1 ? 'strip_control_chars' : 'fallback',
                    ]);
                }
                break;
            } catch (\JsonException $e) {
                $lastException = $e;
                $decoded = null;
            }
        }

        if (is_array($decoded)) {
            Log::channel('stack')->info("[python] {$scriptLabel} JSON decodificado", [
                'decoded_keys' => array_keys($decoded),
                'success_flag' => $decoded['success'] ?? null,
            ]);
            return $decoded;
        }

        Log::channel('stack')->error("[python] {$scriptLabel} JSON inválido", [
            'json_error' => $lastException?->getMessage() ?? 'unknown',
            'stdout_full' => $output,
            'stderr' => $error,
            'candidates_tried' => count($candidates),
        ]);
        throw new \RuntimeException('Saída JSON inválida: ' . ($lastException?->getMessage() ?? 'unknown'), 0, $lastException);
    }

    public function execute(array $data): array
    {
        $pythonBin = $this->resolvePythonBin(['json', 'pandas']);
        $scriptPath = base_path('app/scripts/match.py');
        return $this->runProcess([$pythonBin, $scriptPath], 'execute (match.py)', $data, 30);
    }

    public function processResume(array $data): array
    {
        $pythonBin = $this->resolvePythonBin(['PyPDF2', 'google.genai', 'json', 'base64', 'io']);
        $scriptPath = base_path('app/scripts/resume.py');
        return $this->runProcess([$pythonBin, $scriptPath], 'processResume', $data, 120);
    }
}
