<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Staff;
use App\Models\ReservationCalender;
use App\Services\Users\StaffService;
use App\Models\MultipleClosedDay;
use App\Models\SingleClosedDay;
use Carbon\Carbon;

class StaffController extends Controller
{
    public function thirdStaff(Request $request){
        //パラメータチェック
        if(!$request->has('time','date')){
            return view('users.error',['errorMsg' =>  __('sentences.user_error.param') ]);
        }
        $date = $request->date;
        $time = $request->time; 
        $reservationDatetime = $request->date . ' ' . $request->time;
        //予約データ取得
        $reservationDatas = ReservationCalender::getReservationDatetime($reservationDatetime);
        //スタッフデータ取得
        $staffDatas = Staff::getStaffAll();
        //レスポンスデータ定義
        $staffs = array();
        //スタッフ毎に予約時間を確認
        $count = 0;
        foreach($staffDatas as $staffData){
            //スタッフ別休日機能の仕様変更により休日判定追加
            ////対象担当者の休日データ取得
            $staffNum = 1;
            $multiData = MultipleClosedDay::getMultiStaff($staffData->id,1);
            $singleRestData = SingleClosedDay::getSingleStaff($staffData->id,$date,1);
            $singleBusinessData = SingleClosedDay::getSingleStaff($staffData->id,$date,0);
            $staffNum = StaffService::getBusinessStaffNum(
                                        $multiData,
                                        $singleRestData,
                                        $singleBusinessData,
                                        $staffNum,
                                        $date,
                                        Carbon::create($date)->dayOfWeek
                            );
            //予約空き情報検索
            $keyIndex = array_search($staffData->id, array_column($reservationDatas->all(), 'staff_id'));
            //スタッフ休日判定
            if($staffNum == 0){
                $staffs[$count] = array('judge' => 'ng');
            //スタッフに紐づいた予約時間がみつからない場合、空きありとする
            }elseif($keyIndex === false){
                $staffs[$count] = array('judge' => 'ok');
            //スタッフに紐づいた予約時間がみつかった場合、空きなしとする
            }else{
                $staffs[$count] = array('judge' => 'ng');
            }
            $staffs[$count] += array('id' => $staffData->id);
            $staffs[$count] += array('name' => $staffData->name);
            $count++;
        }
        return view('users.staff',['date' => $date ,'time' => $time,'staffs' => $staffs]);
    }
    
    public function staffFirst(){
        $staffDatas = Staff::getStaffAll();
        $staffs[] = array();
        $count = 0;
        foreach($staffDatas as $staffData){
            $staffs[$count] = array('judge' => 'ok');
            $staffs[$count] += array('id' => $staffData->id);
            $staffs[$count] += array('name' => $staffData->name);
            $count++;
        }
        return view('users.staff',['staffs' => $staffs]);
    }
    
    public function staffSecond(Request $request){
        //パラメータチェック
        if(!$request->has('menu','menuName')){
            return view('users.error',['errorMsg' =>  __('sentences.user_error.param') ]);
        }
        //全スタッフデータ取得
        $staffDatas = Staff::getStaffAll();
        //blade表示時の判定の為、'judge'要素を追加する
        $staffs = StaffService::addJugdeElement($staffDatas);
        //スタッフ全データ送信
        return view('users.staff',['menu' => $request->menu ,'menuName' => $request->menuName ,'staffs' => $staffs]);
    }
}
