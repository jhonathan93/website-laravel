@extends('blade.app', ['title' => 'Cadastro'])

@section('content')
    <form class="p-6 space-y-6">
        <livewire:components.forms.users.users-form />

        <livewire:components.forms.addresses.addresses-form />

        <div class="flex items-center">
            <input type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" id="terms" name="terms" required>

            <label for="terms" class="ml-2 block text-sm text-gray-900">
                Concordo com os <a href="#" class="text-blue-600 hover:text-blue-800">Termos e Condições</a> e <a href="#" class="text-blue-600 hover:text-blue-800">Política de Privacidade</a>
            </label>
        </div>

        <div class="flex flex-col sm:flex-row gap-4 justify-end">
            <button type="reset" class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                Limpar
            </button>

            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                Criar Conta
            </button>
        </div>
    </form>
@endsection
