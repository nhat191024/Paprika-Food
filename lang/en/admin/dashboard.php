<?php

return [
    'filters' => [
        'start_date' => 'From date',
        'end_date' => 'To date',
    ],

    'stats' => [
        'revenue' => 'Revenue',
        'total_orders' => 'Total orders',
        'pending_orders' => 'Pending orders',
        'pending_orders_description' => 'Pending + Processing',
        'new_customers' => 'New customers',
        'vs_previous' => ':change% vs previous period',
    ],

    'revenue_chart' => [
        'heading' => 'Revenue per day',
        'revenue_label' => 'Revenue (€)',
        'orders_label' => 'Orders',
    ],

    'orders_by_status_chart' => [
        'heading' => 'Orders by status',
        'pending' => 'Pending',
        'processing' => 'Processing',
        'ready' => 'Ready',
        'completed' => 'Completed',
        'cancelled' => 'Cancelled',
    ],

    'top_products' => [
        'heading' => 'Top selling products',
        'name' => 'Product',
        'category' => 'Category',
        'total_sold' => 'Qty sold',
        'total_revenue' => 'Revenue',
    ],
];
