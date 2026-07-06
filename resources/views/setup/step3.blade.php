@extends('layouts.setup')

@section('content')
<style>
    /* ==========================================================
       SKILLFOCUS — TOKENS (mesma paleta usada em /jobs, /reports,
       /matches, telas de auth e nos Passos 1 e 2 do setup)
    ========================================================== */
    .sf-eyebrow { color: #7C3AED; letter-spacing: .08em; }
    .sf-card { border: 1px solid #E9E5F3; box-shadow: 0 1px 2px rgba(23,21,42,.04), 0 10px 28px -14px rgba(23,21,42,.14); }
    .sf-step-dot { transition: all .2s ease; }

    /* Colunas do quadro ESG — cada pilar com sua própria identidade,
       reaproveitando as famílias de cor já usadas em /jobs e /reports */
    .sf-board-col { border-radius: 18px; padding: 1.1rem; border: 2px solid; }
    .sf-board-col.env { background-color: #E7F8EF; border-color: #C7EDD8; }
    .sf-board-col.social { background-color: #F3EEFE; border-color: #DCCFF8; }
    .sf-board-col.gov { background-color: #E9F1FE; border-color: #C9DBFB; }

    .sf-board-col-title { font-weight: 700; padding-bottom: .6rem; margin-bottom: .9rem; border-bottom: 1px solid rgba(0,0,0,.06); display: flex; align-items: center; gap: .5rem; }
    .sf-board-col.env .sf-board-col-title { color: #157A47; }
    .sf-board-col.social .sf-board-col-title { color: #6D28D9; }
    .sf-board-col.gov .sf-board-col-title { color: #1D4ED8; }

    .sf-goal-card { background-color: #FFFFFF; border-radius: 12px; box-shadow: 0 1px 2px rgba(23,21,42,.04); transition: all .15s ease; }
    .sf-goal-card:hover { box-shadow: 0 6px 14px -6px rgba(23,21,42,.14); }
    .sf-goal-card.is-checked-env { box-shadow: 0 0 0 2px #157A47 inset; }
    .sf-goal-card.is-checked-social { box-shadow: 0 0 0 2px #7C3AED inset; }
    .sf-goal-card.is-checked-gov { box-shadow: 0 0 0 2px #1D4ED8 inset; }

    .sf-checkbox-env:checked { accent-color: #157A47; }
    .sf-checkbox-social:checked { accent-color: #7C3AED; }
    .sf-checkbox-gov:checked { accent-color: #1D4ED8; }

    .sf-custom-goal-box { border: 2px dashed #E9E5F3; border-radius: 18px; background-color: #FBFAFF; }
    .sf-btn-continue {
        background: linear-gradient(155deg, #7C3AED, #5B21B6);
        box-shadow: 0 10px 22px -10px rgba(124,58,237,.6);
        transition: transform .15s ease, box-shadow .15s ease;
    }
    .sf-btn-continue:hover { transform: translateY(-1px); box-shadow: 0 14px 26px -10px rgba(124,58,237,.7); }
    .sf-btn-back { transition: all .15s ease; }
    .sf-btn-back:hover { border-color: #C9BEF2; color: #7C3AED; background-color: #FBFAFF; }
    .sf-add-goal-btn { color: #7C3AED; transition: color .15s ease; }
    .sf-add-goal-btn:hover { color: #5B21B6; }
</style>

<form method="POST" action="{{ route('setup.step3.post') }}">
    @csrf
    <div class="flex flex-col lg:flex-row gap-8 relative">
        <!-- Left: Goal Selection -->
        <div class="flex-1">

            <!-- Indicador de progresso do wizard -->
            <div class="flex items-center gap-2 mb-8">
                @for ($i = 1; $i <= 4; $i++)
                    <div class="flex items-center gap-2 flex-1">
                        <div class="sf-step-dot w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold
                            {{ $i <= 3 ? 'text-white' : 'text-[#9C97B5] bg-[#F3EEFE]' }}"
                            @if($i <= 3) style="background: linear-gradient(155deg, #7C3AED, #5B21B6);" @endif>
                            {{ $i }}
                        </div>
                        @if($i < 4)
                        <div class="h-[2px] flex-1 rounded-full {{ $i <= 2 ? 'bg-[#7C3AED]' : 'bg-[#E9E5F3]' }}"></div>
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
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">
                @php
                $selectedEsgGoals = $esgGoals->pluck('title')->toArray();
                $esgCategories = [
                'environmental' => [
                'title' => 'Ambiental',
                'accent' => 'env',
                'icon' => '<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3c-3 3-6 6.5-6 10.5A6 6 0 0012 20a6 6 0 006-6.5C18 9.5 15 6 12 3z"/></svg>',
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
                'icon' => '<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-4a4 4 0 10-4-4 4 4 0 004 4zm6 4a4 4 0 10-4-4"/></svg>',
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
                'icon' => '<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>',
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
                        <div class="goal-item" data-goal-key="{{ $goalKey }}" data-goal-title="{{ $goalData['title'] }}" data-tracking-type="{{ $goalData['tracking_type'] }}">
                            <label class="sf-goal-card {{ in_array($goalData['title'], $selectedEsgGoals) ? 'is-checked-'.$category['accent'] : '' }} flex items-start p-3 cursor-pointer">
                                <input type="checkbox" name="esg_goals[]" value="{{ $goalKey }}" class="sf-checkbox-{{ $category['accent'] }} goal-checkbox mr-3 mt-1 w-4 h-4" {{ in_array($goalData['title'], $selectedEsgGoals) ? 'checked' : '' }}>
                                <span class="text-sm text-[#47435C]">{{ $goalData['title'] }}</span>
                            </label>
                            @if($goalData['tracking_type'] !== 'status')
                            <div class="mt-2 pl-7">
                                <label class="text-xs font-medium text-[#77738F] mb-1 block">Valor Alvo</label>
                                @php
                                // Get existing value if available
                                $existingGoal = $esgGoals->where('title', $goalData['title'])->first();
                                $existingValue = $existingGoal ? $existingGoal->target_value : '';
                                @endphp
                                <div class="flex items-center gap-2">
                                    <input type="number" name="target_value_{{ $goalKey }}" value="{{ old('target_value_' . $goalKey, $existingValue) }}" class="px-3 py-1.5 bg-white border border-[#E9E5F3] rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#7C3AED]/30 focus:border-[#7C3AED] w-[calc(100%-24px)]">
                                    <div class="w-4 text-xs text-[#9C97B5] font-semibold">
                                        {{$goalData['tracking_type'] === 'percentage' ? '%' : ''}}
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
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4" id="esg-goals-1">
                        <div>
                            <label class="block text-sm font-medium text-[#47435C] mb-2">Título da Meta</label>
                            <input type="text" name="custom_title" class="w-full px-4 py-2 bg-white border-2 border-[#E9E5F3] rounded-lg focus:outline-none focus:border-[#7C3AED] focus:ring-4 focus:ring-[#7C3AED]/10" placeholder="Contratar 30 profissionais sub-representados">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-[#47435C] mb-2">Meta</label>
                            <input type="number" name="custom_target" class="w-full px-4 py-2 bg-white border-2 border-[#E9E5F3] rounded-lg focus:outline-none focus:border-[#7C3AED] focus:ring-4 focus:ring-[#7C3AED]/10" placeholder="30">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-[#47435C] mb-2">Prazo</label>
                            <input type="month" name="custom_deadline" class="w-full px-4 py-2 bg-white border-2 border-[#E9E5F3] rounded-lg focus:outline-none focus:border-[#7C3AED] focus:ring-4 focus:ring-[#7C3AED]/10">
                        </div>
                    </div>
                </div>
                <button type="button" class="sf-add-goal-btn mt-4 font-semibold flex items-center gap-2" id="add-esg-goal-btn">
                    <span>+ Adicionar Meta</span>
                </button>
            </div>

            <!-- Navigation -->
            <div class="flex justify-between items-center pt-2 border-t border-[#E9E5F3]">
                <a href="{{ route('setup.step2') }}" class="sf-btn-back text-[#47435C] font-semibold py-3 px-6 rounded-xl border-2 border-[#E9E5F3]">
                    Voltar
                </a>
                <button type="submit" class="sf-btn-continue text-white font-semibold py-3 px-8 rounded-xl">
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

<!-- <script>
    let selectedGoalKey = null;
    const esgGoalConfigs = {}; // Stores: key -> { trackingType, targetValue, deadline }


    // Helper to escape quotes
    function escapeHtml(unsafe) {
        if (unsafe == null) return '';
        return String(unsafe)
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }

    // Helper to format goal config form
    function buildGoalConfigForm(goalKey, goalTitle, trackingType) {
        const config = esgGoalConfigs[goalKey] || {
            trackingType: trackingType,
            targetValue: '',
            deadline: ''
        };
        let formHtml = `
            <h4 class="font-bold text-lg text-purple-800 mb-4">${escapeHtml(goalTitle)}</h4>
            <input type="hidden" name="goal_keys[]" value="${goalKey}">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de Medição</label>
                <select name="tracking_type_${goalKey}" class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-purple-500">
                    <option value="count" ${config.trackingType === 'count' ? 'selected' : ''}>Contagem</option>
                    <option value="percentage" ${config.trackingType === 'percentage' ? 'selected' : ''}>Percentual</option>
                    <option value="status" ${config.trackingType === 'status' ? 'selected' : ''}>Status</option>
                </select>
            </div>
        `;

        formHtml += `
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Meta</label>
                <input type="number" name="target_value_${goalKey}" value="${escapeHtml(config.targetValue)}" class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-purple-500">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Prazo</label>
                <input type="month" name="deadline_${goalKey}" value="${escapeHtml(config.deadline)}" class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-purple-500">
            </div>
        `;

        return formHtml;
    }

    // Open config panel
    document.querySelectorAll('.goal-item').forEach((item) => {
        item.addEventListener('click', () => {
            selectedGoalKey = item.dataset.goalKey;
            const goalTitle = item.dataset.goalTitle;
            const trackingType = item.dataset.trackingType;

            // Show config panel
            const configPanel = document.getElementById('config-panel');
            const configPanelTitle = document.getElementById('config-panel-title');
            const configPanelContent = document.getElementById('config-panel-content');
            configPanelTitle.textContent = `Configurar: ${goalTitle}`;
            configPanelContent.innerHTML = buildGoalConfigForm(selectedGoalKey, goalTitle, trackingType);
            configPanel.style.display = 'block';

            // Add active state
            document.querySelectorAll('.goal-item').forEach(el => el.classList.remove('ring-4', 'ring-purple-300'));
            item.classList.add('ring-4', 'ring-purple-300');
        });
    });

    // Close config panel
    document.getElementById('close-config').addEventListener('click', () => {
        document.getElementById('config-panel').style.display = 'none';
        selectedGoalKey = null;
        document.querySelectorAll('.goal-item').forEach(el => el.classList.remove('ring-4', 'ring-purple-300'));
    });
</script> -->

<script>
    // Realce visual do card ao marcar/desmarcar (independente do painel
    // lateral, que permanece desativado conforme o script original acima).
    document.querySelectorAll('.goal-checkbox').forEach((checkbox) => {
        checkbox.addEventListener('change', function () {
            const card = this.closest('.sf-goal-card');
            const accentClass = Array.from(this.classList).find(c => c.startsWith('sf-checkbox-'));
            if (!card || !accentClass) return;
            const accent = accentClass.replace('sf-checkbox-', '');
            card.classList.toggle('is-checked-' + accent, this.checked);
        });
    });
</script>
@endsection
