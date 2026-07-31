<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entrar | SkillFocus</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* ==========================================================
           SKILLFOCUS — DESIGN TOKENS
           Idênticos aos usados em jobs.blade.php. Manter esse bloco
           igual em toda view nova é o que garante a identidade única
           do produto — não duplicar com valores "parecidos".
        ========================================================== */
        :root {
            --color-primary: #7C3AED;
            --color-primary-dark: #5B21B6;
            --color-primary-hover: #6D28D9;
            --color-primary-soft: #F3EEFE;
            --color-primary-softer: #FBFAFF;

            --color-shield: #0D9488;
            --color-shield-soft: #E8F8F6;
            --color-shield-warn: #B45309;
            --color-shield-warn-soft: #FEF6E7;

            --color-ink: #17152A;
            --color-body: #47435C;
            --color-muted: #77738F;
            --color-border: #E9E5F3;
            --color-surface: #FFFFFF;
            --color-bg: #FAF9FD;

            --radius-sm: 10px;
            --radius-md: 16px;
            --radius-lg: 22px;
            --shadow-card: 0 1px 2px rgba(23, 21, 42, .04), 0 10px 28px -14px rgba(23, 21, 42, .14);
            --shadow-pop: 0 12px 32px -8px rgba(23, 21, 42, .16);

            --font-display: 'Sora', 'Inter', sans-serif;
            --font-body: 'Inter', sans-serif;
        }

        * {
            -webkit-font-smoothing: antialiased;
        }

        html,
        body {
            height: 100%;
        }

        body {
            font-family: var(--font-body);
            color: var(--color-body);
            min-height: 100vh;
        }

        h1,
        h2,
        h3,
        .font-display {
            font-family: var(--font-display);
        }

        a {
            text-decoration: none;
        }

        /* ==========================================================
           LAYOUT — split screen
           Uma tela de login genérica é só um cartão centralizado; aqui
           o lado esquerdo carrega a proposta real do produto (a
           pontuação Bias Shield que aparece em cada vaga na view de
           gerenciamento), então quem chega já entende o diferencial
           antes mesmo de entrar. Em telas pequenas o painel some e
           sobra só o essencial: marca + formulário.
        ========================================================== */
        .login-shell {
            min-height: 100vh;
            display: flex;
        }

        /* ---- Painel esquerdo (só >=lg) ---- */
        .login-aside {
            width: 44%;
            flex-shrink: 0;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 3rem 3.25rem;
            color: #fff;
            background:
                radial-gradient(circle at 15% 15%, rgba(124, 58, 237, .55), transparent 45%),
                radial-gradient(circle at 85% 85%, rgba(13, 148, 136, .45), transparent 50%),
                linear-gradient(165deg, var(--color-ink) 0%, #241F3D 55%, #1B1830 100%);
            overflow: hidden;
        }

        .login-aside::after {
            content: "";
            position: absolute;
            inset: 0;
            background-image: radial-gradient(rgba(255, 255, 255, .08) 1px, transparent 1px);
            background-size: 22px 22px;
            mask-image: linear-gradient(180deg, transparent, rgba(0, 0, 0, .7) 55%, transparent);
            pointer-events: none;
        }

        .login-aside .brand-row a,
        .mobile-brand a {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            font-family: var(--font-display);
            font-weight: 700;
            font-size: 1.15rem;
            position: relative;
            z-index: 1;
            color: inherit;
        }

        .brand-icon {
            color: #fff;
            border-radius: 9px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.05rem;
            flex-shrink: 0;
        }

        .mobile-brand .brand-text {
            color: #462559;
        }

        .mobile-brand .brand-text span {
            color: #4a0353;
        }

        .brand-text {
            color: inherit;
        }

        .brand-text span {
            color: #C4B5FD;
        }

        .login-aside .aside-content {
            position: relative;
            z-index: 1;
            max-width: 400px;
        }

        .login-aside .eyebrow {
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: #C4B5FD;
            margin-bottom: 0.9rem;
        }

        .login-aside h1 {
            font-size: 2rem;
            font-weight: 700;
            line-height: 1.25;
            letter-spacing: -0.02em;
            margin-bottom: 0.9rem;
        }

        .login-aside p.lede {
            color: #C9C6DC;
            font-size: 0.95rem;
            line-height: 1.6;
        }

        .aside-feature-list {
            list-style: none;
            padding: 0;
            margin: 1.75rem 0 0;
            display: flex;
            flex-direction: column;
            gap: 0.9rem;
        }

        .aside-feature-list li {
            display: flex;
            align-items: flex-start;
            gap: 0.7rem;
            font-size: 0.87rem;
            color: #E3E1F0;
        }

        .aside-feature-list .feat-icon {
            width: 28px;
            height: 28px;
            border-radius: 8px;
            background-color: rgba(13, 148, 136, .22);
            color: #5EEAD4;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 0.85rem;
        }

        .login-aside .trust-line {
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.78rem;
            color: #B7B2CF;
            border-top: 1px solid rgba(255, 255, 255, .1);
            padding-top: 1.25rem;
        }

        .login-aside .trust-line i {
            color: #5EEAD4;
        }

        /* ---- Painel direito (formulário) ---- */
        .login-form-panel {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2.5rem 1.5rem;
            background-color: var(--color-bg);
            background-image: radial-gradient(circle at 100% 0%, rgba(124, 58, 237, .06), transparent 45%);
        }

        .mobile-brand {
            display: none;
        }

        .login-card {
            background: var(--color-surface);
            width: 100%;
            max-width: 420px;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-card);
            border: 1px solid var(--color-border);
            padding: 2.25rem;
            position: relative;
        }

        .auth-toggle {
            background-color: var(--color-bg);
            border: 1px solid var(--color-border);
            border-radius: 999px;
            padding: 0.3rem;
            display: flex;
            gap: 0.2rem;
            margin-bottom: 1.75rem;
        }

        .auth-toggle .btn-toggle {
            flex: 1;
            text-align: center;
            padding: 0.55rem 1rem;
            font-weight: 600;
            font-size: 0.85rem;
            border-radius: 999px;
            color: var(--color-muted);
            transition: all .18s ease;
        }

        .auth-toggle .btn-toggle.active {
            background-color: var(--color-ink);
            color: #fff;
        }

        .auth-toggle .btn-toggle:not(.active):hover {
            color: var(--color-ink);
        }

        .form-title {
            font-family: var(--font-display);
            font-weight: 700;
            font-size: 1.45rem;
            color: var(--color-ink);
            letter-spacing: -0.01em;
            margin-bottom: 0.3rem;
        }

        .form-subtitle {
            color: var(--color-muted);
            font-size: 0.88rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        /* ==========================================================
           SELETOR DE TIPO DE CONTA (CARDS)
        ========================================================== */
        .type-selector-wrapper {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.8rem;
            margin-bottom: 1.5rem;
        }

        .type-card {
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 1.1rem 0.5rem;
            border: 1px solid var(--color-border);
            border-radius: var(--radius-md);
            background-color: var(--color-surface);
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
            color: var(--color-muted);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
        }

        .type-card:hover {
            border-color: #C4B5FD;
            background-color: var(--color-bg);
            color: var(--color-primary-dark);
            transform: translateY(-2px);
        }

        .type-card.active {
            border-color: var(--color-primary);
            background-color: var(--color-primary-softer);
            color: var(--color-primary-dark);
            box-shadow: 0 4px 14px rgba(124, 58, 237, 0.12);
        }

        .type-card i {
            font-size: 1.6rem;
            margin-bottom: 0.4rem;
            color: inherit;
        }

        .type-card span {
            font-size: 0.88rem;
            font-weight: 600;
            color: inherit;
        }

        /* Oculta o input radio, mantendo-o acessível e submetível */
        .type-card input[type="radio"] {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
        }

        /* -------------------------------------------------------- */

        .field-label {
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--color-ink);
            margin-bottom: 0.4rem;
            display: block;
        }

        .input-group-custom {
            background-color: var(--color-bg);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            padding: 0 0.9rem;
            margin-bottom: 1.1rem;
            transition: border-color .18s ease, box-shadow .18s ease, background-color .18s ease;
        }

        .input-group-custom:focus-within {
            border-color: var(--color-primary);
            background-color: #fff;
            box-shadow: 0 0 0 3px rgba(124, 58, 237, .12);
        }

        .input-group-custom i {
            color: var(--color-primary);
            font-size: 1rem;
        }

        .input-group-custom input {
            border: none;
            background: transparent;
            padding: 0.75rem 0.7rem;
            width: 100%;
            outline: none;
            color: var(--color-ink);
            font-size: 0.92rem;
        }

        .input-group-custom input::placeholder {
            color: #ACA8C2;
        }

        .toggle-visibility {
            background: none;
            border: none;
            color: var(--color-muted);
            padding: 0.25rem;
            display: flex;
            align-items: center;
            transition: color .15s ease;
        }

        .toggle-visibility:hover {
            color: var(--color-ink);
        }

        .form-meta-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.4rem;
        }

        .remember-check {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.83rem;
            color: var(--color-body);
        }

        .remember-check input {
            width: 16px;
            height: 16px;
            accent-color: var(--color-primary);
            cursor: pointer;
        }

        .forgot-password {
            color: var(--color-primary);
            font-size: 0.83rem;
            font-weight: 600;
        }

        .forgot-password:hover {
            color: var(--color-primary-hover);
            text-decoration: underline;
        }

        .alert-soft-danger {
            background-color: #FDEEEE;
            border: 1px solid #F6D4D4;
            color: #B42318;
            border-radius: var(--radius-sm);
            padding: 0.8rem 1rem;
            font-size: 0.83rem;
            margin-bottom: 1.1rem;
        }

        .alert-soft-danger ul {
            margin-bottom: 0;
            padding-left: 1.1rem;
        }

        .btn-submit {
            background: linear-gradient(155deg, var(--color-primary), var(--color-primary-dark));
            color: #fff;
            border: none;
            border-radius: var(--radius-sm);
            padding: 0.85rem;
            font-size: 0.95rem;
            font-weight: 600;
            width: 100%;
            box-shadow: 0 10px 22px -10px rgba(124, 58, 237, .6);
            transition: transform .15s ease, box-shadow .15s ease;
        }

        .btn-submit:hover {
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 14px 26px -10px rgba(124, 58, 237, .7);
        }

        .register-link {
            text-align: center;
            font-size: 0.88rem;
            color: var(--color-body);
            margin-top: 1.5rem;
        }

        .register-link a {
            color: var(--color-primary);
            font-weight: 700;
        }

        .register-link a:hover {
            color: var(--color-primary-hover);
            text-decoration: underline;
        }

        /* ---------------- Responsivo ---------------- */
        @media (max-width: 991.98px) {
            .login-aside {
                display: none;
            }

            .mobile-brand {
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 0.55rem;
                font-family: var(--font-display);
                font-weight: 700;
                font-size: 1.1rem;
                color: var(--color-ink);
                margin-bottom: 1.75rem;
            }
        }

        @media (max-width: 420px) {
            .login-card {
                padding: 1.75rem 1.35rem;
            }

            .type-selector-wrapper {
                grid-template-columns: 1fr;
            }

            /* Em telas muito pequenas empilha os botões */
        }
    </style>
</head>

<body>

    <div class="login-shell">

        {{-- PAINEL ESQUERDO — proposta de valor (Bias Shield), some no mobile --}}
        <aside class="login-aside">
            <div class="brand-row">
                <a href="#">
                    <span class="brand-icon"><img src="logo.webp" alt="Skillfocus logo"></span>
                    <div class="brand-text"> Skill<span>Focus</span></div>
                </a>
            </div>

            <div class="aside-content">
                <div class="eyebrow">Recrutamento sem viés</div>
                <h1>Toda vaga, com uma triagem mais justa.</h1>
                <p class="lede">Centralize suas vagas, acompanhe candidatos e monitore o índice de equidade de cada processo seletivo em um só lugar.</p>

                <ul class="aside-feature-list">
                    <li>
                        <span class="feat-icon"><i class="bi bi-shield-check"></i></span>
                        Pontuação Bias Shield calculada para cada vaga aberta
                    </li>
                    <li>
                        <span class="feat-icon"><i class="bi bi-graph-up"></i></span>
                        Métricas de diversidade acompanhadas em tempo real
                    </li>
                    <li>
                        <span class="feat-icon"><i class="bi bi-lock"></i></span>
                        Dados de candidatos armazenados com segurança
                    </li>
                </ul>
            </div>

            <div class="trust-line">
                <i class="bi bi-lock-fill"></i> Dados protegidos · Bias Shield ativo
            </div>
        </aside>

        {{-- PAINEL DIREITO — formulário --}}
        <main class="login-form-panel">
            <div style="width: 100%; max-width: 420px;">

                <div class="mobile-brand">
                    <a href="#">
                        <span class="brand-icon"><img src="logo.webp" alt="Skillfocus logo"></span>
                        <div class="brand-text"> Skill<span>Focus</span></div>
                    </a>
                </div>

                <div class=" login-card">

                    <div class="auth-toggle">
                        <a href="{{ url('/login') }}" class="btn-toggle active">Entrar</a>
                        <a href="{{ url('/register') }}" class="btn-toggle">Criar conta</a>
                    </div>

                    <h1 class="form-title">Bem-vindo de volta</h1>
                    <p class="form-subtitle">Acesse sua conta para continuar</p>

                    <!-- SELETOR DE PERFIL -->
                    <div class="type-selector-wrapper">
                        <!-- Card Empresa (Estado ativo e Input de verdade para submit, oculto via CSS) -->
                        <label class="type-card active" id="card-empresa">
                            <input type="radio" name="login_type" value="empresa" checked>
                            <i class="bi bi-building"></i>
                            <span>Sou Empresa</span>
                        </label>

                        <!-- Card Candidato -->
                        <label class="type-card" id="card-candidato">
                            <input type="radio" name="login_type" value="candidato">
                            <i class="bi bi-person-badge"></i>
                            <span>Sou Candidato</span>
                        </label>
                    </div>

                    @if ($errors->any())
                    <div class="alert-soft-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form method="POST" action="/login">
                        @csrf
                        <input type="hidden" name="login_type" id="loginTypeInput" value="empresa">

                        <label class="field-label" for="email">E-mail</label>
                        <div class="input-group-custom">
                            <i class="bi bi-envelope"></i>
                            <input type="email" name="email" id="email" placeholder="seu@email.com" required value="{{ old('email') }}">
                        </div>

                        <label class="field-label" for="password">Senha</label>
                        <div class="input-group-custom">
                            <i class="bi bi-key"></i>
                            <input type="password" name="password" id="password" placeholder="Sua senha" required>
                            <button type="button" class="toggle-visibility" id="togglePassword" aria-label="Mostrar senha">
                                <i class="bi bi-eye" id="togglePasswordIcon"></i>
                            </button>
                        </div>

                        <div class="form-meta-row">
                            <label class="remember-check">
                                <input type="checkbox" name="remember">
                                Lembrar de mim
                            </label>
                            <a href="{{ route('password.request') }}" class="forgot-password">Esqueceu a senha?</a>
                        </div>

                        <button type="submit" class="btn btn-submit">
                            Entrar na plataforma
                        </button>
                    </form>

                    <div class="register-link">
                        Não tem conta? <a href="{{ url('/register') }}">Criar agora</a>
                    </div>

                </div>
            </div>
        </main>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Alternar visibilidade da senha — apenas UX, não altera o envio do formulário.
        document.getElementById('togglePassword').addEventListener('click', function() {
            const input = document.getElementById('password');
            const icon = document.getElementById('togglePasswordIcon');
            const isHidden = input.type === 'password';
            input.type = isHidden ? 'text' : 'password';
            icon.classList.toggle('bi-eye', !isHidden);
            icon.classList.toggle('bi-eye-slash', isHidden);
        });

        // Alternar entre tipo de conta no login
        const cardEmpresa = document.getElementById('card-empresa');
        const cardCandidato = document.getElementById('card-candidato');
        const loginTypeInput = document.getElementById('loginTypeInput');
        const radioInputs = document.querySelectorAll('input[name="login_type"]');

        radioInputs.forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.value === 'empresa') {
                    cardEmpresa.classList.add('active');
                    cardCandidato.classList.remove('active');
                    loginTypeInput.value = 'empresa';
                } else {
                    cardEmpresa.classList.remove('active');
                    cardCandidato.classList.add('active');
                    loginTypeInput.value = 'candidato';
                }
            });
        });
    </script>
</body>

</html>