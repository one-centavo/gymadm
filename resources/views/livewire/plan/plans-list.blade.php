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
                <p class="text-4xl font-black mt-2">{{ $stats['total'] }}</p>
            </div>
            <div class="border-4 border-black bg-white p-4 shadow-[6px_6px_0px_0px_rgba(0,0,0,1)] flex flex-col justify-between">
                <div class="flex justify-between items-start">
                    <span class="text-[10px] font-black uppercase text-slate-500">Activos</span>
                    <div class="bg-green-400 p-1 border-2 border-black shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">
                        <x-heroicon-s-check-badge class="h-5 w-5 text-black"/>
                    </div>
                </div>
                <p class="text-4xl font-black mt-2">{{ $stats['active'] }}</p>
            </div>

            <div class="border-4 border-black bg-white p-4 shadow-[6px_6px_0px_0px_rgba(0,0,0,1)] flex flex-col justify-between">
                <div class="flex justify-between items-start">
                    <span class="text-[10px] font-black uppercase text-slate-500">Inactivos</span>
                    <div class="bg-gray-400 p-1 border-2 border-black shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">
                        <x-heroicon-s-user-group class="h-5 w-5 text-black"/>
                    </div>
                </div>
                <p class="text-4xl font-black mt-2">{{ $stats['inactive'] }}</p>
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
                    placeholder="Buscar por plan por nombre..."
                    class="w-full border-2 border-black pl-10 pr-4 py-2 font-bold text-sm outline-none focus:border-gym-blue bg-white"
                >
            </div>
            <select
                wire:model.live="statusFilter"
                class="border-2 border-black px-4 py-2 font-black text-xs uppercase bg-white outline-none focus:ring-0 cursor-pointer"
            >
                <option value="all">Ver todos</option>
                <option value="active">Solo Activos</option>
                <option value="inactive">Solo Inactivos</option>
            </select>
        </div>

        <div>
            <div class="overflow-x-auto">
                <table class="w-full min-w-max border-collapse">
                    <thead class="bg-black text-white sticky top-0 z-10">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-black uppercase tracking-widest border-r border-white/20">Nombre</th>
                        <th class="px-6 py-3 text-left text-xs font-black uppercase tracking-widest border-r border-white/20">Precio</th>
                        <th class="px-6 py-3 text-left text-xs font-black uppercase tracking-widest border-r border-white/20">Duración</th>
                        <th class="px-6 py-3 text-left text-xs font-black uppercase tracking-widest border-r border-white/20">Descripción</th>
                        <th class="px-6 py-3 text-left text-xs font-black uppercase tracking-widest border-r border-white/20">Estado</th>
                        <th class="px-6 py-3 text-center text-xs font-black uppercase tracking-widest">Acciones</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y-2 divide-black bg-white">
                    @forelse($plans as $plan)
                        <tr wire:key="plan-{{ $plan->id }}" class="bg-white hover:bg-slate-50 transition-colors {{ $plan->status === 'inactive' ? 'opacity-60' : '' }}">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold border-r-2 border-black/5">
                                {{ $plan->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold border-r-2 border-black/5 text-gym-blue">
                                ${{ number_format((float) $plan->price, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold border-r-2 border-black/5">
                                {{ $plan->duration_value }} {{ $plan->duration_unit === 'days' ? 'días' : ($plan->duration_unit === 'weeks' ? 'semanas' : 'meses') }}
                            </td>
                            <td class="px-6 py-4 text-sm font-bold border-r-2 border-black/5 max-w-xs truncate" title="{{ $plan->description ?? 'Sin descripción' }}">
                                {{ $plan->description ?? 'Sin descripción' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap border-r-2 border-black/5">
                                @if($plan->status === 'active')
                                    <span class="bg-green-300 border-2 border-black px-3 py-1 text-[10px] font-black uppercase shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">Activo</span>
                                @else
                                    <span class="bg-gray-400 text-white border-2 border-black px-3 py-1 text-[10px] font-black uppercase shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">Inactivo</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center space-x-2">
                                <button title="Ver Detalles" class="p-1 border-2 border-black hover:bg-gym-blue transition-colors shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] active:translate-y-0.5 active:shadow-none">
                                    <x-heroicon-o-eye class="h-4 w-4"/>
                                </button>
                                <button
                                    title="Editar"
                                    type="button"
                                    wire:click="$dispatch('open-edit-plan',{id: {{ $plan->id }}}); $dispatch('prefix-edit-plan-form')"
                                    class="p-1 border-2 border-black hover:bg-pink-500 transition-colors shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] active:translate-y-0.5 active:shadow-none">
                                    <x-heroicon-o-pencil class="h-4 w-4"/>
                                </button>
                                <button
                                    title="Cambiar Estado"
                                    type="button"
                                     wire:click="$dispatch('open-plan-status-modal', { id: {{ $plan->id }} })"
                                    class="p-1 border-2 border-black {{ $plan->status === 'active' ? 'bg-red-400' : 'bg-green-400' }} shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">
                                    <x-heroicon-o-power class="h-4 w-4"/>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center font-black uppercase tracking-widest text-gray-400">
                                No se encontraron planes con ese filtro.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            @if($plans->hasPages())
                <div class="p-4 border-t-4 border-black bg-white">
                    {{ $plans->links() }}
                </div>
            @endif
        </div>
    </section>
</div>

