<div class="flex flex-col gap-6 w-full">
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
                <p class="text-4xl font-black mt-2">{{ $stats['total'] }}</p>
            </div>

            <div class="border-4 border-black bg-white p-4 shadow-[6px_6px_0px_0px_rgba(0,0,0,1)] flex flex-col justify-between">
                <div class="flex justify-between items-start">
                    <span class="text-[10px] font-black uppercase text-slate-500">Próximos</span>
                    <div class="bg-yellow-400 p-1 border-2 border-black shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">
                        <x-heroicon-s-exclamation-triangle class="h-5 w-5 text-black"/>
                    </div>
                </div>
                <p class="text-4xl font-black mt-2">{{ $stats['expiring'] }}</p>
            </div>

            <div class="border-4 border-black bg-white p-4 shadow-[6px_6px_0px_0px_rgba(0,0,0,1)] flex flex-col justify-between">
                <div class="flex justify-between items-start">
                    <span class="text-[10px] font-black uppercase text-slate-500">Vencidos</span>
                    <div class="bg-pink-500 p-1 border-2 border-black shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">
                        <x-heroicon-s-x-circle class="h-5 w-5 text-black"/>
                    </div>
                </div>
                <p class="text-4xl font-black mt-2">{{ $stats['expired'] }}</p>
            </div>
        </div>
    </div>

    <section class="border-4 border-black bg-white shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] flex flex-col">
        <div class="p-4 border-b-4 border-black flex flex-col sm:flex-row gap-4 bg-slate-50 shrink-0">
            <div class="relative flex-1">
                <x-heroicon-o-magnifying-glass class="absolute left-3 top-1/2 -translate-y-1/2 h-5 w-5 text-slate-400"/>
                <input
                    wire:model.live="search"
                    type="text"
                    placeholder="Buscar por nombre o ID..."
                    class="w-full border-2 border-black pl-10 pr-4 py-2 font-bold text-sm outline-none focus:border-gym-blue bg-white"
                >
            </div>
            <select
                wire:model.live="statusFilter"
                class="border-2 border-black px-4 py-2 font-black text-xs uppercase bg-white outline-none focus:ring-0 cursor-pointer"
            >
                <option value="all">Ver todos</option>
                <option value="active">Solo Activos</option>
                <option value="expiring">Próximos a vencer</option>
                <option value="expired">Solo Vencidos</option>
            </select>
        </div>

        <div>
            <div class="overflow-x-auto">
                <table class="w-full min-w-max border-collapse">
                    <thead class="bg-black text-white sticky top-0 z-10">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-black uppercase tracking-widest border-r border-white/20">Identificación</th>
                        <th class="px-6 py-3 text-left text-xs font-black uppercase tracking-widest border-r border-white/20">Nombres</th>
                        <th class="px-6 py-3 text-left text-xs font-black uppercase tracking-widest border-r border-white/20">Apellidos</th>
                        <th class="px-6 py-3 text-center text-xs font-black uppercase tracking-widest border-r border-white/20">Días Disponibles</th>
                        <th class="px-6 py-3 text-left text-xs font-black uppercase tracking-widest border-r border-white/20">Estado</th>
                        <th class="px-6 py-3 text-center text-xs font-black uppercase tracking-widest">Acciones</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y-2 divide-black bg-white">
                    @forelse($members as $member)
                        @php
                            $membership = $member->activeMembership;
                            $daysRemaining = $membership?->getDaysRemaining() ?? 0;
                        @endphp

                        <tr class="bg-white hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold border-r-2 border-black/5">
                                {{ $member->document_number }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold border-r-2 border-black/5 text-gym-blue">
                                {{ $member->first_name }} {{ $member->middle_name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold border-r-2 border-black/5">
                                {{ $member->last_name }} {{ $member->second_lastname }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold border-r-2 border-black/5 text-center">
                                <span class="{{ $membership?->isExpired() ? 'text-red-600' : ($daysRemaining <= 3 ? 'text-orange-500' : 'text-green-600') }}">
                                    {{ $daysRemaining }} días
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap border-r-2 border-black/5">
                                @if($membership?->isExpired())
                                    <span class="bg-red-500 text-white border-2 border-black px-3 py-1 text-[10px] font-black uppercase shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">Vencido</span>
                                @elseif($daysRemaining <= 3)
                                    <span class="bg-orange-400 border-2 border-black px-3 py-1 text-[10px] font-black uppercase shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">Por Vencer</span>
                                @else
                                    <span class="bg-green-300 border-2 border-black px-3 py-1 text-[10px] font-black uppercase shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">Activo</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center space-x-2">
                                <button title="Ver Detalles" class="p-1 border-2 border-black hover:bg-gym-blue transition-colors shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] active:translate-y-0.5 active:shadow-none">
                                    <x-heroicon-o-eye class="h-4 w-4"/>
                                </button>
                                <button
                                    title="Editar"
                                    wire:click="$dispatch('open-edit-drawer', { id: {{ $member->id }} })"
                                    class="p-1 border-2 border-black hover:bg-pink-500 transition-colors shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] active:translate-y-0.5 active:shadow-none">
                                    <x-heroicon-o-pencil class="h-4 w-4"/>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center font-black uppercase tracking-widest text-gray-400">
                                No se encontraron miembros registrados.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            @if($members->hasPages())
                <div class="p-4 border-t-4 border-black bg-white">
                    {{ $members->links() }}
                </div>
            @endif
        </div>
    </section>
</div>
