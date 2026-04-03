<div class="flex flex-col gap-6 w-full">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 shrink-0">
        <div class="lg:col-span-7 grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="border-4 border-black bg-white p-4 shadow-[6px_6px_0px_0px_rgba(0,0,0,1)] flex flex-col justify-between">
                <div class="flex justify-between items-start">
                    <span class="text-[10px] font-black uppercase text-slate-500">Total</span>
                    <div class="bg-gym-blue p-1 border-2 border-black shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">
                        <x-heroicon-s-user-group class="h-5 w-5 text-black"/>
                    </div>
                </div>
                <p class="text-4xl font-black mt-2">{{ $stats['total'] ?? '-' }}</p>
            </div>
            <div class="border-4 border-black bg-white p-4 shadow-[6px_6px_0px_0px_rgba(0,0,0,1)] flex flex-col justify-between">
                <div class="flex justify-between items-start">
                    <span class="text-[10px] font-black uppercase text-slate-500">Vigentes</span>
                    <div class="bg-green-400 p-1 border-2 border-black shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">
                        <x-heroicon-s-check-badge class="h-5 w-5 text-black"/>
                    </div>
                </div>
                <p class="text-4xl font-black mt-2">{{ $stats['vigente'] ?? '-' }}</p>
            </div>
            <div class="border-4 border-black bg-white p-4 shadow-[6px_6px_0px_0px_rgba(0,0,0,1)] flex flex-col justify-between">
                <div class="flex justify-between items-start">
                    <span class="text-[10px] font-black uppercase text-slate-500">Vencidas</span>
                    <div class="bg-gray-400 p-1 border-2 border-black shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">
                        <x-heroicon-s-user-group class="h-5 w-5 text-black"/>
                    </div>
                </div>
                <p class="text-4xl font-black mt-2">{{ $stats['vencido'] ?? '-' }}</p>
            </div>
        </div>
    </div>
    <section class="border-4 border-black bg-white shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] flex flex-col">
        <div class="p-4 border-b-4 border-black flex flex-col sm:flex-row gap-4 bg-slate-50 shrink-0">
            <div class="relative flex-1">
                <x-heroicon-o-magnifying-glass class="absolute left-3 top-1/2 -translate-y-1/2 h-5 w-5 text-slate-400"/>
                <input
                    wire:model.live.debounce.500ms="search"
                    type="text"
                    placeholder="Buscar por nombre, apellido o documento..."
                    class="w-full border-2 border-black pl-10 pr-4 py-2 font-bold text-sm outline-none focus:border-gym-blue bg-white"
                >
            </div>
            <select
                wire:model.live="statusFilter"
                class="border-2 border-black px-4 py-2 font-black text-xs uppercase bg-white outline-none focus:ring-0 cursor-pointer"
            >
                <option value="all">Ver todos</option>
                <option value="vigente">Vigentes</option>
                <option value="por_vencer">Por vencer</option>
                <option value="vencido">Vencidas</option>
                <option value="cancelado">Canceladas</option>
            </select>
        </div>
        <div>
            <div class="overflow-x-auto">
                <table class="w-full min-w-max border-collapse">
                    <thead class="bg-black text-white sticky top-0 z-10">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-black uppercase tracking-widest border-r border-white/20">Nombre</th>
                        <th class="px-6 py-3 text-left text-xs font-black uppercase tracking-widest border-r border-white/20">Documento</th>
                        <th class="px-6 py-3 text-left text-xs font-black uppercase tracking-widest border-r border-white/20">Plan</th>
                        <th class="px-6 py-3 text-left text-xs font-black uppercase tracking-widest border-r border-white/20">Vence</th>
                        <th class="px-6 py-3 text-left text-xs font-black uppercase tracking-widest border-r border-white/20">Días Restantes</th>
                        <th class="px-6 py-3 text-left text-xs font-black uppercase tracking-widest border-r border-white/20">Estado</th>
                        <th class="px-6 py-3 text-center text-xs font-black uppercase tracking-widest">Acciones</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y-2 divide-black bg-white">
                    @forelse($memberships as $membership)
                        <tr wire:key="membership-{{ $membership->membership_id }}" class="bg-white hover:bg-slate-50 transition-colors {{ $membership->membership_status === 'canceled' ? 'opacity-60' : '' }}">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold border-r-2 border-black/5">
                                {{ $membership->first_name }} {{ $membership->last_name }} {{ $membership->second_lastname }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold border-r-2 border-black/5">
                                {{ $membership->document_number }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold border-r-2 border-black/5">
                                {{ $membership->plan_name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold border-r-2 border-black/5">
                                {{ \Carbon\Carbon::parse($membership->end_date)->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold border-r-2 border-black/5 text-center">
                                {{ $membership->dias_restantes }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap border-r-2 border-black/5">
                                @php
                                    $status = $membership->membership_status;
                                @endphp
                                @if($status === 'active' && $membership->dias_restantes > 3)
                                    <span class="bg-green-300 border-2 border-black px-3 py-1 text-[10px] font-black uppercase shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">Vigente</span>
                                @elseif($status === 'active' && $membership->dias_restantes >= 0 && $membership->dias_restantes <= 3)
                                    <span class="bg-yellow-300 border-2 border-black px-3 py-1 text-[10px] font-black uppercase shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">Por vencer</span>
                                @elseif($status === 'canceled')
                                    <span class="bg-gray-400 text-white border-2 border-black px-3 py-1 text-[10px] font-black uppercase shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">Cancelada</span>
                                @elseif($membership->dias_restantes < 0)
                                    <span class="bg-red-400 text-white border-2 border-black px-3 py-1 text-[10px] font-black uppercase shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">Vencida</span>
                                @else
                                    <span class="bg-slate-300 border-2 border-black px-3 py-1 text-[10px] font-black uppercase shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">Desconocido</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center space-x-2">
                                <button title="Ver Detalles" class="p-1 border-2 border-black hover:bg-gym-blue transition-colors shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] active:translate-y-0.5 active:shadow-none">
                                    <x-heroicon-o-eye class="h-4 w-4"/>
                                </button>
                                <button
                                    title="Editar"
                                    type="button"
                                    wire:click="$dispatch('open-edit-membership', { id: {{ $membership->membership_id }} })"
                                    class="p-1 border-2 border-black hover:bg-pink-500 transition-colors shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] active:translate-y-0.5 active:shadow-none">
                                    <x-heroicon-o-pencil class="h-4 w-4"/>
                                </button>
                                <button
                                    title="Cambiar Estado"
                                    type="button"
                                    wire:click="$dispatch('open-membership-status-modal', { id: {{ $membership->membership_id }} })"
                                    class="p-1 border-2 border-black {{ $membership->membership_status === 'active' ? 'bg-red-400' : 'bg-green-400' }} shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">
                                    <x-heroicon-o-power class="h-4 w-4"/>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-10 text-center font-black uppercase tracking-widest text-gray-400">
                                No se encontraron membresías con ese filtro.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            @if($memberships->hasPages())
                <div class="p-4 border-t-4 border-black bg-white">
                    {{ $memberships->links() }}
                </div>
            @endif
        </div>
    </section>
</div>
