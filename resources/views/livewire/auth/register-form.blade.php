<div>
    <main class="flex flex-col items-center justify-center h-dvh gap-6 bg-gym-hero">
        <header class="flex flex-col gap-4 w-11/12 max-w-lg items-center">
            <div class="flex justify-center items-center bg-gym-blue border-3 border-black px-4 py-2 shadow-brutal w-1/2">
                <h1 class="text-black text-4xl tracking-wide uppercase font-black">GYMADM</h1>
                <x-icons.dumbbell-lifting class="h-14 w-36"/>
            </div>
            <div class="w-full px-6 py-3 bg-black border-3 border-gym-blue shadow-blue-gym">
                <h2 class="text-center text-white text-2xl md:text-3xl tracking-wide uppercase font-bold">
                    Tu viaje empieza aquí
                </h2>
            </div>
        </header>

        <div class="flex justify-center items-center gap-4">
            <div class="{{ $step === 1 ? 'bg-gym-blue' : 'bg-white' }} px-4 py-1 border-2 border-black font-bold">1</div>
            <div class="h-1 w-8 bg-gray-500"></div>
            <div class="{{ $step === 2 ? 'bg-gym-blue' : 'bg-white' }} px-4 py-1 border-2 border-black font-bold">2</div>
            <div class="h-1 w-8 bg-gray-500"></div>
            <div class="{{ $step === 3 ? 'bg-gym-blue' : 'bg-white' }} px-4 py-1 border-2 border-black font-bold">3</div>
        </div>
        <section class="w-11/12 {{ $step === 3? 'max-w-2xl' : 'max-w-md'}} bg-white">
            <form wire:submit="{{ $step === 1 ? 'sendOtp' : ($step === 2 ? 'verifyOtp' : 'registerMember') }}" class="flex flex-col border-2 p-6 gap-4 shadow-brutal items-center">
                <div wire:key="register-step-{{ $step }}" class="w-full step-slide-left">
                    @if($step === 1)
                        @include('auth.register.get-email')
                    @elseif($step === 2)
                        @include('auth.register.get-otp')
                    @elseif($step === 3)
                        @include('auth.register.get-data')
                    @endif
                </div>
            </form>
        </section>
    </main>

    @if($showSuccessModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 px-4">
            <div class="w-full max-w-md bg-white border-2 border-black p-6 shadow-brutal">
                <h3 class="text-xl font-black uppercase tracking-wide text-black">Registro completado</h3>
                <p class="mt-3 text-sm text-gray-700">
                    Tu cuenta fue creada con éxito. Ya puedes iniciar sesión para continuar.
                </p>
                <button
                    type="button"
                    wire:click="goToLogin"
                    class="mt-6 text-black font-base bg-gym-blue p-2 w-full flex items-center justify-center gap-2 border-2 shadow-brutal hover:translate-x-1 hover:translate-y-1 hover:shadow-none cursor-pointer transition-all duration-300 ease-in-out"
                >
                    IR A INICIAR SESIÓN
                </button>
            </div>
        </div>
    @endif
</div>
