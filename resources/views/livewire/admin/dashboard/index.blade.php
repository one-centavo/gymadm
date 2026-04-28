<section>
    <header class="mb-8">
        <h1 class="brutal-title">Panel de Administración</h1>
        <p class="font-bold text-slate-600">Bienvenido de nuevo, {{ auth()->user()->first_name }}.</p>
    </header>

    <livewire:admin.dashboard.dashboard-main/>
</section>
