<x-ui.side-panel
    title="RENOVAR MEMBRESÍA"
    eventName="renew-membership-form"
    wireSubmit="renew"
    submitLabel="RENOVAR MEMBRESÍA"
>
    @if(empty($userId))
        <div class="p-4 text-center text-red-600 font-black uppercase">No se ha seleccionado un miembro para renovar la membresía.</div>
    @else
        {{-- Miembro (solo informativo) --}}
        <div class="flex flex-col">
            <label class="font-black uppercase text-xs tracking-widest">Miembro</label>
            <input type="text" value="{{ $selectedMemberName }}" readonly class="border-4 border-black p-3 font-bold bg-gray-100 text-gray-500 cursor-not-allowed">
            <span class="text-xs text-slate-600 italic mt-1">Documento: <span class="font-bold">{{ $selectedMemberDocument }}</span></span>
        </div>

        {{-- Selector de plans (editable) --}}
        <div class="flex flex-col mt-4">
            <label class="font-black uppercase text-xs tracking-widest">Plan</label>
            <select wire:model.live="planId" class="border-4 border-black p-3 font-bold bg-white focus:bg-gym-blue/10 outline-none">
                <option value="" disabled>Seleccionar plan</option>
                @forelse($planOptions as $plan)
                    <option value="{{ $plan['id'] }}">
                        {{ $plan['name'] }} ( ${{ number_format($plan['price'], 0, ',', '.') }} )
                    </option>
                @empty
                    <option value="" disabled>No hay planes activos</option>
                @endforelse
            </select>
            @error('planId') <span class="text-pink-600 font-black text-xs uppercase italic">{{ $message }}</span> @enderror
        </div>

        {{-- Fecha de inicio (editable) --}}
        <div class="flex flex-col mt-4">
            <label class="font-black uppercase text-xs tracking-widest">Fecha de Inicio</label>
            <input type="date" wire:model="startDate" class="border-4 border-black p-3 font-bold focus:bg-gym-blue/10 outline-none">
            @error('startDate') <span class="text-pink-600 font-black text-xs uppercase italic">{{ $message }}</span> @enderror
        </div>

        {{-- Fecha de vencimiento (solo informativo) --}}
        <div class="flex flex-col mt-2">
            <label class="font-black uppercase text-xs tracking-widest">Fecha de Vencimiento</label>
            <input type="text" value="{{ $endDate }}" readonly class="border-4 border-black p-3 font-bold bg-gray-100 text-gray-500 cursor-not-allowed">
        </div>

        {{-- Método de pago (editable) --}}
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

        @error('renew')
        <div class="bg-red-400 border-4 border-black p-3 text-black font-black uppercase text-sm shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
            {{ $message }}
        </div>
        @enderror
    @endif
</x-ui.side-panel>
