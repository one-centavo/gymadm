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
            @error('first_name')
            <span class="block mt-1 text-red-500 text-xs font-bold normal-case">{{ $message }}</span>
            @enderror
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
            @error('middle_name')
            <span class="block mt-1 text-red-500 text-xs font-bold normal-case">{{ $message }}</span>
            @enderror
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
            @error('last_name')
            <span class="block mt-1 text-red-500 text-xs font-bold normal-case">{{ $message }}</span>
            @enderror
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
            @error('second_last_name')
            <span class="block mt-1 text-red-500 text-xs font-bold normal-case">{{ $message }}</span>
            @enderror
        </label>
        <label class="text-sm font-black">
            TIPO DE DOCUMENTO
            <select wire:model="document_type" class="border-2 w-full p-3 focus:shadow-blue-gym focus:transition-shadow duration-75 focus:outline-none">
                <option value="" disabled>Seleccionar</option>
                <option value="TI">TI</option>
                <option value="CC">CC</option>
                <option value="CE">CE</option>
                <option value="PP">PP (Pasaporte)</option>
            </select>
            @error('document_type')
            <span class="block mt-1 text-red-500 text-xs font-bold normal-case">{{ $message }}</span>
            @enderror
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
            @error('document_number')
            <span class="block mt-1 text-red-500 text-xs font-bold normal-case">{{ $message }}</span>
            @enderror
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
            @error('phone_number')
            <span class="block mt-1 text-red-500 text-xs font-bold normal-case">{{ $message }}</span>
            @enderror
        </label>
        <div class="contents" x-data="{
            showPassword: false,
            showPasswordConfirmation: false,
            password: '',
            passwordConfirmation: '',
            passwordRules: [
                { key: 'min', label: 'Minimo 8 caracteres', test: value => value.length >= 8 },
                { key: 'upper', label: 'Al menos una letra mayuscula', test: value => /[A-Z]/.test(value) },
                { key: 'lower', label: 'Al menos una letra minuscula', test: value => /[a-z]/.test(value) },
                { key: 'number', label: 'Al menos un numero', test: value => /[0-9]/.test(value) },
                { key: 'symbol', label: 'Al menos un simbolo', test: value => /[^A-Za-z0-9]/.test(value) },
            ],
            meets(rule) {
                return rule.test(this.password || '');
            },
            hasPassword() {
                return (this.password || '').length > 0;
            },
            hasConfirmation() {
                return (this.passwordConfirmation || '').length > 0;
            },
            matchesConfirmation() {
                return this.hasPassword() && this.password === this.passwordConfirmation;
            }
        }">
            <label class="text-sm font-black">
                CONTRASEÑA
                <div class="relative mt-1">
                    <input
                        :type="showPassword ? 'text' : 'password'"
                        x-model="password"
                        placeholder="********"
                        maxlength="50"
                        wire:model="password"
                        wire:key="input-password"
                        class="border-2 w-full p-3 pr-11 focus:shadow-blue-gym focus:transition-shadow duration-75 focus:outline-none"
                    >
                    <button
                        type="button"
                        class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-600 hover:text-black cursor-pointer"
                        @click="showPassword = !showPassword"
                        :aria-label="showPassword ? 'Ocultar contraseña' : 'Mostrar contraseña'"
                        :aria-pressed="showPassword.toString()"
                    >
                        <x-heroicon-o-eye x-show="!showPassword" x-cloak class="w-5 h-5" />
                        <x-heroicon-o-eye-slash x-show="showPassword" x-cloak class="w-5 h-5" />
                    </button>
                </div>
                @error('password')
                <span class="block mt-1 text-red-500 text-xs font-bold normal-case">{{ $message }}</span>
                @enderror
            </label>

            <label class="text-sm font-black">
                CONFIRMACIÓN
                <div class="relative mt-1">
                    <input
                        :type="showPasswordConfirmation ? 'text' : 'password'"
                        x-model="passwordConfirmation"
                        placeholder="********"
                        maxlength="50"
                        wire:model="password_confirmation"
                        wire:key="input-password-confirmation"
                        class="border-2 w-full p-3 pr-11 focus:shadow-blue-gym focus:transition-shadow duration-75 focus:outline-none"
                    >
                    <button
                        type="button"
                        class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-600 hover:text-black cursor-pointer"
                        @click="showPasswordConfirmation = !showPasswordConfirmation"
                        :aria-label="showPasswordConfirmation ? 'Ocultar confirmación de contraseña' : 'Mostrar confirmación de contraseña'"
                        :aria-pressed="showPasswordConfirmation.toString()"
                    >
                        <x-heroicon-o-eye x-show="!showPasswordConfirmation" x-cloak class="w-5 h-5" />
                        <x-heroicon-o-eye-slash x-show="showPasswordConfirmation" x-cloak class="w-5 h-5" />
                    </button>
                </div>
                @error('password_confirmation')
                <span class="block mt-1 text-red-500 text-xs font-bold normal-case">{{ $message }}</span>
                @enderror
            </label>

            <div class="col-span-2 border-2 bg-gray-50 p-3 text-xs space-y-2">
                <p class="font-black uppercase tracking-wide text-gray-700">Criterios de contraseña</p>
                <template x-for="rule in passwordRules" :key="rule.key">
                    <div class="flex items-center gap-2" :class="hasPassword() ? (meets(rule) ? 'text-green-600' : 'text-red-500') : 'text-gray-500'">
                        <x-heroicon-o-check-circle x-show="hasPassword() && meets(rule)" x-cloak class="w-4 h-4 shrink-0" />
                        <x-heroicon-o-x-circle x-show="hasPassword() && !meets(rule)" x-cloak class="w-4 h-4 shrink-0" />
                        <x-heroicon-o-minus-circle x-show="!hasPassword()" x-cloak class="w-4 h-4 shrink-0" />
                        <span x-text="rule.label"></span>
                    </div>
                </template>
                <div class="flex items-center gap-2" :class="hasConfirmation() ? (matchesConfirmation() ? 'text-green-600' : 'text-red-500') : 'text-gray-500'">
                    <x-heroicon-o-check-circle x-show="hasConfirmation() && matchesConfirmation()" x-cloak class="w-4 h-4 shrink-0" />
                    <x-heroicon-o-x-circle x-show="hasConfirmation() && !matchesConfirmation()" x-cloak class="w-4 h-4 shrink-0" />
                    <x-heroicon-o-minus-circle x-show="!hasConfirmation()" x-cloak class="w-4 h-4 shrink-0" />
                    <span>La confirmacion debe coincidir con la contrasena</span>
                </div>
            </div>
        </div>
        @error('registration')
        <span class="text-red-500 text-sm font-bold col-span-2">{{ $message }}</span>
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
