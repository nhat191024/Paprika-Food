<div class="space-y-5">
    @foreach($orders as $order)
        @include('orders.partials.order-card', ['order' => $order])
        @include('orders.partials.order-details-modal', ['order' => $order])
    @endforeach
</div>

