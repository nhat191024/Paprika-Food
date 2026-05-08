<?php

namespace App\States\Voucher;

class Expired extends VoucherState
{
    public static string $name = 'expired';

    public function color(): string
    {
        return 'gray';
    }
}
