<div class="space-y-12">
    <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <article class="brutal-card bg-gym-blue">
            <h3 class="font-black uppercase text-sm">Miembros Totales</h3>
            <p class="text-5xl font-black mt-2">{{ $kpis['total_members'] }}</p>
        </article>

        <article class="brutal-card bg-gym-yellow">
            <h3 class="font-black uppercase text-sm">Ingresos Mes</h3>
            <p class="text-4xl font-black mt-2">${{ number_format($kpis['monthly_income'], 0, ',', '.') }}</p>
        </article>

        <article class="brutal-card bg-gym-lime">
            <h3 class="font-black uppercase text-sm">Activos Ahora</h3>
            <p class="text-5xl font-black mt-2">{{ $kpis['active_memberships'] }}</p>
        </article>

        <article class="brutal-card bg-gym-pink text-white">
            <h3 class="font-black uppercase text-sm">Por Vencer (7d)</h3>
            <p class="text-5xl font-black mt-2">{{ $kpis['upcoming_expirations'] }}</p>
        </article>
    </section>

    <section class="space-y-4">
        <div class="flex justify-between items-end">
            <h2 class="text-2xl font-black uppercase italic">Últimos Registros</h2>
            <a href="{{ route('admin.history') }}" class="brutal-btn bg-white hover:bg-gym-yellow">
                Ver Historial
            </a>
        </div>

        <div class="overflow-x-auto border-4 border-black shadow-brutal">
            <table class="w-full bg-white">
                <thead>
                <tr>
                    <th class="brutal-table-header">Nombre</th>
                    <th class="brutal-table-header">Documento</th>
                    <th class="brutal-table-header">Plan Actual</th>
                    <th class="brutal-table-header text-center">Estado</th>
                </tr>
                </thead>
                <tbody class="divide-y-4 divide-black">
                @foreach($recentMembers as $member)
                    <tr class="hover:bg-slate-50">
                        <td class="p-4 font-bold uppercase">{{ $member->first_name }} {{ $member->last_name }}</td>
                        <td class="p-4 font-mono">{{ $member->document_number }}</td>
                        <td class="p-4">
                            <span class="px-2 py-1 border-2 border-black bg-gym-yellow font-black text-xs uppercase">
                                {{ $member->memberships->first()->plan->name ?? 'SIN PLAN' }}
                            </span>
                        </td>
                        <td class="p-4 text-center">
                            @php $is_active = $member->status === 'active'; @endphp
                            <span class="px-3 py-1 border-2 border-black {{ $is_active ? 'bg-gym-lime' : 'bg-gym-pink' }} font-black text-xs uppercase shadow-brutal-sm">
                                {{ $member->status }}
                            </span>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </section>
</div>
