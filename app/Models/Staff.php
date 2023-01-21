<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $fillable = [
        'name',
        'priority',
        'delete_flg',
    ];
    //有効なスタッフ数の取得
    public static function getStaffCount(){
        return Staff::where('delete_flg',0)->get()->count();
    }
    //有効なスタッフの取得
    public static function getStaffAll(){
        return Staff::where('delete_flg',0)->orderBy('priority','asc')->get();
    }
    //有効無効含むすべてのスタッフの取得
    public static function getStaffDelAll(){
        return Staff::orderBy('id','asc')->get();
    }
    //有効な登録の古いスタッフの取得
    public static function getFirstStaffId(){
        $staff = Staff::where('delete_flg',0)->orderBy('id','asc')->first();
        return $staff->id;
    }
}
