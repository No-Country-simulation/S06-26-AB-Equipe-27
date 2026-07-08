@extends('layouts.setup')

@section('content')
<style>
    /* ==========================================================
       SKILLFOCUS — TOKENS (mesma paleta usada em /jobs, /reports,
       /matches, telas de auth e nos Passos 1 e 2 do setup)
    ========================================================== */
    .sf-eyebrow {
        color: #7C3AED;
        letter-spacing: .08em;
    }

    .sf-card {
        border: 1px solid #E9E5F3;
        box-shadow: 0 1px 2px rgba(23, 21, 42, .04), 0 10px 28px -14px rgba(23, 21, 42, .14);
    }

    .sf-step-dot {
        transition: all .2s ease;
    }

    /* Colunas do quadro ESG — cada pilar com sua própria identidade,
       reaproveitando as famílias de cor já usadas em /jobs e /reports */
    .sf-board-col {
        border-radius: 18px;
        padding: 1.1rem;
        border: 2px solid;
    }

    .sf-board-col.env {
        background-color: #E7F8EF;
        border-color: #C7EDD8;
    }

    .sf-board-col.social {
        background-color: #F3EEFE;
        border-color: #DCCFF8;
    }

    .sf-board-col.gov {
        background-color: #E9F1FE;
        border-color: #C9DBFB;
    }

    .sf-board-col-title {
        font-weight: 700;
        padding-bottom: .6rem;
        margin-bottom: .9rem;
        border-bottom: 1px solid rgba(0, 0, 0, .06);
        display: flex;
        align-items: center;
        gap: .5rem;
    }

    .sf-board-col.env .sf-board-col-title {
        color: #157A47;
    }

    .sf-board-col.social .sf-board-col-title {
        color: #6D28D9;
    }

    .sf-board-col.gov .sf-board-col-title {
        color: #1D4ED8;
    }

    .sf-goal-card {
        background-color: #FFFFFF;
        border-radius: 12px;
        box-shadow: 0 1px 2px rgba(23, 21, 42, .04);
        transition: all .15s ease;
        padding: 0.9rem !important;
    }

    .sf-goal-card:hover {
        box-shadow: 0 6px 14px -6px rgba(23, 21, 42, .14);
    }

    .sf-goal-card.is-checked-env {
        box-shadow: 0 0 0 2px #157A47 inset;
    }

    .sf-goal-card.is-checked-social {
        box-shadow: 0 0 0 2px #7C3AED inset;
    }

    .sf-goal-card.is-checked-gov {
        box-shadow: 0 0 0 2px #1D4ED8 inset;
    }

    /* Custom Radio & Checkbox Styles */
    .sf-checkbox-env,
    .sf-checkbox-social,
    .sf-checkbox-gov {
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        width: 20px;
        height: 20px;
        border: 2px solid #E9E5F3;
        background-color: #FFFFFF;
        cursor: pointer;
        position: relative;
        transition: all 0.15s ease;
        flex-shrink: 0;
        border-radius: 6px;
    }

    .sf-checkbox-env:checked {
        border-color: #157A47;
        background-color: #157A47;
    }

    .sf-checkbox-social:checked {
        border-color: #7C3AED;
        background-color: #7C3AED;
    }

    .sf-checkbox-gov:checked {
        border-color: #1D4ED8;
        background-color: #1D4ED8;
    }

    .sf-checkbox-env:checked::after,
    .sf-checkbox-social:checked::after,
    .sf-checkbox-gov:checked::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 12px;
        height: 12px;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='white'%3E%3Cpath d='M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z'/%3E%3C/svg%3E");
        background-size: contain;
        background-repeat: no-repeat;
    }

    .sf-custom-goal-box {
        border: 2px solid #E9E5F3;
        border-radius: 18px;
        background-color: #FBFAFF;
    }

    .sf-btn-continue {
        background: linear-gradient(155deg, #7C3AED, #5B21B6);
        box-shadow: 0 10px 22px -10px rgba(124, 58, 237, .6);
        transition: transform .15s ease, box-shadow .15s ease;
        height: 48px;
        width: 100%;
        max-width: 120px;
    }

    .sf-btn-continue:hover {
        transform: translateY(-1px);
        box-shadow: 0 14px 26px -10px rgba(124, 58, 237, .7);
    }

    .sf-btn-back {
        transition: all .15s ease;
        height: 48px;
        width: 100%;
        max-width: 100px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .sf-btn-back:hover {
        border-color: #C9BEF2;
        color: #7C3AED;
        background-color: #FBFAFF;
    }

    .sf-add-goal-btn {
        color: #7C3AED;
        transition: color .15s ease;
    }

    .sf-add-goal-btn:hover {
        color: #5B21B6;
    }

    /* Collapsible Goal Section */
    .goal-collapsible {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease;
    }

    .goal-collapsible.open {
        max-height: 200px;
    }

    .goal-toggle-btn {
        cursor: pointer;
        color: #77738F;
        transition: transform 0.2s ease, color 0.2s ease;
        margin-left: auto;
    }

    .goal-toggle-btn.open {
        transform: rotate(180deg);
        color: #7C3AED;
    }

    .target-input-wrapper {
        border-radius: 12px;
        background-color: #fbf9ff;
        align-items: center;
        padding: .5rem 1rem;
    }

    .target-input {
        background-color: #FFFFFF;
        border: 1px solid #E9E5F3;
        border-radius: 10px;
        text-align: center;
        font-weight: 600;
        width: 65px;
        display: flex;
        padding: 0.5rem 0.5rem 0.5rem 1rem;
    }

    .target-input:focus {
        outline: none;
        border-color: #7C3AED;
        box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.15);
    }

    .target-qty-btn {
        background-color: #FFFFFF;
        border: 1px solid #E9E5F3;
        border-radius: 8px;
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.15s ease;
    }

    .target-qty-btn:hover {
        background-color: #7C3AED;
        border-color: #7C3AED;
        color: white;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {

        .sf-btn-continue,
        .sf-btn-back {
            padding: 0.625rem 1rem !important;
            font-size: 0.875rem !important;
        }

        .sf-board-col {
            padding: 0.75rem !important;
        }

        .sf-goal-card {
            padding: 0.9rem !important;
        }

        .sf-custom-goal-box {
            padding: 1rem !important;
        }

        .mb-9 {
            margin-bottom: 1.5rem !important;
        }

        .mb-8 {
            margin-bottom: 1.25rem !important;
        }
    }
</style>

<form method="POST" action="{{ route('setup.step3.post') }}">
    @csrf
    <div class="flex flex-col lg:flex-row gap-8 relative">
        <!-- Left: Goal Selection -->
        <div class="flex-1">

            <!-- Indicador de progresso do wizard -->
            <div class="flex items-center gap-2 mb-8">
                @for ($i = 1; $i <= 4; $i++)
                    <div class="flex items-center gap-2 {{$i < 4 ? 'flex-1' : 'flex-0'}}">
                    <div class="sf-step-dot w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold
                            {{ $i <= 3 ? 'text-white' : 'text-[#9C97B5] bg-[#F3EEFE]' }}"
                        @if($i <=3) style="background: linear-gradient(155deg, #7C3AED, #5B21B6);" @endif>
                        {{ $i }}
                    </div>
                    @if($i < 4)
                        <div class="h-[2px] flex-1 rounded-full {{ $i <= 2 ? 'bg-[#7C3AED]' : 'bg-[#E9E5F3]' }}">
            </div>
            @endif
        </div>
        @endfor
    </div>

    <div class="flex items-center gap-1 mb-2">
        <span class="sf-eyebrow text-xs font-bold uppercase">Etapa 3 de 4</span>
    </div>
    <h2 class="text-2xl font-bold text-[#17152A] mb-2">Metas ESG</h2>
    <p class="text-[#77738F] mb-8">Monte seu quadro de metas ambientais, sociais e de governança.</p>

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

    <!-- ESG Board -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mb-8">
        @php
        $selectedEsgGoals = $esgGoals->pluck('title')->toArray();
        $esgCategories = [
        'environmental' => [
        'title' => 'Ambiental',
        'accent' => 'env',
        'icon' => '<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c-3 3-6 6.5-6 10.5A6 6 0 0012 20a6 6 0 006-6.5C18 9.5 15 6 12 3z" />
        </svg>',
        'goals' => [
        'ecologic_preservation' => ['title' => 'Preservação ecológica', 'tracking_type' => 'count'],
        'reduce_emissions' => ['title' => 'Reduzir emissões', 'tracking_type' => 'percentage'],
        'renewable_energy' => ['title' => 'Adotar energia renovável', 'tracking_type' => 'count'],
        'other_env' => ['title' => 'Outro', 'tracking_type' => 'count'],
        ],
        ],
        'social' => [
        'title' => 'Social',
        'accent' => 'social',
        'icon' => '<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-4a4 4 0 10-4-4 4 4 0 004 4zm6 4a4 4 0 10-4-4" />
        </svg>',
        'goals' => [
        'hire_underrepresented' => ['title' => 'Contratar talentos sub-representados', 'tracking_type' => 'count'],
        'mentorship' => ['title' => 'Programas de mentoria', 'tracking_type' => 'count'],
        'accessibility' => ['title' => 'Melhorias de acessibilidade', 'tracking_type' => 'percentage'],
        'community' => ['title' => 'Engajamento comunitário', 'tracking_type' => 'count'],
        'scholarships' => ['title' => 'Bolsas de estudo', 'tracking_type' => 'count'],
        ],
        ],
        'governance' => [
        'title' => 'Governança',
        'accent' => 'gov',
        'icon' => '<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
        </svg>',
        'goals' => [
        'anti_bias' => ['title' => 'Processo de recrutamento antiviés', 'tracking_type' => 'status'],
        'dei_training' => ['title' => 'Treinamento em DEI', 'tracking_type' => 'status'],
        'anonymous_reporting' => ['title' => 'Canal de denúncia anônimo', 'tracking_type' => 'status'],
        'compliance' => ['title' => 'Auditorias de conformidade', 'tracking_type' => 'status'],
        ],
        ],
        ];
        @endphp

        @foreach($esgCategories as $categoryKey => $category)
        <div class="sf-board-col {{ $category['accent'] }}">
            <h3 class="sf-board-col-title">
                {!! $category['icon'] !!} {{ $category['title'] }}
            </h3>
            <div class="space-y-2">
                @foreach($category['goals'] as $goalKey => $goalData)
                @php
                $isChecked = in_array($goalData['title'], $selectedEsgGoals);
                $existingGoal=$esgGoals->where('title', $goalData['title'])->first();
                $existingValue=$existingGoal ? $existingGoal->target_value : '' ;
                @endphp
                <div class="goal-item" data-goal-key="{{ $goalKey }}">
                    <label class="sf-goal-card {{ $isChecked ? 'is-checked-'.$category['accent'] : '' }} flex items-start p-3 cursor-pointer">
                        <input type="checkbox" name="esg_goals[]" value="{{ $goalKey }}" class="sf-checkbox-{{ $category['accent'] }} goal-checkbox mr-3 mt-1 w-5 h-5" {{ $isChecked ? 'checked' : '' }}>
                        <span class="text-sm text-[#47435C] flex-1">{{ $goalData['title'] }}</span>
                        @if($goalData['tracking_type'] !== 'status')
                        <button type="button" class="goal-toggle-btn {{ $isChecked ? 'open' : '' }}" data-toggle="goal-{{ $goalKey }}">
                            <i class="bi bi-chevron-down"></i>
                        </button>
                        @endif
                    </label>

                    @if($goalData['tracking_type'] !== 'status')
                    <div class="goal-collapsible {{ $isChecked ? 'open' : '' }}" id="goal-{{ $goalKey }}">
                        <div class="target-input-wrapper mt-2 pl-7">
                            <div class="text-xs font-medium text-[#77738F] mb-2 text-center pr-2 {{$goalData['tracking_type'] === 'percentage' ? 'pr-6' : ''}}">Valor alvo</div>
                            <div class="flex items-center justify-center">
                                <button type="button" class="target-qty-btn" onclick="changeGoalValue('{{ $goalKey }}', -1)">
                                    <i class="bi bi-dash"></i>
                                </button>
                                <input type="number" name="target_value_{{ $goalKey }}" id="input-{{ $goalKey }}" value="{{ old('target_value_' . $goalKey, $existingValue) }}" class="target-input" min="0">
                                <button type="button" class="target-qty-btn" onclick="changeGoalValue('{{ $goalKey }}', 1)">
                                    <i class="bi bi-plus"></i>
                                </button>
                                @if($goalData['tracking_type'] === 'percentage')
                                <span class="text-sm text-[#77738F] font-bold pl-1.5">%</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>

    <!-- Custom Goal -->
    <div class="sf-custom-goal-box mb-8 p-6">
        <div class="flex items-center gap-2 mb-4">
            <span class="w-8 h-8 rounded-lg bg-[#F3EEFE] text-[#7C3AED] inline-flex items-center justify-center flex-shrink-0">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
            </span>
            <h3 class="font-bold text-lg text-[#17152A]">Criar Meta Personalizada</h3>
        </div>
        <div id="esg-goals-container">
            <div class="custom-goal-item grid grid-cols-1 md:grid-cols-4 gap-4 mb-4" data-index="0">
                <div>
                    <label class="block text-sm font-medium text-[#47435C] mb-2">Título da Meta</label>
                    <input type="text" name="custom_goals[0][title]" class="w-full px-4 py-2 bg-white border-2 border-[#E9E5F3] rounded-lg focus:outline-none focus:border-[#7C3AED] focus:ring-4 focus:ring-[#7C3AED]/10" placeholder="Contratar 30 profissionais sub-representados">
                </div>
                <div>
                    <label class="block text-sm font-medium text-[#47435C] mb-2">Tipo de Meta</label>
                    <select name="custom_goals[0][pillar]" class="w-full px-4 py-2 bg-white border-2 border-[#E9E5F3] rounded-lg focus:outline-none focus:border-[#7C3AED] focus:ring-4 focus:ring-[#7C3AED]/10">
                        <option value="environmental">Ambiental</option>
                        <option value="social" selected>Social</option>
                        <option value="governance">Governança</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-[#47435C] mb-2">Meta</label>
                    <input type="number" name="custom_goals[0][target_value]" class="w-full px-4 py-2 bg-white border-2 border-[#E9E5F3] rounded-lg focus:outline-none focus:border-[#7C3AED] focus:ring-4 focus:ring-[#7C3AED]/10" placeholder="30">
                </div>
                <div>
                    <label class="block text-sm font-medium text-[#47435C] mb-2">Prazo</label>
                    <input type="month" name="custom_goals[0][deadline]" class="w-full px-4 py-2 bg-white border-2 border-[#E9E5F3] rounded-lg focus:outline-none focus:border-[#7C3AED] focus:ring-4 focus:ring-[#7C3AED]/10">
                </div>
            </div>
        </div>
        <button type="button" class="sf-add-goal-btn mt-4 font-semibold flex items-center gap-2" id="add-esg-goal-btn">
            <span>+ Adicionar Meta</span>
        </button>
    </div>

    <!-- Navigation -->
    <div class="flex justify-between items-center pt-2 border-t border-[#E9E5F3]">
        <a href="{{ route('setup.step2') }}" class="sf-btn-back text-[#47435C] font-semibold rounded-xl border-2 border-[#E9E5F3]">
            Voltar
        </a>
        <button type="submit" class="sf-btn-continue text-white font-semibold rounded-xl">
            Continuar
        </button>
    </div>
    </div>

    <!-- Right: Configuration Panel -->
    <div class="w-full lg:w-64 h-full sf-card bg-white rounded-2xl p-6 absolute block right-0" id="config-panel" style="display: none;">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold text-[#17152A]" id="config-panel-title">Configurar Meta</h3>
            <button type="button" id="close-config" class="text-[#9C97B5] hover:text-[#47435C]">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div id="config-panel-content">
            <p class="text-[#77738F] mb-4">Selecione uma meta para configurar</p>
        </div>
    </div>
    </div>
</form>

<script>
    // Function to change goal value with + / - buttons
    function changeGoalValue(goalKey, delta) {
        const input = document.getElementById(`input-${goalKey}`);
        if (!input) return;
        let currentValue = parseInt(input.value) || 0;
        currentValue = Math.max(0, currentValue + delta);
        input.value = currentValue;
    }

    // Realce visual do card ao marcar/desmarcar e toggle collapsible
    document.querySelectorAll('.goal-checkbox').forEach((checkbox) => {
        checkbox.addEventListener('change', function() {
            const card = this.closest('.sf-goal-card');
            const goalItem = this.closest('.goal-item');
            const accentClass = Array.from(this.classList).find(c => c.startsWith('sf-checkbox-'));
            if (!card || !accentClass || !goalItem) return;
            const accent = accentClass.replace('sf-checkbox-', '');
            card.classList.toggle('is-checked-' + accent, this.checked);

            const collapsible = goalItem.querySelector('.goal-collapsible');
            const toggleBtn = goalItem.querySelector('.goal-toggle-btn');
            if (collapsible && toggleBtn) {
                collapsible.classList.toggle('open', this.checked);
                toggleBtn.classList.toggle('open', this.checked);
            }
        });
    });

    // Handle toggle button clicks to open/close collapsible
    document.querySelectorAll('.goal-toggle-btn').forEach((btn) => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();

            const targetId = this.dataset.toggle;
            const collapsible = document.getElementById(targetId);
            if (collapsible) {
                collapsible.classList.toggle('open');
                this.classList.toggle('open');
            }
        });
    });

    // Handle adding new custom goals
    document.getElementById('add-esg-goal-btn').addEventListener('click', function() {
        const container = document.getElementById('esg-goals-container');
        const lastItem = container.querySelector('.custom-goal-item:last-child');
        const nextIndex = lastItem ? parseInt(lastItem.dataset.index) + 1 : 0;

        const newGoalItem = document.createElement('div');
        newGoalItem.className = 'custom-goal-item grid grid-cols-1 md:grid-cols-4 gap-4 mb-4';
        newGoalItem.dataset.index = nextIndex;

        newGoalItem.innerHTML = `
            <div>
                <label class="block text-sm font-medium text-[#47435C] mb-2">Título da Meta</label>
                <input type="text" name="custom_goals[${nextIndex}][title]" class="w-full px-4 py-2 bg-white border-2 border-[#E9E5F3] rounded-lg focus:outline-none focus:border-[#7C3AED] focus:ring-4 focus:ring-[#7C3AED]/10" placeholder="Contratar 30 profissionais sub-representados">
            </div>
            <div>
                <label class="block text-sm font-medium text-[#47435C] mb-2">Tipo de Meta</label>
                <select name="custom_goals[${nextIndex}][pillar]" class="w-full px-4 py-2 bg-white border-2 border-[#E9E5F3] rounded-lg focus:outline-none focus:border-[#7C3AED] focus:ring-4 focus:ring-[#7C3AED]/10">
                    <option value="environmental">Ambiental</option>
                    <option value="social" selected>Social</option>
                    <option value="governance">Governança</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-[#47435C] mb-2">Meta</label>
                <input type="number" name="custom_goals[${nextIndex}][target_value]" class="w-full px-4 py-2 bg-white border-2 border-[#E9E5F3] rounded-lg focus:outline-none focus:border-[#7C3AED] focus:ring-4 focus:ring-[#7C3AED]/10" placeholder="30">
            </div>
            <div>
                <label class="block text-sm font-medium text-[#47435C] mb-2">Prazo</label>
                <input type="month" name="custom_goals[${nextIndex}][deadline]" class="w-full px-4 py-2 bg-white border-2 border-[#E9E5F3] rounded-lg focus:outline-none focus:border-[#7C3AED] focus:ring-4 focus:ring-[#7C3AED]/10">
            </div>
        `;

        container.appendChild(newGoalItem);
    });
</script>
@endsection