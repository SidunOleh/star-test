<?php

namespace App\Enums;

enum OrderStatus: string
{
    case Pending = 'pending';

    case Done = 'done';
    
    case Cancelled = 'cancelled';
}