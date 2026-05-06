<?php

namespace App\Enums;

enum PaymentMethods: string
{
    case CASH = 'cash';
    case CREDIT_CARD = 'credit_card';
}
