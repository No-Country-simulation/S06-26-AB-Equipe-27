@extends('layouts.candidate-setup')

@section('content')
<div class="flex items-center gap-2 mb-8">
    @for ($i = 1; $i <= 6; $i++)
        <div class="flex items-center gap-2 {{ $i < 6 ? 'flex-1' : 'flex-0' }}">
            <div class="sf-step-dot w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold
                {{ $i <= 4 ? 'text-white' : 'text-[#9C97B5] bg-[#F3EEFE]' }}"
                @if($i <= 4) style="background: linear-gradient(155deg, #7C3AED, #5B21B6);" @endif>
                {{ $i }}
            </div>
            @if($i < 6)
                <div class="h-[2px] flex-1 rounded-full {{ $i <= 3 ? 'bg-[#7C3AED]' : 'bg-[#E9E5F3]' }}"></div>
            @endif
        </div>
    @endfor
</div>

<div class="flex items-center gap-1 mb-2">
    <span class="sf-eyebrow text-xs font-bold uppercase">Etapa 4 de 6</span>
</div>
<h2 class="text-2xl font-bold text-[#17152A] mb-2">Experiência Profissional</h2>
<p class="text-[#77738F] mb-8">Revise as experiências extraídas automaticamente do seu currículo. Você pode editar se necessário.</p>

<div class="sf-card bg-white rounded-2xl p-6 md:p-8">
    <form id="experience-form" method="POST" action="{{ route('candidate-setup.step4.post') }}">
        @csrf

        <div id="experiences-container" class="space-y-4 mb-6">
            @php
                $experiences = $candidate->work_experience ?? [];
                if (empty($experiences)) {
                    $experiences = [[]];
                }
            @endphp
            @foreach ($experiences as $index => $exp)
                <div class="sf-item-card experience-item">
                    <div class="flex items-start justify-between mb-4">
                        <h3 class="text-base font-bold text-[#17152A]">Experiência {{ $index + 1 }}</h3>
                        @if (count($experiences) > 1 || !empty($candidate->work_experience))
                            <button type="button" class="remove-exp-btn sf-btn-danger">
                                <i class="bi bi-trash"></i> Remover
                            </button>
                        @endif
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="sf-field-label">Empresa</label>
                            <input type="text" name="work_experience[{{ $index }}][company]" value="{{ $exp['company'] ?? '' }}" class="sf-input">
                        </div>
                        <div>
                            <label class="sf-field-label">Cargo</label>
                            <input type="text" name="work_experience[{{ $index }}][position]" value="{{ $exp['position'] ?? '' }}" class="sf-input">
                        </div>
                        <div>
                            <label class="sf-field-label">Ano de Início</label>
                            <input type="text" name="work_experience[{{ $index }}][start_year]" value="{{ $exp['start_year'] ?? '' }}" class="sf-input">
                        </div>
                        <div>
                            <label class="sf-field-label">Ano de Fim (ou "Presente")</label>
                            <input type="text" name="work_experience[{{ $index }}][end_year]" value="{{ $exp['end_year'] ?? '' }}" class="sf-input">
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <button type="button" id="add-exp-btn" class="sf-btn-secondary">
            <i class="bi bi-plus mr-1"></i> Adicionar outra Experiência
        </button>

        <div class="flex justify-between items-center gap-3 pt-6 mt-6 border-t border-[#E9E5F3]">
            <a href="{{ route('candidate-setup.step3') }}" class="sf-btn-back">
                <i class="bi bi-arrow-left mr-2"></i> Voltar
            </a>
            <button type="submit" class="sf-btn-continue">Continuar</button>
        </div>
    </form>
</div>

<script>
    let experienceCount = {{ count($experiences) }};

    document.getElementById('add-exp-btn').addEventListener('click', function() {
        const container = document.getElementById('experiences-container');
        const newExp = document.createElement('div');
        newExp.className = 'sf-item-card experience-item';
        newExp.innerHTML = `
            <div class="flex items-start justify-between mb-4">
                <h3 class="text-base font-bold text-[#17152A]">Experiência ${experienceCount + 1}</h3>
                <button type="button" class="remove-exp-btn sf-btn-danger">
                    <i class="bi bi-trash"></i> Remover
                </button>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="sf-field-label">Empresa</label>
                    <input type="text" name="work_experience[${experienceCount}][company]" class="sf-input">
                </div>
                <div>
                    <label class="sf-field-label">Cargo</label>
                    <input type="text" name="work_experience[${experienceCount}][position]" class="sf-input">
                </div>
                <div>
                    <label class="sf-field-label">Ano de Início</label>
                    <input type="text" name="work_experience[${experienceCount}][start_year]" class="sf-input">
                </div>
                <div>
                    <label class="sf-field-label">Ano de Fim (ou "Presente")</label>
                    <input type="text" name="work_experience[${experienceCount}][end_year]" class="sf-input">
                </div>
            </div>
        `;
        container.appendChild(newExp);
        experienceCount++;
        newExp.querySelector('.remove-exp-btn').addEventListener('click', () => {
            newExp.remove();
            reindexExperiences();
        });
        reindexExperiences();
    });

    document.querySelectorAll('.remove-exp-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            this.closest('.experience-item').remove();
            reindexExperiences();
        });
    });

    function reindexExperiences() {
        const items = document.querySelectorAll('.experience-item');
        items.forEach((item, index) => {
            item.querySelector('h3').textContent = `Experiência ${index + 1}`;
            item.querySelectorAll('input').forEach(input => {
                input.name = input.name.replace(/work_experience\[\d+\]/, `work_experience[${index}]`);
            });
            const removeBtn = item.querySelector('.remove-exp-btn');
            if (removeBtn) removeBtn.style.display = items.length <= 1 ? 'none' : 'inline-flex';
        });
        experienceCount = items.length;
    }
</script>
@endsection
