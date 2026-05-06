<?php

namespace App\Enums;

enum OrderType: string
{
    case ONLINE = 'online';
    case DINE_IN = 'dine_in';
}
