@extends('layouts.setup')

@section('content')
<form method="POST" action="{{ route('setup.step3.post') }}">
    @csrf
    <div class="flex flex-col lg:flex-row gap-8 relative">
        <!-- Left: Goal Selection -->
        <div class="flex-1">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Passo 3 — Metas ESG</h2>
            <p class="text-gray-600 mb-8">Selecione suas metas ESG (quadro estilo Trello)</p>

            <!-- Validation Errors -->
            @if ($errors->any())
            <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">Ops! Algo deu errado.</h3>
                        <div class="mt-2 text-sm text-red-700">
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
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                @php
                $selectedEsgGoals = $esgGoals->pluck('title')->toArray();
                $esgCategories = [
                'environmental' => [
                'title' => 'Ambiental',
                'color' => 'green',
                'goals' => [
                'ecologic_preservation' => ['title' => 'Preservação ecológica', 'tracking_type' => 'count'],
                'reduce_emissions' => ['title' => 'Reduzir emissões', 'tracking_type' => 'percentage'],
                'renewable_energy' => ['title' => 'Adotar energia renovável', 'tracking_type' => 'count'],
                'other_env' => ['title' => 'Outro', 'tracking_type' => 'count'],
                ],
                ],
                'social' => [
                'title' => 'Social',
                'color' => 'blue',
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
                'color' => 'purple',
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
                <div class="bg-{{ $category['color'] }}-50 rounded-xl p-4 border-2 border-{{ $category['color'] }}-200">
                    <h3 class="font-bold text-lg text-{{ $category['color'] }}-800 mb-4 pb-2 border-b border-{{ $category['color'] }}-200">{{ $category['title'] }}</h3>
                    <div class="space-y-2">
                        @foreach($category['goals'] as $goalKey => $goalData)
                        <div class="goal-item" data-goal-key="{{ $goalKey }}" data-goal-title="{{ $goalData['title'] }}" data-tracking-type="{{ $goalData['tracking_type'] }}">
                            <label class="flex items-start p-3 bg-white rounded-lg shadow-sm cursor-pointer transition-all hover:shadow-md {{ in_array($goalData['title'], $selectedEsgGoals) ? 'ring-2 ring-purple-500' : '' }}">
                                <input type="checkbox" name="esg_goals[]" value="{{ $goalKey }}" class="mr-3 mt-1 w-4 h-4 text-purple-600 goal-checkbox" {{ in_array($goalData['title'], $selectedEsgGoals) ? 'checked' : '' }}>
                                <span class="text-sm">{{ $goalData['title'] }}</span>
                            </label>
                            @if($goalData['tracking_type'] !== 'status')
                            <div class="mt-2 pl-7">
                                <label class="text-xs font-medium text-gray-600 mb-1">Valor Alvo</label>
                                @php
                                // Get existing value if available
                                $existingGoal = $esgGoals->where('title', $goalData['title'])->first();
                                $existingValue = $existingGoal ? $existingGoal->target_value : '';
                                @endphp
                                <div class="flex gap-2">
                                    <input type="number" name="target_value_{{ $goalKey }}" value="{{ old('target_value_' . $goalKey, $existingValue) }}" class="px-3 py-1 border border-gray-300 rounded text-sm focus:outline-none focus:ring-2 focus:ring-purple-500 w-[calc(100%-40px)]">
                                    <div class="w-2">
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
            <div class="mb-8 bg-gray-50 p-6 rounded-xl border-2 border-dashed border-gray-300">
                <h3 class="font-bold text-lg text-gray-800 mb-4">Criar Meta Personalizada</h3>
                <div class="" id="esg-goals-container">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4" id="esg-goals-1">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Título da Meta</label>
                            <input type="text" name="custom_title" class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-purple-500" placeholder="Contratar 30 profissionais sub-representados">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Meta</label>
                            <input type="number" name="custom_target" class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-purple-500" placeholder="30">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Prazo</label>
                            <input type="month" name="custom_deadline" class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-purple-500">
                        </div>
                    </div>
                </div>
                <button type="button" class="mt-4 text-purple-600 hover:text-purple-700 font-medium flex items-center gap-2" id="add-esg-goal-btn">
                    <span>+ Adicionar Meta</span>
                </button>
            </div>

            <!-- Navigation -->
            <div class="flex justify-between">
                <a href="{{ route('setup.step2') }}" class="text-gray-600 hover:text-gray-800 font-medium py-3 px-6 rounded-xl border-2 border-gray-300 hover:border-gray-400 transition-all">
                    Voltar
                </a>
                <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white font-semibold py-3 px-8 rounded-xl transition-all transform hover:scale-105 shadow-lg">
                    Continuar
                </button>
            </div>
        </div>

        <!-- Right: Configuration Panel -->
        <div class="w-full lg:w-64 h-full bg-white rounded-2xl shadow-md p-6 border-2 absolute block right-0 border-gray-200" id="config-panel" style="display: none;">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold text-gray-800" id="config-panel-title">Configurar Meta</h3>
                <button type="button" id="close-config" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div id="config-panel-content">
                <p class="text-gray-600 mb-4">Selecione uma meta para configurar</p>
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
@endsection