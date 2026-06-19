<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SkillFocus - Painel</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-br from-purple-50 via-blue-50 to-indigo-50 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="max-w-6xl mx-auto mb-8">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-4xl font-bold text-purple-800">SkillFocus</h1>
                    <p class="text-gray-600">Plataforma de Inteligência de Diversidade & ESG</p>
                </div>
                <div class="flex items-center gap-4">
                    <span class="text-gray-700">Bem-vindo(a), {{ Auth::user()->name }}</span>
                    <a href="{{ route('logout') }}" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg font-medium transition-colors">Sair</a>
                </div>
            </div>

            <!-- Check if setup is completed -->
            @if(!Auth::user()->company || !Auth::user()->company->setup_completed)
            <div class="bg-yellow-50 border-2 border-yellow-400 rounded-2xl p-6 mb-8">
                <div class="flex items-center gap-4">
                    <div class="flex-shrink-0">
                        <svg class="w-12 h-12 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-xl font-bold text-yellow-800 mb-1">Conclua sua configuração!</h3>
                        <p class="text-yellow-700 mb-3">Termine de configurar suas metas de diversidade e ESG para começar.</p>
                        <a href="{{ route('setup.step1') }}" class="inline-block bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-6 rounded-lg transition-colors">Iniciar Configuração</a>
                    </div>
                </div>
            </div>
            @endif

            <!-- Dashboard Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Diversity Score -->
                <div class="bg-white rounded-2xl shadow-xl p-6 transform hover:scale-105 transition-transform">
                    <div class="bg-gradient-to-br from-purple-500 to-purple-700 rounded-xl p-4 mb-4">
                        <h3 class="text-white font-bold text-lg">Pontuação de Diversidade</h3>
                    </div>
                    <div class="text-center">
                        <p class="text-6xl font-bold text-purple-700 mb-4">85<span class="text-3xl text-gray-400">/100</span></p>
                        <div class="w-full bg-gray-200 rounded-full h-4 mb-2">
                            <div class="bg-gradient-to-r from-purple-500 to-purple-700 h-4 rounded-full" style="width: 85%"></div>
                        </div>
                        <p class="text-sm text-gray-500">Excelente progresso!</p>
                    </div>
                </div>

                <!-- ESG Goals -->
                <div class="bg-white rounded-2xl shadow-xl p-6 transform hover:scale-105 transition-transform">
                    <div class="bg-gradient-to-br from-green-500 to-emerald-700 rounded-xl p-4 mb-4">
                        <h3 class="text-white font-bold text-lg">Metas ESG</h3>
                    </div>
                    <div class="space-y-4">
                        @if(Auth::user()->company && Auth::user()->company->esgGoals->count() > 0)
                        @foreach(Auth::user()->company->esgGoals->take(2) as $goal)
                        <div class="p-3 bg-gray-50 rounded-lg">
                            <p class="font-medium text-gray-800 text-sm">{{ $goal->title }}</p>
                            <div class="flex items-center gap-2 mt-2">
                                <div class="flex-1 bg-gray-200 rounded-full h-2">
                                    <div class="bg-gradient-to-r from-green-500 to-emerald-500 h-2 rounded-full" style="width: {{ rand(30, 70) }}%"></div>
                                </div>
                                <span class="text-xs font-semibold text-gray-600">{{ rand(1, 50) }}%</span>
                            </div>
                        </div>
                        @endforeach
                        @else
                        <p class="text-gray-500 text-sm">Nenhuma meta definida ainda</p>
                        @endif
                    </div>
                </div>

                <!-- Diversity Priorities -->
                <div class="bg-white rounded-2xl shadow-xl p-6 transform hover:scale-105 transition-transform">
                    <div class="bg-gradient-to-br from-blue-500 to-indigo-700 rounded-xl p-4 mb-4">
                        <h3 class="text-white font-bold text-lg">Prioridades de Diversidade</h3>
                    </div>
                    <div class="space-y-2">
                        @if(Auth::user()->company && Auth::user()->company->diversityGoals->count() > 0)
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
                        @foreach(Auth::user()->company->diversityGoals as $goal)
                        <div class="flex items-center justify-between p-2">
                            <span class="text-gray-800 font-medium">{{ $groupLabels[$goal->group] ?? ucwords(str_replace('_', ' ', $goal->group)) }}</span>
                            <span class="px-3 py-1 rounded-full text-xs font-bold {{ $goal->priority === 'high' ? 'bg-red-100 text-red-700' : ($goal->priority === 'medium' ? 'bg-yellow-100 text-yellow-700' : 'bg-green-100 text-green-700') }}">{{ strtoupper($priorityLabels[$goal->priority] ?? $goal->priority) }}</span>
                        </div>
                        @endforeach
                        @else
                        <p class="text-gray-500 text-sm">Nenhuma prioridade definida</p>
                        @endif
                    </div>
                </div>

                <!-- AI Recommendation -->
                <div class="bg-white rounded-2xl shadow-xl p-6 transform hover:scale-105 transition-transform">
                    <div class="bg-gradient-to-br from-orange-500 to-amber-700 rounded-xl p-4 mb-4">
                        <h3 class="text-white font-bold text-lg">Recomendação IA</h3>
                    </div>
                    <div class="text-center">
                        <p class="text-3xl font-bold text-orange-700 mb-4">1,248</p>
                        <p class="text-sm text-gray-600 mb-4">profissionais correspondentes</p>
                        <div class="bg-orange-50 rounded-lg p-3 mb-4">
                            <p class="text-sm text-gray-700 font-medium">Principais regiões:</p>
                            <div class="flex flex-wrap gap-2 mt-2 justify-center">
                                <span class="bg-orange-200 text-orange-800 px-3 py-1 rounded-full text-xs">Salvador</span>
                                <span class="bg-orange-200 text-orange-800 px-3 py-1 rounded-full text-xs">Recife</span>
                                <span class="bg-orange-200 text-orange-800 px-3 py-1 rounded-full text-xs">Fortaleza</span>
                            </div>
                        </div>
                        <button class="w-full bg-gradient-to-r from-orange-500 to-amber-600 hover:from-orange-600 hover:to-amber-700 text-white font-semibold py-3 px-6 rounded-lg transition-all transform hover:scale-105">
                            Ver Candidatos
                        </button>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white rounded-2xl shadow-lg p-6 border-2 border-purple-200 hover:border-purple-400 transition-all cursor-pointer">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-16 h-16 bg-purple-100 rounded-xl flex items-center justify-center">
                            <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-purple-800">Publicar Vaga</h3>
                            <p class="text-gray-600">Criar uma nova oferta de emprego</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-lg p-6 border-2 border-blue-200 hover:border-blue-400 transition-all cursor-pointer">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-16 h-16 bg-blue-100 rounded-xl flex items-center justify-center">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-blue-800">Mapa de Talentos</h3>
                            <p class="text-gray-600">Ver concentração de talentos</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-lg p-6 border-2 border-green-200 hover:border-green-400 transition-all cursor-pointer">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-16 h-16 bg-green-100 rounded-xl flex items-center justify-center">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-green-800">Relatórios</h3>
                            <p class="text-gray-600">Ver métricas de diversidade</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>