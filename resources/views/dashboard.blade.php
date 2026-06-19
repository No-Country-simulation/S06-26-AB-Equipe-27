<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

        h1, h2, h3, h4, h5, h6, .btn, .navbar-brand {
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
        .form-control, .form-select {
            border-radius: 0.75rem;
            padding: 0.65rem 1rem;
            border: 1px solid #E2E8F0;
            background-color: #FAFAFA;
        }

        .form-control:focus, .form-select:focus {
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

        .badge-active { background-color: rgba(0, 191, 165, 0.15); color: #00796B; }
        .badge-progress { background-color: rgba(255, 109, 0, 0.15); color: #E65100; }

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
<body>

<!-- Navbar Top. -->
<nav class="navbar navbar-expand-lg dash-navbar sticky-top py-3">
    <div class="container">
        <a class="navbar-brand" href="#">Skill<span>Focus</span></a>

        <div class="d-flex align-items-center ms-auto">
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
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item py-2" href="#"><i class="bi bi-gear-wide me-2 text-muted"></i> Configurações</a></li>
                    <li><a class="dropdown-item py-2 text-danger" href="{{route('logout')}}"><i class="bi bi-box-arrow-right me-2"></i> Sair</a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<!-- Container Dashboard. -->
<main class="container my-5">

    <!-- Texto inicial -->
    <div class="mb-4">
        <div class="">
            <h1 class="fw-bold h3" style="color: var(--primary-color);">Olá, Equipe de Atração e Seleção</h1>
            <p class="text-muted">Gerencie suas oportunidades e monitore o andamento dos processos seletivos sem vieses.</p>
        </div>
    </div>
    <div class="row g-4">

        <div class="col-lg-12">
            <div class="card dash-card">
                <h3 class="card-title-dash">
                    <i class="bi bi-columns-gap text-muted"></i> Vagas Publicadas & Andamentos
                </h3>

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
                                        <span class="tag-diversity">{{$job->city}}</span>
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

                                <!-- Ver candidatos. -->
                                <td class="text-end pe-3">
                                    <button type="button" class="btn btn-sm btn-light border" title="Ver candidatos">
                                        <i class="bi bi-eye text-muted"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</main>

<!-- Bootstrap 5.3 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
