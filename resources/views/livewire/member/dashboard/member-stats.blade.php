<div class="flex flex-col lg:flex-row gap-6 lg:gap-8 w-full font-roboto">
    <aside class="shrink-0 lg:w-72 order-last lg:order-first flex flex-col gap-4">
        <h3 class="font-black text-sm tracking-[0.2em] mb-1">ACCESO RÁPIDO</h3>

        <a href="#"
           class="bg-white border-4 border-black shadow-brutal p-4 flex items-center gap-4 hover:-translate-y-1 transition-transform group">
            <div class="bg-gym-blue border-4 border-black size-12 flex items-center justify-center shrink-0">
                <svg class="size-6 text-black" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M21 12H9m12 0-3-3m3 3-3 3M3 12h.01M6 12h.01"></path>
                </svg>
            </div>
            <div class="flex-1">
                <div class="font-black uppercase text-base leading-tight mb-0.5">VER HISTORIAL</div>
                <div class="text-xs text-gray-700 font-semibold">de Pagos</div>
            </div>
            <svg class="size-5 text-black group-hover:translate-x-1 transition-transform" fill="none"
                 stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path>
            </svg>
        </a>

        <a href="#"
           class="bg-white border-4 border-black shadow-brutal p-4 flex items-center gap-4 hover:-translate-y-1 transition-transform group">
            <div class="bg-gym-blue border-4 border-black size-12 flex items-center justify-center shrink-0">
                <svg class="size-6 text-black" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
            <div class="flex-1">
                <div class="font-black uppercase text-[15px] leading-tight mb-0.5">ACTUALIZAR DATOS</div>
                <div class="text-xs text-gray-700 font-semibold">Perfil y Seguridad</div>
            </div>
            <svg class="size-5 text-black group-hover:translate-x-1 transition-transform" fill="none"
                 stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path>
            </svg>
        </a>
    </aside>

    <!-- ÁREA PRINCIPAL -->
    <section class="flex-1 flex flex-col gap-6 lg:gap-8">
        @if($stats['status'] === 'ACTIVO')
            <article
                class="w-full flex flex-col bg-gym-blue border-4 border-black shadow-brutal divide-y-4 divide-black overflow-hidden">
                <header class="w-full p-5 flex justify-between items-center">
                    <div class="bg-gym-yellow border-4 border-black px-4 py-1 shadow-brutal-sm -rotate-1">
            <span class="font-black text-sm tracking-widest uppercase">
                {{$stats['status']}}
            </span>
                    </div>

                    <x-heroicon-o-check-badge class="size-10 text-black stroke-3"/>
                </header>

                <section class="w-full p-6 lg:p-8 flex flex-col lg:flex-row lg:items-end justify-between gap-8">

                    <div class="flex flex-col items-center lg:items-start">
                        <h2 class="font-black text-lg tracking-[0.2em] uppercase leading-none mb-2">
                            Días Restantes
                        </h2>
                        <span class="text-[7rem] lg:text-[8.5rem] font-black leading-none tracking-tighter">
                            {{ $stats['days_remaining'] }}
                        </span>
                    </div>

                    <div class="bg-white border-4 border-black shadow-brutal-sm p-4 w-full lg:w-72 flex flex-col gap-3">
                        <div
                            class="flex justify-between items-center font-black text-[10px] tracking-widest text-black border-b-2 border-black pb-1 uppercase">
                            <span>Plan Actual</span>
                            <span>Vence el</span>
                        </div>

                        <div class="flex justify-between items-start gap-4 font-black">
                            <span class="text-base leading-tight uppercase">
                                {{ $stats['plan_name'] }}
                            </span>
                            <span class="text-sm text-right leading-tight">
                                {{ $stats['expiry_day_month'] }}<br>
                                {{ $stats['expiry_year'] }}
                            </span>
                        </div>
                    </div>

                </section>

            </article>
        @elseif($stats['status'] === 'PENDIENTE')
            <!-- ESTADO PENDIENTE -->
            <article
                class="w-full flex flex-col items-center text-center bg-gym-yellow border-4 border-black shadow-brutal divide-y-4 divide-black overflow-hidden">

                <header class="w-full p-4 lg:p-6 flex justify-between items-start">
                    <div class="bg-gym-lime border-4 border-black px-3 py-1 shadow-brutal-sm -rotate-2">
                        <span class="font-black text-sm tracking-tighter uppercase">Pendiente</span>
                    </div>

                    <x-heroicon-o-clock class="size-10 text-black stroke-2"/>
                </header>

                <section class="w-full flex-1 py-10 px-5 flex flex-col justify-center gap-2">
                    <h2 class="font-black text-3xl lg:text-4xl tracking-tighter uppercase leading-none">
                        Registro<br>Incompleto
                    </h2>
                    <p class="font-bold text-lg uppercase opacity-90">
                        Acércate a recepción
                    </p>
                </section>

                <footer class="w-full p-4 bg-white">
                    <div
                        class="flex justify-between items-center text-left font-black text-[10px] sm:text-xs uppercase tracking-tight gap-4">
                        <p>Pendiente de<br>Activación</p>
                        <p class="text-right">Visítanos<br>en sede</p>
                    </div>
                </footer>

            </article>
        @else
            <!-- ESTADO VENCIDO -->
            <article
                class="w-full flex flex-col items-center text-center bg-gym-pink border-4 border-black shadow-brutal divide-y-4 divide-black overflow-hidden">

                <header class="w-full p-5 flex justify-between items-center bg-transparent">
                    <div class="bg-gym-yellow border-4 border-black px-4 py-1 shadow-brutal-sm rotate-2">
            <span class="font-black text-sm tracking-widest uppercase">
                Vencido
            </span>
                    </div>

                    <x-heroicon-o-x-circle class="size-10 text-black stroke-3"/>
                </header>

                <section class="w-full p-8 lg:p-12 flex flex-col gap-4 bg-white">
                    <h2 class="font-black text-2xl lg:text-3xl tracking-tighter uppercase leading-none">
                        Tu membresía<br>ha expirado
                    </h2>
                    <p class="font-bold text-lg border-2 border-black inline-block px-4 py-1 self-center bg-gym-pink/10">
                        Venció el 10 de Febrero, 2026
                    </p>
                </section>

                <footer class="w-full p-6 bg-cyan-400 hover:bg-cyan-300 transition-colors cursor-pointer group">
        <span
            class="font-black text-xl lg:text-2xl tracking-widest uppercase group-hover:scale-105 inline-block transition-transform">
            ¡Renueva en sede!
        </span>
                </footer>

            </article>
        @endif

        <!-- TARJETAS SECUNDARIAS (Próximo Pago y Costo) -->
        <div class="grid grid-cols-2 gap-4 lg:gap-8">
            <!-- Próximo Pago -->
            <div class="bg-white border-4 border-black shadow-brutal p-5 flex flex-col justify-start">
                <div class="bg-gym-blue border-4 border-black size-12 flex items-center justify-center mb-6">
                    <svg class="size-6 text-black" fill="none" stroke="currentColor" stroke-width="2.5"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h4 class="font-black text-[11px] tracking-widest uppercase mb-2">PRÓXIMO PAGO</h4>
                <div
                    class="font-black text-lg lg:text-xl">{{ $stats['status'] === 'ACTIVO' ? $stats['next_payment'] : '-' }}</div>
            </div>

            <!-- Costo Mensual -->
            <div class="bg-white border-4 border-black shadow-brutal p-5 flex flex-col justify-start">
                <div class="bg-gym-blue border-4 border-black size-12 flex items-center justify-center mb-6">
                    <svg class="size-6 text-black" fill="none" stroke="currentColor" stroke-width="2.5"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                    </svg>
                </div>
                <h4 class="font-black text-[11px] tracking-widest uppercase mb-2">COSTO MENSUAL</h4>
                <div
                    class="font-black text-lg lg:text-xl">{{ $stats['status'] === 'ACTIVO' ? $stats['plan_price'] : '-' }}</div>
            </div>
        </div>

    </section>
</div>
