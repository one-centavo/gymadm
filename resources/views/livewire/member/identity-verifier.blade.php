<form wire:submit.prevent="processIdentification" class="flex flex-col sm:flex-row gap-3">
    <input type="number" inputmode="numeric"
           pattern="[0-9]*"
           wire:model="document_number"
           min="0"
           oninput="if(this.value < 0) this.value = 0;"
           placeholder="ID para iniciar" class="border-4 border-black px-4 py-3 w-full font-bold focus:bg-gym-blue/10 outline-none transition-colors" />
    <button class="bg-gym-blue border-4 border-black px-6 py-3 font-black uppercase shadow-brutal cursor-pointer hover:translate-x-0.5 hover:translate-y-0.5 hover:shadow-none transition-all">
        CONTINUAR
    </button>
</form>
