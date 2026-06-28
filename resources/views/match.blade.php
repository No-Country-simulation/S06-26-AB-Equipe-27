<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Matches | SkillFocus</title>

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

        .dash-card {
            background: #ffffff;
            border: none;
            border-radius: 1.5rem;
            box-shadow: 0 10px 30px rgba(74, 20, 140, 0.03);
            padding: 2rem;
            height: 100%;
        }

        .match-item-card {
            background-color: #ffffff;
            border: 1px solid #E2E8F0;
            border-radius: 1rem;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .match-item-card:hover {
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

        .tag-score {
            font-size: 0.75rem;
            background-color: rgba(0, 191, 165, 0.1);
            color: var(--accent-color);
            padding: 0.25rem 0.6rem;
            border-radius: 0.5rem;
            font-weight: 600;
        }

        .tag-badge {
            font-size: 0.75rem;
            background-color: rgba(255, 109, 0, 0.1);
            color: var(--secondary-color);
            padding: 0.25rem 0.6rem;
            border-radius: 0.5rem;
            font-weight: 600;
        }

        .bg-color {
            background:#4A148C;
        }

        .clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .clamp-IA {
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

    </style>
</head>


<body>
    <nav class="navbar navbar-expand-lg dash-navbar sticky-top py-3 mb-5">
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
            <h1 class="fw-bold h3" style="color: var(--primary-color);">{{ $job->title }}</h1>
            <p class="text-muted clamp-3">{{ $job->description }}</p>
        </div>

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <div class="card dash-card shadow-sm border-0 rounded-4 p-3">
            <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
                <h3 class="fw-bold h4 mb-0" style="color: var(--primary-color);">
                    <i class="bi bi-people-fill me-2" style="color: var(--secondary-color);"></i>Matches de Candidatos
                </h3>
                <form action="{{ route('match.generate', $job->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary rounded-pill px-4" style="background-color: var(--primary-color); border: none;">
                        <i class="bi bi-lightning-charge-fill me-2"></i>Gerar Matches
                    </button>
                </form>
            </div>

            @if($matches->isEmpty())
            <div class="text-center py-5">
                <i class="bi bi-search display-1 text-muted mb-3 opacity-50"></i>
                <p class="text-muted lead">Nenhum match encontrado. Clique em "Gerar Matches" para acionar a IA!</p>
            </div>
            @else
            <div class="row g-4">
                @foreach ($matches as $match)
                <div class="col-12">
                    <div class="match-item-card p-4 rounded-4 border {{ $match->status === 'selecionado' ? 'border-success bg-light' : '' }} hover-shadow transition" style="transition: all 0.3s ease;">
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-4">

                            <div class="flex-grow-1 w-100">
                                <div class="d-flex flex-wrap gap-2 align-items-center mb-2">
                                    <h5 class="fw-bold mb-0 me-2" style="color: var(--primary-color);">Candidato Mascarado #{{ $match->id }}</h5>

                                    <span class="badge bg-color text-white rounded-pill px-3 py-2"><i class="bi bi-star-fill me-1"></i>{{ $match->score_match }}% Match</span>
                                    <span class="badge bg-info text-dark rounded-pill px-3 py-2"><i class="bi bi-award-fill me-1"></i>{{ $match->badge_diversidade }}</span>
                                </div>

                                <p class="text-muted small mb-2 fw-medium">
                                    <i class="bi bi-briefcase me-1"></i> Nível: {{ $match->seniority }}
                                </p>

                                <p class="small mb-3 text-secondary border-start border-3 ps-3 py-1 bg-light rounded-end">
                                    {{ $match->recomendacao }}
                                </p>

                                <div class="d-flex flex-wrap gap-2 align-items-center mt-3">
                                    <span class="text-muted small me-1">Skills:</span>
                                    @if(!empty($match->skills))
                                        @foreach($match->skills as $skill)
                                        <span class="badge text-dark bg-white border fw-normal py-1 px-2 shadow-sm" style="font-size: 0.75rem; border-radius: 0.5rem;">
                                            {{ $skill }}
                                        </span>
                                        @endforeach
                                    @else
                                        <span class="text-muted small">Nenhuma skill mapeada.</span>
                                    @endif
                                </div>
                            </div>

                            <div class="d-flex flex-column align-items-md-end min-vw-25 border-md-start ps-md-4 mt-3 mt-md-0 w-100 w-md-auto text-center text-md-end">

                                @if($match->status === 'pendente')
                                    <form action="{{ route('match.select', $match->id) }}" method="POST" class="w-100">
                                        @csrf
                                        <button type="submit" class="btn btn-success rounded-pill px-4 py-2 fw-bold shadow-sm w-100">
                                            <i class="bi bi-person-fill-add me-2"></i> Selecionar Candidato
                                        </button>
                                    </form>
                                    <p class="text-muted small mt-2 mb-0" style="font-size: 0.75rem;">
                                        O candidato será notificado <br class="d-none d-md-block">sobre seu interesse.
                                    </p>
                                @else
                                    <div class="d-flex flex-column align-items-center align-items-md-end">
                                        <span class="badge bg-success py-2 px-3 rounded-pill text-white shadow-sm fs-6">
                                            <i class="bi bi-check-all me-1"></i> Candidato Notificado
                                        </span>
                                        <p class="text-success small mt-2 mb-0 fw-medium">
                                            Aguardando retorno do candidato.
                                        </p>
                                    </div>
                                @endif

                            </div>

                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
