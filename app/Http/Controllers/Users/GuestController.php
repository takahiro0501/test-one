<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Users\GuestRequest;
use App\Models\Guest;
use App\Models\Reservation;
use App\Models\ReservationCalender;
use App\Models\Menu;
use Illuminate\Support\Carbon;
use Illuminate\Database\QueryException;

class GuestController extends Controller
{
    public function index(Request $request){

        //パラメータチェック
        if(!$request->has('menu','menuName','staff','staffName','date','time') && 
            !$request->session()->has('_old_input') ){
            return view('users.error',['errorMsg' =>  __('sentences.user_error.param') ]);
        }
        return view('users.guest-confirm',[
            'menu' => $request->menu, 
            'menuName' => $request->menuName, 
            'staff' => $request->staff, 
            'staffName' => $request->staffName, 
            'date' => $request->date,
            'time' => $request->time
        ]);
    }

    public function guestExe(GuestRequest $request){
        //パラメータチェック
        if (!$request->has('menu','menuName','staff','staffName','date','time')) {
            return view('users.error',['errorMsg' =>  __('sentences.user_error.param') ]);
        }
        try{
            //ゲストデータInsert
            $guest = Guest::create([
                'name' => mb_convert_kana(trim($request->lastname).' '.trim($request->firstname), 'kvrn'),
                'phone' => mb_convert_kana(trim($request->phone), 'kvrn'),
            ]);
            //予約データInsert
            $reservation = Reservation::create([
                'guest_id' => $guest->id,
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
