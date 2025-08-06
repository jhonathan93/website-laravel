@extends('blade.app')

@section('content')
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-md max-w-md w-full">
            <div class="text-center">
                <svg class="mx-auto h-12 w-12 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>

                <h2 class="mt-4 text-xl font-bold text-gray-900">Acesso Restrito</h2>

                <p class="mt-2 text-gray-600">Você precisa estar autenticado para acessar esta página.</p>

                <div class="mt-6">
                    <a href="{{ route('login') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Ir para Login
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
