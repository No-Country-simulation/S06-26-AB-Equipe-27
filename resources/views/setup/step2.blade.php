@extends('layouts.setup')

@section('content')
<h2 class="text-2xl font-bold text-gray-800 mb-6">Passo 2 — Prioridades de Diversidade na Contratação</h2>
<p class="text-gray-600 mb-8">Quais grupos são prioridades estratégicas?</p>

<form method="POST" action="{{ route('setup.step2.post') }}">
    @csrf

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

    <!-- Priority Groups -->
    <div class="mb-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-8">
            @php
            $diversityGroups = [
            'women' => 'Mulheres',
            'black' => 'Profissionais Negros',
            'indigenous' => 'Profissionais Indígenas',
            'disabled' => 'Pessoas com Deficiência (PCD)',
            'lgbt' => 'LGBTQIA+',
            'refugee' => 'Refugiados / Imigrantes',
            'over_50' => 'Profissionais Sêniores (50+)',
            'neurodivergent' => 'Profissionais Neurodivergentes',
            ];
            $selectedGroups = $goals->pluck('group')->toArray();
            $priorities = $goals->pluck('priority', 'group')->toArray();
            @endphp
            @foreach($diversityGroups as $value => $label)
            <label class="flex items-center p-4 border-2 rounded-lg cursor-pointer transition-all {{ in_array($value, $selectedGroups) ? 'border-purple-500 bg-purple-50' : 'border-gray-200 hover:border-purple-300' }}">
                <input type="checkbox" name="groups[]" value="{{ $value }}" class="mr-3 w-4 h-4 text-purple-600 group-checkbox" {{ in_array($value, $selectedGroups) ? 'checked' : '' }} data-group="{{ $value }}">
                <span>{{ $label }}</span>
            </label>
            @endforeach
        </div>

        <!-- Priority Levels -->
        <div class="space-y-6 mb-8" id="priority-levels">
            @foreach($diversityGroups as $value => $label)
            <div class="p-4 bg-purple-50 rounded-xl border-2 border-purple-200 group-priority-item" data-group-priority="{{ $value }}" style="{{ in_array($value, $selectedGroups) ? '' : 'display: none;' }}">
                <h4 class="font-semibold text-purple-800 mb-3">{{ $label }}</h4>
                <p class="text-sm text-gray-600 mb-3">Prioridade:</p>
                <div class="flex gap-4">
                    @foreach(['low' => 'Baixa', 'medium' => 'Média', 'high' => 'Alta'] as $pValue => $pLabel)
                    <label class="flex items-center">
                        <input type="radio" name="priorities[{{ $value }}]" value="{{ $pValue }}" class="mr-2" {{ (isset($priorities[$value]) && $priorities[$value] === $pValue) || (!isset($priorities[$value]) && $pValue === 'medium') ? 'checked' : '' }}>
                        <span class="text-sm">{{ $pLabel }}</span>
                    </label>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Hiring Goal -->
    <div class="mb-8 bg-gradient-to-r from-purple-50 to-blue-50 p-6 rounded-xl border-2 border-purple-200">
        <h3 class="font-bold text-lg text-purple-800 mb-4">Meta de Contratação</h3>
        <p class="text-gray-600 mb-4">Aumentar a representatividade em:</p>
        <div class="flex items-center gap-4">
            <input type="number" name="target_percentage" value="{{ old('target_percentage', $goals->first()->target_percentage ?? 20) }}" min="0" max="100" class="w-24 px-4 py-2 border-2 border-gray-300 rounded-lg text-center text-xl font-bold focus:border-purple-500">
            <span class="text-2xl font-bold text-gray-700">%</span>
            <span class="text-gray-600">até</span>
            <select name="target_year" class="px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-purple-500">
                @for($year = date('Y'); $year <= date('Y') + 10; $year++)
                    <option value="{{ $year }}" {{ old('target_year', $goals->first()->target_year ?? date('Y') + 2) == $year ? 'selected' : '' }}>{{ $year }}</option>
                    @endfor
            </select>
        </div>
    </div>

    <!-- Navigation -->
    <div class="flex justify-between">
        <a href="{{ route('setup.step1') }}" class="text-gray-600 hover:text-gray-800 font-medium py-3 px-6 rounded-xl border-2 border-gray-300 hover:border-gray-400 transition-all">
            Voltar
        </a>
        <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white font-semibold py-3 px-8 rounded-xl transition-all transform hover:scale-105 shadow-lg">
            Continuar
        </button>
    </div>
</form>

<script>
    document.querySelectorAll('.group-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const group = this.getAttribute('data-group');
            const priorityDiv = document.querySelector(`[data-group-priority="${group}"]`);

            if (priorityDiv) {
                if (this.checked) {
                    priorityDiv.style.display = 'block';
                } else {
                    priorityDiv.style.display = 'none';
                }
            }
        });
    });
</script>
@endsection