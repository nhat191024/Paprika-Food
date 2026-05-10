<?php

return [
    'category' => [
        'model' => [
            'singular' => 'Danh mục',
            'plural' => 'Danh mục',
        ],
        'table' => [
            'name' => 'Tên',
            'slug' => 'Slug',
            'parent' => 'Danh mục cha',
            'order' => 'Thứ tự',
            'children_count' => 'Danh mục con',
            'products_count' => 'Số sản phẩm',
            'created_at' => 'Ngày tạo',
        ],
        'form' => [
            'sections' => [
                'general' => 'Thông tin chung',
                'settings' => 'Cài đặt',
            ],
            'fields' => [
                'name_en' => 'Tên (Tiếng Anh)',
                'name_el' => 'Tên (Tiếng Hy Lạp)',
                'slug' => 'Slug',
                'parent_id' => 'Danh mục cha',
                'order' => 'Thứ tự sắp xếp',
            ],
        ],
        'filters' => [
            'trashed' => 'Đã xóa',
        ],
        'relation' => [
            'children' => [
                'title' => 'Danh mục con',
            ],
        ],
    ],

    'product' => [
        'model' => [
            'singular' => 'Sản phẩm',
            'plural' => 'Sản phẩm',
        ],
        'table' => [
            'thumbnail' => 'Ảnh',
            'name' => 'Tên',
            'category' => 'Danh mục',
            'price' => 'Giá',
            'is_combo' => 'Combo',
            'status' => 'Trạng thái',
            'created_at' => 'Ngày tạo',
        ],
        'form' => [
            'sections' => [
                'general' => 'Thông tin chung',
                'pricing' => 'Giá & Trạng thái',
                'thumbnail' => 'Hình ảnh',
                'variants' => 'Biến thể sản phẩm',
                'add_variants' => 'Thêm biến thể',
                'combo_groups' => 'Nhóm Combo',
                'add_combo_groups' => 'Thêm nhóm combo',
            ],
            'fields' => [
                'name_en' => 'Tên (Tiếng Anh)',
                'name_el' => 'Tên (Tiếng Hy Lạp)',
                'description_en' => 'Mô tả (Tiếng Anh)',
                'description_el' => 'Mô tả (Tiếng Hy Lạp)',
                'slug' => 'Slug',
                'category_id' => 'Danh mục',
                'price' => 'Giá (EUR)',
                'is_combo' => 'Là sản phẩm combo',
                'status' => 'Trạng thái',
                'thumbnail' => 'Hình ảnh đại diện',
                'variant_name_en' => 'Tên biến thể (Tiếng Anh)',
                'variant_name_el' => 'Tên biến thể (Tiếng Hy Lạp)',
                'price_adjustment' => 'Chênh lệch giá (EUR)',
                'variant_sort_order' => 'Thứ tự hiển thị',
                'variant_is_active' => 'Đang hoạt động',
                'combo_group_name_en' => 'Tên nhóm (Tiếng Anh)',
                'combo_group_name_el' => 'Tên nhóm (Tiếng Hy Lạp)',
                'min_select' => 'Chọn tối thiểu',
                'max_select' => 'Chọn tối đa',
                'is_required' => 'Bắt buộc',
                'items' => 'Mục chọn',
                'add_item' => 'Thêm lựa chọn',
                'item_type' => 'Loại mục',
                'item_type_product' => 'Sản phẩm',
                'item_type_variant' => 'Biến thể',
                'item_product_id' => 'Sản phẩm',
                'item_variant_id' => 'Biến thể',
                'extra_price' => 'Giá thêm (EUR)',
            ],
        ],
        'filters' => [
            'category' => 'Danh mục',
            'is_combo' => 'Combo',
            'status' => 'Trạng thái',
        ],
        'bulk_actions' => [
            'change_status' => 'Đổi trạng thái',
            'change_status_modal_heading' => 'Đổi trạng thái cho các sản phẩm đã chọn',
            'status' => 'Trạng thái mới',
        ],
        'status' => [
            'active' => 'Đang bán',
            'inactive' => 'Ngừng bán',
            'out_of_stock' => 'Hết hàng',
        ],
        'notifications' => [
            'change_status_success' => 'Đã đổi trạng thái thành công',
            'change_status_failure' => 'Đổi trạng thái thất bại',
        ],
    ],
];
