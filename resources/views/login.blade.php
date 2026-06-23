<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | SkillFocus</title>

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
        }

        h1, h2, h3, h4, .btn {
            font-family: 'Poppins', sans-serif;
        }

        .login-container {
            max-width: 900px;
            margin: 0 auto;
        }

        .login-card {
            border: none;
            border-radius: 1.5rem;
            box-shadow: 0 15px 35px rgba(74, 20, 140, 0.08);
            overflow: hidden;
            background: #ffffff;
        }

        /* Área de Boas-vindas com Gradiente */
        .brand-section {
            background: linear-gradient(135deg, var(--primary-color) 0%, #7B1FA2 50%, var(--secondary-color) 100%);
            color: white;
            padding: 4rem 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        /* Círculos decorativos para representar pluralidade */
        .brand-section::before, .brand-section::after {
            content: '';
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
        }
        .brand-section::before {
            width: 200px;
            height: 200px;
            top: -50px;
            left: -50px;
        }
        .brand-section::after {
            width: 300px;
            height: 300px;
            bottom: -100px;
            right: -100px;
        }

        .brand-section h2 {
            font-weight: 700;
            font-size: 2.5rem;
            margin-bottom: 1rem;
            z-index: 1;
        }

        .brand-section p {
            font-size: 1.1rem;
            opacity: 0.9;
            z-index: 1;
        }

        /* Área do Formulário */
        .form-section {
            padding: 4rem 3rem;
        }

        .form-title {
            color: var(--primary-color);
            font-weight: 600;
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
        }

        .form-floating .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(74, 20, 140, 0.1);
        }

        .form-floating label {
            color: #8D8D8D;
        }

        /* Botão Personalizado */
        .btn-login {
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 0.75rem;
            padding: 0.875rem;
            font-size: 1.1rem;
            font-weight: 600;
            width: 100%;
            transition: all 0.3s ease;
            margin-top: 1rem;
        }

        .btn-login:hover {
            background-color: var(--secondary-color);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(255, 109, 0, 0.25);
        }

        .forgot-password {
            color: var(--accent-color);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.9rem;
            transition: color 0.2s;
        }

        .forgot-password:hover {
            color: var(--primary-color);
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
    <div class="container login-container">
        <div class="card login-card">
            <div class="row g-0">

                <div class="col-lg-5 d-none d-lg-flex brand-section">
                    <h2>SkillFocus</h2>
                    <p>Conectando talentos diversos às melhores oportunidades. Acreditamos que a pluralidade é o motor da inovação.</p>
                </div>

                <div class="col-lg-7 form-section">
                    <h3 class="form-title">Bem-vindo(a) de volta!</h3>
                    <p class="form-subtitle">Acesse sua conta para continuar transformando equipes.</p>

                    <form method="POST" action="/login">
                        @csrf

                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="email" name="email" placeholder="nome@exemplo.com" required>
                            <label for="email"><i class="bi bi-envelope me-2"></i>E-mail profissional</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Senha" required>
                            <label for="password"><i class="bi bi-lock me-2"></i>Sua senha</label>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="rememberMe">
                                <label class="form-check-label text-muted" for="rememberMe" style="font-size: 0.9rem;">
                                    Lembrar de mim
                                </label>
                            </div>
                            <a href="{{route('password.request')}}" class="forgot-password">Esqueceu a senha?</a>
                        </div>

                        <button type="submit" class="btn btn-login">
                            Entrar na Plataforma <i class="bi bi-arrow-right ms-2"></i>
                        </button>
                    </form>
                    <div class="text-center mt-4" style="font-size: 0.9rem; color: red;">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    <div class="text-center mt-4">
                        <p class="text-muted" style="font-size: 0.9rem;">
                            Sua empresa ainda não faz parte? <a href="{{url('/register')}}" style="color: var(--secondary-color); font-weight: 500; text-decoration: none;">Cadastre-se aqui</a>.
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
