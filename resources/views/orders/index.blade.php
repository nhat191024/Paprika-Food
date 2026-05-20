<x-layouts::main title="{{ __('client/orders.title') }}">
    <div class="-mx-6 -mt-6 flex-1 bg-zinc-50 px-6 py-12 dark:bg-zinc-950 lg:-mx-8 lg:-mt-8 lg:px-8">
        <div class="mx-auto max-w-6xl">
            @include('orders.partials.header')

            @include('orders.partials.flash')

            @if($orders->isEmpty())
                @include('orders.partials.empty-state')
            @else
                @include('orders.partials.order-list', ['orders' => $orders])
            @endif
        </div>
    </div>
</x-layouts::main>
