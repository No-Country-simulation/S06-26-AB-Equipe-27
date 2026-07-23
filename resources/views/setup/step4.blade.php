@extends('layouts.setup')

@section('content')
<style>
    /* ==========================================================
       SKILLFOCUS — TOKENS (mesma paleta usada em /jobs, /reports,
       /matches, telas de auth e nos Passos 1, 2 e 3 do setup)
    ========================================================== */
    .sf-eyebrow {
        color: #7C3AED;
        letter-spacing: .08em;
    }

    .sf-card {
        border: 1px solid #E9E5F3;
        box-shadow: 0 1px 2px rgba(23, 21, 42, .04), 0 10px 28px -14px rgba(23, 21, 42, .14);
    }

    .sf-step-dot {
        transition: all .2s ease;
    }

    /* Lista de prioridades arrastável */
    .sf-priority-item {
        border: 2px solid #E9E5F3;
        background-color: #FFFFFF;
        border-radius: 14px;
        transition: border-color .15s ease, box-shadow .15s ease, opacity .15s ease;
    }

    .sf-priority-item:hover {
        border-color: #C9BEF2;
        box-shadow: 0 6px 14px -6px rgba(23, 21, 42, .14);
    }

    .sf-priority-item.dragging {
        opacity: .4;
    }

    .sf-rank-badge {
        background-color: #F3EEFE;
        color: #7C3AED;
        font-family: 'Sora', 'Inter', sans-serif;
    }

    .sf-drag-handle {
        color: #C9C5DA;
    }

    /* Painel de raio de busca (marca) */
    .sf-radius-box {
        background: linear-gradient(135deg, #F3EEFE, #FBFAFF);
        border: 2px solid #E9E5F3;
        border-radius: 18px;
        padding: 1rem;
        height: 11rem;
    }

    .sf-radius-value {
        font-family: 'Sora', 'Inter', sans-serif;
        color: #7C3AED;
    }

    /* Slider customizado, cor de marca no preenchimento e no thumb */
    input[type="range"].sf-range {
        -webkit-appearance: none;
        appearance: none;
        width: 100%;
        height: 6px;
        border-radius: 99px;
        background: #E9E5F3;
        outline: none;
    }

    input[type="range"].sf-range::-webkit-slider-thumb {
        -webkit-appearance: none;
        appearance: none;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: #7C3AED;
        box-shadow: 0 2px 8px rgba(124, 58, 237, .45);
        cursor: pointer;
        border: 3px solid #fff;
    }

    input[type="range"].sf-range::-moz-range-thumb {
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: #7C3AED;
        box-shadow: 0 2px 8px rgba(124, 58, 237, .45);
        cursor: pointer;
        border: 3px solid #fff;
    }

    /* Painel do toggle "remoto" (tom Bias Shield) */
    .sf-remote-box {
        background: linear-gradient(135deg, #E8F8F6, #FBFAFF);
        border: 2px solid #CFF0EA;
        border-radius: 18px;
        padding: 1rem;
        height: 11rem;
    }

    /* Custom Radio & Checkbox Styles */
    .sf-remote-checkbox {
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        width: 24px;
        height: 24px;
        border: 2px solid #E9E5F3;
        background-color: #FFFFFF;
        cursor: pointer;
        position: relative;
        transition: all 0.15s ease;
        flex-shrink: 0;
        border-radius: 6px;
    }

    .sf-remote-checkbox:checked {
        border-color: #0D9488;
        background-color: #0D9488;
    }

    .sf-remote-checkbox:checked::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 14px;
        height: 14px;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='white'%3E%3Cpath d='M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z'/%3E%3C/svg%3E");
        background-size: contain;
        background-repeat: no-repeat;
    }

    .sf-btn-final {
        background: linear-gradient(155deg, #7C3AED, #5B21B6);
        box-shadow: 0 10px 22px -10px rgba(124, 58, 237, .6);
        transition: transform .15s ease, box-shadow .15s ease;
        height: 48px;
        width: 100%;
        max-width: 170px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .sf-btn-final:hover {
        transform: translateY(-1px);
        box-shadow: 0 14px 26px -10px rgba(124, 58, 237, .7);
    }

    .sf-btn-back {
        transition: all .15s ease;
        height: 48px;
        width: 100%;
        max-width: 100px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .sf-btn-back:hover {
        border-color: #C9BEF2;
        color: #7C3AED;
        background-color: #FBFAFF;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {

        .sf-btn-final,
        .sf-btn-back {
            padding: 0.625rem 1rem !important;
            font-size: 0.875rem !important;
        }

        .sf-priority-item {
            padding: 0.75rem !important;
        }

        .sf-radius-box,
        .sf-remote-box {
            padding: 1rem !important;
        }

        .mb-9 {
            margin-bottom: 1.5rem !important;
        }

        .mb-8 {
            margin-bottom: 1.25rem !important;
        }
    }
</style>

<!-- Indicador de progresso do wizard -->
<div class="flex items-center gap-2 mb-8">
    @for ($i = 1; $i <= 4; $i++)
        <div class="flex items-center gap-2 {{$i < 4 ? 'flex-1' : 'flex-0'}}">
        <div class="sf-step-dot w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold text-white"
            style="background: linear-gradient(155deg, #7C3AED, #5B21B6);">
            {{ $i }}
        </div>
        @if($i < 4)
            <div class="h-[2px] flex-1 rounded-full bg-[#7C3AED]">
</div>
@endif
</div>
@endfor
</div>

<div class="flex items-center gap-1 mb-2">
    <span class="sf-eyebrow text-xs font-bold uppercase">Etapa 4 de 4</span>
</div>
<h2 class="text-2xl font-bold text-[#17152A] mb-2">Preferências de Correspondência por IA</h2>
<p class="text-[#77738F] mb-8">É aqui que sua plataforma se torna única.</p>

<div class="sf-card bg-white rounded-2xl p-6 md:p-8">
    <form method="POST" action="{{ route('setup.step4.post') }}">
        @csrf

        <!-- Validation Errors -->
        @if ($errors->any())
        <div class="mb-8 bg-[#FDEAEA] border border-[#F5C6C6] p-4 rounded-xl">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-[#B91C1C]" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-semibold text-[#991B1B]">Ops! Algo deu errado.</h3>
                    <div class="mt-2 text-sm text-[#B91C1C]">
                        <ul class="list-disc pl-5 space-y-1">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Matching Priority -->
        <div class="mb-9">
            <div class="flex items-center gap-2 mb-1">
                <span class="w-8 h-8 rounded-lg bg-[#F3EEFE] text-[#7C3AED] inline-flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7h12M8 12h12M8 17h12M4 7h.01M4 12h.01M4 17h.01" />
                    </svg>
                </span>
                <label class="block text-sm font-semibold text-[#17152A]">O que é mais importante ao combinar candidatos?</label>
            </div>
            <p class="text-xs text-[#9C97B5] mb-4 ml-10">Arraste os cartões para classificar por ordem de importância.</p>

            <div class="space-y-2" id="priority-list">
                @php
                $defaultPriority = ['technical_skills', 'diversity_goals', 'experience'];
                $currentPriority = $preferences->matching_priority ?? $defaultPriority;
                $priorityLabels = [
                'technical_skills' => 'Habilidades Técnicas',
                'diversity_goals' => 'Metas de Diversidade',
                'experience' => 'Experiência',
                ];
                @endphp
                @foreach($currentPriority as $index => $item)
                <div class="sf-priority-item flex items-center p-3.5 cursor-grab active:cursor-grabbing" draggable="true">
                    <span class="sf-rank-badge flex items-center justify-center w-8 h-8 rounded-full font-bold mr-4 flex-shrink-0">{{ $index + 1 }}</span>
                    <span class="font-medium text-[#47435C] flex-1">{{ $priorityLabels[$item] }}</span>
                    <input type="hidden" name="matching_priority[]" value="{{ $item }}">
                    <svg class="sf-drag-handle w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"></path>
                    </svg>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Candidate Radius & Remote -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-9">
            <div class="sf-radius-box p-6">
                <div class="flex items-center gap-2 mb-2">
                    <span class="w-8 h-8 rounded-lg bg-white text-[#7C3AED] inline-flex items-center justify-center flex-shrink-0 shadow-sm">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </span>
                    <label class="block text-sm font-semibold text-[#17152A]">Raio do Candidato</label>
                </div>
                <div class="flex items-baseline gap-2 mb-3">
                    <span class="sf-radius-value text-3xl font-extrabold" id="radius-value">{{ $preferences->candidate_radius ?? 50 }}</span>
                    <span class="text-[#77738F] text-sm font-medium">km</span>
                </div>
                <input type="range" class="sf-range" name="candidate_radius" min="5" max="200" value="{{ $preferences->candidate_radius ?? 50 }}" oninput="document.getElementById('radius-value').textContent = this.value">
                <div class="flex justify-between text-xs text-[#9C97B5] mt-2">
                    <span>5 km</span>
                    <span>200 km</span>
                </div>
            </div>

            <div class="sf-remote-box p-6 flex flex-col justify-center">
                <label class="flex items-start gap-3 cursor-pointer">
                    <input type="checkbox" name="include_remote" class="sf-remote-checkbox w-5 h-5 mt-0.5" {{ $preferences->include_remote ?? true ? 'checked' : '' }}>
                    <span>
                        <span class="font-semibold text-[#17152A] block mb-1">Incluir candidatos remotos</span>
                        <span class="text-xs text-[#47435C]">Amplia o alcance do Bias Shield para além do raio definido ao lado.</span>
                    </span>
                </label>
            </div>
        </div>

        <!-- Navigation -->
        <div class="flex justify-between items-center pt-2 border-t border-[#E9E5F3]">
            <a href="{{ route('setup.step3') }}" class="sf-btn-back text-[#47435C] font-semibold rounded-xl border-2 border-[#E9E5F3]">
                Voltar
            </a>
            <button type="submit" class="sf-btn-final text-white font-semibold rounded-xl inline-flex items-center gap-2">
                Revisão Final
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        </div>
    </form>
</div>

<script>
    // Drag and drop functionality
    const priorityList = document.getElementById('priority-list');
    let draggedItem = null;

    priorityList.addEventListener('dragstart', function(e) {
        draggedItem = e.target.closest('[draggable]');
        draggedItem.classList.add('dragging');
        setTimeout(() => draggedItem.style.opacity = '0.5', 0);
    });

    priorityList.addEventListener('dragend', function(e) {
        draggedItem.classList.remove('dragging');
        draggedItem.style.opacity = '';
        updateOrder();
    });

    priorityList.addEventListener('dragover', function(e) {
        e.preventDefault();
        const afterElement = getDragAfterElement(priorityList, e.clientY);
        if (afterElement == null) {
            priorityList.appendChild(draggedItem);
        } else {
            priorityList.insertBefore(draggedItem, afterElement);
        }
    });

    function getDragAfterElement(container, y) {
        const draggableElements = [...container.querySelectorAll('[draggable]:not(.dragging)')];
        return draggableElements.reduce((closest, child) => {
            const box = child.getBoundingClientRect();
            const offset = y - box.top - box.height / 2;
            if (offset < 0 && offset > closest.offset) {
                return {
                    offset: offset,
                    element: child
                };
            } else {
                return closest;
            }
        }, {
            offset: Number.NEGATIVE_INFINITY
        }).element;
    }

    function updateOrder() {
        const items = priorityList.querySelectorAll('[draggable]');
        items.forEach((item, index) => {
            item.querySelector('span:first-child').textContent = index + 1;
            const hiddenInput = item.querySelector('input[type="hidden"]');
            // Remove and re-append to update order in DOM (which sets POST order)
            item.appendChild(hiddenInput);
        });
    }
</script>
@endsection