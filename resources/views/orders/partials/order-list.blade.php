<div class="space-y-5" data-animate="stagger-children">
    @foreach($orders as $order)
        @include('orders.partials.order-card', ['order' => $order])
        @include('orders.partials.order-details-modal', ['order' => $order])
    @endforeach
</div>

