<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Vaga | SkillFocus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@500;600;700&family=Sora:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
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
            --color-danger: #DC2626;
            --color-danger-soft: #FDEDEC;
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
            --shadow-card-hover: 0 18px 36px -14px rgba(124, 58, 237, .28);
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
            background-color: var(--color-bg);
            background-image:
                radial-gradient(circle at 100% 0%, rgba(124, 58, 237, .06), transparent 45%),
                radial-gradient(circle at 0% 20%, rgba(13, 148, 136, .045), transparent 40%);
            background-attachment: fixed;
            color: var(--color-body);
            overflow-x: hidden;
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

        .main-container {
            padding: 3rem 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: calc(100% - 61px);
        }

        .form-card {
            background: var(--color-surface);
            width: 100%;
            max-width: 750px;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-card);
            border: 1px solid var(--color-border);
            padding: 2.25rem;
        }

        .btn-create {
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

        .btn-create:hover {
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 14px 26px -10px rgba(124, 58, 237, .7);
        }

        .add-skill-btn {
            color: var(--color-primary);
            font-weight: 600;
            font-size: 0.875rem;
            padding: 0;
            border: none;
            background: none;
        }

        .add-skill-btn:hover {
            color: var(--color-primary-hover);
        }

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
            padding: 0 0 0 0.9rem;
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

        .input-group-custom input,
        .input-group-custom textarea,
        .input-group-custom select {
            border: none;
            background: transparent;
            padding: 0.75rem 0.7rem;
            width: 100%;
            outline: none;
            color: var(--color-ink);
            font-size: 0.92rem;
        }

        .input-group-custom textarea {
            resize: vertical;
            padding-top: 0.9rem;
            padding-bottom: 0.9rem;
        }

        .input-group-custom input::placeholder,
        .input-group-custom textarea::placeholder {
            color: #ACA8C2;
        }

        .skills-wrapper .input-group-custom {
            margin-bottom: 0.5rem;
        }
    </style>
</head>

<body>

    {{-- NAVBAR SUPERIOR --}}
    <x-navbar activePage="jobs" />

    <div class="main-container">
        <div class="form-card">
            <h1 class="fw-bold mb-1 font-display" style="font-size: 1.85rem; color: var(--color-ink);">
                Editar vaga
            </h1>
            <p class="text-muted mb-4" style="font-size: 0.9375rem;">
                Preencha os dados abaixo para editar uma oportunidade.
            </p>
            <form method="POST" action="/jobs/{{ $job->id }}/edit">
                @csrf
                @method('PUT')

                @php
                $inputs = [
                [
                'label' => 'Título da oportunidade',
                'name' => 'title',
                'type' => 'text',
                'placeholder' => 'Título da vaga',
                'icon' => 'bi-briefcase',
                'required' => true,
                'value' => $job->title,
                ],
                [
                'label' => 'Descrição detalhada',
                'name' => 'description',
                'type' => 'textarea',
                'placeholder' => 'Descreva as atividades e o perfil esperado...',
                'icon' => 'bi-file-text',
                'required' => true,
                'rows' => 4,
                'value' => $job->description,
                ],
                ];
                @endphp

                @foreach($inputs as $input)
                <x-input
                    label="{{ $input['label'] }}"
                    name="{{ $input['name'] }}"
                    type="{{ $input['type'] }}"
                    placeholder="{{ $input['placeholder'] ?? '' }}"
                    icon="{{ $input['icon'] }}"
                    :value="$input['value'] ?? null"
                    :required="$input['required']"
                    :rows="$input['rows'] ?? null"
                    :options="$input['options'] ?? null" />
                @endforeach

                <div class="mb-4">
                    <label class="field-label">Principais Competências</label>
                    <div id="skills-container" class="skills-wrapper">
                        @php
                        $skills = is_array($job->required_skills) ? $job->required_skills : (is_string($job->required_skills) ? json_decode($job->required_skills, true) : []);
                        @endphp
                        @if(!empty($skills))
                        @foreach($skills as $skill)
                        <div class="input-group-custom mb-2">
                            <i class="bi bi-briefcase" style="color: #7C3AED;"></i>
                            <input type="text" name="required_skills[]" value="{{ $skill }}" placeholder="Skill (ex: Laravel)" required>
                            <button type="button" class="btn border-0 bg-transparent text-danger" onclick="this.parentElement.remove()">
                                <i class="bi bi-trash3"></i>
                            </button>
                        </div>
                        @endforeach
                        @else
                        <div class="input-group-custom mb-2">
                            <i class="bi bi-briefcase" style="color: #7C3AED;"></i>
                            <input type="text" name="required_skills[]" placeholder="Skill (ex: Laravel)" required>
                        </div>
                        @endif
                    </div>
                    <button type="button" id="add-skill-btn" class="add-skill-btn">
                        <i class="bi bi-plus-circle me-1"></i>Adicionar mais uma Skill
                    </button>
                </div>

                @php
                $rowInputs = [
                [
                'label' => 'Senioridade',
                'name' => 'level',
                'type' => 'select',
                'icon' => 'bi-person-badge',
                'required' => true,
                'options' => ['' => 'Selecione', 'junior' => 'Júnior', 'pleno' => 'Pleno', 'senior' => 'Sênior'],
                'col' => 'col-md-6',
                'value' => $job->level,
                ],
                [
                'label' => 'Cidade',
                'name' => 'city',
                'type' => 'text',
                'placeholder' => 'Cidade',
                'icon' => 'bi-geo-alt',
                'required' => true,
                'col' => 'col-md-6',
                'value' => $job->city,
                ],
                ];
                @endphp

                <div class="row g-3 mb-4">
                    @foreach($rowInputs as $input)
                    <div class="{{ $input['col'] }}">
                        <x-input
                            label="{{ $input['label'] }}"
                            name="{{ $input['name'] }}"
                            type="{{ $input['type'] }}"
                            placeholder="{{ $input['placeholder'] ?? '' }}"
                            icon="{{ $input['icon'] }}"
                            :value="$input['value'] ?? null"
                            :required="$input['required']"
                            :rows="$input['rows'] ?? null"
                            :options="$input['options'] ?? null" />
                    </div>
                    @endforeach
                </div>

                @php
                $singleInputs = [
                [
                'label' => 'Bairro',
                'name' => 'district',
                'type' => 'text',
                'placeholder' => 'Bairro',
                'icon' => 'bi-geo-alt',
                'required' => true,
                'value' => $job->district,
                ],
                ];
                @endphp

                @foreach($singleInputs as $input)
                <x-input
                    label="{{ $input['label'] }}"
                    name="{{ $input['name'] }}"
                    type="{{ $input['type'] }}"
                    placeholder="{{ $input['placeholder'] ?? '' }}"
                    icon="{{ $input['icon'] }}"
                    :value="$input['value'] ?? null"
                    :required="$input['required']"
                    :rows="$input['rows'] ?? null"
                    :options="$input['options'] ?? null" />
                @endforeach
                <button type="submit" class="btn-create w-100 mb-3">
                    Atualizar vaga
                </button>
                <p class="text-center text-muted mb-0" style="font-size: 0.875rem;">
                    Precisa de ajuda? <a href="#" style="color: var(--color-primary); font-weight: 700;">Saiba mais</a>
                </p>
            </form>
        </div>
    </div>
    <script>
        document.getElementById('add-skill-btn').addEventListener('click', function() {
            const container = document.getElementById('skills-container');
            const inputGroup = document.createElement('div');
            inputGroup.className = 'input-group-custom mb-2';
            inputGroup.innerHTML = `
                <i class="bi bi-briefcase" style="color: #7C3AED;"></i>
                <input type="text" name="required_skills[]" placeholder="Skill (ex: PHP)" required>
                <button type="button" class="btn border-0 bg-transparent text-danger" onclick="this.parentElement.remove()">
                    <i class="bi bi-trash3"></i>
                </button>
            `;
            container.appendChild(inputGroup);
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>