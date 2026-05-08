<?php

namespace App\States\Order;

class Completed extends OrderState
{
    public static string $name = 'completed';

    public function color(): string
    {
        return 'success';
    }
}
