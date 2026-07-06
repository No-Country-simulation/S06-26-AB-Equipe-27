@extends('layouts.setup')

@section('content')
<style>
    /* ==========================================================
       SKILLFOCUS — TOKENS (mesma paleta usada em /jobs, /reports,
       /matches, telas de auth e no Passo 1 do setup)
    ========================================================== */
    .sf-eyebrow {
        color: #7C3AED;
        letter-spacing: .08em;
    }

    .sf-card {
        border: 1px solid #E9E5F3;
        box-shadow: 0 1px 2px rgba(23, 21, 42, .04), 0 10px 28px -14px rgba(23, 21, 42, .14);
    }

    .sf-option {
        border: 2px solid #E9E5F3;
        transition: all .18s ease;
    }

    .sf-option:hover {
        border-color: #A7DED8;
        background-color: #FBFAFF;
    }

    .sf-option.is-selected-shield {
        border-color: #0D9488;
        background-color: #E8F8F6;
    }

    .sf-checkbox:checked {
        accent-color: #0D9488;
    }

    .sf-priority-panel {
        border: 1px solid #E9E5F3;
        background-color: #FBFAFF;
        border-radius: 16px;
    }

    .sf-priority-chip {
        border: 1px solid #E9E5F3;
        background-color: #FFFFFF;
        transition: all .15s ease;
        cursor: pointer;
    }

    .sf-priority-chip:hover {
        border-color: #C9BEF2;
    }

    .sf-priority-chip.is-low {}

    .sf-priority-chip input:checked+span {
        font-weight: 700;
    }

    .sf-priority-chip.chip-low.is-checked {
        border-color: #157A47;
        background-color: #E7F8EF;
    }

    .sf-priority-chip.chip-low.is-checked span {
        color: #157A47;
    }

    .sf-priority-chip.chip-medium.is-checked {
        border-color: #B45309;
        background-color: #FDF1DF;
    }

    .sf-priority-chip.chip-medium.is-checked span {
        color: #B45309;
    }

    .sf-priority-chip.chip-high.is-checked {
        border-color: #B91C1C;
        background-color: #FDEAEA;
    }

    .sf-priority-chip.chip-high.is-checked span {
        color: #B91C1C;
    }

    .sf-goal-box {
        background: linear-gradient(135deg, #F3EEFE, #E8F8F6);
        border: 2px solid #E9E5F3;
    }

    .sf-btn-continue {
        background: linear-gradient(155deg, #7C3AED, #5B21B6);
        box-shadow: 0 10px 22px -10px rgba(124, 58, 237, .6);
        transition: transform .15s ease, box-shadow .15s ease;
    }

    .sf-btn-continue:hover {
        transform: translateY(-1px);
        box-shadow: 0 14px 26px -10px rgba(124, 58, 237, .7);
    }

    .sf-btn-back {
        transition: all .15s ease;
    }

    .sf-btn-back:hover {
        border-color: #C9BEF2;
        color: #7C3AED;
        background-color: #FBFAFF;
    }

    .sf-step-dot {
        transition: all .2s ease;
    }
</style>

<!-- Indicador de progresso do wizard -->
<div class="flex items-center gap-2 mb-8">
    @for ($i = 1; $i <= 4; $i++)
        <div class="flex items-center gap-2 {{$i < 4 ? 'flex-1' : 'flex-0'}}">
        <div class="sf-step-dot w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold
                {{ $i <= 2 ? 'text-white' : 'text-[#9C97B5] bg-[#F3EEFE]' }}"
            @if($i <=2) style="background: linear-gradient(155deg, #7C3AED, #5B21B6);" @endif>
            {{ $i }}
        </div>
        @if($i < 4)
            <div class="h-[2px] flex-1 rounded-full {{ $i <= 1 ? 'bg-[#7C3AED]' : 'bg-[#E9E5F3]' }}">
</div>
@endif
</div>
@endfor
</div>

<div class="flex items-center gap-1 mb-2">
    <span class="sf-eyebrow text-xs font-bold uppercase">Etapa 2 de 4</span>
</div>
<h2 class="text-2xl font-bold text-[#17152A] mb-2">Prioridades de Diversidade na Contratação</h2>
<p class="text-[#77738F] mb-8">Quais grupos são prioridades estratégicas para o seu Bias Shield?</p>

<div class="sf-card bg-white rounded-2xl p-6 md:p-8">
    <form method="POST" action="{{ route('setup.step2.post') }}">
        @csrf

        <!-- Validation Errors -->
        @if ($errors->any())
        <div class="mb-8 bg-[#FDEAEA] border border-[#F5C6C6] p-4 rounded-xl">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-[#B91C1C]" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-semibold text-[#991B1B]">Ops! Algo deu errado.</h3>
                    <div class="mt-2 text-sm text-[#B91C1C]">
                        <ul class="list-disc pl-5 space-y-1">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Priority Groups -->
        <div class="mb-9">
            <div class="flex items-center gap-2 mb-1">
                <span class="w-8 h-8 rounded-lg bg-[#E8F8F6] text-[#0D9488] inline-flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-4a4 4 0 10-4-4 4 4 0 004 4zm6 4a4 4 0 10-4-4" />
                    </svg>
                </span>
                <label class="block text-sm font-semibold text-[#17152A]">Grupos prioritários</label>
            </div>
            <p class="text-xs text-[#9C97B5] mb-4 ml-10">Selecione os grupos que fazem parte da sua estratégia de diversidade.</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-8">
                @php
                $diversityGroups = [
                'women' => 'Mulheres',
                'black' => 'Profissionais Negros',
                'indigenous' => 'Profissionais Indígenas',
                'disabled' => 'Pessoas com Deficiência (PCD)',
                'lgbt' => 'LGBTQIAP++',
                'refugee' => 'Refugiados / Imigrantes',
                'over_50' => 'Profissionais Sêniores (50+)',
                'neurodivergent' => 'Profissionais Neurodivergentes',
                ];
                $selectedGroups = $goals->pluck('group')->toArray();
                $priorities = $goals->pluck('priority', 'group')->toArray();
                @endphp
                @foreach($diversityGroups as $value => $label)
                <label class="sf-option flex items-center p-4 rounded-xl cursor-pointer
                    {{ in_array($value, $selectedGroups) ? 'is-selected-shield' : '' }}">
                    <input type="checkbox" name="groups[]" value="{{ $value }}" class="sf-checkbox group-checkbox mr-3 w-4 h-4"
                        {{ in_array($value, $selectedGroups) ? 'checked' : '' }} data-group="{{ $value }}">
                    <span class="text-sm font-medium {{ in_array($value, $selectedGroups) ? 'text-[#0D9488]' : 'text-[#47435C]' }}">{{ $label }}</span>
                </label>
                @endforeach
            </div>

            <!-- Priority Levels -->
            <div class="space-y-3" id="priority-levels">
                @foreach($diversityGroups as $value => $label)
                @php
                $current = $priorities[$value] ?? 'medium';
                @endphp
                <div class="sf-priority-panel p-4 group-priority-item" data-group-priority="{{ $value }}" style="{{ in_array($value, $selectedGroups) ? '' : 'display: none;' }}">
                    <h4 class="font-semibold text-[#17152A] mb-3 text-sm">{{ $label }}</h4>
                    <p class="text-xs text-[#9C97B5] mb-2 uppercase font-semibold tracking-wide">Prioridade</p>
                    <div class="flex flex-wrap gap-2">
                        @foreach(['low' => 'Baixa', 'medium' => 'Média', 'high' => 'Alta'] as $pValue => $pLabel)
                        <label class="sf-priority-chip chip-{{ $pValue }} {{ $current === $pValue ? 'is-checked' : '' }} flex items-center px-4 py-2 rounded-full">
                            <input type="radio" name="priorities[{{ $value }}]" value="{{ $pValue }}" class="mr-2 w-3.5 h-3.5" {{ $current === $pValue ? 'checked' : '' }}>
                            <span class="text-sm text-[#47435C]">{{ $pLabel }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Hiring Goal -->
        <div class="sf-goal-box mb-9 p-6 rounded-2xl">
            <div class="flex items-center gap-2 mb-3">
                <span class="w-8 h-8 rounded-lg bg-white text-[#7C3AED] inline-flex items-center justify-center flex-shrink-0 shadow-sm">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                </span>
                <h3 class="font-bold text-lg text-[#17152A]">Meta de Contratação</h3>
            </div>
            <p class="text-[#47435C] mb-4 text-sm">Aumentar a representatividade destes grupos em:</p>
            <div class="flex flex-wrap items-center gap-3">
                <input type="number" name="target_value" value="{{ old('target_value', isset($goal->target_value) ? round($goal->target_value) : 20) }}" min="0" max="100"
                    class="w-24 px-4 py-2.5 bg-white border-2 border-[#E9E5F3] rounded-xl text-center text-xl font-bold text-[#17152A] focus:outline-none focus:border-[#7C3AED] focus:ring-4 focus:ring-[#7C3AED]/10">

                <span class="text-2xl font-bold text-[#7C3AED]">%</span>
                <span class="text-[#77738F] text-sm">até</span>
                <select name="target_year" class="px-4 py-2.5 bg-white border-2 border-[#E9E5F3] rounded-xl text-[#17152A] font-semibold focus:outline-none focus:border-[#7C3AED] focus:ring-4 focus:ring-[#7C3AED]/10">
                    @for($year = date('Y'); $year <= date('Y') + 10; $year++)
                        <option value="{{ $year }}" {{ old('target_year', $goals->first()?->target_year ?? date('Y') + 2) == $year ? 'selected' : '' }}>{{ $year }}</option>
                        @endfor
                </select>
            </div>
        </div>

        <!-- Navigation -->
        <div class="flex justify-between items-center pt-2 border-t border-[#E9E5F3]">
            <a href="{{ route('setup.step1') }}" class="sf-btn-back text-[#47435C] font-semibold py-3 px-6 rounded-xl border-2 border-[#E9E5F3]">
                Voltar
            </a>
            <button type="submit" class="sf-btn-continue text-white font-semibold py-3 px-8 rounded-xl">
                Continuar
            </button>
        </div>
    </form>
</div>

<script>
    document.querySelectorAll('.group-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const group = this.getAttribute('data-group');
            const priorityDiv = document.querySelector(`[data-group-priority="${group}"]`);
            const optionLabel = this.closest('label');

            if (priorityDiv) {
                priorityDiv.style.display = this.checked ? 'block' : 'none';
            }

            if (optionLabel) {
                const textSpan = optionLabel.querySelector('span');
                if (this.checked) {
                    optionLabel.classList.add('is-selected-shield');
                    if (textSpan) textSpan.classList.add('text-[#0D9488]');
                } else {
                    optionLabel.classList.remove('is-selected-shield');
                    if (textSpan) textSpan.classList.remove('text-[#0D9488]');
                }
            }
        });
    });

    document.querySelectorAll('.sf-priority-chip input[type="radio"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const name = this.name;
            document.querySelectorAll(`input[name="${name}"]`).forEach(r => {
                r.closest('.sf-priority-chip').classList.remove('is-checked');
            });
            this.closest('.sf-priority-chip').classList.add('is-checked');
        });
    });
</script>
@endsection