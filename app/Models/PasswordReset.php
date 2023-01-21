<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    protected $fillable = [
        'menu_id',
        'menu_name',
        'staff_id',
        'staff_name',
        'reservation_datetime'
    ];
}
