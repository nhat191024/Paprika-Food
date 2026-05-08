<?php

namespace App\States\Voucher;

class Inactive extends VoucherState
{
    public static string $name = 'inactive';

    public function color(): string
    {
        return 'warning';
    }
}
