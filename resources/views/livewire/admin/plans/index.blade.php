<section class="flex flex-col gap-6 pb-24 md:pb-0">
    <header class="flex flex-col md:flex-row justify-between items-start md:items-center shrink-0">
        <div>
            <h1 class="text-4xl font-black tracking-tighter uppercase">PLANES</h1>
            <span class="text-slate-500 font-bold text-sm tracking-widest">GESTIÓN Y CONTROL DE PLANES DE MEMBRESÍA</span>
        </div>
    </header>
    <section class="flex justify-end w-full">
        <button
            @click="$dispatch('prefix-plan-form')"
            class="bg-gym-blue border-4 w-full md:w-60 border-black p-4 font-black uppercase shadow-brutal hover:translate-x-1 hover:translate-y-1 hover:shadow-none transition-all cursor-pointer"
        >
            + Crear Nuevo Plan
        </button>

    </section>
    <livewire:admin.plans.plans-list/>
    <livewire:admin.plans.create-plan/>
    <livewire:admin.plans.update-plan-info/>
    <livewire:admin.plans.toggle-status-plan/>
</section>
