<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'user_id',
        'menu_id',
        'staff_id',
        'guest_id',
        'reservation_datetime'
    ];
    //userTBLに対して、1対1のリレーション定義
    public function user(){
        return $this->belongsTo('App\Models\User');
    }
    //menuTBLに対して、1対1のリレーション定義
    public function guest(){
        return $this->belongsTo('App\Models\Guest');
    }
    //menuTBLに対して、1対1のリレーション定義
    public function menu(){
        return $this->belongsTo('App\Models\Menu');
    }
    //staffTBLに対して、1対1のリレーション定義
    public function staff(){
        return $this->belongsTo('App\Models\Staff');
    }

}
