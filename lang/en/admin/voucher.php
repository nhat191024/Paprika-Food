<?php

return [
    'navigation' => [
        'label' => 'Vouchers',
    ],

    'model' => [
        'singular' => 'Voucher',
        'plural' => 'Vouchers',
    ],

    'states' => [
        'active' => 'Active',
        'inactive' => 'Inactive',
        'expired' => 'Expired',
    ],

    'discount_types' => [
        'fixed' => 'Fixed Amount',
        'percent' => 'Percentage',
    ],

    'form' => [
        'sections' => [
            'general' => 'General Information',
            'discount' => 'Discount Configuration',
            'validity' => 'Validity & Usage Limit',
        ],
        'fields' => [
            'code' => 'Voucher Code',
            'status' => 'Status',
            'discount_type' => 'Discount Type',
            'discount_value' => 'Discount Value',
            'min_order_amount' => 'Minimum Order Amount',
            'max_discount' => 'Maximum Discount Cap',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'is_unlimited' => 'Unlimited Usage',
            'usage_limit' => 'Usage Limit',
        ],
    ],

    'table' => [
        'code' => 'Code',
        'discount_type' => 'Type',
        'discount_value' => 'Value',
        'min_order_amount' => 'Min. Order',
        'start_date' => 'Start Date',
        'end_date' => 'End Date',
        'is_unlimited' => 'Unlimited',
        'usage' => 'Used / Limit',
        'status' => 'Status',
    ],

    'filters' => [
        'status' => 'Status',
        'discount_type' => 'Discount Type',
    ],
];
