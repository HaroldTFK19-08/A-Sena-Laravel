<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('titulo', 'Inicio')</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('logoSena.svg') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex flex-col bg-[#F5F7F5] text-slate-800 antialiased selection:bg-[#39A900] selection:text-white">
    @include('Includes.Auth.Header')
    <main class="flex-1 bg-gradient-to-br from-[#F5F7F5] via-white to-[#EAF5E5]">
        @yield('contenido')
    </main>
    @include('Includes.Auth.Footer')
</body>
</html>
