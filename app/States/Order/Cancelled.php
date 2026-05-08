<?php

namespace App\States\Order;

class Cancelled extends OrderState
{
    public static string $name = 'cancelled';

    public function color(): string
    {
        return 'danger';
    }
}
