<?php

return [
    'category' => [
        'model' => [
            'singular' => 'Category',
            'plural' => 'Categories',
        ],
        'table' => [
            'name' => 'Name',
            'slug' => 'Slug',
            'parent' => 'Parent',
            'order' => 'Order',
            'children_count' => 'Subcategories',
            'products_count' => 'Products',
            'created_at' => 'Created at',
        ],
        'form' => [
            'sections' => [
                'general' => 'General',
                'settings' => 'Settings',
            ],
            'fields' => [
                'name_en' => 'Name (English)',
                'name_el' => 'Name (Greek)',
                'slug' => 'Slug',
                'parent_id' => 'Parent category',
                'order' => 'Sort order',
            ],
        ],
        'filters' => [
            'trashed' => 'Deleted records',
        ],
        'relation' => [
            'children' => [
                'title' => 'Subcategories',
            ],
        ],
    ],

    'product' => [
        'model' => [
            'singular' => 'Product',
            'plural' => 'Products',
        ],
        'table' => [
            'thumbnail' => 'Thumbnail',
            'name' => 'Name',
            'category' => 'Category',
            'price' => 'Price',
            'is_combo' => 'Combo',
            'status' => 'Status',
            'created_at' => 'Created at',
        ],
        'form' => [
            'sections' => [
                'general' => 'General',
                'pricing' => 'Pricing & Status',
                'thumbnail' => 'Thumbnail',
                'variants' => 'Variants',
                'combo_groups' => 'Combo Groups',
            ],
            'fields' => [
                'name_en' => 'Name (English)',
                'name_el' => 'Name (Greek)',
                'description_en' => 'Description (English)',
                'description_el' => 'Description (Greek)',
                'slug' => 'Slug',
                'category_id' => 'Category',
                'price' => 'Price (EUR)',
                'is_combo' => 'Is combo product',
                'status' => 'Status',
                'thumbnail' => 'Thumbnail',
                'variant_name_en' => 'Variant name (English)',
                'variant_name_el' => 'Variant name (Greek)',
                'price_adjustment' => 'Price adjustment (EUR)',
                'variant_sort_order' => 'Sort order',
                'variant_is_active' => 'Active',
                'combo_group_name_en' => 'Group name (English)',
                'combo_group_name_el' => 'Group name (Greek)',
                'min_select' => 'Min selections',
                'max_select' => 'Max selections',
                'is_required' => 'Required',
                'items' => 'Items',
                'item_type' => 'Item type',
                'item_type_product' => 'Product',
                'item_type_variant' => 'Variant',
                'item_product_id' => 'Product',
                'item_variant_id' => 'Variant',
                'extra_price' => 'Extra price (EUR)',
            ],
        ],
        'filters' => [
            'category' => 'Category',
            'is_combo' => 'Combo',
            'status' => 'Status',
        ],
        'bulk_actions' => [
            'change_status' => 'Change status',
            'change_status_modal_heading' => 'Change status for selected products',
            'status' => 'New status',
        ],
        'status' => [
            'active' => 'Active',
            'inactive' => 'Inactive',
            'out_of_stock' => 'Out of stock',
        ],
        'notifications' => [
            'change_status_success' => 'Status changed successfully',
            'change_status_failure' => 'Failed to change status',
        ],
    ],
];
