<x-layouts::main title="Menu">
    <div x-data="{ 
        search: '', 
        activeCategory: window.location.hash || '#offers',
        activeFilter: 'all'
    }" 
    @hashchange.window="activeCategory = window.location.hash"
    class="flex-1 flex flex-col">
        
        @include('menu.partials.filter-bar')

        <!-- Main Content Wrapper (2-column layout) -->
        <div class="flex flex-col md:flex-row gap-8 py-8 flex-1">
            @include('menu.partials.sidebar')

            <!-- Right Content Area -->
            <main class="flex-1 flex flex-col gap-16">
                @include('menu.partials.sections.offers')
                @include('menu.partials.sections.burgers')
            </main>
        </div>
    </div>

    <div class="-mx-6 lg:-mx-8 -mb-6 lg:-mb-8 mt-12">
        @include('partials.footer')
    </div>
</x-layouts::main>
