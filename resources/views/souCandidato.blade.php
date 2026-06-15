<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SkillFocus</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* HERO */
        .hero {
            height: 50vh;
            background: url('images/banner_032.jpg') center/cover no-repeat;
            position: relative;
        }

        .hero::before {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(0,0,0,0.4);
        }

        .hero-content {
            position: relative;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* IMAGE BLOCK */
        .img-box {
            height: 300px;
            overflow: hidden;
            border-radius: 12px;
        }

        .img-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        /* LOGIN BOX */
        .login-box {
            border: 1px solid #000;
            border-radius: 12px;
            padding: 20px;
        }
    </style>
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg bg-light">
    <div class="container">
        <a class="navbar-brand" href="#">SkillFocus</a>

        <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#nav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="nav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="{{route('home')}}">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="{{route('souCandidato')}}">Sou candidato</a></li>
                <li class="nav-item"><a class="nav-link" href="{{route('souRecrutador')}}">Sou recrutador</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- HERO -->
<section class="hero">
    <div class="hero-content text-white text-center">
        <h1 class="fw-bold display-5">Nós somos o futuro.</h1>
    </div>
</section>

<!-- SECTION 1 -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-7">
                <h1>Contrate com base em competências</h1>
                <p>
                    O SkillFocus utiliza Inteligência Artificial para interpretar dados,
                    mapear competências e gerar insights estratégicos para recrutamento.
                </p>
                <button class="btn btn-dark w-50">Começar agora</button>
            </div>
        </div>
    </div>
</section>

<hr>

<!-- SECTION 2 (IMG SOME NO MOBILE) -->
<section class="py-5">
    <div class="container">
        <div class="row align-items-center">

            <!-- IMAGEM: some no mobile -->
            <div class="col-lg-6 d-none d-lg-block">
                <div class="img-box">
                    <img src="https://cdn.pixabay.com/photo/2016/08/22/14/42/engineer-1612104_1280.jpg">
                </div>
            </div>

            <div class="col-lg-6">
                <h1>Para Recrutadores e Empresas</h1>
                <h6>Decisões mais inteligentes</h6>
                <p>
                    O SkillFocus transforma dados em decisões estratégicas,
                    reduzindo vieses e ampliando a qualidade das contratações.
                </p>
            </div>

        </div>
    </div>
</section>

<hr>

<!-- LOGIN -->
<section class="py-5">
    <div class="container">
        <div class="row align-items-center">

            <div class="col-lg-6 mb-4">
                <h3>Aqui você contrata sem viés.</h3>
                <p>Processos mais justos, inteligentes e eficientes.</p>
            </div>

            <div class="col-lg-6">
                <div class="login-box">
                    <h3>Login</h3>
                    <input class="form-control mb-2" placeholder="Email">
                    <input type="password" class="form-control mb-3" placeholder="Senha">
                    <button class="btn btn-dark w-100">Entrar</button>
                </div>
            </div>

        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
