@extends('layouts.candidate-setup')

@section('content')
<div class="flex items-center gap-2 mb-8">
    @for ($i = 1; $i <= 6; $i++)
        <div class="flex items-center gap-2 {{ $i < 6 ? 'flex-1' : 'flex-0' }}">
            <div class="sf-step-dot w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold
                {{ $i <= 5 ? 'text-white' : 'text-[#9C97B5] bg-[#F3EEFE]' }}"
                @if($i <= 5) style="background: linear-gradient(155deg, #7C3AED, #5B21B6);" @endif>
                {{ $i }}
            </div>
            @if($i < 6)
                <div class="h-[2px] flex-1 rounded-full {{ $i <= 4 ? 'bg-[#7C3AED]' : 'bg-[#E9E5F3]' }}"></div>
            @endif
        </div>
    @endfor
</div>

<div class="flex items-center gap-1 mb-2">
    <span class="sf-eyebrow text-xs font-bold uppercase">Etapa 5 de 6</span>
</div>
<h2 class="text-2xl font-bold text-[#17152A] mb-2">Educação</h2>
<p class="text-[#77738F] mb-8">Essas informações foram extraídas automaticamente do seu currículo. Você pode editá-las ou adicionar novas.</p>

<div class="sf-card bg-white rounded-2xl p-6 md:p-8">
    <form id="education-form" method="POST" action="{{ route('candidate-setup.step5.post') }}">
        @csrf

        <div id="educations-container" class="space-y-4 mb-6">
            @php
                $educations = $candidate->education ?? [];
                if (empty($educations)) {
                    $educations = [[]];
                }
            @endphp
            @foreach ($educations as $index => $edu)
                <div class="sf-item-card education-item">
                    <div class="flex items-start justify-between mb-4">
                        <h3 class="text-base font-bold text-[#17152A]">Formação {{ $index + 1 }}</h3>
                        @if (count($educations) > 1 || !empty($candidate->education))
                            <button type="button" class="remove-edu-btn sf-btn-danger">
                                <i class="bi bi-trash"></i> Remover
                            </button>
                        @endif
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="sf-field-label">Grau / Curso</label>
                            <input type="text" name="education[{{ $index }}][degree]" value="{{ $edu['degree'] ?? '' }}" class="sf-input">
                        </div>
                        <div>
                            <label class="sf-field-label">Instituição</label>
                            <input type="text" name="education[{{ $index }}][school]" value="{{ $edu['school'] ?? '' }}" class="sf-input">
                        </div>
                        <div>
                            <label class="sf-field-label">Ano de Início</label>
                            <input type="text" name="education[{{ $index }}][start_year]" value="{{ $edu['start_year'] ?? '' }}" class="sf-input">
                        </div>
                        <div>
                            <label class="sf-field-label">Ano de Conclusão</label>
                            <input type="text" name="education[{{ $index }}][end_year]" value="{{ $edu['end_year'] ?? '' }}" class="sf-input">
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <button type="button" id="add-edu-btn" class="sf-btn-secondary">
            <i class="bi bi-plus mr-1"></i> Adicionar outra Formação
        </button>

        <div class="flex justify-between items-center gap-3 pt-6 mt-6 border-t border-[#E9E5F3]">
            <a href="{{ route('candidate-setup.step4') }}" class="sf-btn-back">
                <i class="bi bi-arrow-left mr-2"></i> Voltar
            </a>
            <button type="submit" class="sf-btn-continue">Continuar</button>
        </div>
    </form>
</div>

<script>
    let educationCount = {{ count($educations) }};

    document.getElementById('add-edu-btn').addEventListener('click', function() {
        const container = document.getElementById('educations-container');
        const newEdu = document.createElement('div');
        newEdu.className = 'sf-item-card education-item';
        newEdu.innerHTML = `
            <div class="flex items-start justify-between mb-4">
                <h3 class="text-base font-bold text-[#17152A]">Formação ${educationCount + 1}</h3>
                <button type="button" class="remove-edu-btn sf-btn-danger">
                    <i class="bi bi-trash"></i> Remover
                </button>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="sf-field-label">Grau / Curso</label>
                    <input type="text" name="education[${educationCount}][degree]" class="sf-input">
                </div>
                <div>
                    <label class="sf-field-label">Instituição</label>
                    <input type="text" name="education[${educationCount}][school]" class="sf-input">
                </div>
                <div>
                    <label class="sf-field-label">Ano de Início</label>
                    <input type="text" name="education[${educationCount}][start_year]" class="sf-input">
                </div>
                <div>
                    <label class="sf-field-label">Ano de Conclusão</label>
                    <input type="text" name="education[${educationCount}][end_year]" class="sf-input">
                </div>
            </div>
        `;
        container.appendChild(newEdu);
        educationCount++;
        newEdu.querySelector('.remove-edu-btn').addEventListener('click', () => {
            newEdu.remove();
            reindexEducations();
        });
        reindexEducations();
    });

    document.querySelectorAll('.remove-edu-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            this.closest('.education-item').remove();
            reindexEducations();
        });
    });

    function reindexEducations() {
        const items = document.querySelectorAll('.education-item');
        items.forEach((item, index) => {
            item.querySelector('h3').textContent = `Formação ${index + 1}`;
            item.querySelectorAll('input').forEach(input => {
                input.name = input.name.replace(/education\[\d+\]/, `education[${index}]`);
            });
            const removeBtn = item.querySelector('.remove-edu-btn');
            if (removeBtn) removeBtn.style.display = items.length <= 1 ? 'none' : 'inline-flex';
        });
        educationCount = items.length;
    }
</script>
@endsection
