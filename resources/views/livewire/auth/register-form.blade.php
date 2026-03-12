<main class="flex flex-col items-center justify-center h-full gap-6 bg-gym-hero">
    <header class="flex flex-col gap-4 w-11/12 max-w-md items-center">
        <div class="flex justify-center bg-gym-blue border-3 border-black px-4 py-2 shadow-brutal w-1/2">
            <h1 class="text-black text-4xl tracking-wide uppercase font-black">GYMADM</h1>
            <img src="" alt="" srcset="">
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
    <section class="w-11/12 max-w-md bg-white">
        <form wire:submit="{{ $step === 1 ? 'sendOtp' : ($step === 2 ? 'verifyOtp' : 'registerMember') }}" class="flex flex-col border-2 p-6 gap-4 shadow-brutal items-center">
            @if($step === 1)
                @include('auth.register.get-email')
            @elseif($step === 2)
                @include('auth.register.get-otp')
            @elseif($step === 3)
                @include('auth.register.get-data')
            @endif
        </form>
    </section>
</main>
