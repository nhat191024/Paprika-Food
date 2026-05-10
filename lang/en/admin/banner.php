<?php

return [
    'model' => [
        'singular' => 'Banner',
        'plural' => 'Banners',
    ],
    'table' => [
        'image' => 'Image',
        'title' => 'Title',
        'link' => 'Link',
        'sort_order' => 'Sort Order',
        'status' => 'Status',
        'created_at' => 'Created at',
    ],
    'form' => [
        'sections' => [
            'general' => 'General',
            'settings' => 'Settings',
            'image' => 'Image',
        ],
        'fields' => [
            'title' => 'Title',
            'link' => 'Link',
            'sort_order' => 'Sort Order',
            'status' => 'Active',
            'image' => 'Banner Image',
        ],
    ],
];
