@php
    $portalName = request()->routeIs('instructor.*')
        ? 'INSTRUCTOR'
        : (request()->routeIs('aprendiz.*') ? 'APRENDIZ' : (request()->routeIs('aspirante.*') ? 'ASPIRANTE' : 'ADMIN'));
@endphp

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('titulo', 'Inicio') | {{ $portalName }} SENA</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('logoSena.svg') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="min-h-screen bg-[#F2F7F8] text-slate-900 antialiased selection:bg-[#8AFD5D] selection:text-[#001E30]">
    <div class="h-screen flex overflow-hidden">
        {{-- SIDEBAR --}}
        @if(request()->routeIs('aprendiz.*'))
            @include('Includes.Usuarios.Aprendices.Sidebar')
        @elseif(request()->routeIs('instructor.*'))
            @include('Includes.Usuarios.Instructores.Sidebar')
        @elseif(request()->routeIs('aspirante.*'))
            @include('Includes.Usuarios.Aspirantes.Sidebar')
        @else
            @include('Includes.Usuarios.Admin.Sidebar')
        @endif
        {{-- CONTENIDO --}}
        <div class="flex-1 min-w-0 flex flex-col">
            {{-- HEADER --}}
            @if(request()->routeIs('aprendiz.*'))
                @include('Includes.Usuarios.Aprendices.Header')
            @elseif(request()->routeIs('instructor.*'))
                @include('Includes.Usuarios.Instructores.Header')
            @elseif(request()->routeIs('aspirante.*'))
                @include('Includes.Usuarios.Aspirantes.Header')
            @else
                @include('Includes.Usuarios.Admin.Header')
            @endif
            {{-- MAIN --}}
            <main class="admin-main flex-1 overflow-y-auto p-6 pb-24 md:p-8 md:pb-24 lg:pb-8">
                <div class="admin-content">
                    @yield('contenido')
                </div>
            </main>
        </div>
    </div>
    @stack('scripts')
</body>
</html>

