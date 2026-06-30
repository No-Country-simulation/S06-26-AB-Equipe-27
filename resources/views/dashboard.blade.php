<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | SkillFocus</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
          integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

    <style>
        /* Paleta de cores base */
        :root {
            --primary-color: #4A148C;
            --secondary-color: #FF6D00;
            --accent-color: #00BFA5;
            --bg-light: #F9F7F6;
            --text-dark: #2B2B2B;
        }

        body {
            background-color: var(--bg-light);
            font-family: 'Inter', sans-serif;
            color: var(--text-dark);
            overflow-x: hidden;
        }

        h1, h2, h3, h4, h5, h6, .btn, .navbar-brand {
            font-family: 'Poppins', sans-serif;
        }

        /* Navbar Top */
        .dash-navbar {
            background-color: #ffffff;
            box-shadow: 0 2px 10px rgba(74, 20, 140, 0.05);
            border-bottom: 2px solid rgba(74, 20, 140, 0.05);
        }

        .navbar-brand {
            font-weight: 700;
            color: var(--primary-color) !important;
        }

        .navbar-brand span {
            color: var(--secondary-color);
        }

        /* Status & Badges */
        .badge-status {
            padding: 0.4rem 0.75rem;
            border-radius: 2rem;
            font-weight: 500;
            font-size: 0.8rem;
        }

        .badge-active {
            background-color: rgba(0, 191, 165, 0.15);
            color: #00796B;
        }

        .tag-diversity {
            font-size: 0.75rem;
            background-color: rgba(74, 20, 140, 0.06);
            color: var(--primary-color);
            padding: 0.2rem 0.6rem;
            border-radius: 0.5rem;
            font-weight: 500;
        }

        /* Customização da barra de progresso */
        .progress-bar-teal {
            background-color: var(--accent-color);
        }

        /* 2. Adicionado: Estilo para delimitar a altura do container do mapa */
        #map-heatmap {
            height: 380px;
            width: 100%;
            z-index: 1; /* Garante que elementos do mapa não fiquem por cima do dropdown da navbar */
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg dash-navbar sticky-top py-3 px-4 mb-5">
        <div class="container-fluid max-w-[1920px] mx-auto flex justify-between items-center">
            <a class="navbar-brand text-2xl" href="#">Skill<span>Focus</span></a>

            <div class="dropdown">
                <a class="text-decoration-none d-flex align-items-center text-dark" href="#" data-bs-toggle="dropdown">
                    <div class="rounded-circle d-flex align-items-center justify-content-center me-2 text-white" style="width: 38px; height: 38px; background-color: var(--primary-color);">
                        <i class="bi bi-person-fill"></i>
                    </div>
                    @auth
                    <span class="d-none d-md-inline fw-medium" style="font-size: 0.95rem;">
                        {{ auth()->user()->name }}
                    </span>
                    @endauth
                </a>

                <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm mt-2">
                    <li><a class="dropdown-item py-2" href="{{url('/dashboard')}}"><i class="bi bi-briefcase-fill me-2 text-muted"></i>Dashboard</a></li>
                    <li><a class="dropdown-item py-2" href="{{url('/jobs/create')}}"><i class="bi bi-plus-circle-fill me-2 text-muted"></i>Criar vaga</a></li>
                    <li><a class="dropdown-item py-2" href="{{url('/jobs')}}"><i class="bi bi-eye-fill me-2 text-muted"></i>Vagas criadas</a></li>
                    <li><a class="dropdown-item py-2" href="{{url('/jobs/reports')}}"><i class="bi bi-clipboard2-fill me-2 text-muted"></i>Relatórios</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item py-2" href="#"><i class="bi bi-gear-wide me-2 text-muted"></i> Configurações</a></li>
                    <li><a class="dropdown-item py-2 text-danGeografiager" href="{{route('logout')}}"><i class="bi bi-box-arrow-right me-2"></i> Sair</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container mx-auto px-4 pb-12 max-w-7xl flex flex-col gap-8">

        @if(!Auth::user()->company || !Auth::user()->company->setup_completed)
        <div class="bg-yellow-50 border-2 border-yellow-400 rounded-2xl p-6 shadow-sm">
            <div class="flex flex-col md:flex-row md:items-center gap-4">
                <div class="flex-shrink-0 flex justify-center">
                    <svg class="w-12 h-12 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <div class="flex-1 text-center md:text-left">
                    <h3 class="text-xl font-bold text-yellow-800 mb-1">Conclua sua configuração!</h3>
                    <p class="text-yellow-700 mb-3 md:mb-0">Termine de configurar suas metas de diversidade e ESG para começar.</p>
                </div>
                <div class="text-center">
                    <a href="{{ route('setup.step1') }}" class="inline-block bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-6 rounded-lg transition-colors w-full md:w-auto">Iniciar Configuração</a>
                </div>
            </div>
        </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <a class="bg-white rounded-2xl shadow-sm p-6 border-2 border-purple-100 hover:border-purple-400 hover:shadow-lg transition-all text-decoration-none" href="{{'/jobs/create'}}">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 bg-purple-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-purple-800 mb-0">Publicar Vaga</h3>
                        <p class="text-gray-500 text-sm mb-0 mt-1">Criar uma nova oferta</p>
                    </div>
                </div>
            </a>

            <div class="bg-white rounded-2xl shadow-sm p-6 border-2 border-blue-100 hover:border-blue-400 hover:shadow-lg transition-all cursor-pointer">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <a href="{{url('/mapa-talentos')}}">
                    <div>
                        <h3 class="text-lg font-bold text-blue-800 mb-0">Mapa de Talentos</h3>
                        <p class="text-gray-500 text-sm mb-0 mt-1">Ver concentração</p>
                    </div>
                    </a>

                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm p-6 border-2 border-green-100 hover:border-green-400 hover:shadow-lg transition-all cursor-pointer">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 bg-green-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                        </svg>
                    </div>
                    <a href="{{url('/jobs/reports')}}">
                    <div>
                        <h3 class="text-lg font-bold text-green-800 mb-0">Relatórios</h3>
                        <p class="text-gray-500 text-sm mb-0 mt-1">Métricas de diversidade</p>
                    </div>
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            <div class="bg-white rounded-2xl shadow-sm hover:shadow-xl p-6 transition-all">
                <div class="bg-gradient-to-br from-purple-500 to-purple-700 rounded-xl p-4 mb-4">
                    <h3 class="text-white font-bold text-lg mb-0">Pontuação de Diversidade</h3>
                </div>
                <div class="text-center pt-2">
                    <p class="text-6xl font-bold text-purple-700 mb-4">85<span class="text-3xl text-gray-400">/100</span></p>
                    <div class="w-full bg-gray-200 rounded-full h-3 mb-2">
                        <div class="bg-gradient-to-r from-purple-500 to-purple-700 h-3 rounded-full" style="width: 85%"></div>
                    </div>
                    <p class="text-sm text-gray-500 fw-medium">Excelente progresso!</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm hover:shadow-xl p-6 transition-all">
                <div class="bg-gradient-to-br from-green-500 to-emerald-700 rounded-xl p-4 mb-4">
                    <h3 class="text-white font-bold text-lg mb-0">Metas ESG</h3>
                </div>
                <div class="space-y-3">
                    @if(Auth::user()->company && Auth::user()->company->esgGoals->count() > 0)
                        @foreach(Auth::user()->company->esgGoals->take(2) as $goal)
                        <div class="p-3 bg-gray-50 border border-gray-100 rounded-lg">
                            <p class="font-semibold text-gray-800 text-sm mb-2">{{ $goal->title }}</p>
                            <div class="flex items-center gap-3">
                                <div class="flex-1 bg-gray-200 rounded-full h-2">
                                    <div class="bg-gradient-to-r from-green-500 to-emerald-500 h-2 rounded-full" style="width: {{ rand(30, 70) }}%"></div>
                                </div>
                                <span class="text-xs font-bold text-gray-600">{{ rand(1, 50) }}%</span>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="text-center py-4">
                            <p class="text-gray-500 text-sm">Nenhuma meta definida ainda</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm hover:shadow-xl p-6 transition-all">
                <div class="bg-gradient-to-br from-blue-500 to-indigo-700 rounded-xl p-4 mb-4">
                    <h3 class="text-white font-bold text-lg mb-0">Prioridades de Diversidade</h3>
                </div>
                <div class="space-y-2">
                    @if(Auth::user()->company && Auth::user()->company->diversityGoals->count() > 0)
                        @php
                            $groupLabels = [
                                'women' => 'Mulheres',
                                'black' => 'Prof. Negros',
                                'indigenous' => 'Prof. Indígenas',
                                'disabled' => 'PCDs',
                                'lgbt' => 'LGBTQIA+',
                                'refugee' => 'Refugiados',
                                'over_50' => 'Sêniores (50+)',
                                'neurodivergent' => 'Neurodivergentes'
                            ];
                            $priorityLabels = [
                                'low' => 'Baixa',
                                'medium' => 'Regular',
                                'high' => 'Alta'
                            ];
                        @endphp
                        @foreach(Auth::user()->company->diversityGoals->take(4) as $goal)
                        <div class="flex items-center justify-between p-2 border-b border-gray-50 last:border-0">
                            <span class="text-gray-800 font-medium text-sm">{{ $groupLabels[$goal->group] ?? ucwords(str_replace('_', ' ', $goal->group)) }}</span>
                            <span class="px-3 py-1 rounded-full text-[10px] font-bold tracking-wider {{ $goal->priority === 'high' ? 'bg-red-100 text-red-700' : ($goal->priority === 'medium' ? 'bg-yellow-100 text-yellow-700' : 'bg-green-100 text-green-700') }}">
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

        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">

            <div class="bg-white rounded-2xl shadow-sm hover:shadow-xl p-6 transition-all lg:col-span-2">
                <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl p-4 mb-4">
                    <h3 class="text-white font-bold text-lg mb-0">Vagas Públicas & Andamentos</h3>
                </div>

                <p class="text-sm text-gray-600 mb-4">Gerencie suas oportunidades e monitore o andamento dos processos seletivos sem vieses.</p>

                <div class="bg-yellow-50/50 rounded-xl p-1 mb-4 border border-yellow-100">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr class="text-muted small" style="font-size: 0.85rem;">
                                    <th scope="col" class="py-3 ps-4 border-0">Cargo</th>
                                    <th scope="col" class="py-3 border-0">Cidade</th>
                                    <th scope="col" class="py-3 border-0">Status</th>
                                    <th scope="col" class="py-3 border-0">Adesão / Match</th>
                                    <th scope="col" class="py-3 text-end pe-4 border-0">Ações</th>
                                </tr>
                            </thead>
                            <tbody class="border-top-0">
                                @foreach($jobs as $job)
                                <tr>
                                    <td class="py-3 ps-4">
                                        <span class="tag-diversity">{{$job->title}}</span>
                                    </td>
                                    <td class="py-3">
                                        <span class="text-sm text-gray-700 fw-medium">{{$job->city}}</span>
                                    </td>
                                    <td>
                                        <span class="badge-status badge-active">Aberto</span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2" style="min-width: 100px;">
                                            <div class="progress w-100 bg-gray-200" style="height: 6px;">
                                                <div class="progress-bar progress-bar-teal rounded-full" style="width: 60%"></div>
                                            </div>
                                            <span class="small text-muted fw-medium">60%</span>
                                        </div>
                                    </td>
                                    <td class="text-end pe-4">
                                        <a href="{{url('/jobs')}}">
                                        <button type="button" class="btn btn-sm btn-light border rounded-lg hover:bg-gray-50" title="Ver Vagas">
                                            <i class="bi bi-eye text-gray-600"></i>
                                        </button>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <a class="block text-center w-full bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-600 hover:to-yellow-700 text-white font-semibold py-3 px-6 rounded-xl transition-all shadow-sm text-decoration-none" href="{{'/dashboard/jobs'}}">
                    Gerenciar Todas as Vagas
                </a>
            </div>

            <div class="bg-white rounded-2xl shadow-sm hover:shadow-xl p-6 transition-all flex flex-col justify-between">
                <div>
                    <div class="bg-gradient-to-br from-orange-500 to-amber-700 rounded-xl p-4 mb-6">
                        <h3 class="text-white font-bold text-lg mb-0 text-center">Recomendação IA</h3>
                    </div>
                    <div class="text-center">
                        <p class="text-5xl font-bold text-orange-600 mb-2">1.248</p>
                        <p class="text-sm text-gray-500 fw-medium mb-6">profissionais com alta compatibilidade</p>

                        <div class="bg-orange-50 rounded-xl p-4 mb-6 border border-orange-100">
                            <p class="text-sm text-gray-700 font-bold mb-3">Principais regiões mapeadas:</p>
                            <div class="flex flex-wrap gap-2 justify-center">
                                <span class="bg-white border border-orange-200 text-orange-800 px-3 py-1.5 rounded-lg text-xs font-semibold shadow-sm">📍 Salvador</span>
                                <span class="bg-white border border-orange-200 text-orange-800 px-3 py-1.5 rounded-lg text-xs font-semibold shadow-sm">📍 Recife</span>
                                <span class="bg-white border border-orange-200 text-orange-800 px-3 py-1.5 rounded-lg text-xs font-semibold shadow-sm">📍 Fortaleza</span>
                            </div>
                        </div>
                    </div>
                </div>

                <button class="w-full bg-gradient-to-r from-orange-500 to-amber-600 hover:from-orange-600 hover:to-amber-700 text-white font-semibold py-3 px-6 rounded-xl transition-all shadow-sm">
                    Analisar Candidatos
                </button>
            </div>

        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.heat/0.2.0/leaflet-heat.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Injeção segura dos dados do Laravel vindo do Controller
            const pointsData = @json($heatPoints ?? []);

            if(pointsData.length > 0) {
                // Inicialização focada no ponto médio padrão (ex: Florianópolis)
                const mapInstance = L.map('map-heatmap').setView([-27.595, -48.556], 12);

                // Camada limpa do OpenStreetMap
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 18,
                    attribution: '&copy; SkillFocus & OpenStreetMap contributors'
                }).addTo(mapInstance);

                // Geração dinâmica do gradiente de calor
                L.heatLayer(pointsData, {
                    radius: 28,
                    blur: 15,
                    maxZoom: 16,
                    max: 0.4,
                    minOpacity: 0.5,
                    gradient: {
                        0.4: 'blue',
                        0.6: 'cyan',
                        0.7: 'lime',
                        0.8: 'yellow',
                        1.0: '#B71C1C'
                    }
                }).addTo(mapInstance);
            }
        });
    </script>
</body>
</html>
