<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('blade.components.head.head', ['title' => $title ?? 'Sistema'])

    <body class="bg-gray-100">
        <livewire:alertMessage/>

        @yield('content')

        @livewireScripts
    </body>
</html>
