<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class ReservationCalender extends Model
{
    protected $fillable = [
        'reservation_datetime',
        'staff_id',
        'reservation_id'
    ];
    
    public static function getReservationGroupBy($no ,$date){
        if($no == 1){
            $date = substr($date,0,7);
        }elseif($no == 2){
            $date = substr($date,0,10);
        }
        return DB::table('reservation_calenders')
                    ->select(DB::raw('count(*) as reservation_count, reservation_datetime'))
                    ->where('reservation_datetime','like', $date.'%')
                    ->groupBy('reservation_datetime')
                    ->get();
    }

    public static function getReservationDatetime($date){
        return ReservationCalender::where('reservation_datetime',$date)->get();
    }

    public static function getReservationDateStaff($date,$staff){
        return ReservationCalender::where([
                    ['reservation_datetime','like', $date.'%'],
                    ['staff_id', '=', $staff],
        ])->get();
    }

    public static function getReservationDatetimeExit($staffId,$datetime){
        $reserve = ReservationCalender::where([
            'staff_id' => $staffId,
            'reservation_datetime' => $datetime
        ])->get();
        return $reserve->isEmpty();
    }

}
