<x-layouts::main title="Home">
    <div class="-mx-6 lg:-mx-8 -mt-6 lg:-mt-8 -mb-6 lg:-mb-8 flex flex-col flex-1">
        <div class="flex-1">
            @include('home.sections.hero')
            @include('home.sections.features')
            @include('home.sections.categories')
            @include('home.sections.store')
            @include('home.sections.social')
        </div>

        @include('partials.footer')
    </div>
</x-layouts::main>
