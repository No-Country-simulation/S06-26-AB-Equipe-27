<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SkillFocus | O Futuro do Recrutamento Plural</title>

    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts: Poppins (Títulos) e Inter (Textos) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        /* Palheta de cores */
        :root {
            --primary-color: #4A148C;
            --secondary-color: #FF6D00;
            --accent-color: #00BFA5;
            --bg-light: #F9F7F6;
            --text-dark: #2B2B2B;
        }

        body {
            background-color: #ffffff;
            font-family: 'Inter', sans-serif;
            color: var(--text-dark);
            overflow-x: hidden;
        }

        h1, h2, h3, h4, h5, h6, .navbar-brand {
            font-family: 'Poppins', sans-serif;
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

        /* HERO - Design Imersivo */
        .hero {
            height: 60vh;
            background: linear-gradient(135deg, rgba(74, 14, 140, 0.85) 0%, rgba(255, 109, 0, 0.8) 100%),
                        url('https://images.unsplash.com/photo-1573497019940-1c28c88b4f3e?auto=format&fit=crop&q=80&w=1920') center/cover no-repeat;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .hero-content h1 {
            font-weight: 800;
            letter-spacing: -1px;
            text-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        /* BOTÕES PERSONALIZADOS */
        .btn-custom-primary {
            background-color: var(--primary-color);
            color: white;
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            padding: 0.8rem 2rem;
            border-radius: 0.75rem;
            border: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(74, 20, 140, 0.2);
        }

        .btn-custom-primary:hover {
            background-color: var(--secondary-color);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 109, 0, 0.3);
        }

        .btn-custom-dark {
            background-color: var(--text-dark);
            color: white;
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            padding: 0.8rem 2rem;
            border-radius: 0.75rem;
            border: none;
            transition: all 0.3s ease;
        }

        .btn-custom-dark:hover {
            background-color: var(--primary-color);
            color: white;
            transform: translateY(-2px);
        }

        /* SEÇÃO DE TEXTOS */
        .section-title {
            color: var(--primary-color);
            font-weight: 700;
            font-size: 2.5rem;
            margin-bottom: 1.2rem;
            letter-spacing: -0.5px;
        }

        .section-text {
            color: #555555;
            font-size: 1.15rem;
            line-height: 1.7;
            margin-bottom: 2rem;
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

        /* IMAGE BLOCK COM MOLDURA DINÂMICA */
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

        /* SEÇÃO INTEGRADA DE LOGIN / CTA */
        .cta-login-section {
            background-color: var(--bg-light);
            border-radius: 2rem;
            padding: 4rem 3rem;
            margin-bottom: 5rem;
            box-shadow: inset 0 0 40px rgba(74, 20, 140, 0.02);
        }

        .login-box {
            background: #ffffff;
            border: none;
            border-radius: 1.25rem;
            padding: 2.5rem;
            box-shadow: 0 15px 35px rgba(74, 20, 140, 0.06);
        }

        .login-box h3 {
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 1.5rem;
        }

        .login-box .form-control {
            border-radius: 0.75rem;
            padding: 0.75rem 1rem;
            border: 1px solid #E0E0E0;
            background-color: #FAFAFA;
        }

        .login-box .form-control:focus {
            border-color: var(--accent-color);
            background-color: #fff;
            box-shadow: 0 0 0 0.25rem rgba(0, 191, 165, 0.15);
        }

        /* FOOTER DECORATIVO */
        footer {
            background-color: var(--primary-color);
            color: rgba(255,255,255,0.8);
            padding: 2rem 0;
            font-size: 0.9rem;
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

<!-- HERO -->
<header class="hero">
    <div class="hero-content text-white text-center container">
        <h1 class="display-3 mb-0">Nós somos o futuro.</h1>
    </div>
</header>

<!-- SECTION 1 (Competências) -->
<section class="py-5 my-4">
    <div class="container">
        <div class="row align-items-center justify-content-between">
            <div class="col-lg-6 order-2 order-lg-1">
                <h1 class="section-title">Contrate com base em competências</h1>
                <p class="section-text">
                    O SkillFocus utiliza Inteligência Artificial para interpretar dados,
                    mapear competências e gerar insights estratégicos para recrutamento.
                </p>
                <button class="btn btn-custom-primary px-5 btn-lg">Começar agora</button>
            </div>
            <div class="col-lg-5 order-1 order-lg-2 mb-4 mb-lg-0">
                <!-- Elemento visual abstrato representando diversidade de conexões -->
                <div class="img-box" style="height: 280px; background: linear-gradient(45deg, var(--accent-color), var(--primary-color)); display:flex; align-items:center; justify-content:center;">
                    <i class="bi bi-cpu text-white" style="font-size: 5rem; opacity: 0.9;"></i>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- SECTION 2 (Empresas - Imagem oculta no Mobile) -->
<section class="py-5 bg-light-subtle">
    <div class="container">
        <div class="row align-items-center g-5">

            <!-- IMAGEM: Oculta em telas menores que LG-->
            <div class="col-lg-6 d-none d-lg-block">
                <div class="img-box">
                    <img src="https://cdn.pixabay.com/photo/2026/04/10/10/21/erwinbosman-woman-10219062_1280.jpg" alt="Profissional trabalhando">
                </div>
            </div>

            <div class="col-lg-6">
                <span class="subtitle-badge">Decisões mais inteligentes</span>
                <h1 class="section-title">Para Recrutadores e Empresas</h1>
                <p class="section-text">
                    O SkillFocus transforma dados em decisões estratégicas,
                    reduzindo vieses e ampliando a qualidade das contratações.
                </p>
            </div>

        </div>
    </div>
</section>

<!-- LOGIN & CALL TO ACTION -->
<section class="py-5">
    <div class="container">
        <div class="cta-login-section">
            <div class="row align-items-center g-5">

                <div class="col-lg-6 text-center text-lg-start">
                    <h2 class="section-title" style="font-size: 2.8rem;">Aqui você contrata sem viés.</h2>
                    <p class="fs-4 text-muted mb-0">Processos mais justos, inteligentes e eficientes.</p>
                </div>

                <div class="col-lg-6">
                    <div class="login-box">
                        <h3>Login</h3>
                        @if ($errors->any())
                                <div class="alert alert-danger">
                                    @foreach ($errors->all() as $error)
                                        <div>{{ $error }}</div>
                                    @endforeach
                                </div>
                            @endif
                        <form method="POST" action="/login">
                            <!-- Inclusão de segurança simulada do framework -->
                            <input type="hidden" name="_token" value="csrf_token_placeholder">

                            <div class="mb-3">
                                <label class="form-label text-muted small fw-semibold">E-mail</label>
                                <input type="email" class="form-control" name="email" placeholder="Seu e-mail cadastrado" required>
                            </div>
                            <div class="mb-4">
                                <label class="form-label text-muted small fw-semibold" >Senha</label>
                                <input type="password" class="form-control" name="password" placeholder="Sua senha de acesso" required>
                            </div>
                            <button type="submit" class="btn btn-custom-dark w-100 py-3">Entrar</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<!-- FOOTER -->
<footer class="text-center">
    <div class="container">
        <p class="mb-0">&copy; 2026 SkillFocus. Potencializando a diversidade através da tecnologia corporativa.</p>
    </div>
</footer>

<!-- Bootstrap 5.3 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
