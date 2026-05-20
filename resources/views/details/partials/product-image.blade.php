<div class="bg-white dark:bg-zinc-900 rounded-3xl p-12 flex items-center justify-center relative overflow-hidden shadow-sm border border-zinc-100 dark:border-zinc-800">
    <div class="absolute inset-0 bg-gradient-to-tr from-zinc-100/50 dark:from-zinc-800/50 to-transparent pointer-events-none rounded-3xl"></div>
    @if($product->getThumbnailUrl())
        <div class="relative size-full flex items-center justify-center z-10">
            <img alt="{{ $product->name }}" class="w-full max-w-md h-auto object-contain transform hover:scale-105 transition-transform duration-500" src="{{ $product->getThumbnailUrl() }}" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
            <div class="hidden size-full items-center justify-center py-12">
                <svg class="size-32 text-zinc-300 dark:text-zinc-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                </svg>
            </div>
        </div>
    @else
        <div class="flex size-full items-center justify-center z-10 py-12">
            <svg class="size-32 text-zinc-300 dark:text-zinc-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
            </svg>
        </div>
    @endif
</div>
