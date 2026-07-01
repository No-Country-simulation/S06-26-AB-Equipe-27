<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | SkillFocus</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

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

        /* Container do Mapa */
        #map-heatmap {
            height: 600px;
            width: 100%;
            z-index: 1;
        }

        /* Estilos da Imagem de Destaque */
        .img-box {
            height: 380px;
            overflow: hidden;
            border-radius: 1.5rem;
            box-shadow: 0 20px 40px rgba(0,0,0,0.08);
            position: relative;
        }

        .img-box::after {
            content: '';
            position: absolute;
            inset: 0;
            border: 4px solid var(--accent-color);
            border-radius: 1.5rem;
            pointer-events: none;
            opacity: 0.5;
        }

        .img-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .img-box:hover img {
            transform: scale(1.03);
        }

        /* Tipografia de Sessões */
        .section-title {
            color: var(--primary-color);
            font-weight: 700;
            font-size: 2.5rem;
            margin-bottom: 1.2rem;
            letter-spacing: -0.5px;
        }

        .subtitle-badge {
            color: var(--secondary-color);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            font-size: 0.9rem;
            display: block;
            margin-bottom: 0.5rem;
        }

        .section-text {
            color: #555555;
            font-size: 1.15rem;
            line-height: 1.7;
            margin-bottom: 2rem;
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
                    <li><a class="dropdown-item py-2" href="{{ url('/dashboard') }}"><i class="bi bi-briefcase-fill me-2 text-muted"></i>Dashboard</a></li>
                    <li><a class="dropdown-item py-2" href="{{ url('/jobs/create') }}"><i class="bi bi-plus-circle-fill me-2 text-muted"></i>Criar vaga</a></li>
                    <li><a class="dropdown-item py-2" href="{{ url('/jobs') }}"><i class="bi bi-eye-fill me-2 text-muted"></i>Vagas criadas</a></li>
                    <li><a class="dropdown-item py-2" href="{{ url('/jobs/reports') }}"><i class="bi bi-clipboard2-fill me-2 text-muted"></i>Relatórios</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item py-2" href="#"><i class="bi bi-gear-wide me-2 text-muted"></i> Configurações</a></li>
                    <li><a class="dropdown-item py-2 text-danger" href="{{ route('logout') }}"><i class="bi bi-box-arrow-right me-2"></i> Sair</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container mx-auto px-4 pb-12 max-w-7xl flex flex-col gap-8">

        <div class="mb-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <a class="bg-white rounded-2xl shadow-sm p-6 border-2 border-purple-100 hover:border-purple-400 hover:shadow-lg transition-all text-decoration-none block" href="{{ url('/jobs/create') }}">
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

                <a class="bg-white rounded-2xl shadow-sm p-6 border-2 border-blue-100 hover:border-blue-400 hover:shadow-lg transition-all text-decoration-none block" href="{{ url('/dashboard') }}">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="27" height="27" fill="#1E40AF" class="bi bi-speedometer" viewBox="0 0 16 16">
                                <path d="M8 2a.5.5 0 0 1 .5.5V4a.5.5 0 0 1-1 0V2.5A.5.5 0 0 1 8 2M3.732 3.732a.5.5 0 0 1 .707 0l.915.914a.5.5 0 1 1-.708.708l-.914-.915a.5.5 0 0 1 0-.707M2 8a.5.5 0 0 1 .5-.5h1.586a.5.5 0 0 1 0 1H2.5A.5.5 0 0 1 2 8m9.5 0a.5.5 0 0 1 .5-.5h1.5a.5.5 0 0 1 0 1H12a.5.5 0 0 1-.5-.5m.754-4.246a.39.39 0 0 0-.527-.02L7.547 7.31A.91.91 0 1 0 8.85 8.569l3.434-4.297a.39.39 0 0 0-.029-.518z"/>
                                <path fill-rule="evenodd" d="M6.664 15.889A8 8 0 1 1 9.336.11a8 8 0 0 1-2.672 15.78zm-4.665-4.283A11.95 11.95 0 0 1 8 10c2.186 0 4.236.585 6.001 1.606a7 7 0 1 0-12.002 0"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-blue-800 mb-0">Dashboard</h3>
                            <p class="text-gray-500 text-sm mb-0 mt-1">Tela inicial</p>
                        </div>
                    </div>
                </a>

                <a class="bg-white rounded-2xl shadow-sm p-6 border-2 border-green-100 hover:border-green-400 hover:shadow-lg transition-all text-decoration-none block" href="{{ url('/jobs/reports') }}">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 bg-green-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-green-800 mb-0">Relatórios</h3>
                            <p class="text-gray-500 text-sm mb-0 mt-1">Métricas de diversidade</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <div class="container px-0">
            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <h3 class="text-xl font-bold text-purple-900 mb-0">Concentração Geográfica de Talentos Mapeados</h3>
                        <p class="text-sm text-gray-500 mb-0 mt-1">Visualização em tempo real das conexões geradas pela SkillFocus</p>
                    </div>
                    <span class="bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs font-semibold px-3 py-1 rounded-full d-flex align-items-center gap-1">
                        <i class="bi bi-lightning-charge-fill"></i> Mapa de alta performance
                    </span>
                </div>
                <div id="map-heatmap" class="rounded-xl border border-gray-200 shadow-inner"></div>
            </div>
        </div>

        <div class="container bg-white rounded-2xl shadow-sm p-6 border border-gray-100 mt-4 mb-5">
            <div class="row align-items-center g-5">
                <div class="col-12 col-lg-6">
                    <span class="subtitle-badge">Saiba onde encontrar</span>
                    <h2 class="section-title">
                        Geografia da Inclusão
                    </h2>
                    <p class="section-text" style="line-height: 1.6;">
                        Mais do que um indicador visual, este mapa reflete nosso compromisso prático com a Diversidade
                        e Inclusão.
                    </p>
                </div>

                <div class="col-12 col-lg-6 d-none d-lg-block">
                    <div class="img-box w-100">
                        <img src="https://cdn.pixabay.com/photo/2018/03/10/12/00/teamwork-3213924_1280.jpg" alt="Trabalho em equipe diversificado">
                    </div>
                </div>
            </div>
        </div>

    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
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
