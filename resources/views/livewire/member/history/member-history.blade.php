<section class="w-full max-w-7xl mx-auto p-4 lg:p-8">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">

        <aside class="space-y-6 lg:sticky lg:top-8">
            <header class="mb-4 lg:mb-8">
                <h1 class="text-5xl font-black uppercase tracking-tight leading-none">Historial</h1>
                <p class="text-gray-600 font-bold text-lg mt-2">Tu registro completo de transacciones</p>
            </header>

            <div class="grid grid-cols-2 lg:grid-cols-1 gap-4">
                <div class="bg-white border-4 border-black p-4 shadow-[6px_6px_0px_0px_rgba(0,0,0,1)]">
                    <div class="bg-gym-blue border-4 border-black p-2 w-fit mb-4">
                        <x-heroicon-s-calendar class="w-8 h-8 text-black" />
                    </div>
                    <h3 class="font-black uppercase text-[10px] tracking-widest text-black">Total Pagos</h3>
                    <p class="text-5xl font-black">{{ $stats['total_payments'] ?? 6 }}</p>
                </div>

                <div class="bg-white border-4 border-black p-4 shadow-[6px_6px_0px_0px_rgba(0,0,0,1)]">
                    <div class="bg-gym-blue border-4 border-black p-2 w-fit mb-4">
                        <x-heroicon-s-credit-card class="w-8 h-8 text-black" />
                    </div>
                    <h3 class="font-black uppercase text-[10px] tracking-widest text-black">Monto Total</h3>
                    <p class="text-4xl font-black leading-tight">
                        ${{ number_format(($stats['total_amount'] ?? 390000) / 1000, 0) }}k
                    </p>
                </div>
            </div>
        </aside>

        <main class="lg:col-span-2 space-y-6">
            <h2 class="font-black uppercase tracking-widest text-sm text-black lg:pt-0 pt-4">
                Transacciones Recientes
            </h2>

            <div class="space-y-6">
                @foreach($transactions as $item)
                    <article class="bg-white border-4 border-black p-5 shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] hover:translate-x-1 hover:translate-y-1 hover:shadow-none transition-all">
                        <div class="flex items-start gap-4">
                            <div class="bg-gym-blue border-4 border-black p-2 shrink-0">
                                <x-heroicon-s-check-circle class="w-10 h-10 text-black" />
                            </div>

                            <div class="flex-1">
                                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                                    <div>
                                        <p class="font-black text-xl uppercase leading-none">
                                            {{ $item->start_date->translatedFormat('d M Y') }}
                                        </p>
                                        <p class="font-bold text-gray-500 text-sm mt-1 uppercase">
                                            {{ $item->membershipPlan->name }}
                                        </p>
                                    </div>
                                    <div class="text-left sm:text-right w-full sm:w-auto">
                                        <p class="font-black text-3xl leading-none mb-2">
                                            ${{ number_format($item->price_paid, 0, ',', '.') }}
                                        </p>
                                        <span class="bg-gym-blue border-2 border-black px-4 py-1 text-[10px] font-black uppercase inline-block">
                                            Pagado
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="border-t-2 border-black border-dashed my-4">

                        <div class="flex items-center gap-2 text-gray-700 font-bold text-xs uppercase">
                            <x-heroicon-s-credit-card class="w-4 h-4 text-gray-400" />
                            <span>{{ $item->payment_method ?? 'Tarjeta Débito' }}</span>
                            <span class="text-gray-400">••••</span>
                            <span>{{ $item->card_last_digits ?? '1234' }}</span>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $transactions->links() }}
            </div>
        </main>
    </div>
</section>
