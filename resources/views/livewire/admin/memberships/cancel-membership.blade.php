<div x-data="{ show: @entangle('openModal') }"
     x-show="show"
     x-on:keydown.escape.window="show = false"
     class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm"
     x-cloak>

    <div class="bg-white border-8 border-black p-8 max-w-lg w-full shadow-[20px_20px_0px_0px_rgba(0,0,0,1)] transform -rotate-1"
         @click.away="$wire.closeModal()">

        <h3 class="text-3xl font-black uppercase mb-2 italic bg-red-500 text-white inline-block px-2">
            CANCELAR MEMBRESÍA
        </h3>

        <p class="font-bold text-xl leading-tight mb-6 mt-4">
            ¿Por qué deseas cancelar esta suscripción? <br>
            <span class="text-sm text-gray-600 font-normal italic">* Esta acción no se puede deshacer.</span>
        </p>

        <div class="mb-6">
            <label class="block uppercase font-black text-sm mb-2">Motivo / Observaciones:</label>
            <textarea
                wire:model="reason"
                placeholder="Ej: El cliente no volvió por motivos de salud..."
                class="w-full border-4 border-black p-4 font-bold focus:shadow-[5px_5px_0px_0px_rgba(0,0,0,1)] transition-all outline-none resize-none h-32 bg-yellow-50"
            ></textarea>
            @error('reason')
            <div class="bg-black text-white font-black uppercase text-xs px-2 py-1 mt-2 inline-block">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="flex flex-col sm:flex-row gap-4">
            <button wire:click="cancel"
                    wire:loading.attr="disabled"
                    class="flex-1 bg-red-500 border-4 border-black p-4 font-black uppercase text-white hover:translate-x-1 hover:translate-y-1 hover:shadow-none shadow-[6px_6px_0px_0px_rgba(0,0,0,1)] transition-all active:bg-red-600">
                <span wire:loading.remove>CONFIRMAR CANCELACIÓN</span>
                <span wire:loading>PROCESANDO...</span>
            </button>

            <button wire:click="closeModal"
                    class="flex-1 bg-gray-200 border-4 border-black p-4 font-black uppercase hover:bg-white transition-colors">
                VOLVER
            </button>
        </div>
    </div>
</div>
