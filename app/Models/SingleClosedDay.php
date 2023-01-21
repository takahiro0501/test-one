<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SingleClosedDay extends Model
{
    protected $fillable = [
        'staff_id',
        'closed_day',
        'status',
    ];

    //Groupbyにて個別休日データ取得（dateYM版）
    public static function getSingleGroupByClosedDay($date,$status)
    {
        return DB::table('single_closed_days')
                            ->select(DB::raw('count(*) as staff_count, closed_day'))
                            ->where('status',$status)
                            ->where('closed_day','like', $date.'%')
                            ->groupBy('closed_day')
                            ->get();
    }
    //StaffIDにて個別休日データ取得(dateYM版)
    public static function getSingleStaff($staff,$date,$status)
    {
        return SingleClosedDay::select(DB::raw("1 as staff_count"),'closed_day')
                                            ->where('staff_id',$staff)
                                            ->where('closed_day','like', $date.'%')
                                            ->where('status',$status)
                                            ->get();
    }

}
