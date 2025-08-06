@extends('blade.app', ['title' => $profile ?? 'Bem-vindo'])

@section('content')
    <div class="flex flex-col min-h-screen bg-gray-50">
        <div class="flex flex-1 overflow-hidden">
            <livewire:menu />

            <main class="flex-1 overflow-y-auto">
                <div class="mx-auto">
                    @yield('main')
                </div>
            </main>
        </div>
    </div>
@endsection
