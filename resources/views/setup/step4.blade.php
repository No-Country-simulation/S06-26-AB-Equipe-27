@extends('layouts.setup')

@section('content')
<h2 class="text-2xl font-bold text-gray-800 mb-6">Passo 4 — Preferências de Correspondência por IA</h2>
<p class="text-gray-600 mb-8">É aqui que sua plataforma se torna única.</p>

<form method="POST" action="{{ route('setup.step4.post') }}">
    @csrf

    <!-- Validation Errors -->
    @if ($errors->any())
    <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-red-800">Ops! Algo deu errado.</h3>
                <div class="mt-2 text-sm text-red-700">
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
    <div class="mb-8">
        <label class="block text-sm font-semibold text-gray-700 mb-4">O que é mais importante ao combinar candidatos?</label>
        <p class="text-sm text-gray-500 mb-4">Arraste para classificar:</p>
        <div class="space-y-2" id="priority-list">
            @php
            $defaultPriority = ['technical_skills', 'diversity_goals', 'location', 'experience', 'education'];
            $currentPriority = $preferences->matching_priority ?? $defaultPriority;
            $priorityLabels = [
            'technical_skills' => 'Habilidades Técnicas',
            'diversity_goals' => 'Metas de Diversidade',
            'location' => 'Localização',
            'experience' => 'Experiência',
            'education' => 'Educação',
            ];
            @endphp
            @foreach($currentPriority as $index => $item)
            <div class="flex items-center p-4 bg-white border-2 border-gray-200 rounded-xl cursor-grab active:cursor-grabbing transition-all hover:border-purple-300 hover:shadow-md" draggable="true">
                <span class="flex items-center justify-center w-8 h-8 bg-purple-100 text-purple-700 rounded-full font-bold mr-4">{{ $index + 1 }}</span>
                <span class="font-medium text-gray-700 flex-1">{{ $priorityLabels[$item] }}</span>
                <input type="hidden" name="matching_priority[]" value="{{ $item }}">
                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"></path>
                </svg>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Candidate Radius & Remote -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
        <div class="bg-gradient-to-br from-purple-50 to-blue-50 p-6 rounded-xl border-2 border-purple-200">
            <label class="block text-sm font-semibold text-gray-700 mb-4">Raio do Candidato</label>
            <div class="flex items-center gap-4 mb-2">
                <span class="text-2xl font-bold text-purple-700" id="radius-value">{{ $preferences->candidate_radius ?? 50 }}</span>
                <span class="text-gray-600">km</span>
            </div>
            <input type="range" name="candidate_radius" min="5" max="200" value="{{ $preferences->candidate_radius ?? 50 }}" class="w-full" oninput="document.getElementById('radius-value').textContent = this.value">
        </div>

        <div class="bg-gradient-to-br from-green-50 to-emerald-50 p-6 rounded-xl border-2 border-green-200">
            <label class="flex items-center gap-3 cursor-pointer">
                <input type="checkbox" name="include_remote" class="w-5 h-5 text-green-600" {{ $preferences->include_remote ?? true ? 'checked' : '' }}>
                <span class="font-semibold text-gray-700">Incluir candidatos remotos</span>
            </label>
        </div>
    </div>

    <!-- Navigation -->
    <div class="flex justify-between">
        <a href="{{ route('setup.step3') }}" class="text-gray-600 hover:text-gray-800 font-medium py-3 px-6 rounded-xl border-2 border-gray-300 hover:border-gray-400 transition-all">
            Voltar
        </a>
        <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white font-semibold py-3 px-8 rounded-xl transition-all transform hover:scale-105 shadow-lg">
            Revisão Final
        </button>
    </div>
</form>

<script>
    // Drag and drop functionality
    const priorityList = document.getElementById('priority-list');
    let draggedItem = null;

    priorityList.addEventListener('dragstart', function(e) {
        draggedItem = e.target.closest('[draggable]');
        setTimeout(() => draggedItem.style.opacity = '0.5', 0);
    });

    priorityList.addEventListener('dragend', function(e) {
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