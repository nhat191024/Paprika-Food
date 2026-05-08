<?php

namespace App\States\Product;

class OutOfStock extends ProductState
{
    public static string $name = 'out_of_stock';

    public function color(): string
    {
        return 'danger';
    }
}
