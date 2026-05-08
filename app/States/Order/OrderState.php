<?php

namespace App\States\Order;

use Spatie\ModelStates\State;
use Spatie\ModelStates\Attributes\AllowTransition;
use Spatie\ModelStates\Attributes\DefaultState;
use Spatie\ModelStates\Attributes\RegisterState;

/**
 * @extends State<\App\Models\Order>
 */
#[
    DefaultState(Pending::class),
    AllowTransition(Pending::class, Processing::class),
    AllowTransition(Processing::class, Ready::class),
    AllowTransition(Ready::class, Completed::class),
    AllowTransition([Pending::class, Processing::class, Ready::class], Cancelled::class),
    RegisterState(Pending::class),
    RegisterState(Processing::class),
    RegisterState(Ready::class),
    RegisterState(Completed::class),
    RegisterState(Cancelled::class)
]
abstract class OrderState extends State
{
    abstract public function color(): string;
}
