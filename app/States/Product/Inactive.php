<?php

namespace App\States\Product;

class Inactive extends ProductState
{
    public static string $name = 'inactive';

    public function color(): string
    {
        return 'gray';
    }
}
