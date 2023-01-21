<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MultipleClosedDay extends Model
{
    protected $fillable = [
        'staff_id',
        'week_no',
        'status'
    ];
    
    public static function getMultiRestStaff($staff)
    {
        return MultipleClosedDay::where('staff_id',$staff)->get();
    }

    //Groupbyにて一括休日データを取得
    public static function getMultiGroupbyWeekNo($status){
        return DB::table('multiple_closed_days')
                            ->select(DB::raw('count(*) as staff_count, week_no'))
                            ->where('status',$status)
                            ->groupBy('week_no')
                            ->get();
    }
    //StaffNoにて一括休日データを取得
    public static function getMultiStaff($staff,$status){
        return MultipleClosedDay::select(DB::raw("1 as staff_count"),'week_no')
                                                    ->where('staff_id',$staff)
                                                    ->where('status',$status)
                                                    ->get();
    }
}
