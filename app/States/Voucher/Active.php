<?php

namespace App\States\Voucher;

class Active extends VoucherState
{
    public static string $name = 'active';

    public function color(): string
    {
        return 'success';
    }
}
