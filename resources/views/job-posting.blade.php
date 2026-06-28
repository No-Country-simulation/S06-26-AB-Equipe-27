<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publicar Vaga | SkillFocus</title>

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

        .allContent {
            background-color: var(--bg-light);
            font-family: 'Inter', sans-serif;
            color: var(--text-dark);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }

        h1, .btn-submit {
            font-family: 'Poppins', sans-serif;
        }

        /* Card do Formulário. */
        .form-card {
            background: #ffffff;
            border: none;
            border-radius: 1.5rem;
            box-shadow: 0 10px 30px rgba(74, 20, 140, 0.04);
            max-width: 700px;
            width: 100%;
            padding: 3rem 2.5rem;
        }

        .form-title {
            color: var(--primary-color);
            font-weight: 700;
            font-size: 1.8rem;
            margin-bottom: 2rem;
        }

        /* Inputs e Textarea. */
        .form-control {
            border-radius: 0.75rem;
            padding: 0.75rem 1rem;
            border: 1px solid #E2E8F0;
            background-color: #FAFAFA;
            transition: all 0.2s ease;
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
            display: block;
        }

        /* Botão Principal. */
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

<div class="allContent">

    <!-- Publicação de vaga. -->
    <div class="form-card">

        <!-- Formulário. -->
        <form method="POST" action="/jobs">
            @csrf
            <h1 class="form-title text-center text-md-start">
                <i class="bi bi-plus-circle text-orange me-2" style="color: var(--secondary-color);"></i>Publicar nova vaga.
            </h1>

            <div class="row g-3">

                <!-- Título. -->
                <div class="col-12">
                    <label>Título da oportunidade</label>
                    <input name="title" class="form-control" placeholder="Título da vaga" type="text" required>
                </div>

                <!-- Descrição. -->
                <div class="col-12">
                    <label>Descrição detalhada</label>
                    <textarea name="description" class="form-control" rows="4" placeholder="Descreva as atividades e o perfil esperado..." required></textarea>
                </div>

                <!-- Skills. -->
                <div class="col-12">
                    <label class="fw-semibold text-muted small mb-2">Principais Competências</label>
                    <div id="skills-container">
                        <div class="mb-2" >
                            <span class=" bg-light text-muted">
                                <input name="required_skills[]" class="form-control" placeholder="Skill (ex: Laravel)" type="text" required>
                            </span>
                        </div>
                    </div>
                    <button type="button" id="add-skill-btn" class="btn btn-sm btn-light border mt-1 fw-medium text-purple" style="color: var(--primary-color);">
                        <i class="bi bi-plus-circle-fill me-1" style="color: var(--secondary-color);"></i>Adicionar mais uma Skill
                    </button>
                </div>


                <!-- Level. -->
                <div class="col-md-4">
                    <label>Sênioridade</label>
                    <input name="level" class="form-control" placeholder="Senior" type="text" required>
                </div>

                <!-- Cidade. -->
                <div class="col-md-4">
                    <label>Cidade</label>
                    <input name="city" class="form-control" placeholder="Cidade" type="text" required>
                </div>

                <!-- Bairro. -->
                <div class="col-md-4">
                    <label>Bairro</label>
                    <input name="district" class="form-control" placeholder="Bairro" type="text" required>
                </div>

                <!-- Criar vaga. -->
                <div class="col-12 mt-4">
                    <button type="submit" class="btn-submit w-100">
                        Criar vaga <i class="bi bi-check-lg ms-1"></i>
                    </button>
                </div>

            </div>
        </form>



    </div>
</div>

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
