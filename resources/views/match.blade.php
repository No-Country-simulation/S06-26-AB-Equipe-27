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
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg dash-navbar sticky-top py-3">
        <div class="container">
            <a class="navbar-brand" href="{{url('/dashboard')}}">Skill<span>Focus</span></a>

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
                        <li><a class="dropdown-item py-2" href="{{url('/jobs')}}"><i class="bi bi-eye-fill me-2 text-muted"></i>Vagas</a></li>
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
            <p class="text-muted">{{ $job->description }}</p>
        </div>

        <div class="card dash-card">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold h4 mb-0" style="color: var(--primary-color);">
                    <i class="bi bi-people-fill me-2" style="color: var(--secondary-color);"></i>Matches de Candidatos
                </h3>
                <form action="{{ route('match.generate', $job->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary" style="background-color: var(--primary-color); border: none;">
                        <i class="bi bi-lightning-charge-fill me-2"></i>Gerar Matches
                    </button>
                </form>
            </div>

            @if($matches->isEmpty())
            <div class="text-center py-5">
                <i class="bi bi-search display-1 text-muted mb-3"></i>
                <p class="text-muted">Nenhum match encontrado. Clique em "Gerar Matches" para começar!</p>
            </div>
            @else
            <div class="row g-3">
                @foreach ($matches as $match)
                <div class="col-12">
                    <div class="match-item-card p-4">
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start gap-3">
                            <div class="flex-grow-1">
                                <div class="d-flex flex-wrap gap-2 align-items-center mb-2">
                                    <h5 class="fw-bold mb-0 me-2" style="color: var(--primary-color);">Candidato {{ $match->id }}</h5>

                                    <span class="tag-score"><i class="bi bi-star-fill me-1"></i>{{ $match->score_match }}%</span>
                                    <span class="tag-badge"><i class="bi bi-award-fill me-1"></i>{{ $match->badge_diversidade }}</span>
                                </div>

                                <p class="text-muted small mb-2">
                                    <i class="bi bi-briefcase me-1"></i>{{ $match->seniority }}
                                </p>

                                <p class="small mb-3">{{ $match->recomendacao }}</p>

                                <div class="d-flex flex-wrap gap-2 align-items-center">
                                    @if(!empty($match->required_skills))
                                    @foreach($match->required_skills as $required_skill)
                                    <span class="badge text-dark bg-light border fw-normal py-1 px-2" style="font-size: 0.75rem; border-radius: 0.5rem;">
                                        {{ $required_skill }}
                                    </span>
                                    @endforeach
                                    @endif
                                </div>
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