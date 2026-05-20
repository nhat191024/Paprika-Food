@props(['image' => null, 'title', 'description', 'price', 'href' => null, 'productId' => null, 'canQuickAdd' => false, 'spicy' => false, 'veggie' => false])

<div x-data="{ title: @js(strtolower((string) $title)), description: @js(strtolower((string) $description)) }"
     x-show="(search === '' || title.includes(search.toLowerCase()) || description.includes(search.toLowerCase())) && 
             (activeFilter === 'all' || 
             (activeFilter === 'spicy' && {{ $spicy ? 'true' : 'false' }}) || 
             (activeFilter === 'non-spicy' && {{ ! $spicy ? 'true' : 'false' }}) ||
             (activeFilter === 'veggie' && {{ $veggie ? 'true' : 'false' }}))"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 scale-95"
     x-transition:enter-end="opacity-100 scale-100"
     class="bg-white dark:bg-zinc-900 rounded-2xl shadow-sm border border-zinc-100 dark:border-zinc-800 p-5 flex flex-col relative group hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
    
    @if($spicy)
        <div class="absolute top-6 right-6 z-10 w-10 h-10 bg-white/80 dark:bg-zinc-800/80 backdrop-blur-sm rounded-full shadow-sm flex items-center justify-center">
            <flux:icon name="fire" class="text-brand-red size-5" variant="solid" />
        </div>
    @endif

    @if($veggie)
        <div class="absolute top-6 right-6 z-10 w-10 h-10 bg-white/80 dark:bg-zinc-800/80 backdrop-blur-sm rounded-full shadow-sm flex items-center justify-center">
            <flux:icon name="leaf" class="text-green-600 size-5" />
        </div>
    @endif
    
    <div class="w-full aspect-square bg-zinc-50 dark:bg-zinc-800/50 rounded-2xl mb-5 relative flex items-center justify-center overflow-hidden">
        @if($href)
            <a href="{{ $href }}" wire:navigate class="absolute inset-0 flex items-center justify-center" aria-label="{{ $title }}">
                @if($image)
                    <div class="relative size-full flex items-center justify-center">
                        <img src="{{ $image }}" alt="{{ $title }}" class="w-4/5 h-4/5 object-contain rounded-[15px] mix-blend-multiply dark:mix-blend-normal group-hover:scale-110 transition-transform duration-500" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="hidden size-full items-center justify-center">
                            <svg class="size-16 text-zinc-300 dark:text-zinc-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                            </svg>
                        </div>
                    </div>
                @else
                    <svg class="size-16 text-zinc-300 dark:text-zinc-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                    </svg>
                @endif
            </a>
        @elseif($image)
            <div class="relative size-full flex items-center justify-center">
                <img src="{{ $image }}" alt="{{ $title }}" class="w-4/5 h-4/5 object-contain mix-blend-multiply dark:mix-blend-normal group-hover:scale-110 transition-transform duration-500" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                <div class="hidden size-full items-center justify-center">
                    <svg class="size-16 text-zinc-300 dark:text-zinc-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                    </svg>
                </div>
            </div>
        @else
            <div class="w-full h-full animate-pulse flex items-center justify-center">
                <svg class="size-16 text-zinc-300 dark:text-zinc-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                </svg>
            </div>
        @endif
    </div>
    
    <h3 class="font-bold text-xl leading-tight mb-2">
        @if($href)
            <a href="{{ $href }}" wire:navigate class="hover:text-brand-red transition-colors">{{ $title }}</a>
        @else
            {{ $title }}
        @endif
    </h3>
    <p class="text-sm text-zinc-500 dark:text-zinc-400 mb-6 line-clamp-2">
        @if($href)
            <a href="{{ $href }}" wire:navigate class="hover:text-zinc-700 dark:hover:text-zinc-200 transition-colors">{{ $description }}</a>
        @else
            {{ $description }}
        @endif
    </p>
    
        <div class="mt-auto">
            <div class="flex border-2 border-brand-red rounded-full overflow-hidden shadow-lg shadow-red-500/10">
                <!-- go to details button -->
                @if($href)
                    <a href="{{ $href }}" wire:navigate class="w-full min-w-0 px-4 py-2 sm:px-5 sm:py-3 bg-brand-red text-white font-black text-base sm:text-lg leading-tight text-center break-words hover:bg-red-700 transition-colors flex items-center justify-center">
                        {{ $price }}
                    </a>
                @else
                    <button class="w-full min-w-0 px-4 py-2 sm:px-5 sm:py-3 bg-brand-red text-white font-black text-base sm:text-lg leading-tight break-words hover:bg-red-700 transition-colors flex items-center justify-center text-center">
                        {{ $price }}
                    </button>
                @endif
            </div>
        </div>
</div>
