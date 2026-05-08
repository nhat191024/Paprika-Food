<?php

namespace App\States\Order;

class Processing extends OrderState
{
    public static string $name = 'processing';

    public function color(): string
    {
        return 'info';
    }
}
