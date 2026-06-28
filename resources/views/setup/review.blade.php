@extends('layouts.setup')

@section('content')
<h2 class="text-2xl font-bold text-gray-800 mb-6">Revisão Final e Conclusão da Configuração</h2>

<!-- Review Cards -->
<div class="space-y-6 mb-8">
    <!-- Company Profile -->
    <div class="bg-gradient-to-r from-purple-50 to-blue-50 p-6 rounded-xl border-2 border-purple-200">
        <h3 class="font-bold text-lg text-purple-800 mb-4 pb-2 border-b border-purple-200">Perfil de Diversidade da Empresa</h3>

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <span class="text-sm text-gray-600">Tamanho:</span>
                <span class="ml-2 font-semibold">{{ $company->size }}</span>
            </div>
            <div>
                <span class="text-sm text-gray-600">Modelo de Trabalho:</span>
                <span class="ml-2 font-semibold">{{ ucfirst($company->work_model) }}</span>
            </div>
        </div>

        <div class="mb-4">
            <p class="text-sm font-semibold text-gray-700 mb-2">Programas:</p>
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
                <span class="bg-purple-200 text-purple-800 px-3 py-1 rounded-full text-sm">
                    ✓ {{ $programLabels[$program] ?? ucwords(str_replace('_', ' ', $program)) }}
                </span>
                @endforeach
            </div>
        </div>

        @if($company->diversity_statement)
        <div class="bg-white p-4 rounded-lg">
            <p class="text-sm text-gray-600 italic">"{{ $company->diversity_statement }}"</p>
        </div>
        @endif
    </div>

    <!-- Diversity Priorities -->
    @if($goals->count() > 0)
    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-6 rounded-xl border-2 border-blue-200">
        <h3 class="font-bold text-lg text-blue-800 mb-4 pb-2 border-b border-blue-200">Prioridades de Diversidade</h3>

        <div class="space-y-3">
            @php
            $groupLabels = [
            'women' => 'Mulheres',
            'black' => 'Profissionais Negros',
            'indigenous' => 'Profissionais Indígenas',
            'disabled' => 'Pessoas com Deficiência (PCD)',
            'lgbt' => 'LGBTQIA+',
            'refugee' => 'Refugiados / Imigrantes',
            'over_50' => 'Profissionais Sêniores (50+)',
            'neurodivergent' => 'Profissionais Neurodivergentes'
            ];
            $priorityLabels = [
            'low' => 'Baixa',
            'medium' => 'Média',
            'high' => 'Alta'
            ];
            @endphp
            @foreach($goals as $goal)
            <div class="flex items-center justify-between bg-white p-3 rounded-lg">
                <span class="font-medium">{{ $groupLabels[$goal->group] ?? ucwords(str_replace('_', ' ', $goal->group)) }}</span>
                <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $goal->priority === 'high' ? 'bg-red-100 text-red-700' : ($goal->priority === 'medium' ? 'bg-yellow-100 text-yellow-700' : 'bg-green-100 text-green-700') }}">
                    {{ strtoupper($priorityLabels[$goal->priority] ?? $goal->priority) }}
                </span>
            </div>
            @endforeach
        </div>

        @if($goals->first()->target_percentage)
        <div class="mt-4 pt-4 border-t border-blue-200">
            <p class="font-medium">Meta: <span class="text-blue-700">{{ $goals->first()->target_percentage }}% até {{ $goals->first()->target_year }}</span></p>
        </div>
        @endif
    </div>
    @endif

    <!-- ESG Goals -->
    @if($esgGoals->count() > 0)
    <div class="bg-gradient-to-r from-green-50 to-emerald-50 p-6 rounded-xl border-2 border-green-200">
        <h3 class="font-bold text-lg text-green-800 mb-4 pb-2 border-b border-green-200">Metas ESG</h3>

        <div class="flex flex-wrap gap-2">
            @foreach($esgGoals as $esgGoal)
            <span class="bg-green-200 text-green-800 px-3 py-1 rounded-full text-sm">
                ✓ {{ $esgGoal->title }}
            </span>
            @endforeach
        </div>
    </div>
    @endif

    <!-- AI Preferences -->
    @if($preferences)
    <div class="bg-gradient-to-r from-yellow-50 to-orange-50 p-6 rounded-xl border-2 border-yellow-200">
        <h3 class="font-bold text-lg text-yellow-800 mb-4 pb-2 border-b border-yellow-200">Preferências de Correspondência por IA</h3>

        <div class="space-y-3">
            <div>
                <p class="text-sm font-semibold text-gray-700 mb-2">Ordem de Prioridade:</p>
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
                    <span class="bg-yellow-200 text-yellow-800 px-3 py-1 rounded-full text-sm">
                        {{ $index + 1 }}. {{ $priorityLabels[$item] ?? ucwords(str_replace('_', ' ', $item)) }}
                    </span>
                    @endforeach
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <span class="text-sm text-gray-600">Raio:</span>
                    <span class="ml-2 font-semibold">{{ $preferences->candidate_radius }} km</span>
                </div>
                <div>
                    <span class="text-sm text-gray-600">Remoto:</span>
                    <span class="ml-2 font-semibold">{{ $preferences->include_remote ? 'Ativado ✓' : 'Desativado' }}</span>
                </div>
            </div>

            @if($preferences->talent_sources && count($preferences->talent_sources) > 0)
            <div>
                <p class="text-sm font-semibold text-gray-700 mb-2">Fontes:</p>
                <div class="flex flex-wrap gap-2">
                    @php
                    $sourceLabels = [
                    'universities' => 'Universidades',
                    'bootcamps' => 'Bootcamps',
                    'experienced' => 'Profissionais Experientes',
                    'career_transition' => 'Programas de Transição de Carreira'
                    ];
                    @endphp
                    @foreach($preferences->talent_sources as $source)
                    <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm">
                        {{ $sourceLabels[$source] ?? ucwords(str_replace('_', ' ', $source)) }}
                    </span>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
    @endif
</div>

<!-- Navigation -->
<div class="flex justify-between items-center">
    <a href="{{ route('setup.step4') }}" class="text-gray-600 hover:text-gray-800 font-medium py-3 px-6 rounded-xl border-2 border-gray-300 hover:border-gray-400 transition-all">
        Editar
    </a>
    <form method="POST" action="{{ route('setup.finish') }}">
        @csrf
        <button type="submit" class="bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white font-semibold py-3 px-10 rounded-xl transition-all transform hover:scale-105 shadow-lg">
            Concluir Configuração
        </button>
    </form>
</div>
@endsection