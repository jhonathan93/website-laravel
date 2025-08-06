@extends('blade.app', ['title' => '404'])

@section('content')
    <div class="bg-gray-100 flex items-center justify-center h-screen">
        <div class="text-center">
            <img class="w-96 h-96 mx-auto" src="{{ asset('storage/images/errors/page-not-found.svg') }}" alt="Página não encontrada">

            <h1 class="text-4xl font-bold text-gray-800 mb-4">404</h1>
            <p class="text-xl text-gray-600 mb-6">Oops! Página não encontrada.</p>
            <p class="text-gray-500 mb-8">A página que você está procurando não existe ou foi removida.</p>

            <a href="{{ route('login') }}" class="px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition duration-300">
                Voltar para a página inicial
            </a>
        </div>
    </div>
@endsection
