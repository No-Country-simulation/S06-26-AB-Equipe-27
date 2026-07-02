<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Progresso ESG | SkillFocus</title>

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

        .goal-card {
            background-color: white;
            border-radius: 1.5rem;
            padding: 1.5rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            border: 1px solid #e5e7eb;
        }

        .tag-diversity {
            font-size: 0.75rem;
            background-color: rgba(74, 20, 140, 0.06);
            color: var(--primary-color);
            padding: 0.2rem 0.6rem;
            border-radius: 0.5rem;
            font-weight: 500;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg dash-navbar sticky-top py-3 px-4 mb-5">
        <div class="container-fluid max-w-[1920px] mx-auto flex justify-between items-center">
            <a class="navbar-brand text-2xl" href="{{route('dashboard')}}">Skill<span>Focus</span></a>
            <div class="dropdown">
                <a class="text-decoration-none d-flex align-items-center text-dark" href="#" data-bs-toggle="dropdown">
                    <div class="rounded-circle d-flex align-items-center justify-center me-2 text-white" style="width: 38px; height: 38px; background-color: var(--primary-color);">
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
                    <li><a class="dropdown-item py-2" href="#"><i class="bi bi-gear-wide me-2 text-muted"></i> Configurações</a></li>
                    <li><a class="dropdown-item py-2 text-danger" href="{{route('logout')}}"><i class="bi bi-box-arrow-right me-2"></i> Sair</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container mx-auto px-4 pb-12 max-w-4xl">
        <div class="mb-8">
            <h1 class="text-3xl font-bold" style="color: var(--primary-color);">Progresso ESG</h1>
            <p class="text-gray-600 mt-2">Acompanhe o progresso das suas metas ambientais, sociais e de governança.</p>
        </div>

        @if(session('success'))
        <div class="bg-green-50 border-2 border-green-400 rounded-2xl p-6 shadow-sm mb-6">
            <div class="flex flex-col md:flex-row md:items-center gap-4">
                <div class="flex-shrink-0 flex justify-center">
                    <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <div class="flex-1 text-center md:text-left">
                    <h3 class="text-xl font-bold text-green-800 mb-1">{{ session('success') }}</h3>
                </div>
            </div>
        </div>
        @endif

        <div class="grid grid-cols-1 gap-6">
            @foreach($goals as $goal)
            <div class="goal-card">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <div class="flex items-center gap-3 mb-2">
                            <h3 class="text-xl font-bold" style="color: var(--primary-color);">{{ $goal->title }}</h3>
                            <span class="tag-diversity">{{ ucfirst($goal->tracking_type) }}</span>
                        </div>
                        @if($goal->description)
                        <p class="text-gray-600 text-sm mb-3">{{ $goal->description }}</p>
                        @endif
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-primary rounded-lg" data-bs-toggle="modal" data-bs-target="#editModal-{{ $goal->id }}">
                        <i class="bi bi-pencil me-1"></i>Atualizar
                    </button>
                </div>

                @if($goal->tracking_type === 'count')
                <div class="flex items-center gap-4">
                    <div class="text-4xl font-bold" style="color: var(--accent-color);">{{ $goal->current_value }}</div>
                    <div class="text-gray-400 text-xl">/ {{ $goal->target_value }}</div>
                    <div class="flex-1 bg-gray-200 rounded-full h-3">
                        <div class="bg-gradient-to-r from-green-500 to-emerald-500 h-3 rounded-full" style="width: {{ $goal->target_value > 0 ? min(($goal->current_value / $goal->target_value) * 100, 100) : 0 }}%"></div>
                    </div>
                </div>
                @if($goal->notes)
                <p class="text-gray-500 text-sm mt-3"><i class="bi bi-sticky me-1"></i>{{ $goal->notes }}</p>
                @endif

                @elseif($goal->tracking_type === 'percentage')
                <div class="flex items-center gap-4">
                    <div class="text-4xl font-bold" style="color: var(--accent-color);">{{ $goal->current_value }}%</div>
                    <div class="text-gray-400 text-xl">/ 100%</div>
                    <div class="flex-1 bg-gray-200 rounded-full h-3">
                        <div class="bg-gradient-to-r from-green-500 to-emerald-500 h-3 rounded-full" style="width: {{ $goal->current_value }}%"></div>
                    </div>
                </div>

                @elseif($goal->tracking_type === 'status')
                <div>
                    @php
                    $statusLabels = [
                    'NOT_STARTED' => 'Not started',
                    'IN_PROGRESS' => 'Em andamento',
                    'COMPLETED' => 'Concluído',
                    'PENDING' => 'Não iniciado',
                    'ACHIEVED' => 'Concluído',
                    'CANCELLED' => 'Não iniciado'
                    ];
                    $statusColors = [
                    'NOT_STARTED' => 'bg-gray-100 text-gray-700',
                    'IN_PROGRESS' => 'bg-blue-100 text-blue-700',
                    'COMPLETED' => 'bg-green-100 text-green-700',
                    'PENDING' => 'bg-gray-100 text-gray-700',
                    'ACHIEVED' => 'bg-green-100 text-green-700',
                    'CANCELLED' => 'bg-red-100 text-red-700'
                    ];
                    @endphp
                    <span class="px-4 py-2 rounded-full font-semibold text-sm {{ $statusColors[$goal->status] ?? 'bg-gray-100 text-gray-700' }}">
                        {{ $statusLabels[$goal->status] ?? $goal->status }}
                    </span>
                </div>
                @endif
            </div>

            <!-- Edit Modal -->
            <div class="modal fade" id="editModal-{{ $goal->id }}" tabindex="-1" aria-labelledby="editModalLabel-{{ $goal->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content rounded-2xl">
                        <form action="{{ route('esg-progress.update', $goal) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-header border-0 pb-0">
                                <h5 class="modal-title font-bold" id="editModalLabel-{{ $goal->id }}" style="color: var(--primary-color);">Atualizar Meta: {{ $goal->title }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                @if($goal->tracking_type === 'count')
                                <div class="mb-4">
                                    <label class="form-label font-medium text-gray-700">Valor Alvo (Fixo)</label>
                                    <input type="number" class="form-control rounded-xl border-gray-300" value="{{ $goal->target_value }}" disabled>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label font-medium text-gray-700">Valor Atual</label>
                                    <input type="number" name="current_value" value="{{ $goal->current_value }}" class="form-control rounded-xl border-gray-300 focus:border-purple-500" min="0" max="{{ $goal->target_value }}" required>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label font-medium text-gray-700">Notas (Opcional)</label>
                                    <textarea name="notes" class="form-control rounded-xl border-gray-300 focus:border-purple-500" rows="3">{{ $goal->notes }}</textarea>
                                </div>

                                @elseif($goal->tracking_type === 'percentage')
                                <div class="mb-4">
                                    <label class="form-label font-medium text-gray-700">Valor Alvo (Fixo)</label>
                                    <input type="number" class="form-control rounded-xl border-gray-300" value="100" disabled>
                                    <span class="text-sm text-gray-500">%</span>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label font-medium text-gray-700">Percentual Atual</label>
                                    <div class="input-group">
                                        <input type="number" name="current_value" value="{{ $goal->current_value }}" class="form-control rounded-xl border-gray-300 focus:border-purple-500" min="0" max="100" required>
                                        <span class="input-group-text rounded-r-xl">%</span>
                                    </div>
                                </div>

                                @elseif($goal->tracking_type === 'status')
                                <div class="mb-4">
                                    <label class="form-label font-medium text-gray-700">Status</label>
                                    <div class="space-y-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="status" value="NOT_STARTED" id="status-not-started-{{ $goal->id }}" {{ in_array($goal->status, ['NOT_STARTED', 'PENDING']) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="status-not-started-{{ $goal->id }}">
                                                Não iniciado
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="status" value="IN_PROGRESS" id="status-in-progress-{{ $goal->id }}" {{ $goal->status === 'IN_PROGRESS' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="status-in-progress-{{ $goal->id }}">
                                                Em andamento
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="status" value="COMPLETED" id="status-completed-{{ $goal->id }}" {{ in_array($goal->status, ['COMPLETED', 'ACHIEVED']) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="status-completed-{{ $goal->id }}">
                                                Concluído
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                            <div class="modal-footer border-0 pt-0">
                                <button type="button" class="btn btn-light rounded-xl" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn text-white rounded-xl" style="background-color: var(--primary-color);">Salvar Alterações</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>