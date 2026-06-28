@extends('layouts.setup')

@section('content')
<h2 class="text-2xl font-bold text-gray-800 mb-6">Passo 3 — Metas ESG</h2>
<p class="text-gray-600 mb-8">Selecione suas metas ESG (quadro estilo Trello)</p>

<form method="POST" action="{{ route('setup.step3.post') }}">
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

    <!-- ESG Board -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        @php
        $selectedEsgGoals = $esgGoals->pluck('title')->toArray();

        $esgCategories = [
        'environmental' => [
        'title' => 'Ambiental',
        'color' => 'green',
        'goals' => [
        'reduce_paper' => 'Reduzir o uso de papel',
        'reduce_emissions' => 'Reduzir emissões',
        'renewable_energy' => 'Adotar energia renovável',
        'other_env' => 'Outro',
        ],
        ],
        'social' => [
        'title' => 'Social',
        'color' => 'blue',
        'goals' => [
        'hire_underrepresented' => 'Contratar talentos sub-representados',
        'mentorship' => 'Programas de mentoria',
        'accessibility' => 'Melhorias de acessibilidade',
        'community' => 'Engajamento comunitário',
        'scholarships' => 'Bolsas de estudo',
        ],
        ],
        'governance' => [
        'title' => 'Governança',
        'color' => 'purple',
        'goals' => [
        'anti_bias' => 'Processo de recrutamento antiviés',
        'dei_training' => 'Treinamento em DEI',
        'anonymous_reporting' => 'Canal de denúncia anônimo',
        'compliance' => 'Auditorias de conformidade',
        ],
        ],
        ];
        @endphp

        @foreach($esgCategories as $categoryKey => $category)
        <div class="bg-{{ $category['color'] }}-50 rounded-xl p-4 border-2 border-{{ $category['color'] }}-200">
            <h3 class="font-bold text-lg text-{{ $category['color'] }}-800 mb-4 pb-2 border-b border-{{ $category['color'] }}-200">{{ $category['title'] }}</h3>
            <div class="space-y-2">
                @foreach($category['goals'] as $goalKey => $goalTitle)
                <label class="flex items-start p-3 bg-white rounded-lg shadow-sm cursor-pointer transition-all hover:shadow-md {{ in_array($goalTitle, $selectedEsgGoals) ? 'ring-2 ring-purple-500' : '' }}">
                    <input type="checkbox" name="esg_goals[]" value="{{ $goalKey }}" class="mr-3 mt-1 w-4 h-4 text-purple-600" {{ in_array($goalTitle, $selectedEsgGoals) ? 'checked' : '' }}>
                    <span class="text-sm">{{ $goalTitle }}</span>
                </label>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>

    <!-- Custom Goal -->
    <div class="mb-8 bg-gray-50 p-6 rounded-xl border-2 border-dashed border-gray-300">
        <h3 class="font-bold text-lg text-gray-800 mb-4">Criar Meta Personalizada</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
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
        <button type="button" class="mt-4 text-purple-600 hover:text-purple-700 font-medium flex items-center gap-2">
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
</form>
@endsection