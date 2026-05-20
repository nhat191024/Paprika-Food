@props(['href', 'active' => false])

<a href="{{ $href }}" 
   @click="activeCategory = '{{ $href }}'"
   {{ $attributes->class([
    'px-4 py-3 font-semibold rounded-lg transition-all duration-200',
]) }}
   :class="activeCategory === '{{ $href }}' ? 'bg-zinc-100 dark:bg-zinc-800 border-l-4 border-brand-red text-brand-red font-bold rounded-r-lg translate-x-1' : 'text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-100 hover:bg-zinc-50 dark:hover:bg-zinc-800/50'"
>
    {{ $slot }}
</a>
