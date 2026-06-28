<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Vaga | SkillFocus</title>

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

        h1, h2, h3, .btn, .navbar-brand {
            font-family: 'Poppins', sans-serif;
        }

        /* Navbar Top. */
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

        /* Card do formulário. */
        .form-card {
            background: #ffffff;
            border: none;
            border-radius: 1.5rem;
            box-shadow: 0 10px 30px rgba(74, 20, 140, 0.03);
            padding: 2.5rem;
            max-width: 750px;
            margin: 0 auto;
        }

        /* Inputs básicos. */
        .form-control {
            border-radius: 0.75rem;
            padding: 0.65rem 1rem;
            border: 1px solid #E2E8F0;
            background-color: #FAFAFA;
        }

        .form-control:focus {
            border-color: var(--accent-color);
            background-color: #ffffff;
            box-shadow: 0 0 0 0.25rem rgba(0, 191, 165, 0.12);
        }

        label {
            font-size: 0.85rem;
            font-weight: 600;
            color: #64748B;
            margin-bottom: 0.4rem;
        }

        /* Botão. */
        .btn-update {
            background-color: var(--primary-color);
            color: white;
            font-weight: 600;
            border-radius: 0.75rem;
            padding: 0.75rem 1.5rem;
            border: none;
            transition: all 0.3s ease;
        }

        .btn-update:hover {
            background-color: var(--secondary-color);
            color: white;
            box-shadow: 0 5px 15px rgba(255, 109, 0, 0.25);
        }
    </style>
</head>
<body>

<!-- Navbar Top. -->
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
<!-- Container principal. -->
<main class="container my-5">

    <div class="form-card">
        <h3 class="fw-bold h4 mb-4" style="color: var(--primary-color);">
            <i class="bi bi-pencil-square me-2" style="color: var(--secondary-color);"></i>Editar Oportunidade
        </h3>

        <!-- Formulário. -->
        <form method="POST" action="/jobs/{{ $job->id }}/edit">
            @csrf
            @method('PUT')

            <!-- Edição do título. -->
            <div class="row g-3">
                <div class="col-12">
                    <label>Título</label>
                    <input type="text" class="form-control" name="title" value="{{ $job->title }}">
                </div>

                <!-- Edição da descrição. -->
                <div class="col-12">
                    <label>Descrição</label>
                    <textarea class="form-control" name="description" rows="4">{{ $job->description }}</textarea>
                </div>

                <!-- Edição das skills. -->
                <div class="col-12">
                    <label>Skills Requeridas</label>

                    <div id="skills-container" class="row g-2">
                        @if(!empty($job->required_skills))
                            @foreach($job->required_skills as $skill)
                                <div class="">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="required_skills[]" value="{{ $skill }}" required>
                                        <button class="btn btn-outline-danger" type="button" onclick="this.closest('.input-group').parentElement.remove();">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>

                <!-- Adicionar skill. -->
                    <div class="mt-2">
                        <button type="button" id="add-skill-btn" class="btn btn-sm btn-light border fw-medium" style="color: var(--primary-color);">
                            <i class="bi bi-plus-circle-fill me-1" style="color: var(--secondary-color);"></i>Adicionar mais uma Skill
                        </button>
                    </div>
                </div>

                <!-- Edição do Level. -->
                <div class="col-md-6">
                    <label>Level</label>
                    <input type="text" class="form-control" name="level" value="{{ $job->level}}">
                </div>

                <!-- Edição da Cidade. -->
                <div class="col-md-6">
                    <label>Cidade</label>
                    <input type="text" class="form-control" name="city" value="{{ $job->city }}">
                </div>

                <!-- Edição do Bairro. -->
                <div class="col-md-6">
                    <label>Bairro</label>
                    <input type="text" class="form-control" name="district" value="{{ $job->district}}">
                </div>

                <!-- Salva modificações. -->
                <div class="col-12 mt-4 text-end">
                    <button type="submit" class="btn-update px-4">Atualizar Vaga</button>
                </div>
            </div>

        </form>
    </div>

</main>

<!-- Script responsável pela visibilidade das skills (adicionar e remover) -->
<script>
    document.getElementById('add-skill-btn').addEventListener('click', function() {
        const container = document.getElementById('skills-container');

        // Cria linha de agrupamento do bootstrap.
        const inputGroup = document.createElement('div');
        inputGroup.className = 'input-group mb-2 animate-fade-in';

        // Cria input.
        const input = document.createElement('input');
        input.name = 'required_skills[]';
        input.className = 'form-control';
        input.placeholder = 'Próxima Skill';
        input.type = 'text';
        input.required = true; // Proibe eventuais campos nulos.

        // Cria botão de remover (lixeira).
        const removeBtn = document.createElement('button');
        removeBtn.className = 'btn btn-outline-danger';
        removeBtn.type = 'button';
        removeBtn.innerHTML = '<i class="bi bi-trash3"></i>';

        // Lógica do botão.
        removeBtn.onclick = function(){
            inputGroup.remove();
        };

        // Acoplamento geral.
        inputGroup.appendChild(input);
        inputGroup.appendChild(removeBtn);
        container.appendChild(inputGroup);
    })
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
