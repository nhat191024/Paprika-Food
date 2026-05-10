<?php

return [
    'model' => [
        'singular' => 'Đơn hàng',
        'plural' => 'Đơn hàng',
    ],

    'table' => [
        'order_number' => 'Mã đơn',
        'customer' => 'Khách hàng',
        'status' => 'Trạng thái',
        'order_type' => 'Loại đơn',
        'payment_method' => 'Thanh toán',
        'items_count' => 'Số món',
        'final_amount' => 'Tổng tiền',
        'created_at' => 'Ngày đặt',
    ],

    'filters' => [
        'status' => 'Trạng thái',
        'order_type' => 'Loại đơn',
        'payment_method' => 'Phương thức thanh toán',
        'date_from' => 'Từ ngày',
        'date_to' => 'Đến ngày',
        'date' => 'Ngày đặt hàng',
    ],

    'infolist' => [
        'sections' => [
            'order_info' => 'Thông tin đơn hàng',
            'customer_info' => 'Khách hàng',
            'delivery_info' => 'Thông tin giao hàng',
            'payment_info' => 'Thanh toán',
            'items' => 'Sản phẩm đã đặt',
            'selections' => 'Lựa chọn thêm',
        ],
        'fields' => [
            'order_number' => 'Mã đơn',
            'status' => 'Trạng thái',
            'order_type' => 'Loại đơn',
            'payment_method' => 'Phương thức thanh toán',
            'created_at' => 'Ngày đặt',
            'customer_name' => 'Tên khách hàng',
            'customer_email' => 'Email',
            'recipient_name' => 'Người nhận',
            'delivery_phone' => 'Số điện thoại',
            'delivery_address' => 'Địa chỉ giao hàng',
            'total_amount' => 'Tổng giá trị',
            'discount_amount' => 'Giảm giá',
            'voucher_code' => 'Voucher đã dùng',
            'final_amount' => 'Thành tiền',
            'product_name' => 'Sản phẩm',
            'quantity' => 'Số lượng',
            'price' => 'Đơn giá',
            'subtotal' => 'Thành tiền',
            'selection_product' => 'Lựa chọn',
            'extra_price' => 'Phụ thu',
        ],
    ],

    'actions' => [
        'confirm' => 'Xác nhận đơn',
        'ready' => 'Sẵn sàng giao',
        'complete' => 'Hoàn thành',
        'cancel' => 'Hủy đơn',
        'cancel_confirm' => 'Bạn có chắc chắn muốn hủy đơn hàng này?',
        'cancel_confirm_button' => 'Hủy đơn',
    ],

    'status' => [
        'pending' => 'Chờ xác nhận',
        'processing' => 'Đang xử lý',
        'ready' => 'Sẵn sàng',
        'completed' => 'Hoàn thành',
        'cancelled' => 'Đã hủy',
    ],

    'order_type' => [
        'online' => 'Đặt online',
        'dine_in' => 'Tại chỗ',
    ],

    'payment_method' => [
        'cash' => 'Tiền mặt',
        'credit_card' => 'Thẻ tín dụng',
    ],
];
