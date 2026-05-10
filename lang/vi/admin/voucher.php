<?php

return [
    'navigation' => [
        'label' => 'Mã giảm giá',
    ],

    'model' => [
        'singular' => 'Mã giảm giá',
        'plural' => 'Mã giảm giá',
    ],

    'states' => [
        'active' => 'Đang hoạt động',
        'inactive' => 'Tạm ngưng',
        'expired' => 'Hết hạn',
    ],

    'discount_types' => [
        'fixed' => 'Giảm cố định',
        'percent' => 'Giảm theo %',
    ],

    'form' => [
        'sections' => [
            'general' => 'Thông tin chung',
            'discount' => 'Cấu hình giảm giá',
            'validity' => 'Thời hạn & Giới hạn sử dụng',
        ],
        'fields' => [
            'code' => 'Mã voucher',
            'status' => 'Trạng thái',
            'discount_type' => 'Loại giảm giá',
            'discount_value' => 'Giá trị giảm',
            'min_order_amount' => 'Đơn hàng tối thiểu',
            'max_discount' => 'Giảm tối đa',
            'start_date' => 'Ngày bắt đầu',
            'end_date' => 'Ngày kết thúc',
            'is_unlimited' => 'Không giới hạn lượt dùng',
            'usage_limit' => 'Giới hạn lượt dùng',
        ],
    ],

    'table' => [
        'code' => 'Mã',
        'discount_type' => 'Loại',
        'discount_value' => 'Giá trị',
        'min_order_amount' => 'Đơn tối thiểu',
        'start_date' => 'Ngày bắt đầu',
        'end_date' => 'Ngày kết thúc',
        'is_unlimited' => 'Không giới hạn',
        'usage' => 'Đã dùng / Giới hạn',
        'status' => 'Trạng thái',
    ],

    'filters' => [
        'status' => 'Trạng thái',
        'discount_type' => 'Loại giảm giá',
    ],
];
