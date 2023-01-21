<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MultipleClosedDay;
use App\Models\SingleClosedDay;
use App\Models\ReservationTime;
use App\Models\ReservationCalender;
use App\Models\Staff;
use App\Models\Menu;
use Carbon\Carbon;
use App\Services\Users\StaffService;

class CalenderController extends Controller
{
    public function firstCalender(){
        return view('users.calender');
    }

    public function thirdCalender(Request $request){
        //パラメータチェック
        if(!$request->has('menu','menuName','staff','staffName')){
            return view('users.error',['errorMsg' =>  __('sentences.user_error.param') ]);
        }
        return view('users.calender' , ['menu' => $request->menu,'menuName' => $request->menuName, 'staff' => $request->staff,'staffName' => $request->staffName]);

    }

    public function show(Request $request){
        //リクエスト処理
        $json = $request->getContent();
        $arr = json_decode($json,true);
        $targetDate = $arr[0]['date'];

        if(mb_strlen($targetDate) == 7){
            $targetDate = $targetDate . '-01';
        }
        //担当者選択で「選択しない」の場合、登録順が一番古い担当者を割り当てる
        if(isset($arr[0]['staff']) && $arr[0]['staff'] == 0){
            $arr[0]['staff'] = Staff::getFirstStaffId();
        }
        //対象日付けの取得（年月日）
        $nowDate = $targetDate;
        $nowYM = substr($targetDate,0,8);
        $nowY = substr($targetDate,0,4);
        $nowM = substr($targetDate,5,2);
        //月初、月末、曜日の取得、
        $dt = Carbon::create($nowY, $nowM, 1);
        $firstDate = $dt->firstOfMonth()->toDateString();
        $endDate = $dt->lastOfMonth()->toDateString();
        $dayOfWeek = Carbon::create($nowY, $nowM, 1)->dayOfWeek;

        //担当者合計変数
        $staffNum = null;
        //休日・予約判定配列作成
        if(is_null($arr[0]['staff'])){
            //担当者が選択されていない場合、有効な全ての担当者数を取得
            $staffNum = Staff::getStaffCount();
            //全スタッフの休日データ取得
            $multiData = MultipleClosedDay::getMultiGroupbyWeekNo(1);
            $singleRestData = SingleClosedDay::getSingleGroupByClosedDay($nowYM,1);
            $singleBusinessData = SingleClosedDay::getSingleGroupByClosedDay($nowYM,0);
            //対象月予約データ取得
            $reservationCalender = ReservationCalender::getReservationGroupBy(1 ,$nowDate);
        }else{
            //担当者が選択されている場合、1を代入
            $staffNum = 1;
            //対象担当者の休日データ取得
            $multiData = MultipleClosedDay::getMultiStaff($arr[0]['staff'],1);
            $singleRestData = SingleClosedDay::getSingleStaff($arr[0]['staff'],$nowYM,1);
            $singleBusinessData = SingleClosedDay::getSingleStaff($arr[0]['staff'],$nowYM,0);
            //対象月予約データ取得
            $reservationCalender = ReservationCalender::where('staff_id','=',$arr[0]['staff'])->get();
            //対象メニューのタイムセパレータ取得
            $timeSeparator = Menu::getMenuTimeSeparator($arr[0]['menu']);
        }
        //予約可能時間の取得
        $reservationTimes = ReservationTime::orderBy('week_no', 'asc')->get();
        //当日の現時刻判定のため、現在時刻を取得
        $nowDt =  Carbon::now();
        //当日の現時刻判定のため、最終受付時間データ取得
        $dataArray = unserialize($reservationTimes[$nowDt->dayOfWeek]->reservable_time);
        $lastDt = new Carbon(end($dataArray));
        //レスポンスデータ定義
        $calender = array();
        //ループ変数初期化
        $loopFrom = (int)substr($firstDate,8);
        $loopTo = (int)substr($endDate,8);
        $now = (int)substr($nowDate,8);
        //【ループ】取得日からスタート-月の最終日まで
        while ($loopFrom <= $loopTo){
            //配列KIYが配列番号と認識されてしまう為、[d]を付与
            $key = 'd'.$loopFrom;
            //その日の営業スタッフ数を取得
            $loopStaffNum = StaffService::getBusinessStaffNum(
                                        $multiData,
                                        $singleRestData,
                                        $singleBusinessData,
                                        $staffNum,
                                        $nowYM . sprintf('%02d', $loopFrom),
                                        $dayOfWeek
                            );
            //現在日付以前の判定
            if($loopFrom  < $now){
                $calender += array($key => '－');
            //現在日付でかつ、現時刻＋1Hが最終予約可能時間を過ぎている場合            
            }elseif($loopFrom == $now && $lastDt->lt($nowDt->addHour())){
                $calender += array($key => '－');
            //休日設定の判定(スタッフ営業人数が０以下の場合)
            }elseif($loopStaffNum <= 0){
                $calender += array($key => '－');
            //予約状況の判定
            }else{
                //対象曜日の予約可能時間の取得
                $blankCount = 0;
                $times = unserialize($reservationTimes[$dayOfWeek]->reservable_time);
                foreach($times as $time){
                    //予約可能時間内から予約データを検索
                    $reserveAvairable = $nowYM . sprintf('%02d', $loopFrom) . ' ' . $time;
                    $keyIndex = array_search($reserveAvairable, array_column($reservationCalender->all(), 'reservation_datetime'));
                    //「カレンダーから予約」の場合
                    if(is_null($arr[0]['staff'])){
                        //予約可能時間に予約された時間が見つかれない場合、その日の営業スタッフ数を空き状況に加算
                        if($keyIndex === false){
                            $blankCount = $blankCount + $loopStaffNum;
                        //予約可能時間に予約された時間がある場合、その日の営業スタッフに予約数を減算したものを加算
                        }elseif($keyIndex !== false){
                            $blankCount = $blankCount + ($loopStaffNum - $reservationCalender[$keyIndex]->reservation_count);
                        }
                        //空き状況が２つ以上あれば、「〇」とする
                        if($blankCount >= 2){
                            $calender = array_merge($calender, array($key => '〇'));
                            break;
                        //ループの最後で空き状況が１つだけなら、「△」とする。０なら、「－」とする。
                        }elseif($time === end($times)){
                            if($blankCount == 1){
                                $calender = array_merge($calender, array($key => '△'));
                                break;
                            }elseif($blankCount == 0){
                                $calender = array_merge($calender, array($key => '－'));
                            }
                        }
                    //「メニューから予約」「担当者から予約」の場合
                    }else{
                        //対象時間の予約が空いている場合
                        if($keyIndex === false ){
                            if($timeSeparator == 1){
                                $calender = array_merge($calender, array($key => '〇'));
                            }elseif($timeSeparator >= 2){
                                //時間を３０分加算しメニュー時間のコマ数分予約空き状況を確認する
                                $addTime = Carbon::create($time)->addMinutes(30)->toTimeString();
                                for($i=2 ; $i <=  $timeSeparator ; $i++){
                                    $addDate = $nowYM . sprintf('%02d', $loopFrom) . ' ' . $addTime;
                                    $index = array_search($addDate, array_column($reservationCalender->all(), 'reservation_datetime'));
                                    //対象コマ時間に対し予約データがある、又は対象コマ時間が予約可能時間でない場合
                                    if($index !== false || in_array($addTime, $times)){
                                        $calender = array_merge($calender, array($key => '－'));
                                        break;
                                    }
                                    //最後のコマ時間まで空き状況があれば、予約可能とする
                                    if($i ==  $timeSeparator){
                                        $calender = array_merge($calender, array($key => '〇'));
                                    }
                                    $addTime = Carbon::create($addTime)->addMinutes(30)->toTimeString();
                                }
                            }
                        //対象時間の予約が埋まっている場合
                        }else{
                            $calender = array_merge($calender, array($key => '－'));
                        }
                    }
                }
            }

            $loopFrom++;
            $dayOfWeek++;
            if($dayOfWeek == 7) $dayOfWeek = 0;
        }
        //レスポンスデータ送信
        header('Content-type: application/json');
        echo json_encode($calender);
    }
}
