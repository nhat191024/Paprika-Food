<?php

return [
    'model' => [
        'singular' => 'Banner',
        'plural' => 'Banners',
    ],
    'table' => [
        'image' => 'Hình ảnh',
        'title' => 'Tiêu đề',
        'link' => 'Liên kết',
        'sort_order' => 'Thứ tự',
        'status' => 'Trạng thái',
        'created_at' => 'Ngày tạo',
    ],
    'form' => [
        'sections' => [
            'general' => 'Thông tin chung',
            'settings' => 'Cài đặt',
            'image' => 'Hình ảnh',
        ],
        'fields' => [
            'title' => 'Tiêu đề',
            'link' => 'Liên kết',
            'sort_order' => 'Thứ tự sắp xếp',
            'status' => 'Kích hoạt',
            'image' => 'Hình ảnh banner',
        ],
    ],
];
