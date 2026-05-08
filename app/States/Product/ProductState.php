<?php

namespace App\States\Product;

use Spatie\ModelStates\State;
use Spatie\ModelStates\StateConfig;
use Spatie\ModelStates\Attributes\AllowTransition;
use Spatie\ModelStates\Attributes\DefaultState;
use Spatie\ModelStates\Attributes\RegisterState;

/**
 * @extends State<\App\Models\Product>
 */
#[
    DefaultState(Active::class),
    AllowTransition(Active::class, Inactive::class),
    AllowTransition(Active::class, OutOfStock::class),
    AllowTransition(Inactive::class, Active::class),
    AllowTransition(OutOfStock::class, Active::class),
    RegisterState(Active::class),
    RegisterState(Inactive::class),
    RegisterState(OutOfStock::class)
]
abstract class ProductState extends State
{
    abstract public function color(): string;
}
