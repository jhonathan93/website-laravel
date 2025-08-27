<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('components.head.head', ['title' => $title ?? 'Sistema'])

    <body class="bg-gray-100">
        <livewire:components.notification.notification />

        @yield('content')

        @livewireScripts
    </body>
</html>
