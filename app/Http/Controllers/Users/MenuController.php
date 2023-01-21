<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\ReservationCalender;
use Illuminate\Support\Carbon;
use App\Services\Users\StaffService;

class MenuController extends Controller
{
    public function forthMenu(Request $request){
        //パラメータチェック
        if(!$request->has('date','time','staff','staffName')){
            return view('users.error',['errorMsg' =>  __('sentences.user_error.param') ]);
        }
        //担当者選択なしの場合、登録が古い空きがある担当者を割り当てる
        if($request->staff == 0){
            $staff = StaffService::getAvailableStaffId($request->date.' '.$request->time);
            if($staff === false){
                return view('users.error',['errorMsg' =>  __('sentences.user_error.param') ]);
            }
        }else{
            $staff = $request->staff;
        }
        //メニューデータ取得
        $menuDatas = Menu::getMenuAll();
        //予約データ取得
        $reservationCalenders = ReservationCalender::getReservationDateStaff($request->date, $staff);
        //レスポンスデータ定義
        $menus = array();
        //メニュー時間と予約時間の突合
        $count = 0;
        foreach($menuDatas as $menuData){
            $judge = 0;
            $dt = new Carbon($request->date . ' '.$request->time);
            //メニュー時間が１コマ（30分）判定
            if($menuData->time_separator == 1){
                $menus[$count] = ['judge' => 'ok','id' => $menuData->id];
            //メニュー時間が２コマ以上の判定
            }else{
                for($i=2 ; $i <= $menuData->time_separator ; $i++){
                    $dt->addMinute(30);
                    $reserveAvairable = $request->date . ' ' . $dt->format('H:i:s');
                    $keyIndex = array_search($reserveAvairable, array_column($reservationCalenders->all(), 'reservation_datetime'));
                    if($keyIndex !== false){
                        $menus[$count] = ['judge' => 'ng','id' => $menuData->id];
                        $judge = 1;
                        break;
                    }
                }
                if($judge == 0){
                    $menus[$count] = ['judge' => 'ok','id' => $menuData->id];
                }
            }
            $menus[$count] += array('id' => $menuData->id);
            $menus[$count] += array('name' => $menuData->name);
            $menus[$count] += array('overview' => $menuData->overview);
            $menus[$count] += array('time' => $menuData->time);
            $menus[$count] += array('money' => $menuData->money);
            $count++;
        }
        return view('users.menu',[
                                    'menus' => $menus,
                                    'staff' => $staff,
                                    'staffName' => $request->staffName,
                                    'date' => $request->date,
                                    'time' => $request->time
                                ]);
    }

    public function menuFirst(){
        //メニューデータ取得
        $menus = Menu::getMenuAll();

        return view('users.menu',compact('menus'));
    }

    public function secondMenu(Request $request){
        //パラメータチェック
        if(!$request->has('staff','staffName')){
            return view('users.error',['errorMsg' =>  __('sentences.user_error.param') ]);
        }
        //メニューデータ取得
        $menuDatas = Menu::getMenuAll();
        $menus[] = array();
        $count = 0;
        foreach($menuDatas as $menuData){
            $menus[$count] = array('judge' => 'ok');
            $menus[$count] += array('id' => $menuData->id);
            $menus[$count] += array('name' => $menuData->name);
            $menus[$count] += array('overview' => $menuData->overview);
            $menus[$count] += array('time' => $menuData->time);
            $menus[$count] += array('money' => $menuData->money);
            $count++;
        }
        return view('users.menu',[
                                    'menus' => $menus,
                                    'staff' => $request->staff,
                                    'staffName' => $request->staffName
                                ]);
    }
}


