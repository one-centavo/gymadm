<div class="flex items-center justify-between bg-gym-blue p-4 border-b-4 border-black text-black">

    <a href="{{url('/')}}" class="flex items-center gap-2 text-2xl font-black uppercase tracking-tighter">
        <span>GYMADM</span>
        <x-icons.dumbbell-lifting class="h-8 w-8 translate-y-1"/>
    </a>

    <div class="relative" x-data="{ open: false }">
        <button
            @click="open = !open"
            @click.outside="open = false"
            class="flex items-center gap-2  py-1 border-2 border-transparent hover:border-black hover:bg-black hover:text-gym-blue transition-all duration-100 group cursor-pointer"
            x-bind:class="{ 'border-black! bg-black! text-gym-blue!': open }"
        >
            <div class="flex items-center gap-2 font-bold uppercase text-sm">
                <span class="hidden md:inline">{{ auth()->user()->role === 'admin' ? 'Administrador' : 'Miembro' }}</span>
                <x-heroicon-o-user-circle class="h-8 w-8 stroke-2"/>
            </div>

            <x-heroicon-o-chevron-down
                class="h-4 w-4 stroke-2 transition-transform duration-200"
                x-bind:class="{ 'rotate-180': open, 'group-hover:rotate-180': !open }"
            />
        </button>

        <div
            x-show="open"
            x-transition
            class="absolute right-0 top-full mt-1 w-48 bg-white border-2 border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] z-50 origin-top-right"
            style="display: none;"
        >
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex w-full items-center justify-between px-4 py-2 text-sm font-bold uppercase text-black hover:bg-black hover:text-gym-blue transition-colors group">
                    <span>Cerrar sesión</span>
                    <x-heroicon-o-arrow-right-start-on-rectangle class="h-5 w-5 stroke-2"/>
                </button>
            </form>
        </div>
    </div>
</div>
