<div class="w-full flex gap-2 items-center p-3">
    <div class="bg-gym-blue border-2 p-1">
        <x-heroicon-o-envelope class="h-5 w-5 font-extrabold" />
    </div>
    <h3 class="text-black text-xl uppercase tracking-wider font-black">CORREO ELECTRÓNICO</h3>
</div>

<p class="text-sm text-gray-500">Ingresa tu correo electrónico para comenzar con el registro.</p>

<div class="space-y-8">
    <div class="space-y-2">
        <label class="text-sm font-black">CORREO ELECTRÓNICO</label>
        <input
            type="email"
            placeholder="tu@correo.com"
            wire:model="email"
            wire:key="input-email"
            class="border-2 w-full p-2 focus:shadow-blue-gym focus:transition-shadow duration-75 focus:outline-none"
        >
        @error('email')
        <span class="text-red-500 text-sm font-bold mt-1">{{ $message }}</span>
        @enderror
    </div>

    <button
        type="submit"
        class="text-base bg-gym-blue p-2 w-full flex items-center justify-center gap-2 border-2 shadow-brutal hover:translate-x-1 hover:translate-y-1 hover:shadow-none cursor-pointer transition-all duration-300 ease-in-out"
    >
        <span wire:loading.remove>CONTINUAR →</span>
        <span wire:loading>Cargando...</span>
    </button>
</div>
<div>
    <span class="text-sm text-gray-500">¿Ya tienes una cuenta?</span>
    <a href="#" class="text-sm text-black underline underline-offset-4 decoration-gym-blue decoration-3 cursor-pointer hover:bg-gray-400/20">Inicia sesión</a>
</div>
