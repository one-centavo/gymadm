<div x-data="{ open: @entangle('open') }"
     class="relative">

    <div x-show="open"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black/60 backdrop-blur-sm z-60"
         @click="open = false">
    </div>


    <div x-show="open"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="translate-x-full"
         class="fixed inset-y-0 right-0 w-full sm:w-125 bg-white border-l-8 border-black z-70 p-8 shadow-[-10px_0px_0px_0px_rgba(0,0,0,1)] flex flex-col overflow-y-auto">

        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-black uppercase tracking-tighter italic">EDITAR MIEMBRO</h2>
            <button @click="open = false" class="border-4 border-black p-2 hover:bg-pink-500 transition-colors cursor-pointer">
                <x-heroicon-o-x-mark class="h-6 w-6 font-black"/>
            </button>
        </div>

        <form wire:submit.prevent="update" class="flex flex-col gap-5">

            <div class="flex flex-col gap-2">
                <label class="font-black uppercase text-xs tracking-widest">Tipo de Identificación</label>
                <select wire:model="document_type" class="border-4 border-black p-3 font-bold bg-white focus:bg-gym-blue/10 outline-none">
                    <option value="" disabled>Seleccionar</option>
                    <option value="CC">Cédula de Ciudadanía</option>
                    <option value="TI">Tarjeta de Identidad</option>
                    <option value="PP">Pasaporte</option>
                </select>
                @error('document_type') <span class="text-pink-600 font-black text-xs uppercase italic">{{ $message }}</span> @enderror
            </div>

            <div class="flex flex-col gap-2">
                <label class="font-black uppercase text-xs tracking-widest">Número de Documento</label>
                <input type="text" wire:model="document_number" class="border-4 border-black p-3 font-bold focus:bg-gym-blue/10 outline-none">
                @error('document_number') <span class="text-pink-600 font-black text-xs uppercase italic">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="flex flex-col gap-2">
                    <label class="font-black uppercase text-xs tracking-widest">Primer Nombre</label>
                    <input type="text" wire:model="first_name" class="border-4 border-black p-3 font-bold focus:bg-gym-blue/10 outline-none">
                    @error('first_name') <span class="text-pink-600 font-black text-xs uppercase italic">{{ $message }}</span> @enderror
                </div>
                <div class="flex flex-col gap-2">
                    <label class="font-black uppercase text-xs tracking-widest">Segundo Nombre</label>
                    <input type="text" wire:model="middle_name" class="border-4 border-black p-3 font-bold focus:bg-gym-blue/10 outline-none">
                    @error('middle_name') <span class="text-pink-600 font-black text-xs uppercase italic">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="flex flex-col gap-2">
                    <label class="font-black uppercase text-xs tracking-widest">Primer Apellido</label>
                    <input type="text" wire:model="last_name" class="border-4 border-black p-3 font-bold focus:bg-gym-blue/10 outline-none">
                    @error('last_name') <span class="text-pink-600 font-black text-xs uppercase italic">{{ $message }}</span> @enderror
                </div>
                <div class="flex flex-col gap-2">
                    <label class="font-black uppercase text-xs tracking-widest">Segundo Apellido</label>
                    <input type="text" wire:model="second_lastname" class="border-4 border-black p-3 font-bold focus:bg-gym-blue/10 outline-none">
                    @error('second_lastname') <span class="text-pink-600 font-black text-xs uppercase italic">{{ $message }}</span> @enderror
                </div>
            </div>


            <div class="flex flex-col gap-2">
                <label class="font-black uppercase text-xs tracking-widest">Correo Electrónico</label>
                <input type="email" wire:model="email" class="border-4 border-black p-3 font-bold focus:bg-gym-blue/10 outline-none">
                @error('email') <span class="text-pink-600 font-black text-xs uppercase italic">{{ $message }}</span> @enderror
            </div>

            <div class="flex flex-col gap-2">
                <label class="font-black uppercase text-xs tracking-widest">Número de Teléfono</label>
                <input type="text" wire:model="phone_number" class="border-4 border-black p-3 font-bold focus:bg-gym-blue/10 outline-none">
                @error('phone_number') <span class="text-pink-600 font-black text-xs uppercase italic">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="mt-4 bg-gym-blue border-4 border-black p-4 font-black uppercase text-xl shadow-[6px_6px_0px_0px_rgba(0,0,0,1)] hover:translate-x-1 hover:translate-y-1 hover:shadow-none transition-all cursor-pointer">
                ACTUALIZAR INFORMACIÓN
            </button>
        </form>
    </div>
</div>
