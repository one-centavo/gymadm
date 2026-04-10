<div class="flex flex-col lg:flex-row gap-6 lg:gap-8 w-full font-roboto">
    <aside class="shrink-0 lg:w-72 order-last lg:order-first flex flex-col gap-4">
        <h3 class="font-black text-sm tracking-[0.2em] mb-1">ACCESO RÁPIDO</h3>

        <a href="#" class="bg-white border-4 border-black shadow-brutal p-4 flex items-center gap-4 hover:-translate-y-1 transition-transform group">
            <div class="bg-gym-blue border-4 border-black size-12 flex items-center justify-center shrink-0">
                <svg class="size-6 text-black" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 12H9m12 0-3-3m3 3-3 3M3 12h.01M6 12h.01"></path>
                </svg>
            </div>
            <div class="flex-1">
                <div class="font-black uppercase text-[15px] leading-tight mb-0.5">VER HISTORIAL</div>
                <div class="text-xs text-gray-700 font-semibold">de Pagos</div>
            </div>
            <svg class="size-5 text-black group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path></svg>
        </a>

        <a href="#" class="bg-white border-4 border-black shadow-brutal p-4 flex items-center gap-4 hover:-translate-y-1 transition-transform group">
            <div class="bg-gym-blue border-4 border-black size-12 flex items-center justify-center shrink-0">
                <svg class="size-6 text-black" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
            <div class="flex-1">
                <div class="font-black uppercase text-[15px] leading-tight mb-0.5">ACTUALIZAR DATOS</div>
                <div class="text-xs text-gray-700 font-semibold">Perfil y Seguridad</div>
            </div>
            <svg class="size-5 text-black group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path></svg>
        </a>
    </aside>

    <!-- ÁREA PRINCIPAL -->
    <div class="flex-1 flex flex-col gap-6 lg:gap-8">
        @if($stats['status'] === 'ACTIVO')
            <div class="bg-gym-blue border-4 border-black shadow-brutal p-5 lg:p-10 flex flex-col relative w-full">
                <!-- Distintivo Superior (Badge y Icono) -->
                <div class="flex justify-between items-start w-full absolute top-5 left-5 right-5 pr-10">
                    <div class="bg-gym-yellow border-4 border-black px-4 py-1.5 shadow-brutal-sm">
                        <span class="font-black text-sm tracking-wider">{{$stats['status']}}</span>
                    </div>
                    <svg class="size-8 text-black" fill="none" stroke="currentColor" stroke-width="4" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>

                <!-- Contenido Principal: Días y Plan -->
                <div class="mt-20 lg:mt-6 flex flex-col lg:flex-row w-full lg:items-center lg:justify-between">
                    <!-- Días Restantes -->
                    <div class="flex-1 text-center lg:text-left mb-6 lg:mb-0 flex flex-col lg:items-start">
                        <h2 class="font-black text-lg lg:text-xl tracking-[0.15em] uppercase border-b-4 border-black lg:border-none pb-2 lg:pb-0 mb-4 lg:mb-0 inline-block w-full lg:w-auto text-center lg:text-left">DÍAS RESTANTES</h2>
                        <div class="text-[5.5rem] lg:text-[7rem] font-black leading-none mt-2 lg:-mt-2 w-full text-center lg:text-left">{{$stats['days_remaining']}}</div>
                    </div>

                    <!-- Tarjeta Plan Actual -->
                    <div class="bg-white border-4 border-black shadow-brutal-sm p-4 w-full lg:w-72 mt-2 border-t-4">
                        <div class="flex justify-between text-[11px] font-black tracking-widest uppercase mb-2 text-gray-800">
                            <span>PLAN ACTUAL</span>
                            <span>VENCE EL</span>
                        </div>
                        <div class="flex justify-between items-start gap-4">
                            <span class="font-black text-[15px] leading-tight">{{$stats['plan_name']}}</span>
                            <span class="font-black text-[15px] leading-tight text-right">13 de Marzo,<br>2026</span>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- ESTADO VENCIDO -->
            <div class="bg-gym-pink border-4 border-black shadow-brutal p-5 lg:p-10 flex flex-col relative w-full items-center text-center">
                <div class="flex justify-between items-start w-full absolute top-5 left-5 right-5 pr-10">
                    <div class="bg-gym-yellow border-4 border-black px-4 py-1.5 shadow-brutal-sm">
                        <span class="font-black text-sm tracking-wider">VENCIDO</span>
                    </div>
                    <!-- Icono Cerchio con X grueso -->
                    <svg class="size-8 text-black bg-white rounded-full border-4 border-black" fill="none" stroke="currentColor" stroke-width="4" viewBox="0 0 24 24" style="background-color: transparent;">
                        <circle cx="12" cy="12" r="10" stroke="currentColor"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 9l-6 6M9 9l6 6"></path>
                    </svg>
                </div>

                <div class="mt-20 w-full max-w-lg flex flex-col gap-6 items-center">
                    <div class="bg-white border-4 border-black p-5 shadow-brutal-sm w-full">
                        <h2 class="font-black text-xl tracking-wider uppercase mb-3">TU MEMBRESÍA HA EXPIRADO</h2>
                        <p class="font-bold text-gray-800">Venció el 10 de Febrero, 2026</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- TARJETAS SECUNDARIAS (Próximo Pago y Costo) -->
        <div class="grid grid-cols-2 gap-4 lg:gap-8">
            <!-- Próximo Pago -->
            <div class="bg-white border-4 border-black shadow-brutal p-5 flex flex-col justify-start">
                <div class="bg-gym-blue border-4 border-black size-12 flex items-center justify-center mb-6">
                    <svg class="size-6 text-black" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h4 class="font-black text-[11px] tracking-widest uppercase mb-2">PRÓXIMO PAGO</h4>
                <div class="font-black text-lg lg:text-xl">{{ $stats['status'] === 'ACTIVO' ? '13 Mar 2026' : '-' }}</div>
            </div>

            <!-- Costo Mensual -->
            <div class="bg-white border-4 border-black shadow-brutal p-5 flex flex-col justify-start">
                <div class="bg-gym-blue border-4 border-black size-12 flex items-center justify-center mb-6">
                    <svg class="size-6 text-black" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                    </svg>
                </div>
                <h4 class="font-black text-[11px] tracking-widest uppercase mb-2">COSTO MENSUAL</h4>
                <div class="font-black text-lg lg:text-xl">{{ $stats['status'] === 'ACTIVO' ? '13 Mar 2026' : '-' }}</div>
            </div>
        </div>

    </div>
</div>
