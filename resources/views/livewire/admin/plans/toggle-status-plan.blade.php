<div x-data="{ show: @entangle('confirmingStatusChange') }"
     x-show="show"
     class="fixed inset-0 z-100 flex items-center justify-center bg-black/50 backdrop-blur-sm"
     x-cloak>

    <div class="bg-white border-8 border-black p-8 max-w-md w-full shadow-[15px_15px_0px_0px_rgba(0,0,0,1)]">
        <h3 class="text-2xl font-black uppercase mb-4 italic">CONFIRMAR CAMBIO DE ESTADO</h3>

        <p class="font-bold text-lg leading-tight mb-6">
            Deseas cambiar el estado de <span class="text-gym-blue underline">{{ $selectedPlanName }}</span>
            de <span class="uppercase italic">"{{ $currentStatus }}"</span>
            a <span class="uppercase italic text-pink-600">"{{ $targetStatus }}"</span>.
        </p>

        <div class="flex gap-4">
            <button wire:click="updateStatus"
                    class="flex-1 bg-green-400 border-4 border-black p-3 font-black uppercase hover:shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] transition-all">
                SI, CAMBIAR
            </button>

            <button @click="show = false"
                    class="flex-1 bg-gray-200 border-4 border-black p-3 font-black uppercase">
                CANCELAR
            </button>
        </div>
    </div>
</div>

