<ul class="flex items-stretch justify-around md:justify-start bg-slate-900 border-t-4 border-gym-blue text-sm font-black text-white md:flex-col md:border-t-0 md:h-full hover:overflow-hidden">

    <x-nav-link :active="request()->routeIs('members.*')" icon="user-group" href="{{ route('members.index') }}">
        Miembros
    </x-nav-link>

    <x-nav-link :active="request()->routeIs('memberships.*')" icon="identification" href="{{ route('memberships.index') }}">
        Membresías
    </x-nav-link>

    <x-nav-link :active="request()->routeIs('plans.*')" icon="calendar" href="{{ route('plans.index') }}">
        Planes
    </x-nav-link>

    <x-nav-link :active="request()->routeIs('history.*')" icon="clock" href="{{ route('history.index') }}">
        Historial
    </x-nav-link>

</ul>
