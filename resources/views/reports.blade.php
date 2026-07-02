<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatórios | SkillFocus</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        :root {
            --primary-color: #4A148C;
            --secondary-color: #FF6D00;
            --bg-light: #F9F7F6;
            --text-dark: #2B2B2B;
        }

        body {
            background-color: var(--bg-light);
            font-family: 'Inter', sans-serif;
            color: var(--text-dark);
        }

        h1,
        h2,
        h3,
        h4,
        .navbar-brand {
            font-family: 'Poppins', sans-serif;
        }

        .dash-navbar {
            background-color: #ffffff;
            border-bottom: 2px solid rgba(74, 20, 140, 0.05);
        }

        .navbar-brand {
            font-weight: 700;
            color: var(--primary-color) !important;
        }

        .navbar-brand span {
            color: var(--secondary-color);
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg dash-navbar sticky-top py-3 px-4 mb-5">
        <div class="container-fluid max-w-[1920px] mx-auto flex justify-between items-center">
            <a class="navbar-brand text-2xl" href="{{url('/dashboard')}}">Skill<span>Focus</span></a>

            <div class="d-flex align-items-center ms-auto">
                <div class="dropdown">
                    <a class="text-decoration-none d-flex align-items-center text-dark" href="#" data-bs-toggle="dropdown">
                        <div class="bg-purple text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 38px; height: 38px; background-color: var(--primary-color);">
                            <i class="bi bi-person-fill"></i>
                        </div>
                        @auth
                        <span class="d-none d-md-inline fw-medium" style="font-size: 0.95rem;">
                            {{ auth()->user()->name }}
                        </span>
                        @endauth
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm mt-2">
                        <li><a class="dropdown-item py-2" href="{{route('dashboard')}}"><i class="bi bi-briefcase-fill me-2 text-muted"></i>Dashboard</a></li>
                        <li><a class="dropdown-item py-2" href="{{route('esg-progress.index')}}"><i class="bi bi-bar-chart-fill me-2 text-muted"></i>Progresso ESG</a></li>
                        <li><a class="dropdown-item py-2" href="{{url('/jobs/create')}}"><i class="bi bi-plus-circle-fill me-2 text-muted"></i>Criar vaga</a></li>
                        <li><a class="dropdown-item py-2" href="{{url('/jobs')}}"><i class="bi bi-eye-fill me-2 text-muted"></i>Vagas criadas</a></li>
                        <li><a class="dropdown-item py-2" href="{{url('/jobs/reports')}}"><i class="bi bi-clipboard2-fill me-2 text-muted"></i>Relatórios</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item py-2 text-danger" href="{{route('logout')}}"><i class="bi bi-box-arrow-right me-2"></i> Sair</a></li>
                    </ul>
                </div>
            </div>
            <a href="{{url('/dashboard')}}" class="btn btn-sm btn-outline-primary rounded-lg">
                <i class="bi bi-arrow-left me-1"></i> Voltar ao Dashboard
            </a>
        </div>
    </nav>

    <main class="container mx-auto px-4 pb-12 max-w-7xl flex flex-col gap-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-purple-900 mb-2">Relatórios Analíticos de Diversidade</h1>
                <p class="text-gray-600">Acompanhamento detalhado do impacto de inclusão e metas ESG em tempo real.</p>
            </div>
            <a href="{{ route('reports.download-pdf') }}" class="bg-purple-600 hover:bg-purple-700 text-white font-semibold py-2 px-6 rounded-xl flex items-center gap-2 transition-all">
                <i class="bi bi-file-earmark-pdf"></i> Baixar PDF
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white rounded-2xl shadow-sm p-6">
                <div class="bg-gradient-to-br from-purple-500 to-purple-700 rounded-xl p-4 mb-4">
                    <h3 class="text-white font-bold text-lg mb-0">Pontuação de Diversidade</h3>
                </div>
                <div class="text-center pt-2">
                    <p class="text-6xl font-bold text-purple-700 mb-4">{{ $diversityScore ?? 0 }}<span class="text-3xl text-gray-400">/100</span></p>
                    <div class="w-full bg-gray-200 rounded-full h-3 mb-2">
                        <div class="bg-gradient-to-r from-purple-500 to-purple-700 h-3 rounded-full" style="width: {{ $diversityScore ?? 0 }}%"></div>
                    </div>
                    <p class="text-sm text-gray-500 fw-medium">Atualizado em tempo real</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm p-6">
                <div class="bg-gradient-to-br from-green-500 to-emerald-700 rounded-xl p-4 mb-4">
                    <h3 class="text-white font-bold text-lg mb-0">Metas ESG</h3>
                </div>
                <div class="space-y-3 overflow-scroll max-h-[250px]">
                    @if($esgGoals->count() > 0)
                    @foreach($esgGoals as $goal)
                    <div class="p-3 bg-gray-50 border border-gray-100 rounded-lg">
                        <p class="font-semibold text-gray-800 text-sm mb-2">{{ $goal->title }}</p>
                        @if($goal->tracking_type === 'percentage')
                        @php
                        $percentage = min($goal->current_value ?? 0, 100);
                        @endphp
                        <div class="flex items-center gap-3">
                            <div class="flex-1 bg-gray-200 rounded-full h-2">
                                <div class="bg-gradient-to-r from-green-500 to-emerald-500 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                            </div>
                            <span class="text-xs font-bold text-gray-600">{{ $percentage }}%</span>
                        </div>
                        @elseif($goal->tracking_type === 'count')
                        @php
                        $target = $goal->target_value ?? 1;
                        $current = $goal->current_value ?? 0;
                        $percentage = min(100, ($current / $target) * 100);
                        @endphp
                        <div class="space-y-1">
                            <div class="flex items-center gap-3">
                                <div class="flex-1 bg-gray-200 rounded-full h-2">
                                    <div class="bg-gradient-to-r from-green-500 to-emerald-500 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                                </div>
                                <span class="text-xs font-bold text-gray-600">{{ $current }}/{{ $target }}</span>
                            </div>
                        </div>
                        @elseif($goal->tracking_type === 'status')
                        @php
                        $statusLabel = [
                        'not_started' => 'Não Iniciado',
                        'in_progress' => 'Em Andamento',
                        'completed' => 'Concluído',
                        ];
                        $statusBadge = [
                        'not_started' => 'bg-gray-200 text-gray-700',
                        'in_progress' => 'bg-blue-200 text-blue-700',
                        'completed' => 'bg-green-200 text-green-700',
                        ];
                        @endphp
                        <span class="px-3 py-1 rounded-full text-xs font-bold {{ $statusBadge[$goal->status] ?? 'bg-gray-200 text-gray-700' }}">
                            {{ $statusLabel[$goal->status] ?? 'Desconhecido' }}
                        </span>
                        @endif
                    </div>
                    @endforeach
                    @else
                    <div class="text-center py-4">
                        <p class="text-gray-500 text-sm">Nenhuma meta definida ainda</p>
                    </div>
                    @endif
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm p-6">
                <div class="bg-gradient-to-br from-blue-500 to-indigo-700 rounded-xl p-4 mb-4">
                    <h3 class="text-white font-bold text-lg mb-0">Prioridades de Diversidade</h3>
                </div>
                <div class="space-y-2 overflow-scroll max-h-[250px]">
                    @if($diversityGoals->count() > 0)
                    @php
                    $groupLabels = [
                    'women' => 'Mulheres',
                    'black' => 'Prof. Negros',
                    'indigenous' => 'Prof. Indígenas',
                    'disabled' => 'PCDs',
                    'lgbt' => 'LGBTQIAP++',
                    'refugee' => 'Refugiados',
                    'over_50' => 'Sêniores (50+)',
                    'neurodivergent' => 'Neurodivergentes'
                    ];
                    $priorityLabels = [
                    'low' => 'BAIXA',
                    'medium' => 'MÉDIA',
                    'high' => 'ALTA'
                    ];
                    $priorityBadges = [
                    'low' => 'bg-green-100 text-green-700',
                    'medium' => 'bg-yellow-100 text-yellow-700',
                    'high' => 'bg-red-100 text-red-700'
                    ];
                    @endphp
                    @foreach($diversityGoals as $goal)
                    <div class="flex items-center justify-between p-2 border-b border-gray-50 last:border-0">
                        <span class="text-gray-800 font-medium text-sm">{{ $groupLabels[$goal->group] ?? ucwords(str_replace('_', ' ', $goal->group)) }}</span>
                        <span class="px-3 py-1 rounded-full text-[10px] font-bold tracking-wider {{ $priorityBadges[$goal->priority] ?? 'bg-gray-100 text-gray-700' }}">
                            {{ strtoupper($priorityLabels[$goal->priority] ?? $goal->priority) }}
                        </span>
                    </div>
                    @endforeach
                    @else
                    <div class="text-center py-4">
                        <p class="text-gray-500 text-sm">Nenhuma prioridade definida</p>
                    </div>
                    @endif
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm p-6 flex flex-col justify-between">
                <div>
                    <div class="bg-gradient-to-br from-orange-500 to-amber-700 rounded-xl p-4 mb-6">
                        <h3 class="text-white font-bold text-lg mb-0 text-center">Recomendação IA</h3>
                    </div>
                    <div class="text-center">
                        <p class="text-6xl font-bold text-orange-600 mb-4">{{ $highScoreMatchings }}</p>
                        <p class="text-sm text-gray-500 fw-medium mb-6">profissionais com alta compatibilidade</p>

                        <div class="bg-orange-50 rounded-xl p-4 mb-6 border border-orange-100">
                            <p class="text-sm text-gray-700 font-bold mb-3">Principais regiões mapeadas:</p>
                            <div class="flex flex-wrap gap-2 justify-center">
                                @foreach($topRegions as $region)
                                <span class="bg-white border border-orange-200 text-orange-800 px-3 py-1.5 rounded-lg text-xs font-semibold shadow-sm">📍 {{ $region }}</span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <a href="{{ route('dashboard') }}" class="w-full text-center bg-gradient-to-r from-orange-500 to-amber-600 hover:from-orange-600 hover:to-amber-700 text-white font-semibold py-2 px-4 rounded-xl transition-all shadow-sm">
                    Analisar Candidatos
                </a>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>