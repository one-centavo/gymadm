<ul class="flex items-stretch justify-around md:justify-start bg-slate-900 border-t-4 border-gym-blue text-sm font-black text-white md:flex-col md:border-t-0 md:h-full hover:overflow-hidden">

    @if(auth()->check() && auth()->user()->role === 'admin')
        <x-nav-link :active="request()->routeIs('members.index')" icon="user-group" href="{{ route('members.index') }}">
            Miembros
        </x-nav-link>

        <x-nav-link :active="request()->routeIs('memberships.index')" icon="identification" href="{{ route('memberships.index') }}">
            Membresías
        </x-nav-link>

        <x-nav-link :active="request()->routeIs('plans.index')" icon="calendar" href="{{ route('plans.index') }}">
            Planes
        </x-nav-link>

        <x-nav-link :active="request()->routeIs('admin.history')" icon="clock" href="{{ route('admin.history') }}">
            Historial
        </x-nav-link>

    @else
        <x-nav-link :active="request()->routeIs('member.dashboard')" icon="home" href="{{ route('member.dashboard') }}">
            Inicio
        </x-nav-link>

        <x-nav-link :active="request()->routeIs('member.history')" icon="clock" href="{{ route('member.history') }}">
            Historial
        </x-nav-link>
    @endif

</ul>
