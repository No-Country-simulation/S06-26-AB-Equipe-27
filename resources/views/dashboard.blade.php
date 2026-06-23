<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Dashboard | SkillFocus</title>

    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts: Poppins e Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        /* Paleta de cores base. */
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
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        .btn,
        .navbar-brand {
            font-family: 'Poppins', sans-serif;
        }

        /* Navbar top. */
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

        /* Cards de métricas. */
        .metric-card {
            background: #ffffff;
            border: none;
            border-radius: 1.25rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
            transition: transform 0.2s ease;
        }

        .metric-card:hover {
            transform: translateY(-3px);
        }

        .icon-circle {
            width: 50px;
            height: 50px;
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        /* Conteúdo principal. */
        .dash-card {
            background: #ffffff;
            border: none;
            border-radius: 1.5rem;
            box-shadow: 0 10px 30px rgba(74, 20, 140, 0.03);
            padding: 2rem;
            height: 100%;
        }

        .card-title-dash {
            color: var(--primary-color);
            font-weight: 700;
            font-size: 1.25rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* Estilo dos Inputs */
        .form-control,
        .form-select {
            border-radius: 0.75rem;
            padding: 0.65rem 1rem;
            border: 1px solid #E2E8F0;
            background-color: #FAFAFA;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--accent-color);
            background-color: #ffffff;
            box-shadow: 0 0 0 0.25rem rgba(0, 191, 165, 0.12);
        }

        /* Botões */
        .btn-publish {
            background-color: var(--primary-color);
            color: white;
            font-weight: 600;
            border-radius: 0.75rem;
            padding: 0.75rem 1.5rem;
            border: none;
            transition: all 0.3s ease;
        }

        .btn-publish:hover {
            background-color: var(--secondary-color);
            color: white;
            box-shadow: 0 5px 15px rgba(255, 109, 0, 0.3);
        }

        /* Status */
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

        .badge-progress {
            background-color: rgba(255, 109, 0, 0.15);
            color: #E65100;
        }

        .tag-diversity {
            font-size: 0.75rem;
            background-color: rgba(74, 20, 140, 0.06);
            color: var(--primary-color);
            padding: 0.2rem 0.6rem;
            border-radius: 0.5rem;
            font-weight: 500;
        }

        .btn-submit {
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 0.75rem;
            padding: 0.85rem;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .btn-submit:hover {
            background-color: var(--secondary-color);
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 5px 15px rgba(255, 109, 0, 0.25);
        }
    </style>
</head>

<!-- Navbar Top. -->
<nav class="navbar navbar-expand-lg dash-navbar sticky-top py-3 justify-between p-4 w-full rounded-2xl">
    <a class="navbar-brand" href="#">Skill<span>Focus</span></a>
    <div class="dropdown">
        <!-- Imagem do usuário. -->
        <a class="text-decoration-none d-flex align-items-center text-dark" href="#" data-bs-toggle="dropdown">
            <div class="bg-purple text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 38px; height: 38px; background-color: var(--primary-color);">
                <i class="bi bi-person-fill"></i>
            </div>
            @auth
            <!-- Nome do usuário. -->
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
            <li>
                <hr class="dropdown-divider">
            </li>
            <li><a class="dropdown-item py-2" href="#"><i class="bi bi-gear-wide me-2 text-muted"></i> Configurações</a></li>
            <li><a class="dropdown-item py-2 text-danger" href="{{route('logout')}}"><i class="bi bi-box-arrow-right me-2"></i> Sair</a></li>
        </ul>
    </div>
</nav>

<main class="m-auto my-5 w-10/12 m-w-[1920px] flex-col">
    <div class="d-flex align-items-center ms-auto flex-col">
        <div class="d-flex align-items-center ms-auto flex-col">
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


                <!-- Jobs -->
                <div class="bg-white rounded-2xl shadow-xl p-6 transform hover:scale-105 transition-transform">
                    <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl p-4 mb-4">
                        <h3 class="text-white font-bold text-center text-lg">Vagas Públicas & Andamentos</h3>
                    </div>
                    <div class="text-center">
                        <p class="text-sm text-gray-600 mb-4">Gerencie suas oportunidades e monitore o andamento dos processos seletivos sem vieses.</p>
                        <div class="bg-yellow-50 rounded-lg p-3 mb-4">
                            <p class="text-sm text-gray-700 font-medium">Vagas Publicadas & Andamentos</p>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr class="text-muted small" style="font-size: 0.85rem;">
                                            <th scope="col" class="py-3 ps-3">Cargo</th>
                                            <th scope="col" class="py-3">Cidade</th>
                                            <th scope="col" class="py-3">Status</th>
                                            <th scope="col" class="py-3">Adesão / Match</th>
                                            <th scope="col" class="py-3 text-end pe-3">Ver Candidatos</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Laço para percorrer banco de dados. -->
                                        @foreach($jobs as $job)
                                        <!-- Título. -->
                                        <tr>
                                            <td class="py-3 ps-3">
                                                <div class="d-flex gap-1 flex-wrap">
                                                    <span class="tag-diversity">{{$job->title}}</span>
                                                </div>
                                            </td>

                                            <!-- Cidade. -->
                                            <td class="py-3 ps-3 ">
                                                <div class="d-flex gap-1 flex-wrap"">
                                        <span class=" tag-diversity">{{$job->city}}</span>
                                                </div>
                                            </td>

                                            <!-- Status. -->
                                            <td>
                                                <span class="badge-status badge-active">Aberto</span>
                                            </td>

                                            <!-- Progresso/match. -->
                                            <td>
                                                <div class="d-flex align-items-center gap-2" style="width: 130px;">
                                                    <div class="progress w-100">
                                                        <div class="progress-bar progress-bar-teal" style="width: 60%"></div>
                                                    </div>
                                                    <span class="small text-muted fw-mediu">60%</span>
                                                </div>
                                            </td>

                                            <!-- Ver Vagas. -->
                                            <td class="text-end pe-3">
                                                <button type="button" class="btn btn-sm btn-light border" title="Ver Vagas">
                                                    <i class="bi bi-eye text-muted"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <a class="block w-full w-full bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-600 hover:to-yellow-700 text-white font-semibold py-3 px-6 rounded-lg transition-all transform hover:scale-105" href="{{'/dashboard/jobs'}}">
                            Gerenciar Vagas
                        </a>
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
                <a class="bg-white rounded-2xl shadow-lg p-6 border-2 border-purple-200 hover:border-purple-400 transition-all cursor-pointer" href="{{'/jobs/create'}}">
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
                </a>

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
</main>

<!-- Bootstrap 5.3 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>