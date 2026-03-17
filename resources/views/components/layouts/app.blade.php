<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'GYMADM') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="h-dvh flex flex-col">

<header class="w-full shrink-0">
    <x-partials.header/>
</header>

<div class="flex flex-1 overflow-hidden">

    <nav class="hidden md:flex md:flex-col md:w-1/5 overflow-y-auto bg-slate-900 border-r-4 border-black">
        <x-partials.navbar/>
    </nav>

    <main class="flex-1 overflow-y-auto p-4 md:p-8">
        {{ $slot }}
    </main>

</div>

<footer class="md:hidden shrink-0 w-full z-50">
    <nav>
        <x-partials.navbar/>
    </nav>
</footer>

@livewireScripts
</body>
</html>
