<x-ui.side-panel
    title="NUEVO PLAN"
    eventName="plan-form"
    wireSubmit="create"
    submitLabel="CREAR PLAN"
>

    <div class="flex flex-col">
        <label class="font-black uppercase text-xs tracking-widest">Nombre del Plan</label>
        <input type="text" wire:model="name" class="border-4 border-black p-3 font-bold focus:bg-gym-blue/10 outline-none" placeholder="Ej: Plan Black Anual">
        @error('name') <span class="text-pink-600 font-black text-xs uppercase italic">{{ $message }}</span> @enderror
    </div>

    <div class="flex flex-col">
        <label class="font-black uppercase text-xs tracking-widest">Descripción</label>
        <textarea wire:model="description" rows="3" class="border-4 border-black p-3 font-bold focus:bg-gym-blue/10 outline-none resize-none" placeholder="Beneficios que incluye el plan..."></textarea>
        @error('description') <span class="text-pink-600 font-black text-xs uppercase italic">{{ $message }}</span> @enderror
    </div>


    <div class="flex flex-col">
        <label class="font-black uppercase text-xs tracking-widest">Precio</label>
        <div class="relative flex items-center">
            <span class="absolute left-4 font-black text-slate-400">$</span>
            <input type="number" wire:model="price" class="w-full border-4 border-black py-3 pl-8 pr-3 font-bold focus:bg-gym-blue/10 outline-none" placeholder="0.00">
        </div>
        @error('price') <span class="text-pink-600 font-black text-xs uppercase italic">{{ $message }}</span> @enderror
    </div>


    <div class="grid grid-cols-2 gap-4">
        <div class="flex flex-col">
            <label class="font-black uppercase text-xs tracking-widest">Duración</label>
            <input type="number" wire:model="duration_value" min="1" class="border-4 border-black p-3 font-bold focus:bg-gym-blue/10 outline-none" placeholder="Ej: 1">
            @error('duration_value') <span class="text-pink-600 font-black text-xs uppercase italic">{{ $message }}</span> @enderror
        </div>

        <div class="flex flex-col">
            <label class="font-black uppercase text-xs tracking-widest">Unidad de Tiempo</label>
            <select wire:model="duration_unit" class="border-4 border-black p-3 font-bold bg-white focus:bg-gym-blue/10 outline-none">
                <option value="" disabled>Seleccionar</option>
                <option value="days">Días</option>
                <option value="weeks">Semanas</option>
                <option value="months">Meses</option>
            </select>
            @error('duration_unit') <span class="text-pink-600 font-black text-xs uppercase italic">{{ $message }}</span> @enderror
        </div>
    </div>


    @error('create')
    <div class="bg-red-400 border-4 border-black p-3 text-black font-black uppercase text-sm shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
        {{ $message }}
    </div>
    @enderror

</x-ui.side-panel>
