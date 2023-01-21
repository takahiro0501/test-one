<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpenTime extends Model
{
    use HasFactory;

    public static function getOpenTime()
    {
        $openTime = OpenTime::all();
        return $openTime[0];
    }
}
