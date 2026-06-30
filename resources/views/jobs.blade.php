<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | SkillFocus</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
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

        /* NAVBAR TOP */
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

        /* CONTEÚDO PRINCIPAL */
        .dash-card {
            background: #ffffff;
            border: none;
            border-radius: 1.5rem;
            box-shadow: 0 10px 30px rgba(74, 20, 140, 0.03);
            padding: 2rem;
            height: 100%;
        }

        /* ESTILO DOS CARDS DE VAGA */
        .job-item-card {
            background-color: #ffffff;
            border: 1px solid #E2E8F0;
            border-radius: 1rem;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .job-item-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.04);
            border-color: var(--accent-color);
        }

        .tag-diversity {
            font-size: 0.75rem;
            background-color: rgba(74, 20, 140, 0.06);
            color: var(--primary-color);
            padding: 0.25rem 0.6rem;
            border-radius: 0.5rem;
            font-weight: 500;
        }

        .clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</head>

<body>
    {{-- visualização básica das vagas publicadas --}}

    <nav class="navbar navbar-expand-lg dash-navbar sticky-top py-3">
        <div class="container">
            <a class="navbar-brand" href="#">Skill<span>Focus</span></a>

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
                        <li><a class="dropdown-item py-2" href="{{url('/dashboard')}}"><i class="bi bi-briefcase-fill me-2 text-muted"></i>Dashboard</a></li>
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
        </div>
    </nav>

    <main class="container my-5">

        <div class="mb-5">
            <h1 class="fw-bold h3" style="color: var(--primary-color);">Painel Corporativo</h1>
            <p class="text-muted">Gerencie e verifique com detalhes todas as suas vagas e oportunidades ativas.</p>
        </div>

        <div class="card dash-card">
            <h3 class="fw-bold h4 mb-4" style="color: var(--primary-color);">
                <i class="bi bi-briefcase me-2" style="color: var(--secondary-color);"></i>Vagas publicadas
            </h3>

            <div class="row g-3">
                @foreach ($jobs as $job)
                <div class="col-12">
                    <div class="job-item-card p-4">
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start gap-3">
                            <div>
                                <h5 class="fw-bold mb-2" style="color: var(--primary-color);">{{ $job->title }}</h5>
                                <p class="text-muted small mb-3 clamp-3">{{ $job->description }}</p>

                                <div class="d-flex flex-wrap gap-2 align-items-center">
                                    <span class="tag-diversity"><i class="bi bi-layer-forward me-1"></i>{{ $job->level }}</span>
                                    <span class="tag-diversity"><i class="bi bi-geo-alt me-1"></i>{{ $job->city }} - {{ $job->district }}</span>
                                    @if(!empty($job->required_skills))
                                    @foreach(json_decode($job->required_skills) as $skill)
                                    <span class="badge text-dark bg-light border fw-normal py-1.5 px-2" style="font-size: 0.75rem; border-radius: 0.5rem;">
                                        {{ $skill }}
                                    </span>
                                    @endforeach
                                    @endif
                                </div>
                            </div>

                            <div class="d-flex gap-2 ms-auto ms-md-0 mt-3 mt-md-0">
                                <a class="btn btn-sm btn-outline-warning px-3 rounded-3" href="/jobs/{{$job->id}}/edit">
                                    <i class="bi bi-pencil me-1"></i> Editar
                                </a>

                                <form action="/jobs/{{$job->id}}/delete" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir esta vaga?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger px-3 rounded-3" type="submit">
                                        <i class="bi bi-trash me-1"></i> Excluir
                                    </button>
                                </form>

                                <a class="btn btn-sm btn-outline-success px-3 rounded-3" href="/match/{{$job->id}}">
                                    <i class="bi bi-person-bounding-box"></i> Matches</i>
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>