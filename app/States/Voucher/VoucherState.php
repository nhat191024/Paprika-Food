<?php

namespace App\States\Voucher;

use Spatie\ModelStates\State;
use Spatie\ModelStates\StateConfig;
use Spatie\ModelStates\Attributes\AllowTransition;
use Spatie\ModelStates\Attributes\DefaultState;
use Spatie\ModelStates\Attributes\RegisterState;

/**
 * @extends State<\App\Models\Voucher>
 */
#[
    DefaultState(Active::class),
    AllowTransition(Active::class, Inactive::class),
    AllowTransition(Active::class, Expired::class),
    AllowTransition(Inactive::class, Active::class),
    RegisterState(Active::class),
    RegisterState(Inactive::class),
    RegisterState(Expired::class)
]
abstract class VoucherState extends State
{
    abstract public function color(): string;
}
