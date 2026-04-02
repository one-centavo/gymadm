<x-ui.side-panel
    title="ASIGNAR MEMBRESÍA"
    eventName="assign-membership-form"
    wireSubmit="assign"
    submitLabel="ASIGNAR MEMBRESÍA"
>
    {{-- Buscador de miembro --}}
    <div class="flex flex-col">
        <label class="font-black uppercase text-xs tracking-widest">Buscar Miembro</label>
        <input type="text" wire:model.live.debounce.500ms="searchTerm" class="border-4 border-black p-3 font-bold focus:bg-gym-blue/10 outline-none" placeholder="Nombre, Apellido o Documento...">
        @error('userId') <span class="text-pink-600 font-black text-xs uppercase italic">{{ $message }}</span> @enderror

        {{-- Resultados de búsqueda --}}
        @if(!empty($searchTerm) && count($members) > 0)
            <ul class="bg-white border-2 border-black mt-2 max-h-40 overflow-y-auto shadow-lg z-50 cursor-pointer">
                @foreach($members as $member)
                    <li>
                        <button type="button" wire:click="selectMember({{ $member['id'] }})" class="w-full text-left px-4 py-2 hover:bg-gym-blue/20">
                            {{ ($member['first_name'] ?? '') . ' ' . ($member['last_name'] ?? '') }}
                            <span class="text-xs text-slate-500 ml-2">{{ $member['document_number'] ?? '' }}</span>
                        </button>
                    </li>
                @endforeach
            </ul>
        @endif
        {{-- Miembro seleccionado --}}
        @if($userId && isset($members[0]))
            <div class="mt-1 text-xs text-slate-600 italic">
                Miembro seleccionado: <span class="font-bold">{{ ($members[0]['first_name'] ?? '') . ' ' . ($members[0]['last_name'] ?? '') }}</span>
                <span class="ml-2">({{ $members[0]['document_number'] ?? '' }})</span>
            </div>
        @endif
    </div>

    {{-- Selector de plan --}}
    <div class="flex flex-col mt-4">
        <label class="font-black uppercase text-xs tracking-widest">Plan</label>
        <select wire:model="planId" wire:change="updateSuggestedDates" class="border-4 border-black p-3 font-bold bg-white focus:bg-gym-blue/10 outline-none">
            <option value="" disabled>Seleccionar plan</option>
            @forelse($planOptions as $plan)
                <option value="{{ $plan['id'] }}">
                    {{ $plan['name'] }}
                    ( <span class="text-xs text-slate-500 font-normal">${{ number_format($plan['price'], 0, ',', '.') }}</span> )
                </option>
            @empty
                <option value="" disabled>No hay planes activos</option>
            @endforelse
        </select>
        @error('planId') <span class="text-pink-600 font-black text-xs uppercase italic">{{ $message }}</span> @enderror
    </div>

    {{-- Fecha de inicio --}}
    <div class="flex flex-col mt-4">
        <label class="font-black uppercase text-xs tracking-widest">Fecha de Inicio</label>
        <input type="date" wire:model="startDate" wire:change="updateSuggestedDates" class="border-4 border-black p-3 font-bold focus:bg-gym-blue/10 outline-none">
        @error('startDate') <span class="text-pink-600 font-black text-xs uppercase italic">{{ $message }}</span> @enderror
    </div>

    {{-- Fecha de vencimiento (solo informativo) --}}
    <div class="flex flex-col mt-2">
        <label class="font-black uppercase text-xs tracking-widest">Fecha de Vencimiento</label>
        <input type="text" value="{{ $endDate }}" readonly class="border-4 border-black p-3 font-bold bg-gray-100 text-gray-500 cursor-not-allowed">
    </div>

    {{-- Método de pago --}}
    <div class="flex flex-col mt-4">
        <label class="font-black uppercase text-xs tracking-widest">Método de Pago</label>
        <select wire:model="paymentMethod" class="border-4 border-black p-3 font-bold bg-white focus:bg-gym-blue/10 outline-none">
            <option value="" disabled>Seleccionar método</option>
            <option value="cash">Efectivo</option>
            <option value="card">Tarjeta</option>
            <option value="transfer">Transferencia</option>
        </select>
        @error('paymentMethod') <span class="text-pink-600 font-black text-xs uppercase italic">{{ $message }}</span> @enderror
    </div>

    {{-- Precio pagado (solo informativo) --}}
    <div class="flex flex-col mt-4">
        <label class="font-black uppercase text-xs tracking-widest">Precio Pagado</label>
        <input type="text" value="${{ number_format($pricePaid, 0, ',', '.') }}" readonly class="border-4 border-black p-3 font-bold bg-gray-100 text-gray-500 cursor-not-allowed">
    </div>

    @error('assign')
    <div class="bg-red-400 border-4 border-black p-3 text-black font-black uppercase text-sm shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
        {{ $message }}
    </div>
    @enderror

</x-ui.side-panel>
