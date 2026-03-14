<div class="w-full flex gap-2 items-center p-3">
    <div class="bg-gym-blue border-2 p-1">
        <x-heroicon-o-user class="h-5 w-5 font-extrabold" />
    </div>
    <h3 class="text-black text-xl uppercase tracking-wider font-black">INFORMACIÓN PERSONAL</h3>
</div>

<p class="text-sm text-gray-500 p-3 flex flex-start w-full">Completa tus datos para finalizar el registro.
</p>

<div class="space-y-8 w-full p-3">

    <div class="flex flex-col md:grid md:grid-cols-2 gap-4 overflow-y-scroll max-h-64">
        <label class="text-sm font-black">
            PRIMER NOMBRE
            <input
                type="text"
                placeholder="Juan"
                maxlength="50"
                wire:model="first_name"
                wire:key="input-first-name"
                class="border-2 w-full p-3 focus:shadow-blue-gym focus:transition-shadow duration-75 focus:outline-none"
            >

        </label>
        <label class="text-sm font-black">
            SEGUNDO NOMBRE
            <input
                type="text"
                placeholder="Luis"
                maxlength="50"
                wire:model="middle_name"
                wire:key="input-second-name"
                class="border-2 w-full p-3 focus:shadow-blue-gym focus:transition-shadow duration-75 focus:outline-none"
            >

        </label>
        <label class="text-sm font-black">
            PRIMER APELLIDO
            <input
                type="text"
                placeholder="Pérez"
                maxlength="50"
                wire:model="last_name"
                wire:key="input-first-last-name"
                class="border-2 w-full p-3 focus:shadow-blue-gym focus:transition-shadow duration-75 focus:outline-none"
            >

        </label>
        <label class="text-sm font-black">
            SEGUNDO APELLIDO
            <input
                type="text"
                placeholder="Gómez"
                maxlength="50"
                wire:model="second_last_name"
                wire:key="input-second-last-name"
                class="border-2 w-full p-3 focus:shadow-blue-gym focus:transition-shadow duration-75 focus:outline-none"
            >

        </label>
        <label class="text-sm font-black">
            TIPO DE DOCUMENTO
            <select wire:model="document_type" class="border-2 w-full p-3 focus:shadow-blue-gym focus:transition-shadow duration-75 focus:outline-none">
                <option disabled selected>Seleccionar</option>
            </select>
        </label>

        <label class="text-sm font-black">
            NUMERO DE DOCUMENTO
            <input
                type="text"
                placeholder="1234567890"
                maxlength="50"
                wire:model="document_number"
                wire:key="input-document-number"
                class="border-2 w-full p-3 focus:shadow-blue-gym focus:transition-shadow duration-75 focus:outline-none"
            >

        </label>
        <label class="text-sm font-black col-span-2">
            NUMERO DE CELULAR
            <input
                type="text"
                placeholder="1234567890"
                maxlength="50"
                wire:model="phone_number"
                wire:key="input-document-number-2"
                class="border-2 w-full p-3 focus:shadow-blue-gym focus:transition-shadow duration-75 focus:outline-none"
            >

        </label>
        <label class="text-sm font-black">
            CONTRASEÑA
            <input
                type="text"
                placeholder="********"
                maxlength="50"
                wire:model="password"
                wire:key="input-password"
                class="border-2 w-full p-3 focus:shadow-blue-gym focus:transition-shadow duration-75 focus:outline-none"
            >

        </label>
        <label class="text-sm font-black">
            CONFIRMACIÓN
            <input
                type="text"
                placeholder="********"
                maxlength="50"
                wire:model="password_confirmation"
                wire:key="input-password-confirmation"
                class="border-2 w-full p-3 focus:shadow-blue-gym focus:transition-shadow duration-75 focus:outline-none"
            >

        </label>
        @error('otp')
        <span class="text-red-500 text-sm font-bold">{{ $message }}</span>
        @enderror
    </div>

    <div class="flex gap-2 items-center flex-1">
        <button
            type="button"
            wire:click="$set('step', 2)"
            wire:key="btn-back-step-2"
            :disabled="$wire.step === 1"
            class="text-base bg-white p-2 w-full flex items-center justify-center gap-2 border-2 shadow-brutal hover:translate-x-1 hover:translate-y-1 hover:shadow-none cursor-pointer transition-all duration-300 ease-in-out disabled:opacity-50 disabled:cursor-not-allowed disabled:shadow-none">
            <x-heroicon-o-arrow-left class="text-black font-bold w-4 h-4"></x-heroicon-o-arrow-left> ATRÁS
        </button>
        <button
            type="submit"
            class="text-black font-base bg-gym-blue p-2 w-full flex items-center justify-center gap-2 border-2 shadow-brutal hover:translate-x-1 hover:translate-y-1 hover:shadow-none cursor-pointer transition-all duration-300 ease-in-out"
        >
            <span wire:loading.remove>REGISTRARSE</span>
            <span wire:loading>Cargando...</span>
        </button>
    </div>
</div>
