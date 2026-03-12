<div class="flex items-center gap-3 mb-4">
    <div class="bg-blue-500 p-2 border-2 border-black">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="square" stroke-linejoin="miter" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
    </div>
    <h3 class="font-black text-xl uppercase">Correo Electrónico</h3>
</div>

<p class="text-gray-600 mb-6 font-medium">Ingresa tu correo electrónico para comenzar el registro.</p>

<div class="mb-6">
    <label class="block font-bold mb-2 uppercase text-sm">Correo Electrónico</label>
    <input
        type="email"
        wire:model="email"
        placeholder="tu@correo.com"
        class="w-full border-4 border-black p-3 focus:outline-none focus:bg-gray-50"
    >
    @error('email')
    <span class="text-red-600 font-bold text-sm mt-1 block">{{ $message }}</span>
    @enderror
</div>

<button
    type="submit"
    class="w-full bg-blue-500 border-4 border-black p-4 font-black uppercase text-lg shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-none transition-all flex justify-center items-center gap-2"
>
    <span wire:loading.remove>Continuar →</span>
    <span wire:loading>Cargando...</span>
</button>

<div class="mt-6 text-center text-sm font-bold">
    <span class="text-gray-600">¿Ya tienes una cuenta?</span>
    <a href="#" class="underline decoration-2 underline-offset-4 hover:text-blue-600">Inicia sesión</a>
</div>

