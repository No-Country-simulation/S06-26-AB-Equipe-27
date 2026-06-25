<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro | Pluralis RH</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500&family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        /* Palheta de cores */
        :root {
            --primary-color: #4A148C;
            --secondary-color: #FF6D00;
            --accent-color: #00BFA5;
            --bg-color: #F9F7F6;
            --text-dark: #2B2B2B;
        }

        .allContent {
            background-color: var(--bg-color);
            font-family: 'Inter', sans-serif;
            color: var(--text-dark);
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 2rem 0; /* Padding extra caso a tela seja pequena na vertical */
        }

        h1, h2, h3, h4, .btn {
            font-family: 'Poppins', sans-serif;
        }

        .register-container {
            max-width: 950px; /* Levemente mais largo para acomodar o formulário maior */
            margin: 0 auto;
        }

        .register-card {
            border: none;
            border-radius: 1.5rem;
            box-shadow: 0 15px 35px rgba(74, 20, 140, 0.08);
            overflow: hidden;
            background: #ffffff;
        }

        .brand-section {
            background: linear-gradient(135deg, var(--secondary-color) 0%, #D84315 40%, var(--primary-color) 100%);
            color: white;
            padding: 4rem 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        /* Círculos decorativos */
        .brand-section::before, .brand-section::after {
            content: '';
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
        }
        .brand-section::before {
            width: 250px;
            height: 250px;
            top: -80px;
            right: -80px;
        }
        .brand-section::after {
            width: 150px;
            height: 150px;
            bottom: 50px;
            left: -50px;
        }

        .brand-section h2 {
            font-weight: 700;
            font-size: 2.4rem;
            margin-bottom: 1rem;
            z-index: 1;
        }

        .brand-section p {
            font-size: 1.1rem;
            opacity: 0.95;
            z-index: 1;
        }

        /* Área do Formulário */
        .form-section {
            padding: 3rem 3rem;
        }

        .form-title {
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .form-subtitle {
            color: #6c757d;
            margin-bottom: 2rem;
            font-size: 0.95rem;
        }

        /* Estilização dos Inputs */
        .form-floating .form-control {
            border-radius: 0.75rem;
            border: 1px solid #E0E0E0;
            padding-top: 1.625rem;
            padding-bottom: 0.625rem;
            background-color: #FAFAFA;
        }

        .form-floating .form-control:focus {
            border-color: var(--accent-color);
            background-color: #ffffff;
            box-shadow: 0 0 0 0.25rem rgba(0, 191, 165, 0.15);
        }

        .form-floating label {
            color: #8D8D8D;
        }

        /* Ícones nos labels */
        .input-icon {
            color: var(--primary-color);
            margin-right: 8px;
        }

        /* Botão Personalizado */
        .btn-register {
            background-color: var(--secondary-color); /* Laranja em destaque no registro */
            color: white;
            border: none;
            border-radius: 0.75rem;
            padding: 0.875rem;
            font-size: 1.1rem;
            font-weight: 600;
            width: 100%;
            transition: all 0.3s ease;
            margin-top: 0.5rem;
        }

        .btn-register:hover {
            background-color: var(--primary-color);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(74, 20, 140, 0.25);
        }

        .terms-text {
            font-size: 0.8rem;
            color: #8D8D8D;
            text-align: center;
            margin-top: 1rem;
        }

        .terms-text a {
            color: var(--accent-color);
            text-decoration: none;
            font-weight: 500;
        }
        /* NAVBAR */
        .navbar {
            background-color: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 15px rgba(74, 20, 140, 0.04);
            padding: 1rem 0;
        }

        .navbar-brand {
            font-weight: 700;
            color: var(--primary-color) !important;
            font-size: 1.5rem;
            letter-spacing: -0.5px;
        }

        .navbar-brand span {
            color: var(--secondary-color);
        }

        .nav-link {
            color: var(--text-dark) !important;
            font-weight: 500;
            margin-left: 1.5rem;
            transition: color 0.3s ease;
            position: relative;
        }

        .nav-link:hover, .nav-link.active {
            color: var(--primary-color) !important;
        }
    </style>
</head>
<body>
    <!-- NAVBAR -->
<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container">
        <a class="navbar-brand" href="#">Skill<span>Focus</span></a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#nav" aria-controls="nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="nav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item"><a class="nav-link active" href="{{url('/')}}">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="{{url('/login')}}">Login</a></li>
                <li class="nav-item"><a class="nav-link" href="{{url('/register')}}">Registro</a></li>
            </ul>
        </div>
    </div>
</nav>
<section class="allContent">
    <div class="container register-container">
        <div class="card register-card">
            <div class="row g-0">

                <div class="col-lg-5 d-none d-lg-flex brand-section">
                    <h2>Junte-se à revolução.</h2>
                    <p>Dê o primeiro passo para construir equipes mais criativas, plurais e inovadoras. O futuro do trabalho é diverso.</p>

                    <div class="mt-5 z-1">
                        <div class="d-flex align-items-center mb-3">
                            <i class="bi bi-check-circle-fill fs-5 me-3" style="color: var(--accent-color);"></i>
                            <span>Atraia talentos únicos</span>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <i class="bi bi-check-circle-fill fs-5 me-3" style="color: var(--accent-color);"></i>
                            <span>Ambiente focado em inclusão</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="bi bi-check-circle-fill fs-5 me-3" style="color: var(--accent-color);"></i>
                            <span>Relatórios customizados</span>
                        </div>

                    </div>
                </div>

                <div class="col-lg-7 form-section">
                    <h3 class="form-title">Crie sua conta corporativa</h3>
                    <p class="form-subtitle">Preencha os dados abaixo para cadastrar sua empresa.</p>

                    <form method="POST" action="/register">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Seu Nome" required>
                                    <label for="name"><i class="bi bi-person input-icon"></i>Nome completo</label>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="company_name" name="company_name" placeholder="Nome da Empresa" required>
                                    <label for="company_name"><i class="bi bi-building input-icon"></i>Empresa</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="email" name="email" placeholder="nome@empresa.com.br" required>
                            <label for="email"><i class="bi bi-envelope input-icon"></i>E-mail corporativo</label>
                        </div>

                        <div class="form-floating mb-4">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Senha" required>
                            <label for="password"><i class="bi bi-shield-lock input-icon"></i>Crie uma senha segura</label>
                        </div>

                        <button type="submit" class="btn btn-register">
                            Criar minha conta <i class="bi bi-check2-circle ms-1"></i>
                        </button>

                        <p class="terms-text">
                            Ao se cadastrar, você concorda com nossos <a href="#">Termos de Uso</a> e <a href="#">Política de Privacidade</a>.
                        </p>
                    </form>

                    <div class="text-center mt-4 pt-3 border-top">
                        <p class="text-muted" style="font-size: 0.95rem;">
                            Sua empresa já possui cadastro? <a href="/login" style="color: var(--primary-color); font-weight: 600; text-decoration: none;">Faça Login</a>
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
