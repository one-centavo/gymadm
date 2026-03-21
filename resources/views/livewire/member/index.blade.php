<section class="flex flex-col gap-6 pb-24 md:pb-0">
    <header class="flex flex-col md:flex-row justify-between items-start md:items-center shrink-0">
        <div>
            <h1 class="text-4xl font-black tracking-tighter uppercase">MIEMBROS</h1>
            <span class="text-slate-500 font-bold text-sm tracking-widest">GESTIÓN Y CONTROL DE MIEMBROS</span>
        </div>
    </header>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 shrink-0">
        <section class="lg:col-span-5 border-4 border-black bg-white p-6 shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] flex flex-col justify-center">
            <h2 class="text-sm font-black uppercase mb-4 flex items-center gap-2">
                <span class="w-2 h-2 bg-black"></span>
                Gestión Rápida
            </h2>
            <livewire:member.identity-verifier/>
        </section>

        <div class="lg:col-span-7 grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="border-4 border-black bg-white p-4 shadow-[6px_6px_0px_0px_rgba(0,0,0,1)] flex flex-col justify-between">
                <div class="flex justify-between items-start">
                    <span class="text-[10px] font-black uppercase text-slate-500">Total</span>
                    <div class="bg-gym-blue p-1 border-2 border-black shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">
                        <x-heroicon-s-user-group class="h-5 w-5 text-black"/>
                    </div>
                </div>
                <p class="text-4xl font-black mt-2">5</p>
            </div>
            <div class="border-4 border-black bg-white p-4 shadow-[6px_6px_0px_0px_rgba(0,0,0,1)] flex flex-col justify-between">
                <div class="flex justify-between items-start">
                    <span class="text-[10px] font-black uppercase text-slate-500">Próximos</span>
                    <div class="bg-yellow-400 p-1 border-2 border-black shadow-brutal-sm">
                        <x-heroicon-s-exclamation-triangle class="h-5 w-5 text-black"/>
                    </div>
                </div>
                <p class="text-4xl font-black mt-2">2</p>
            </div>
            <div class="border-4 border-black bg-white p-4 shadow-[6px_6px_0px_0px_rgba(0,0,0,1)] flex flex-col justify-between">
                <div class="flex justify-between items-start">
                    <span class="text-[10px] font-black uppercase text-slate-500">Vencidos</span>
                    <div class="bg-pink-500 p-1 border-2 border-black shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">
                        <x-heroicon-s-x-circle class="h-5 w-5 text-black"/>
                    </div>
                </div>
                <p class="text-4xl font-black mt-2">1</p>
            </div>
        </div>
    </div>

    <section class="border-4 border-black bg-white shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] flex flex-col">
        <div class="p-4 border-b-4 border-black flex flex-col sm:flex-row gap-4 bg-slate-50 shrink-0">
            <div class="relative flex-1">
                <x-heroicon-o-magnifying-glass class="absolute left-3 top-1/2 -translate-y-1/2 h-5 w-5 text-slate-400"/>
                <input type="text" placeholder="Buscar por nombre o ID..." class="w-full border-2 border-black pl-10 pr-4 py-2 font-bold text-sm outline-none focus:border-gym-blue">
            </div>
            <button class="border-2 border-black px-6 py-2 font-black text-xs uppercase hover:bg-black hover:text-white transition-colors">
                VER TODOS
            </button>
        </div>

        <div>
            <div class="overflow-x-auto">
                <table class="w-full min-w-max border-collapse">
                    <thead class="bg-black text-white sticky top-0 z-10">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-black uppercase tracking-widest border-r border-white/20">Identificación</th>
                        <th class="px-6 py-3 text-left text-xs font-black uppercase tracking-widest border-r border-white/20">Nombres</th>
                        <th class="px-6 py-3 text-left text-xs font-black uppercase tracking-widest border-r border-white/20">Membresía</th>
                        <th class="px-6 py-3 text-left text-xs font-black uppercase tracking-widest border-r border-white/20">Estado</th>
                        <th class="px-6 py-3 text-center text-xs font-black uppercase tracking-widest">Acciones</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y-2 divide-black">
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold border-r-2 border-black/5">9876543210</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold border-r-2 border-black/5 text-gym-blue">María López</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold border-r-2 border-black/5">Mensualidad Full</td>
                        <td class="px-6 py-4 whitespace-nowrap border-r-2 border-black/5">
                            <span class="bg-green-300 border-2 border-black px-3 py-1 text-[10px] font-black uppercase">Activo</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center space-x-2">
                            <button class="p-1 border-2 border-black hover:bg-gym-blue transition-colors">
                                <x-heroicon-o-pencil class="h-4 w-4"/>
                            </button>
                            <button class="p-1 border-2 border-black hover:bg-pink-500 transition-colors">
                                <x-heroicon-o-trash class="h-4 w-4"/>
                            </button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    <livewire:member.create-member/>
</section>
