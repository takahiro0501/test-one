<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservationTime extends Model
{
    public static function getReservationTimesWeek(int $weekNo)
    {
        return ReservationTime::where('week_no', $weekNo)->first();
    }
}
