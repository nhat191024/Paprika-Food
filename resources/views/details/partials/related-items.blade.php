@if($relatedProducts->isNotEmpty())
    <section class="mt-20">
        <flux:heading size="xl" class="mb-8 font-bold text-3xl" data-animate="fade-up">{{ __('client/details.you_might_also_like') }}</flux:heading>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6" data-animate="stagger-children">
            @foreach($relatedProducts as $relatedProduct)
                <a href="{{ route('product.details', $relatedProduct->slug) }}" wire:navigate class="bg-white dark:bg-zinc-900 rounded-2xl p-4 border border-zinc-200 dark:border-zinc-800 hover:border-amber-500 transition-colors group shadow-sm">
                    <div class="aspect-square bg-zinc-50 dark:bg-zinc-800/50 rounded-xl mb-4 flex items-center justify-center overflow-hidden">
                        @if($relatedProduct->getThumbnailUrl())
                            <img alt="{{ $relatedProduct->name }}" class="w-full h-full object-contain group-hover:scale-110 transition-transform duration-300" src="{{ $relatedProduct->getThumbnailUrl() }}">
                        @else
                            <flux:icon name="utensils" class="text-zinc-300 dark:text-zinc-700 size-12" />
                        @endif
                    </div>
                    <h4 class="font-semibold text-zinc-900 dark:text-white mb-1 truncate">{{ $relatedProduct->name }}</h4>
                    <p class="text-amber-600 font-bold">{{ number_format((float) $relatedProduct->price, 2) }} &euro;</p>
                </a>
            @endforeach
        </div>
    </section>
@endif
