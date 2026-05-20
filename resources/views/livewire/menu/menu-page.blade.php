<div>
    <div x-data="{ 
        search: '', 
        activeCategory: window.location.hash || '#cat-{{ $categories->first()?->slug }}',
        activeFilter: 'all'
    }" 
    @hashchange.window="activeCategory = window.location.hash"
    class="flex-1 flex flex-col">
        
        @include('menu.partials.filter-bar')

        <div class="flex flex-col md:flex-row gap-8 py-8 flex-1">
            
            <aside class="w-full md:w-64 flex-shrink-0" data-animate="fade-right">
                <div class="sticky top-[9.5rem] flex flex-col gap-1">
                    <nav class="flex flex-col gap-1">
                        @foreach($categories as $category)
                            <x-menu.category-link href="#cat-{{ $category->slug }}">{{ $category->name }}</x-menu.category-link>
                        @endforeach
                    </nav>
                </div>
            </aside>

            <!-- Right Content Area -->
            <main class="flex-1 flex flex-col gap-16">
                @foreach($categories as $category)
                    <section id="cat-{{ $category->slug }}" class="scroll-mt-24">
                        <flux:heading level="2" size="xl" class="mb-8 font-black" data-animate="fade-up">{{ $category->name }}</flux:heading>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8" data-animate="stagger-children">
                            @foreach($category->products as $product)
                                <x-menu.product-card 
                                    :title="$product->name"
                                    :image="$product->getThumbnailUrl()"
                                    :description="$product->description"
                                    :price="number_format((float) $product->price, 2) . ' €'"
                                    :href="route('product.details', $product->slug)"
                                    :product-id="$product->id"
                                    :can-quick-add="$product->variants_count === 0 && $product->combo_groups_count === 0"
                                    :deal="$product->is_combo"
                                />
                            @endforeach
                        </div>
                    </section>
                @endforeach
            </main>
        </div>
    </div>

    <div class="-mx-6 lg:-mx-8 -mb-6 lg:-mb-8 mt-12">
        @include('partials.footer')
    </div>
</div>
