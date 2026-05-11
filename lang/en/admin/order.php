<?php

return [
    'model' => [
        'singular' => 'Order',
        'plural' => 'Orders',
    ],

    'new_orders' => [
        'plural' => 'New Orders',
    ],

    'table' => [
        'order_number' => 'Order #',
        'customer' => 'Customer',
        'status' => 'Status',
        'order_type' => 'Type',
        'payment_method' => 'Payment',
        'items_count' => 'Items',
        'final_amount' => 'Total',
        'created_at' => 'Ordered at',
    ],

    'filters' => [
        'status' => 'Status',
        'order_type' => 'Order type',
        'payment_method' => 'Payment method',
        'date_from' => 'From date',
        'date_to' => 'To date',
        'date' => 'Order date',
    ],

    'infolist' => [
        'sections' => [
            'order_info' => 'Order Information',
            'customer_info' => 'Customer',
            'delivery_info' => 'Delivery Information',
            'payment_info' => 'Payment',
            'items' => 'Ordered Items',
            'selections' => 'Add-ons',
        ],
        'fields' => [
            'order_number' => 'Order #',
            'status' => 'Status',
            'order_type' => 'Type',
            'payment_method' => 'Payment method',
            'created_at' => 'Ordered at',
            'customer_name' => 'Customer name',
            'customer_email' => 'Email',
            'recipient_name' => 'Recipient',
            'delivery_phone' => 'Phone',
            'delivery_address' => 'Delivery address',
            'total_amount' => 'Subtotal',
            'discount_amount' => 'Discount',
            'voucher_code' => 'Voucher applied',
            'final_amount' => 'Total',
            'product_name' => 'Product',
            'quantity' => 'Quantity',
            'price' => 'Unit price',
            'subtotal' => 'Subtotal',
            'selection_product' => 'Selection',
            'extra_price' => 'Extra price',
        ],
    ],

    'incoming' => [
        'no_pending' => 'No new orders right now.',
        'no_processing' => 'No orders in processing.',
    ],

    'actions' => [
        'confirm' => 'Confirm Order',
        'ready' => 'Mark as Ready',
        'complete' => 'Complete',
        'cancel' => 'Cancel Order',
        'cancel_confirm' => 'Are you sure you want to cancel this order?',
        'cancel_confirm_button' => 'Cancel Order',
        'view' => 'View',
        'back' => 'Back',
    ],

    'status' => [
        'pending' => 'Pending',
        'processing' => 'Processing',
        'ready' => 'Ready',
        'completed' => 'Completed',
        'cancelled' => 'Cancelled',
    ],

    'order_type' => [
        'online' => 'Online',
        'dine_in' => 'Dine-in',
    ],

    'payment_method' => [
        'cash' => 'Cash',
        'credit_card' => 'Credit Card',
    ],
];
