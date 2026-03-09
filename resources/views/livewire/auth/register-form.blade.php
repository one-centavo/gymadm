<div class="p-6 bg-white shadow-md rounded-lg">
    {{-- Barra de Progreso (Opcional pero melosa) --}}
    <div class="mb-4 text-sm font-medium text-gray-500">
        Paso {{ $step }} de 3
    </div>

    @if($step === 1)
        @include('auth.register.get-email')
    @elseif($step === 2)
        @include('auth.register.get-otp')
    @elseif($step === 3)
        @include('auth.register.get-data')
    @endif
</div>
