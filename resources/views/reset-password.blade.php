<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redefinir Senha | SkillFocus</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* ==========================================================
           SKILLFOCUS — DESIGN TOKENS
           (mesmos tokens usados em /jobs e /reports)
        ========================================================== */
        :root {
            --color-primary: #7C3AED;
            --color-primary-dark: #5B21B6;
            --color-primary-hover: #6D28D9;
            --color-primary-soft: #F3EEFE;
            --color-primary-softer: #FBFAFF;

            --color-shield: #0D9488;
            --color-shield-soft: #E8F8F6;
            --color-shield-danger: #B91C1C;
            --color-shield-danger-soft: #FDEAEA;

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
            --shadow-pop: 0 20px 48px -16px rgba(23, 21, 42, .20);

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
            background-color: var(--color-bg);
            background-image:
                radial-gradient(circle at 100% 0%, rgba(124, 58, 237, .08), transparent 45%),
                radial-gradient(circle at 0% 100%, rgba(13, 148, 136, .06), transparent 40%);
            background-attachment: fixed;
            color: var(--color-body);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
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

        /* ---------------- Brand mark (contexto de marca, como na navbar) ---------------- */
        .brand-row {
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

        .brand-row a {
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

        .brand-text {
            color: #462559;
        }

        .brand-text span {
            color: #4a0353;
        }

        /* ---------------- Card principal ---------------- */
        .auth-card {
            background-color: var(--color-surface);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-pop);
            padding: 2.5rem;
            max-width: 440px;
            width: 100%;
            position: relative;
            overflow: hidden;
        }

        .auth-card::before {
            content: "";
            position: absolute;
            inset: 0 0 auto 0;
            height: 4px;
            background: linear-gradient(90deg, var(--color-primary), var(--color-shield));
        }

        /* Ícone de destaque */
        .icon-box {
            width: 60px;
            height: 60px;
            background-color: var(--color-primary-soft);
            color: var(--color-primary);
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin: 0 auto 1.5rem auto;
        }

        .auth-heading h1 {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--color-ink);
            letter-spacing: -0.01em;
        }

        .auth-heading p {
            color: var(--color-muted);
            font-size: 0.9rem;
        }

        /* Inputs */
        .form-floating .form-control {
            border-radius: var(--radius-sm);
            border: 1px solid var(--color-border);
            background-color: var(--color-surface);
            color: var(--color-ink);
            padding: 1rem;
            font-size: 0.95rem;
        }

        .form-floating .form-control:focus {
            border-color: var(--color-primary);
            box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.12);
        }

        .form-floating label {
            color: var(--color-muted);
            font-size: 0.9rem;
        }

        /* Toggle de mostrar/ocultar senha */
        .password-field {
            position: relative;
        }

        .password-toggle {
            position: absolute;
            top: 0;
            bottom: 0;
            right: 0.9rem;
            display: flex;
            align-items: center;
            color: var(--color-muted);
            background: none;
            border: none;
            font-size: 1.05rem;
            z-index: 5;
            transition: color .15s ease;
        }

        .password-toggle:hover {
            color: var(--color-primary);
        }

        /* Indicador simples de força/requisitos */
        .hint-text {
            font-size: 0.78rem;
            color: var(--color-muted);
            display: flex;
            align-items: center;
            gap: 0.4rem;
            margin-top: -0.5rem;
        }

        .hint-text i {
            color: var(--color-shield);
            font-size: 0.85rem;
        }

        /* Botão principal */
        .btn-purple {
            background: linear-gradient(155deg, var(--color-primary), var(--color-primary-dark));
            color: #fff;
            border-radius: var(--radius-sm);
            padding: 0.8rem;
            font-weight: 600;
            font-size: 0.95rem;
            width: 100%;
            border: none;
            box-shadow: 0 10px 22px -10px rgba(124, 58, 237, .6);
            transition: transform .15s ease, box-shadow .15s ease;
        }

        .btn-purple:hover {
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 14px 26px -10px rgba(124, 58, 237, .7);
        }

        /* Alertas de erro */
        .alert {
            border-radius: var(--radius-sm);
            font-size: 0.87rem;
            background-color: var(--color-shield-danger-soft);
            color: var(--color-shield-danger);
            border: 1px solid rgba(185, 28, 28, .15);
        }

        .alert ul {
            padding-left: 1.1rem;
        }

        /* Link secundário */
        .back-link {
            color: var(--color-primary);
            font-weight: 600;
            font-size: 0.87rem;
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            transition: gap .15s ease, color .15s ease;
        }

        .back-link:hover {
            color: var(--color-primary-hover);
            gap: 0.55rem;
        }

        /* Rodapé de segurança, reforçando o selo Bias Shield da marca */
        .security-note {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
            color: var(--color-shield);
            font-weight: 600;
            font-size: 0.78rem;
            margin-top: 1.75rem;
        }
    </style>
</head>

<body>

    <div class="w-100 d-flex flex-column align-items-center">

        <div class="brand-row">
            <a href="#">
                <span class="brand-icon"><img src="logo.webp" alt="Skillfocus logo"></span>
                <div class="brand-text"> Skill<span>Focus</span></div>
            </a>
        </div>

        <div class="auth-card">
            <div class="icon-box">
                <i class="bi bi-shield-lock-fill"></i>
            </div>

            <div class="auth-heading text-center mb-4">
                <h1 class="mb-2">Redefinir Senha</h1>
                <p class="mb-0">Crie uma nova senha para acessar sua conta SkillFocus.</p>
            </div>

            @if ($errors->any())
            <div class="alert border-0 mb-4" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="/reset-password" method="POST">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ $email }}">

                <div class="form-floating mb-2 password-field">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Nova Senha" required>
                    <label for="password">Nova Senha</label>
                    <button type="button" class="password-toggle" data-target="password" aria-label="Mostrar senha">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
                <p class="hint-text mb-3"><i class="bi bi-info-circle-fill"></i> Use pelo menos 8 caracteres.</p>

                <div class="form-floating mb-4 password-field">
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirmar Senha" required>
                    <label for="password_confirmation">Confirmar Nova Senha</label>
                    <button type="button" class="password-toggle" data-target="password_confirmation" aria-label="Mostrar senha">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>

                <button type="submit" class="btn btn-purple">
                    Redefinir Senha
                </button>

                <div class="text-center mt-4">
                    <a href="/login" class="back-link">
                        <i class="bi bi-arrow-left"></i> Voltar ao login
                    </a>
                </div>
            </form>
        </div>

        <div class="security-note">
            <i class="bi bi-lock-fill"></i> Dados protegidos · Bias Shield ativo
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('.password-toggle').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var input = document.getElementById(btn.getAttribute('data-target'));
                var icon = btn.querySelector('i');
                var isHidden = input.type === 'password';
                input.type = isHidden ? 'text' : 'password';
                icon.classList.toggle('bi-eye');
                icon.classList.toggle('bi-eye-slash');
            });
        });
    </script>
</body>

</html>