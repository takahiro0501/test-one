<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\ReservationCalender;
use App\Models\Menu;
use App\Models\Staff;
use Illuminate\Support\Carbon;
use Illuminate\Database\QueryException;

class ConfirmController extends Controller
{
    public function index(Request $request){
    //パラメータチェック
    if (!$request->session()->has('menu','menuName','staff','staffName','date','time')) {
        return view('users.error',['errorMsg' =>  __('sentences.user_error.param') ]);
    }
    return view('users.confirm',[
            'menu' => $request->session()->get('menu'), 
            'menuName' => $request->session()->get('menuName'), 
            'staff' => $request->session()->get('staff'), 
            'staffName' => $request->session()->get('staffName'), 
            'date' => $request->session()->get('date'),
            'time' => $request->session()->get('time')
        ]);
    }

    public function confirmExe(Request $request){
        //パラメータチェック
        if (!$request->has('menu','menuName','staff','staffName','date','time','user')) {
            return view('users.error',['errorMsg' =>  __('sentences.user_error.param') ]);
        }
        try{
            //予約データInsert
            $reservation = Reservation::create([
                'user_id' => $request->user,
                'menu_id' => $request->menu,
                'staff_id' => $request->staff,
                'reservation_datetime' => $request->date . ' ' . $request->time,
            ]);
            //予約カレンダーデータInsert
            $time_separator = Menu::getMenuTimeSeparator($request->menu);
            $dt = Carbon::create($request->date . ' ' . $request->time);
            for($i=0;$i<$time_separator;$i++){
                $reservationCalender = ReservationCalender::create([
                    'reservation_datetime' => $dt->format('Y-m-d H:i'),
                    'staff_id' => $request->staff,
                    'reservation_id' => $reservation->id,
                ]);
                $dt->addMinutes(30);
            }
        }catch(QueryException $e){
            return view('users.error',['errorMsg' =>  __('sentences.user_error.reservation_sql') ]);
        }
        return view('users.thanks',[
            'menuName' => $request->menuName, 
            'staffName' => $request->staffName, 
            'date' => $request->date,
            'time' => $request->time
        ]);
    }
}
