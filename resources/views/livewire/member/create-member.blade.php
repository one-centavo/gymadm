<x-ui.side-panel
    title="NUEVO MIEMBRO"
    eventName="registration-form"
    wireSubmit="register"
    submitLabel="REGISTRAR MIEMBRO"
>
    <div class="flex flex-col">
        <label class="font-black uppercase text-xs tracking-widest">Tipo de Identificación</label>
        <select wire:model="document_type" class="border-4 border-black p-3 font-bold bg-white focus:bg-gym-blue/10 outline-none">
            <option value="" disabled>Seleccionar</option>
            <option value="CC">Cédula de Ciudadanía</option>
            <option value="TI">Tarjeta de Identidad</option>
            <option value="PP">Pasaporte</option>
        </select>
        @error('document_type') <span class="text-pink-600 font-black text-xs uppercase italic">{{ $message }}</span> @enderror
    </div>

    <div class="flex flex-col">
        <label class="font-black uppercase text-xs tracking-widest">Número de Documento</label>
        <input type="text" wire:model="document_number" class="border-4 border-black p-3 font-bold focus:bg-gym-blue/10 outline-none" placeholder="Ej: 1075...">
        @error('document_number') <span class="text-pink-600 font-black text-xs uppercase italic">{{ $message }}</span> @enderror
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div class="flex flex-col">
            <label class="font-black uppercase text-xs tracking-widest">Primer Nombre</label>
            <input type="text" wire:model="first_name" class="border-4 border-black p-3 font-bold focus:bg-gym-blue/10 outline-none">
            @error('first_name') <span class="text-pink-600 font-black text-xs uppercase italic">{{ $message }}</span> @enderror
        </div>
        <div class="flex flex-col">
            <label class="font-black uppercase text-xs tracking-widest">Segundo Nombre</label>
            <input type="text" wire:model="middle_name" class="border-4 border-black p-3 font-bold focus:bg-gym-blue/10 outline-none">
            @error('middle_name') <span class="text-pink-600 font-black text-xs uppercase italic">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div class="flex flex-col">
            <label class="font-black uppercase text-xs tracking-widest">Primer Apellido</label>
            <input type="text" wire:model="last_name" class="border-4 border-black p-3 font-bold focus:bg-gym-blue/10 outline-none">
            @error('last_name') <span class="text-pink-600 font-black text-xs uppercase italic">{{ $message }}</span> @enderror
        </div>
        <div class="flex flex-col">
            <label class="font-black uppercase text-xs tracking-widest">Segundo Apellido</label>
            <input type="text" wire:model="second_last_name" class="border-4 border-black p-3 font-bold focus:bg-gym-blue/10 outline-none">
            @error('second_last_name') <span class="text-pink-600 font-black text-xs uppercase italic">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="flex flex-col">
        <label class="font-black uppercase text-xs tracking-widest">Correo Electrónico</label>
        <input type="email" wire:model="email" class="border-4 border-black p-3 font-bold focus:bg-gym-blue/10 outline-none" placeholder="correo@ejemplo.com">
        @error('email') <span class="text-pink-600 font-black text-xs uppercase italic">{{ $message }}</span> @enderror
    </div>

    <div class="flex flex-col">
        <label class="font-black uppercase text-xs tracking-widest">Número de Teléfono</label>
        <input type="text" wire:model="phone_number" class="border-4 border-black p-3 font-bold focus:bg-gym-blue/10 outline-none">
        @error('phone_number') <span class="text-pink-600 font-black text-xs uppercase italic">{{ $message }}</span> @enderror
    </div>
</x-ui.side-panel>
