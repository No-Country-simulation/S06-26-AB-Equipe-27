<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Senha | SkillFocus</title>

    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts: Poppins (Títulos) e Inter (Textos) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        /* Paleta de Cores*/
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
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
        }

        h1, h2, h3, .btn {
            font-family: 'Poppins', sans-serif;
        }

        .recovery-card {
            background: #ffffff;
            border: none;
            border-radius: 2rem;
            box-shadow: 0 20px 40px rgba(74, 20, 140, 0.06);
            max-width: 480px;
            width: 100%;
            overflow: hidden;
        }

        /* Detalhe de pluralidade no topo */
        .card-top-bar {
            height: 6px;
            background: linear-gradient(to right, var(--primary-color), var(--accent-color), var(--secondary-color));
            width: 100%;
        }

        .card-body-content {
            padding: 3rem 2.5rem;
        }

        /* Ícone de interrogação/recuperação */
        .icon-box {
            width: 70px;
            height: 70px;
            background: rgba(255, 109, 0, 0.1);
            color: var(--secondary-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem auto;
            font-size: 2rem;
        }

        .title {
            color: var(--primary-color);
            font-weight: 700;
            font-size: 1.6rem;
            margin-bottom: 0.5rem;
        }

        .subtitle {
            color: #6C757D;
            font-size: 0.95rem;
            margin-bottom: 2rem;
            line-height: 1.5;
        }

        /* Alerta Personalizado de Sucesso */
        .alert-success {
            background-color: rgba(0, 191, 165, 0.1);
            border: 1px solid rgba(0, 191, 165, 0.2);
            color: #00796B;
            border-radius: 0.75rem;
            font-size: 0.9rem;
            padding: 1rem;
            margin-bottom: 1.5rem;
        }

        /* Customização do Input Estilizado */
        .form-floating .form-control {
            border-radius: 0.75rem;
            border: 1px solid #E2E8F0;
            background-color: #FAFAFA;
            padding-top: 1.625rem;
            padding-bottom: 0.625rem;
        }

        .form-floating .form-control:focus {
            border-color: var(--primary-color);
            background-color: #ffffff;
            box-shadow: 0 0 0 0.25rem rgba(74, 20, 140, 0.1);
        }

        .form-floating label {
            color: #8D8D8D;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* Botão de Envio */
        .btn-recovery {
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 0.75rem;
            padding: 0.875rem;
            font-size: 1rem;
            font-weight: 600;
            width: 100%;
            transition: all 0.3s ease;
            margin-top: 1rem;
        }

        .btn-recovery:hover {
            background-color: var(--secondary-color);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 109, 0, 0.25);
        }

        /* Link de Voltar */
        .btn-back {
            color: #8D8D8D;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.9rem;
            transition: color 0.2s ease;
        }

        .btn-back:hover {
            color: var(--primary-color);
        }
    </style>
</head>
<body>

    <div class="recovery-card">
        <!-- Barra de Cores do Topo -->
        <div class="card-top-bar"></div>

        <div class="card-body-content">

            <!-- Caixa do Ícone -->
            <div class="icon-box">
                <i class="bi bi-person-lock"></i>
            </div>

            <!-- Textos de Cabeçalho -->
            <div class="text-center">
                <h2 class="title">Recuperar Senha</h2>
                <p class="subtitle">Esqueceu suas credenciais? Não se preocupe. Digite seu e-mail abaixo para receber as instruções de redefinição.</p>
            </div>

            <!-- Formulário com a lógica enviada -->
            <form action="{{ route('password.email') }}" method="POST">
                @csrf

                <!-- Bloco Condicional de Mensagem de Status (Laravel) -->
                @if (session('status'))
                    <div class="alert alert-success d-flex align-items-center" role="alert">
                        <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                        <div>{{ session('status') }}</div>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif
                <!-- Campo E-mail estruturado com Floating Label -->
                <div class="form-floating mb-4">
                    <input type="email" class="form-control" id="email" name="email" placeholder="nome@empresa.com" required>
                    <label for="email">
                        <i class="bi bi-envelope text-muted"></i> Digite seu E-mail:
                    </label>
                </div>

                <!-- Botão de Envio solicitado -->
                <button type="submit" class="btn btn-recovery">
                    Enviar link de recuperação <i class="bi bi-paper-plane ms-2"></i>
                </button>
            </form>

            <!-- Link de retorno para conveniência do usuário -->
            <div class="text-center mt-4 pt-3 border-top">
                <a href="/login" class="btn-back">
                    <i class="bi bi-arrow-left me-1"></i> Voltar para o Login
                </a>
            </div>
            <div class="text-center mt-4 pt-3 border-top">
                <span>
                        @if($errors->any())
                        {{$errors->first()}}
                        @endif
                </span>
            </div>

        </div>
    </div>

    <!-- Bootstrap 5.3 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
