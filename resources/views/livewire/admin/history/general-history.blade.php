<section class="w-full space-y-8 animate-fade-in">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">

        <aside class="space-y-6 lg:sticky lg:top-8 order-1">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-1 gap-6">
                <article class="bg-white border-4 border-black p-6 shadow-brutal flex flex-col items-start">
                    <div class="bg-gym-blue border-4 border-black p-2 mb-4">
                        <x-heroicon-s-calendar class="w-8 h-8 text-black" />
                    </div>
                    <h3 class="font-black uppercase text-[10px] tracking-widest text-black/60">Total Pagos</h3>
                    <p class="text-6xl font-black italic tracking-tighter">{{ $stats['total_sales'] }}</p>
                </article>

                <article class="bg-white border-4 border-black p-6 shadow-brutal flex flex-col items-start">
                    <div class="bg-gym-blue border-4 border-black p-2 mb-4">
                        <x-heroicon-s-credit-card class="w-8 h-8 text-black" />
                    </div>
                    <h3 class="font-black uppercase text-[10px] tracking-widest text-black/60">Monto Total</h3>
                    <p class="text-5xl font-black italic tracking-tighter">
                        ${{ number_format($stats['total_revenue'], 0, ',', '.')}}
                    </p>
                </article>
            </div>
        </aside>

        <section class="lg:col-span-2 space-y-6 order-2">
            <header class="flex items-center justify-between border-b-4 border-black pb-2 mb-4">
                <h2 class="font-black uppercase tracking-widest text-sm text-black">Transacciones Recientes</h2>
            </header>

            <div class="flex flex-col gap-6">
                @forelse($transactions as $item)
                    <article class="bg-white border-4 border-black p-5 shadow-brutal transition-all hover:translate-x-1 hover:translate-y-1 hover:shadow-none">
                        <div class="flex flex-col sm:flex-row items-start gap-6">
                            <div class="bg-gym-blue border-4 border-black p-3 shrink-0">
                                <x-heroicon-s-check-circle class="w-10 h-10 text-black" />
                            </div>

                            <div class="flex-1 w-full">
                                <div class="flex flex-col lg:flex-row justify-between items-start gap-4">
                                    <div class="space-y-1">
                                        <p class="font-black text-2xl uppercase italic leading-none tracking-tighter text-black">
                                            {{ $item->user->first_name }} {{ $item->user->last_name }}
                                        </p>
                                        <div class="flex flex-wrap gap-2 items-center text-[10px] font-bold uppercase text-gray-500 tracking-wider">
                                            <span class="bg-black text-white px-2 py-0.5">DOC: {{ $item->user->document_number }}</span>
                                            <span>{{ $item->membershipPlan->name }}</span>
                                        </div>
                                    </div>
                                    <div class="flex flex-col items-start lg:items-end w-full lg:w-auto">
                                        <p class="font-black text-3xl leading-none mb-2 italic tracking-tighter">${{ number_format($item->price_paid, 0, ',', '.') }}</p>
                                        <span class="bg-gym-blue border-2 border-black px-4 py-1 text-[10px] font-black uppercase shadow-brutal-sm">
                                            {{ $item->status }}
                                        </span>
                                    </div>
                                </div>

                                <hr class="border-t-2 border-black border-dashed my-4 w-full">

                                <footer class="flex flex-wrap items-center justify-between gap-4 text-gray-700 font-bold text-[10px] uppercase">
                                    <div class="flex items-center gap-2">
                                        <x-heroicon-s-credit-card class="w-4 h-4 text-gray-400" />
                                        <span>{{ $item->payment_method }}</span>
                                        <span class="text-gray-300">• • • •</span>
                                        <span>1234</span>
                                    </div>
                                    <div class="flex items-center gap-2 italic">
                                        <span>{{ $item->start_date->translatedFormat('d M Y') }}</span>
                                        <span class="text-gray-400">—</span>
                                        <span>{{ $item->end_date->translatedFormat('d M Y') }}</span>
                                    </div>
                                </footer>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="bg-white border-4 border-black p-10 shadow-brutal text-center">
                        <p class="font-black uppercase italic text-gray-400">No hay transacciones registradas</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-8">
                {{ $transactions->links() }}
            </div>
        </section>
    </div>
</section>
