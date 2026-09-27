<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('titulo', 'Registro') - ADMIN SENA</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('logoSena.svg') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex flex-col bg-[#001E30] text-slate-100 antialiased selection:bg-[#8AFD5D] selection:text-[#001E30]">
    @include('Includes.Auth.Header')

    <main class="flex flex-col">
        @yield('contenido')
    </main>

    @include('Includes.Auth.Footer')
</body>
</html>

