<?php

namespace App\Enum;

enum BookingStatusEnum:string{
    case Created = 'created';
    case Ongoing = 'ongoing';
    case Completed = 'completed';
    case Cancelled = 'cancelled';
}
