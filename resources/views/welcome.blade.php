<x-layouts::main title="Home">
    {{-- Break out of flux:main container to achieve full width edge-to-edge layout --}}
    <div class="-mx-6 lg:-mx-8 -mt-6 lg:-mt-8 -mb-6 lg:-mb-8">
        
        @include('partials.home.hero')
        @include('partials.home.features')
        @include('partials.home.categories')
        @include('partials.home.store')
        @include('partials.home.social')
        @include('partials.footer')

    </div>
</x-layouts::main>
