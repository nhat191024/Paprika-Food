<?php

namespace App\States\Product;

class Active extends ProductState
{
    public static string $name = 'active';

    public function color(): string
    {
        return 'success';
    }
}
