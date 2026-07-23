<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar conta de Candidato | SkillFocus</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* ==========================================================
           SKILLFOCUS — DESIGN TOKENS
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
            --shadow-card: 0 1px 2px rgba(23,21,42,.04), 0 10px 28px -14px rgba(23,21,42,.14);
            --shadow-pop: 0 12px 32px -8px rgba(23,21,42,.16);

            --font-display: 'Sora', 'Inter', sans-serif;
            --font-body: 'Inter', sans-serif;
        }

        * { -webkit-font-smoothing: antialiased; }

        html, body { height: 100%; }

        body {
            font-family: var(--font-body);
            color: var(--color-body);
            min-height: 100vh;
        }

        h1, h2, h3, .font-display { font-family: var(--font-display); }
        a { text-decoration: none; }

        /* ==========================================================
           LAYOUT — split screen
        ========================================================== */
        .login-shell {
            min-height: 100vh;
            display: flex;
        }

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
                radial-gradient(circle at 15% 15%, rgba(124,58,237,.55), transparent 45%),
                radial-gradient(circle at 85% 85%, rgba(13,148,136,.45), transparent 50%),
                linear-gradient(165deg, var(--color-ink) 0%, #241F3D 55%, #1B1830 100%);
            overflow: hidden;
        }

        .login-aside::after {
            content: "";
            position: absolute;
            inset: 0;
            background-image: radial-gradient(rgba(255,255,255,.08) 1px, transparent 1px);
            background-size: 22px 22px;
            mask-image: linear-gradient(180deg, transparent, rgba(0,0,0,.7) 55%, transparent);
            pointer-events: none;
        }

        .login-aside .brand-row {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            font-family: var(--font-display);
            font-weight: 700;
            font-size: 1.15rem;
            position: relative;
            z-index: 1;
        }

        .brand-icon {
            background: linear-gradient(155deg, var(--color-primary), var(--color-primary-dark));
            color: #fff;
            border-radius: 9px;
            width: 34px;
            height: 34px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.05rem;
            box-shadow: 0 4px 10px -3px rgba(124,58,237,.6);
            flex-shrink: 0;
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

        .aside-steps {
            list-style: none;
            padding: 0;
            margin: 1.9rem 0 0;
            display: flex;
            flex-direction: column;
            gap: 1.15rem;
        }

        .aside-steps li {
            display: flex;
            align-items: flex-start;
            gap: 0.85rem;
        }

        .aside-steps .step-num {
            width: 26px;
            height: 26px;
            border-radius: 50%;
            background-color: rgba(255,255,255,.1);
            border: 1px solid rgba(255,255,255,.18);
            color: #fff;
            font-size: 0.75rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .aside-steps .step-text {
            font-size: 0.87rem;
            color: #E3E1F0;
            line-height: 1.5;
        }

        .aside-steps .step-text strong {
            display: block;
            color: #fff;
            font-size: 0.9rem;
            margin-bottom: 0.1rem;
        }

        .login-aside .trust-line {
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.78rem;
            color: #B7B2CF;
            border-top: 1px solid rgba(255,255,255,.1);
            padding-top: 1.25rem;
        }

        .login-aside .trust-line i { color: #5EEAD4; }

        /* ---- Painel direito (formulário) ---- */
        .login-form-panel {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2.5rem 1.5rem;
            background-color: var(--color-bg);
            background-image: radial-gradient(circle at 100% 0%, rgba(124,58,237,.06), transparent 45%);
        }

        .mobile-brand { display: none; }

        .login-card {
            background: var(--color-surface);
            width: 100%;
            max-width: 440px;
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

        .auth-toggle .btn-toggle:not(.active):hover { color: var(--color-ink); }

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

        .form-subtitle .free-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background-color: var(--color-shield);
            flex-shrink: 0;
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
            box-shadow: 0 2px 8px rgba(0,0,0,0.02);
        }

        .type-card:hover {
            border-color: #C4B5FD;
            background-color: var(--color-bg);
            color: var(--color-primary-dark);
            transform: translateY(-2px);
        }

        /* Na view de candidato, o estilo ativo muda para dar ênfase no perfil pessoal */
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

        .field-group { margin-bottom: 1.1rem; }

        .input-group-custom {
            background-color: var(--color-bg);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            padding: 0 0.9rem;
            transition: border-color .18s ease, box-shadow .18s ease, background-color .18s ease;
        }

        .input-group-custom:focus-within {
            border-color: var(--color-primary);
            background-color: #fff;
            box-shadow: 0 0 0 3px rgba(124,58,237,.12);
        }

        .input-group-custom i { color: var(--color-primary); font-size: 1rem; }

        .input-group-custom input {
            border: none;
            background: transparent;
            padding: 0.75rem 0.7rem;
            width: 100%;
            outline: none;
            color: var(--color-ink);
            font-size: 0.92rem;
        }

        .input-group-custom input::placeholder { color: #ACA8C2; }

        .toggle-visibility {
            background: none;
            border: none;
            color: var(--color-muted);
            padding: 0.25rem;
            display: flex;
            align-items: center;
            transition: color .15s ease;
        }
        .toggle-visibility:hover { color: var(--color-ink); }

        .password-hint {
            font-size: 0.76rem;
            color: var(--color-muted);
            margin-top: 0.4rem;
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
        .alert-soft-danger ul { margin-bottom: 0; padding-left: 1.1rem; }

        .btn-submit {
            background: linear-gradient(155deg, var(--color-primary), var(--color-primary-dark));
            color: #fff;
            border: none;
            border-radius: var(--radius-sm);
            padding: 0.85rem;
            font-size: 0.95rem;
            font-weight: 600;
            width: 100%;
            box-shadow: 0 10px 22px -10px rgba(124,58,237,.6);
            transition: transform .15s ease, box-shadow .15s ease;
            margin-top: 0.25rem;
        }

        .btn-submit:hover {
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 14px 26px -10px rgba(124,58,237,.7);
        }

        .terms-text {
            font-size: 0.76rem;
            color: var(--color-muted);
            text-align: center;
            margin-top: 1.1rem;
            line-height: 1.5;
        }
        .terms-text a { color: var(--color-primary); font-weight: 600; }
        .terms-text a:hover { color: var(--color-primary-hover); text-decoration: underline; }

        .login-link {
            text-align: center;
            font-size: 0.88rem;
            color: var(--color-body);
            margin-top: 1.4rem;
        }
        .login-link a { color: var(--color-primary); font-weight: 700; }
        .login-link a:hover { color: var(--color-primary-hover); text-decoration: underline; }

        /* ---------------- Responsivo ---------------- */
        @media (max-width: 991.98px) {
            .login-aside { display: none; }
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
            .login-card { padding: 1.75rem 1.35rem; }
            .type-selector-wrapper { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

    <div class="login-shell">

        {{-- PAINEL ESQUERDO — Focado na jornada do Candidato --}}
        <aside class="login-aside">
            <div class="brand-row">
                <span class="brand-icon"><i class="bi bi-graph-up-arrow"></i></span>
                Skill<span style="color: #C4B5FD;">Focus</span>
            </div>

            <div class="aside-content">
                <div class="eyebrow">Para Candidatos</div>
                <h1>O seu talento em primeiro lugar.</h1>
                <p class="lede">Participe de processos seletivos justos, onde as empresas olham para o que realmente importa: as suas habilidades e o seu potencial.</p>

                <ul class="aside-steps">
                    <li>
                        <span class="step-num"><i class="bi bi-person-fill"></i></span>
                        <span class="step-text"><strong>Crie seu perfil</strong>Preencha seus dados básicos e contato.</span>
                    </li>
                    <li>
                        <span class="step-num"><i class="bi bi-stars"></i></span>
                        <span class="step-text"><strong>Destaque sua experiência</strong>Adicione suas habilidades e histórico profissional.</span>
                    </li>
                    <li>
                        <span class="step-num"><i class="bi bi-briefcase-fill"></i></span>
                        <span class="step-text"><strong>Encontre a vaga ideal</strong>Seja notado por empresas que valorizam a diversidade.</span>
                    </li>
                </ul>
            </div>

            <div class="trust-line">
                <i class="bi bi-shield-check" style="font-size: 1.1rem;"></i> Privacidade garantida · Seleção sem vieses
            </div>
        </aside>

        {{-- PAINEL DIREITO — Formulário --}}
        <main class="login-form-panel">
            <div style="width: 100%; max-width: 440px;">

                <div class="mobile-brand">
                    <span class="brand-icon"><i class="bi bi-graph-up-arrow"></i></span>
                    Skill<span style="color: var(--color-primary);">Focus</span>
                </div>

                <div class="login-card">

                    <div class="auth-toggle">
                        <a href="{{ url('/login') }}" class="btn-toggle">Entrar</a>
                        <a href="{{ url('/register') }}" class="btn-toggle active">Criar conta</a>
                    </div>

                    <h1 class="form-title">Para candidatos</h1>
                    <p class="form-subtitle"><span class="free-dot"></span>Encontre os melhores trabalhos</p>

                    <!-- SELETOR DE PERFIL (Invertido para Candidato) -->
                    <div class="type-selector-wrapper">
                        <!-- Card Empresa (Agora é um link) -->
                        <a href="{{ url('/register') }}" class="type-card">
                            <i class="bi bi-building"></i>
                            <span>Sou Empresa</span>
                        </a>

                        <!-- Card Candidato (Estado ativo e Input de verdade) -->
                        <label class="type-card active">
                            <input type="radio" name="account_type" value="candidato" checked>
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

                    <form method="POST" action="/registerCandidato">
                        @csrf

                        <div class="field-group">
                            <label class="field-label" for="name">Nome completo</label>
                            <div class="input-group-custom">
                                <i class="bi bi-person"></i>
                                <input type="text" name="name" id="name" placeholder="Seu nome" required value="{{ old('name') }}">
                            </div>
                        </div>

                        <div class="field-group">
                            <label class="field-label" for="email">Seu melhor e-mail</label>
                            <div class="input-group-custom">
                                <i class="bi bi-envelope"></i>
                                <input type="email" name="email" id="email" placeholder="voce@contato.com" required value="{{ old('email') }}">
                            </div>
                        </div>

                        <div class="field-group">
                            <label class="field-label" for="password">Senha</label>
                            <div class="input-group-custom">
                                <i class="bi bi-key"></i>
                                <input type="password" name="password" id="password" placeholder="Crie uma senha" required minlength="8">
                                <button type="button" class="toggle-visibility" id="togglePassword" aria-label="Mostrar senha">
                                    <i class="bi bi-eye" id="togglePasswordIcon"></i>
                                </button>
                            </div>
                            <p class="password-hint">Use pelo menos 8 caracteres.</p>
                        </div>

                        <button type="submit" class="btn btn-submit">
                            Criar conta
                        </button>

                        <p class="terms-text">
                            Ao se cadastrar, você aceita nossos <a href="#">Termos de Serviço</a> e nossa <a href="#">Política de Privacidade</a>.
                        </p>
                    </form>

                    <div class="login-link">
                        Já tem conta? <a href="{{ url('/login') }}">Entrar</a>
                    </div>

                </div>
            </div>
        </main>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('togglePassword').addEventListener('click', function () {
            const input = document.getElementById('password');
            const icon = document.getElementById('togglePasswordIcon');
            const isHidden = input.type === 'password';
            input.type = isHidden ? 'text' : 'password';
            icon.classList.toggle('bi-eye', !isHidden);
            icon.classList.toggle('bi-eye-slash', isHidden);
        });
    </script>
</body>
</html>
