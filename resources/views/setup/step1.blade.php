@extends('layouts.setup')

@section('content')
<h2 class="text-2xl font-bold text-gray-800 mb-6">Passo 1 — Perfil de Diversidade da Empresa</h2>
<p class="text-gray-600 mb-8">Conte-nos sobre sua empresa</p>

<form method="POST" action="{{ route('setup.step1.post') }}">
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

    <!-- Company Size -->
    <div class="mb-8">
        <label class="block text-sm font-semibold text-gray-700 mb-4">Tamanho da Empresa</label>
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
            @foreach(['1-10', '11-50', '51-200', '201-1000', '1000+'] as $size)
            <label class="flex items-center p-4 border-2 rounded-xl cursor-pointer transition-all {{ old('size', $company->size) === $size ? 'border-purple-500 bg-purple-50' : 'border-gray-200 hover:border-purple-300' }}">
                <input type="radio" name="size" value="{{ $size }}" class="mr-3 w-4 h-4 text-purple-600" {{ old('size', $company->size) === $size ? 'checked' : '' }} required>
                <span class="font-medium">{{ $size }}</span>
            </label>
            @endforeach
        </div>
    </div>

    <!-- Work Model -->
    <div class="mb-8">
        <label class="block text-sm font-semibold text-gray-700 mb-4">Modelo de Trabalho</label>
        <div class="grid grid-cols-3 gap-4">
            @foreach(['remote' => 'Remoto', 'hybrid' => 'Híbrido', 'on-site' => 'Presencial'] as $value => $label)
            <label class="flex items-center p-4 border-2 rounded-xl cursor-pointer transition-all {{ old('work_model', $company->work_model) === $value ? 'border-purple-500 bg-purple-50' : 'border-gray-200 hover:border-purple-300' }}">
                <input type="radio" name="work_model" value="{{ $value }}" class="mr-3 w-4 h-4 text-purple-600" {{ old('work_model', $company->work_model) === $value ? 'checked' : '' }} required>
                <span class="font-medium">{{ $label }}</span>
            </label>
            @endforeach
        </div>
    </div>

    <!-- Inclusion Programs -->
    <div class="mb-8">
        <label class="block text-sm font-semibold text-gray-700 mb-4">Programas de Inclusão</label>
        <div class="grid grid-cols-2 gap-3">
            @php
            $programs = [
            'diversity_committee' => 'Comitê de Diversidade',
            'accessibility_program' => 'Programa de Acessibilidade',
            'mentorship_program' => 'Programa de Mentoria',
            'internship_program' => 'Programa de Estágio',
            'returnship_program' => 'Programa de Retorno ao Trabalho',
            'erg' => 'Grupos de Recursos de Funcionários (ERGs)',
            ];
            $selectedPrograms = old('inclusion_programs', $company->inclusion_programs ?? []);
            @endphp
            @foreach($programs as $value => $label)
            <label class="flex items-center p-3 border-2 rounded-lg cursor-pointer transition-all {{ in_array($value, (array)$selectedPrograms) ? 'border-purple-500 bg-purple-50' : 'border-gray-200 hover:border-purple-300' }}">
                <input type="checkbox" name="inclusion_programs[]" value="{{ $value }}" class="mr-3 w-4 h-4 text-purple-600" {{ in_array($value, (array)$selectedPrograms) ? 'checked' : '' }}>
                <span>{{ $label }}</span>
            </label>
            @endforeach
        </div>
    </div>

    <!-- Diversity Statement -->
    <div class="mb-8">
        <label class="block text-sm font-semibold text-gray-700 mb-4">Declaração de Diversidade</label>
        <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 bg-gray-50">
            <textarea name="diversity_statement" rows="4" class="w-full bg-transparent border-none resize-none focus:ring-0 text-gray-700" placeholder="Estamos comprometidos em criar um ambiente de trabalho inclusivo onde profissionais de todos os fundos possam prosperar.">{{ old('diversity_statement', $company->diversity_statement) }}</textarea>
        </div>
    </div>

    <!-- Continue Button -->
    <div class="flex justify-end">
        <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white font-semibold py-3 px-8 rounded-xl transition-all transform hover:scale-105 shadow-lg">
            Continuar
        </button>
    </div>
</form>
@endsection