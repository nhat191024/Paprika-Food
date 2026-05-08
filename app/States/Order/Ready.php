<?php

namespace App\States\Order;

class Ready extends OrderState
{
    public static string $name = 'ready';

    public function color(): string
    {
        return 'warning';
    }
}
