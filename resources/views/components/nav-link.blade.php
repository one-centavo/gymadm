@props(['active' => false, 'icon', 'href'])

<li class="flex-1 md:flex-none md:border-b-4 md:border-black md:last:border-b-0">
    <a href="{{ $href }}"
       wire:navigate
        {{ $attributes->merge([
    'class' => 'grid grid-rows-2 justify-items-center py-4 transition-all border-r-2 border-black last:border-r-0 md:border-r-0 md:flex md:items-center md:justify-start md:gap-4 md:px-6 md:py-5 transform hover:md:translate-x-2 transition-all duration-100 ' .
    ($active
        ? 'bg-slate-800 text-white font-black border-t-8  md:border-t-0 md:border-l-8  border-gym-blue'
        : 'bg-slate-900 text-slate-400 hover:bg-slate-800 hover:text-white')
    ])}}>

        @php
            $iconName = ($active ? 'heroicon-s-' : 'heroicon-o-') . $icon;
        @endphp

        <x-dynamic-component :component="$iconName" class="h-6 w-6 stroke-2" />

        <span class="tracking-tighter uppercase text-sm md:text-base">
            {{ $slot }}
        </span>
    </a>
</li>
