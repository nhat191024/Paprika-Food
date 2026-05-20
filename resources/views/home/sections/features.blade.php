<!-- Burger Carousel / Feature Section -->
<section class="w-full bg-[#eeeeee] px-8 py-20 text-center dark:bg-zinc-900">
    <div class="mx-auto max-w-7xl">
        <h2 class="mb-12 text-4xl font-extrabold uppercase text-[#1A1A1A] dark:text-zinc-100 md:text-5xl">{{ __('client/home.features_title') }}</h2>
        <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
            @foreach($featuredProducts as $index => $product)
                <a href="{{ route('product.details', ['product_slug' => $product->slug]) }}" wire:navigate class="flex flex-col items-center bg-white p-6 dark:bg-zinc-800 rounded-2xl shadow-sm border border-zinc-200 dark:border-zinc-700/50 reveal-on-scroll opacity-0 translate-y-8 cursor-pointer hover:shadow-md transition-shadow" style="animation-delay: {{ $index * 200 }}ms">
                    @if($product->getThumbnailUrl())
                        <img alt="{{ $product->name }}" class="mb-4 w-full aspect-square object-cover rounded-xl" src="{{ $product->getThumbnailUrl() }}">
                    @else
                        <div class="mb-4 w-full aspect-square flex items-center justify-center bg-zinc-100 dark:bg-zinc-700 rounded-xl">
                            <flux:icon.photo class="size-12 text-zinc-400" />
                        </div>
                    @endif
                    <h3 class="text-xl font-bold uppercase text-[#1A1A1A] dark:text-zinc-100">{{ $product->name }}</h3>
                </a>
            @endforeach
        </div>
    </div>
</section>
