<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Senha | SkillFocus</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* ==========================================================
           SKILLFOCUS — DESIGN TOKENS
           Idênticos a login.blade.php e register.blade.php.
        ========================================================== */
        :root {
            --color-primary: #7C3AED;
            --color-primary-dark: #5B21B6;
            --color-primary-hover: #6D28D9;
            --color-primary-soft: #F3EEFE;
            --color-primary-softer: #FBFAFF;

            --color-shield: #0D9488;
            --color-shield-soft: #E8F8F6;

            --color-ink: #17152A;
            --color-body: #47435C;
            --color-muted: #77738F;
            --color-border: #E9E5F3;
            --color-surface: #FFFFFF;
            --color-bg: #FAF9FD;

            --radius-sm: 10px;
            --radius-lg: 22px;
            --shadow-card: 0 1px 2px rgba(23,21,42,.04), 0 10px 28px -14px rgba(23,21,42,.14);

            --font-display: 'Sora', 'Inter', sans-serif;
            --font-body: 'Inter', sans-serif;
        }

        * { -webkit-font-smoothing: antialiased; }
        html, body { height: 100%; }

        body {
            font-family: var(--font-body);
            color: var(--color-body);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1.25rem;
            background-color: var(--color-bg);
            background-image:
                radial-gradient(circle at 100% 0%, rgba(124,58,237,.06), transparent 45%),
                radial-gradient(circle at 0% 100%, rgba(13,148,136,.05), transparent 45%);
            background-attachment: fixed;
        }

        h1, h2, h3, .font-display { font-family: var(--font-display); }
        a { text-decoration: none; }

        .recovery-brand {
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
        }

        .recovery-card {
            background: var(--color-surface);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-card);
            max-width: 440px;
            width: 100%;
            padding: 2.25rem;
        }

        .icon-box {
            width: 60px;
            height: 60px;
            background-color: var(--color-primary-soft);
            color: var(--color-primary);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.25rem auto;
            font-size: 1.6rem;
        }

        .title {
            color: var(--color-ink);
            font-weight: 700;
            font-size: 1.4rem;
            margin-bottom: 0.5rem;
        }

        .subtitle {
            color: var(--color-muted);
            font-size: 0.9rem;
            margin-bottom: 1.85rem;
            line-height: 1.55;
        }

        .alert-soft-success {
            background-color: var(--color-shield-soft);
            border: 1px solid #BFE8E2;
            color: #0B6B62;
            border-radius: var(--radius-sm);
            font-size: 0.87rem;
            padding: 0.85rem 1rem;
            margin-bottom: 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.55rem;
        }

        .alert-soft-danger {
            background-color: #FDEEEE;
            border: 1px solid #F6D4D4;
            color: #B42318;
            border-radius: var(--radius-sm);
            padding: 0.8rem 1rem;
            font-size: 0.83rem;
            margin-bottom: 1.25rem;
        }
        .alert-soft-danger ul { margin-bottom: 0; padding-left: 1.1rem; }

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
            margin-bottom: 1.5rem;
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

        .btn-recovery {
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
        }

        .btn-recovery:hover {
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 14px 26px -10px rgba(124,58,237,.7);
        }

        .btn-back {
            color: var(--color-muted);
            font-weight: 600;
            font-size: 0.87rem;
            transition: color .15s ease;
        }
        .btn-back:hover { color: var(--color-primary); }

        .divider-line {
            border-top: 1px solid var(--color-border);
            margin-top: 1.5rem;
            padding-top: 1.25rem;
        }
    </style>
</head>
<body>

    <div style="width: 100%; max-width: 440px;">

        <div class="recovery-brand">
            <span class="brand-icon"><i class="bi bi-graph-up-arrow"></i></span>
            Skill<span style="color: var(--color-primary);">Focus</span>
        </div>

        <div class="recovery-card">

            <div class="icon-box">
                <i class="bi bi-person-lock"></i>
            </div>

            <div class="text-center">
                <h2 class="title">Recuperar senha</h2>
                <p class="subtitle">Esqueceu suas credenciais? Digite seu e-mail abaixo para receber as instruções de redefinição.</p>
            </div>

            <form action="{{ route('password.email') }}" method="POST">
                @csrf

                @if (session('status'))
                <div class="alert-soft-success">
                    <i class="bi bi-check-circle-fill"></i>
                    <div>{{ session('status') }}</div>
                </div>
                @endif

                @if ($errors->any())
                <div class="alert-soft-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <label class="field-label" for="email">E-mail</label>
                <div class="input-group-custom">
                    <i class="bi bi-envelope"></i>
                    <input type="email" id="email" name="email" placeholder="nome@empresa.com" required>
                </div>

                <button type="submit" class="btn btn-recovery">
                    Enviar link de recuperação <i class="bi bi-send ms-1"></i>
                </button>
            </form>

            <div class="text-center divider-line">
                <a href="/login" class="btn-back">
                    <i class="bi bi-arrow-left me-1"></i> Voltar para o login
                </a>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
