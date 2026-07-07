@extends('layouts.setup')

@section('content')
<style>
    /* ==========================================================
       SKILLFOCUS — TOKENS (mesma paleta usada em /jobs, /reports,
       /matches, telas de auth e nos 4 passos do setup)
    ========================================================== */
    .sf-eyebrow { color: #7C3AED; letter-spacing: .08em; }
    .sf-card { border: 1px solid #E9E5F3; box-shadow: 0 1px 2px rgba(23,21,42,.04), 0 10px 28px -14px rgba(23,21,42,.14); border-radius: 20px; }
    .sf-step-dot { transition: all .2s ease; }

    /* Cabeçalho de cada bloco de revisão, com acento de cor próprio
       reaproveitando as famílias de tokens já usadas no restante do app */
    .sf-review-header { display: flex; align-items: center; gap: .65rem; padding-bottom: .9rem; margin-bottom: 1.1rem; border-bottom: 1px solid #F0EEF7; }
    .sf-review-header h3 { font-weight: 700; font-size: 1.05rem; color: #17152A; }
    .sf-review-icon { width: 36px; height: 36px; border-radius: 10px; display: inline-flex; align-items: center; justify-content: center; flex-shrink: 0; }

    .sf-icon-purple { background-color: #F3EEFE; color: #7C3AED; }
    .sf-icon-blue   { background-color: #E9F1FE; color: #1D4ED8; }
    .sf-icon-shield { background-color: #E8F8F6; color: #0D9488; }
    .sf-icon-gold   { background-color: #FDF1DF; color: #B45309; }

    .sf-pill { display: inline-flex; align-items: center; gap: .3rem; padding: .35rem .85rem; border-radius: 999px; font-size: .8rem; font-weight: 600; }
    .sf-pill-purple { background-color: #F3EEFE; color: #6D28D9; }
    .sf-pill-shield { background-color: #E8F8F6; color: #0D9488; }
    .sf-pill-gold   { background-color: #FDF1DF; color: #B45309; }

    .sf-row { background-color: #FBFAFF; border: 1px solid #F0EEF7; border-radius: 12px; }

    .sf-priority-badge-low    { background-color: #E7F8EF; color: #157A47; }
    .sf-priority-badge-medium { background-color: #FDF1DF; color: #B45309; }
    .sf-priority-badge-high   { background-color: #FDEAEA; color: #B91C1C; }

    .sf-quote-box { background-color: #FBFAFF; border-left: 3px solid #7C3AED; border-radius: 0 12px 12px 0; }

    .sf-btn-finish {
        background: linear-gradient(155deg, #7C3AED, #5B21B6);
        box-shadow: 0 12px 26px -10px rgba(124,58,237,.6);
        transition: transform .15s ease, box-shadow .15s ease;
    }
    .sf-btn-finish:hover { transform: translateY(-1px); box-shadow: 0 16px 30px -10px rgba(124,58,237,.7); }
    .sf-btn-back { transition: all .15s ease; }
    .sf-btn-back:hover { border-color: #C9BEF2; color: #7C3AED; background-color: #FBFAFF; }
</style>

<!-- Indicador de progresso do wizard — todas as etapas concluídas -->
<div class="flex items-center gap-2 mb-8">
    @for ($i = 1; $i <= 4; $i++)
        <div class="flex items-center gap-2 flex-1">
            <div class="sf-step-dot w-9 h-9 rounded-full flex items-center justify-center text-white"
                style="background: linear-gradient(155deg, #7C3AED, #5B21B6);">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <div class="h-[2px] flex-1 rounded-full bg-[#7C3AED]"></div>
        </div>
    @endfor
    <div class="sf-step-dot w-9 h-9 rounded-full flex items-center justify-center text-white flex-shrink-0"
        style="background: linear-gradient(155deg, #0D9488, #0B7A70);">
        <i class="text-sm">✓</i>
    </div>
</div>

<div class="flex items-center gap-1 mb-2">
    <span class="sf-eyebrow text-xs font-bold uppercase">Revisão final</span>
</div>
<h2 class="text-2xl font-bold text-[#17152A] mb-2">Revisão Final e Conclusão da Configuração</h2>
<p class="text-[#77738F] mb-8">Confira tudo antes de ativar o Bias Shield na sua plataforma.</p>

<!-- Review Cards -->
<div class="space-y-5 mb-8">

    <!-- Company Profile -->
    <div class="sf-card bg-white p-6">
        <div class="sf-review-header">
            <span class="sf-review-icon sf-icon-purple">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 21h18M5 21V7l7-4 7 4v14M9 9h1m-1 4h1m4-4h1m-1 4h1m-9 8v-4a2 2 0 012-2h2a2 2 0 012 2v4" />
                </svg>
            </span>
            <h3>Perfil de Diversidade da Empresa</h3>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <span class="text-sm text-[#77738F]">Tamanho:</span>
                <span class="ml-2 font-semibold text-[#17152A]">{{ $company->size }}</span>
            </div>
            <div>
                <span class="text-sm text-[#77738F]">Modelo de Trabalho:</span>
                <span class="ml-2 font-semibold text-[#17152A]">{{ ucfirst($company->work_model) }}</span>
            </div>
        </div>

        <div class="mb-4">
            <p class="text-sm font-semibold text-[#47435C] mb-2">Programas:</p>
            <div class="flex flex-wrap gap-2">
                @php
                $programLabels = [
                'diversity_committee' => 'Comitê de Diversidade',
                'accessibility_program' => 'Programa de Acessibilidade',
                'mentorship_program' => 'Programa de Mentoria',
                'internship_program' => 'Programa de Estágio',
                'returnship_program' => 'Programa de Retorno ao Trabalho',
                'erg' => 'Grupos de Recursos de Funcionários (ERGs)'
                ];
                @endphp
                @foreach($company->inclusion_programs as $program)
                <span class="sf-pill sf-pill-purple">
                    ✓ {{ $programLabels[$program] ?? ucwords(str_replace('_', ' ', $program)) }}
                </span>
                @endforeach
            </div>
        </div>

        @if($company->diversity_statement)
        <div class="sf-quote-box p-4">
            <p class="text-sm text-[#47435C] italic">"{{ $company->diversity_statement }}"</p>
        </div>
        @endif
    </div>

    <!-- Diversity Priorities -->
    @if($goals->count() > 0)
    <div class="sf-card bg-white p-6">
        <div class="sf-review-header">
            <span class="sf-review-icon sf-icon-blue">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-4a4 4 0 10-4-4 4 4 0 004 4zm6 4a4 4 0 10-4-4" />
                </svg>
            </span>
            <h3>Prioridades de Diversidade</h3>
        </div>

        <div class="space-y-2">
            @php
            $groupLabels = [
            'women' => 'Mulheres',
            'black' => 'Profissionais Negros',
            'indigenous' => 'Profissionais Indígenas',
            'disabled' => 'Pessoas com Deficiência (PCD)',
            'lgbt' => 'LGBTQIAP++',
            'refugee' => 'Refugiados / Imigrantes',
            'over_50' => 'Profissionais Sêniores (50+)',
            'neurodivergent' => 'Profissionais Neurodivergentes'
            ];
            $priorityLabels = [
            'low' => 'Baixa',
            'medium' => 'Regular',
            'high' => 'Alta'
            ];
            @endphp
            @foreach($goals as $goal)
            <div class="sf-row flex items-center justify-between p-3">
                <span class="font-medium text-[#47435C]">{{ $groupLabels[$goal->group] ?? ucwords(str_replace('_', ' ', $goal->group)) }}</span>
                <span class="px-3 py-1 rounded-full text-xs font-bold sf-priority-badge-{{ $goal->priority }}">
                    {{ strtoupper($priorityLabels[$goal->priority] ?? $goal->priority) }}
                </span>
            </div>
            @endforeach
        </div>

        @if($goals->first()->target_value)
        <div class="mt-4 pt-4 border-t border-[#E9E5F3]">
            <p class="font-medium text-[#47435C]">Meta: <span class="text-[#1D4ED8] font-bold">{{ $goals->first()->target_value }}% até {{ $goals->first()->target_year }}</span></p>
        </div>
        @endif
    </div>
    @endif

    <!-- ESG Goals -->
    @if($esgGoals->count() > 0)
    <div class="sf-card bg-white p-6">
        <div class="sf-review-header">
            <span class="sf-review-icon sf-icon-shield">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </span>
            <h3>Metas ESG</h3>
        </div>

        <div class="flex flex-wrap gap-2">
            @foreach($esgGoals as $esgGoal)
            <span class="sf-pill sf-pill-shield">
                ✓ {{ $esgGoal->title }}
            </span>
            @endforeach
        </div>
    </div>
    @endif

    <!-- AI Preferences -->
    @if($preferences)
    <div class="sf-card bg-white p-6">
        <div class="sf-review-header">
            <span class="sf-review-icon sf-icon-gold">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
            </span>
            <h3>Preferências de Correspondência por IA</h3>
        </div>

        <div class="space-y-4">
            <div>
                <p class="text-sm font-semibold text-[#47435C] mb-2">Ordem de Prioridade:</p>
                <div class="flex flex-wrap gap-2">
                    @if($preferences->matching_priority)
                    @php
                    $priorityLabels = [
                    'technical_skills' => 'Habilidades Técnicas',
                    'diversity_goals' => 'Metas de Diversidade',
                    'location' => 'Localização',
                    'experience' => 'Experiência',
                    'education' => 'Educação'
                    ];
                    @endphp
                    @foreach($preferences->matching_priority as $index => $item)
                    <span class="sf-pill sf-pill-gold">
                        {{ $index + 1 }}. {{ $priorityLabels[$item] ?? ucwords(str_replace('_', ' ', $item)) }}
                    </span>
                    @endforeach
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 pt-2">
                <div class="sf-row p-3">
                    <span class="text-xs text-[#9C97B5] block mb-0.5">Raio</span>
                    <span class="font-bold text-[#17152A]">{{ $preferences->candidate_radius }} km</span>
                </div>
                <div class="sf-row p-3">
                    <span class="text-xs text-[#9C97B5] block mb-0.5">Remoto</span>
                    <span class="font-bold text-[#17152A]">{{ $preferences->include_remote ? 'Ativado ✓' : 'Desativado' }}</span>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<!-- Navigation -->
<div class="flex justify-between items-center pt-2">
    <a href="{{ route('setup.step4') }}" class="sf-btn-back text-[#47435C] font-semibold py-3 px-6 rounded-xl border-2 border-[#E9E5F3]">
        Editar
    </a>
    <form method="POST" action="{{ route('setup.finish') }}">
        @csrf
        <button type="submit" class="sf-btn-finish text-white font-semibold py-3 px-10 rounded-xl inline-flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
            </svg>
            Concluir Configuração
        </button>
    </form>
</div>
@endsection
