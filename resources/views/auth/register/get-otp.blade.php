<div class="w-full flex gap-2 items-center p-3">
    <div class="bg-gym-blue border-2 p-1">
        <x-heroicon-o-key class="h-5 w-5 font-extrabold" />
    </div>
    <h3 class="text-black text-xl uppercase tracking-wider font-black">CÓDIGO DE VERIFICACIÓN</h3>
</div>

<p class="text-sm text-gray-500 p-3">Hemos enviado un código de verificación a
    <span class="text-black font-bold">{{$email}}</span>
</p>

<div class="space-y-8 w-full p-3">

    <div class="space-y-2">
        <label class="text-sm font-black">CÓDIGO</label>
        <input
            type="text"
            inputmode="numeric"
            pattern="[0-9]*"
            placeholder="• • • • • •"
            maxlength="6"
            wire:model="otp"
            wire:key="input-otp"
            class="text-center text-lg border-2 w-full p-3 focus:shadow-blue-gym focus:transition-shadow duration-75 focus:outline-none"
        >
        @error('otp')
        <span class="text-red-500 text-sm font-bold">{{ $message }}</span>
        @enderror
    </div>

    <div class="flex gap-2 items-center flex-1">
        <button
            type="button"
            wire:click="$set('step', 1)"
            wire:key="btn-back-step-2"
            :disabled="$wire.step === 1"
            class="text-base bg-white p-2 w-full flex items-center justify-center gap-2 border-2 shadow-brutal hover:translate-x-1 hover:translate-y-1 hover:shadow-none cursor-pointer transition-all duration-300 ease-in-out disabled:opacity-50 disabled:cursor-not-allowed disabled:shadow-none">
            <x-heroicon-o-arrow-left class="text-black font-bold w-4 h-4"></x-heroicon-o-arrow-left> ATRÁS
        </button>
        <button
            type="submit"
            class="text-black font-base bg-gym-blue p-2 w-full flex items-center justify-center gap-2 border-2 shadow-brutal hover:translate-x-1 hover:translate-y-1 hover:shadow-none cursor-pointer transition-all duration-300 ease-in-out"
        >
            <span wire:loading.remove>CONTINUAR →</span>
            <span wire:loading>Cargando...</span>
        </button>
    </div>

    <div class="flex flex-col items-center gap-2"
         x-data="{
            timer: @entangle('resendCountdown'),
            reloj: null,
            iniciarReloj() {
                if (this.reloj) clearInterval(this.reloj);
                this.reloj = setInterval(() => {
                    if (this.timer > 0) {
                        this.timer--;
                    } else {
                        clearInterval(this.reloj);
                    }
                }, 1000);
            }
         }"
         x-init="if (timer > 0) iniciarReloj();"
         @reloj-reiniciado.window="timer = 60; iniciarReloj();"
    >
        <span>
            ¿No recibiste el código?
            <button
                type="button"
                wire:click="resendOtp"
                wire:loading.attr="disabled"
                x-bind:disabled="timer > 0"
                wire:key="btn-resend-otp"
                class="text-sm text-black underline underline-offset-4 decoration-gym-blue decoration-3 cursor-pointer hover:bg-gray-400/20 disabled:opacity-50 disabled:cursor-not-allowed disabled:no-underline transition-all duration-200">

                <span x-show="timer === 0" wire:loading.remove wire:target="resendOtp">
                    Reenviar código
                </span>

                <span x-show="timer > 0" x-cloak>
                    Reenviar en <span x-text="timer"></span>s
                </span>

                <span wire:loading wire:target="resendOtp">Enviando...</span>
            </button>
        </span>

        @if (session()->has('message'))
            <span class="text-xs text-green-600 font-bold animate-pulse">
                {{ session('message') }}
             </span>
        @endif
    </div>

</div>

