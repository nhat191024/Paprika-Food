<?php

return [
    'model' => [
        'singular' => 'Khách hàng',
        'plural' => 'Khách hàng',
    ],

    'table' => [
        'avatar' => 'Ảnh đại diện',
        'name' => 'Họ và tên',
        'email' => 'Email',
        'roles' => 'Vai trò',
        'email_verified_at' => 'Đã xác minh',
        'created_at' => 'Ngày tạo',
        'updated_at' => 'Cập nhật',
    ],
    'filters' => [
        'roles' => 'Vai trò',
        'email_verified' => 'Email đã xác minh',
    ],
    'form' => [
        'sections' => [
            'account_information' => 'Thông tin tài khoản',
            'avatar' => 'Ảnh đại diện',
        ],
        'fields' => [
            'name' => 'Họ và tên',
            'email' => 'Email',
            'password' => 'Mật khẩu',
            'roles' => 'Vai trò',
            'avatar' => 'Ảnh đại diện',
        ],
    ],
];
