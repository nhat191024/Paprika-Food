<?php

namespace App\Enums;

enum VoucherStatus: string
{
    case ACTIVE = 'active';
    case EXPIRED = 'expired';
    case INACTIVE = 'inactive';
}
