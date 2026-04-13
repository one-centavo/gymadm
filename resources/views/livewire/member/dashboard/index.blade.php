<section class="w-full max-w-7xl mx-auto pb-6">
    <div class="mb-5">
        <h1 class="font-black text-2xl uppercase italic">
            ¡Hola, {{ auth()->user()->first_name }}!
        </h1>
    </div>
    <livewire:member.dashboard.member-stats />
</section>
