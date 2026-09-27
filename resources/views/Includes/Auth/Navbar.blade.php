<nav class="flex items-center gap-4">
    <ul class="flex justify-center items-center space-x-3 sm:space-x-4">
        <li>
            <a href="{{ route('auth.login') }}" class="text-sm font-medium px-4 py-2 rounded-lg transition-colors {{ request()->routeIs('auth.login') ? 'text-[#8AFD5D] bg-white/10' : 'text-slate-200 hover:text-white hover:bg-white/5' }}">
                Iniciar Sesión
            </a>
        </li>
        <li>
            <a href="{{ route('auth.register') }}" class="text-sm font-semibold text-[#001E30] bg-[#8AFD5D] hover:bg-[#72db4c] px-5 py-2.5 rounded-lg shadow-md hover:shadow-[#8AFD5D]/20 transition-all duration-200">
                Registrarse
            </a>
        </li>
    </ul>
</nav>
