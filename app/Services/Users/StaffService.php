<?php

namespace App\Services\Users;

use App\Models\Staff;
use App\Models\ReservationCalender;

class StaffService
{
    public static function addJugdeElement($staffDatas)
    {
        $staffs = array();
        $count = 0;
        foreach($staffDatas as $staff){
            $staffs[$count] = ['judge' => 'ok', 'id' => $staff->id,'name' => $staff->name];
            $count++;
        }
        return $staffs;
    }

    public static function getAvailableStaffId($datetime)
    {
        $staffs = Staff::getStaffAll();
        foreach($staffs as $staff){
            if(ReservationCalender::getReservationDatetimeExit($staff->id,$datetime)){
                return $staff->id;
            }
        }
        return false;
    }

    //その日の営業スタッフ人数を取得
    public static function getBusinessStaffNum( 
                                                    $multiData,            //一括休日データ
                                                    $singleRestData,       //個別休日データ
                                                    $singleBusinessData,   //個別営業日データ
                                                    $staffNum,             //全スタッフ数データ
                                                    $date,                 //対象日（2022-00-00）
                                                    $dayOfWeek             //対象曜日
                                                )
    {
        //対象日（$loopFrom）の営業スタッフ数を取得する
        $multiRestNum = 0;
        $multikeyIndex = array_search($dayOfWeek, array_column($multiData->all(), 'week_no'));
        if($multikeyIndex !== false){
            $multiRestNum = $multiData[$multikeyIndex]->staff_count;
        }
        //個別休日データ取得
        $singleRestNum = 0;
        $singleRestkeyIndex = array_search($date,array_column($singleRestData->all(), 'closed_day'));
        if($singleRestkeyIndex !== false){
            $singleRestNum = $singleRestData[$singleRestkeyIndex]->staff_count;
        }
        //個別営業日データ取得
        $singleBusinessNum = 0;
        $singleBusinesskeyIndex = array_search($date,array_column($singleBusinessData->all(), 'closed_day'));
        if($singleBusinesskeyIndex !== false){
            $singleBusinessNum = $singleBusinessData[$singleBusinesskeyIndex]->staff_count;
        }
        //対象日の営業スタッフ数
        return $staffNum - $multiRestNum - $singleRestNum + $singleBusinessNum ;
    }
}
