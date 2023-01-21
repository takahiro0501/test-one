<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\ReservationTime;
use App\Models\Staff;
use App\Models\Menu;
use App\Models\ReservationCalender;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use App\Models\MultipleClosedDay;
use App\Models\SingleClosedDay;
use App\Services\Users\StaffService;
use Illuminate\Support\Facades\Log;

class TimeController extends Controller
{
    public function secondTime(Request $request){
        //パラメータチェック
        if(!$request->has('date')){
            return view('users.error',['errorMsg' =>  __('sentences.user_error.param') ]);
        }
        //現在時刻の取得
        $now =  Carbon::now()->addHour();
        //予約データ取得(日条件検索)
        $reservationCalender = ReservationCalender::getReservationGroupBy(2,$request->date);
        //対象日の予約可能日の取得
        $dayOfWeek = Carbon::create($request->date)->dayOfWeek;
        $availableTime = ReservationTime::getReservationTimesWeek($dayOfWeek);
        $availableTimes[] = unserialize($availableTime->reservable_time);
        //対象日の営業スタッフ数取得
        $allStaff = Staff::getStaffCount();
        $multiData = MultipleClosedDay::getMultiGroupbyWeekNo(1);
        $singleRestData = SingleClosedDay::getSingleGroupByClosedDay($request->date,1);
        $singleBusinessData = SingleClosedDay::getSingleGroupByClosedDay($request->date,0);
        $staff = StaffService::getBusinessStaffNum(
                                    $multiData,
                                    $singleRestData,
                                    $singleBusinessData,
                                    $allStaff,
                                    $request->date,
                                    $dayOfWeek
                        );
        //レスポンスデータ定義
        $times = array();
        //営業時間と予約時間の突合
        foreach($availableTimes[0] as $time){
            $targetTime = new Carbon($request->date . ' ' .$time);
            $keyIndex = array_search($request->date.' '. $targetTime->format('H:i').':00' , array_column($reservationCalender->all(), 'reservation_datetime'));
            if($keyIndex !== false &&  $reservationCalender[$keyIndex]->reservation_count == $staff){
                $times += array(substr($targetTime->format('H:i'),0,6) => 'ng');
            }else{
                if($targetTime->lt($now)){
                    $times += array(substr($targetTime->format('H:i'),0,6) => 'ng');                                        
                }else{
                    $times += array(substr($targetTime->format('H:i'),0,6) => 'ok');
                }
            }
            $targetTime->addMinutes(30);
        }
        return view('users.time',['times' => $times,'date' => $request->date]);
    }

    public function fourthTime(Request $request){
        //パラメータチェック
        if(!$request->has('menu','menuName','staff','staffName','date')){
            return view('users.error',['errorMsg' =>  __('sentences.user_error.param') ]);
        }
        //現在時刻の取得
        $now =  Carbon::now()->addHour();
        //担当者選択なしの場合、登録が古い担当者を割り当てる
        if($request->staff == 0){
            $request->staff = Staff::getFirstStaffId();
        }
        //対象担当者の予約情報の取得
        $reservationCalender = ReservationCalender::getReservationDateStaff($request->date,$request->staff);
        //対象日の予約可能日の取得
        $dayOfWeek = Carbon::create($request->date)->dayOfWeek;
        $availableTime = ReservationTime::getReservationTimesWeek($dayOfWeek);
        $availableTimes[] = unserialize($availableTime->reservable_time);
        //対象メニューの時間（timeSeparator）取得
        $timeSeparator = Menu::getMenuTimeSeparator($request->menu);
        //レスポンスデータ定義
        $times = array();
        //予約可能時間でのループ
        foreach($availableTimes[0] as $time){
            $targetTime = new Carbon($request->date . ' ' .$time);
            //メニュー時間のループ
            for($i=1; $i<=$timeSeparator ; $i++){
                $keyIndex = array_search($request->date . ' ' . $time, array_column($reservationCalender->all(), 'reservation_datetime'));
                //予約データが見つかった場合は、ngでループを抜ける
                if($keyIndex !== false){
                    $times += array(substr($time,0,5) => 'ng');
                    break;
                }
                if($i==$timeSeparator){
                    if($targetTime->lt($now)){
                        $times += array(substr($targetTime->format('H:i'),0,6) => 'ng');                                      
                    }else{
                        $times += array(substr($targetTime->format('H:i'),0,6) => 'ok');
                    }          
                }
                $targetTime->addMinutes(30);
            }
        }
        return view('users.time',[
                                    'menu' => $request->menu, 
                                    'menuName' => $request->menuName, 
                                    'staff' => $request->staff , 
                                    'staffName' => $request->staffName, 
                                    'date' => $request->date,
                                    'times' => $times
                                ]);
    }
}
