<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\ReservationCalender;
use App\Models\ReservationTime;
use App\Models\Menu;
use App\Models\Staff;
use App\Models\SingleClosedDay;
use App\Models\MultipleClosedDay;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Carbon;
use Illuminate\Database\QueryException;
use App\Http\Requests\Admin\ReservationEditRequest;


class AdminReservationController extends Controller
{
    public function index(){

        $reservations = Reservation::with(['user','guest','menu','staff'])
            ->orderBy('reservation_datetime', 'ASC')
            ->get();
        $menus = Menu::getMenuDelAll();
        $staffs = Staff::getStaffDelAll();
        return view('admin.reservation-list',compact('reservations','menus','staffs'));
    }

    public function search(Request $request){
        //検索条件定義
        $karte = mb_convert_kana(trim($request->karte), 'kvrn');
        $userName = mb_convert_kana(trim($request->name), 'kvrn');
        $menu = $request->menu;
        $staff = $request->staff;
        $fromDate = $request->fromDate;
        $toDate = $request->toDate;
        //セレクトボックスデータ
        $menus = Menu::getMenuDelAll();
        $staffs = Staff::getStaffDelAll();
        //クエリ準備
        $query = Reservation::query();
        //カルテ番号検索
        if(!empty($request->karte)){
            $query->whereHas('user', function($q) use ($karte){
                $q->where('karte_no','like', '%'.$karte.'%');
            });
        }
        //名前検索
        if(!empty($userName)){
            $query->whereHas('user', function($q) use ($userName){
                $q->where('name','like', '%'.$userName.'%');
            });
        }
        //メニュー検索
        if(!empty($menu)){
            $query->where('menu_id', $menu);
        }
        //スタッフ検索
        if(!empty($staff)){
            $query->where('staff_id', $staff);
        }
        //日付け（from）を検索条件に含める
        if(!empty($fromDate)){
            $query->whereDate("reservation_datetime", '>=' , $fromDate);
        }
        //日付け（to）を検索条件に含める
        if(!empty($toDate)){
            $query->whereDate("reservation_datetime", '<=' , $toDate);
        }
        //クエリ実行
        $reservations = $query->orderby('reservation_datetime','ASC')->get();
        return view('admin.reservation-list',compact('reservations','menus','staffs','karte','userName','menu','staff','fromDate','toDate'));
    }

    public function edit(string $reservationId)
    {   
        //予約データ取得
        $reservation = Reservation::with(['user','guest','menu','staff'])->find($reservationId);
        //selectBoxメニュー、スタッフデータ作成
        $menus = Menu::getMenuAll();
        $staffs = Staff::getStaffAll();
        //selectBox時間データ作成
        $starttime =  new Carbon('00:00');
        $endtime =  new Carbon('23:30');
        $times[] = $starttime->format('H:i');
        while($starttime->format('H:i') !== $endtime->format('H:i')){
            $times[] = $starttime->addMinutes(30)->format('H:i');
        }
        return view('admin.reservation-edit',['reserve' => $reservation,'menus' => $menus ,'staffs' => $staffs ,'times' => $times]);
    }

    public function editExe(ReservationEditRequest $request)
    {
        //休日チェック
        $dayOfWeek = Carbon::create($request->date)->dayOfWeek;
        $multi = MultipleClosedDay::where('week_no',$dayOfWeek)->first();
        //一括休日TBLで営業日に設定されている、かつ個別休日TBLで休日が設定されている場合
        if($multi->status == 0){
            if(SingleClosedDay::where('closed_day',$request->date)->where('status', 1)->exists())
            {
                throw ValidationException::withMessages([
                    'reserveCheck' => 'エラー：対象の日は、「個別休診日設定」にて休診日に設定されています'
                ]);
            }
        //一括休日TBLで休日に設定されている、かつ個別休日TBLで営業日が設定されていない場合
        }elseif($multi->status == 1){
            if(!SingleClosedDay::where('closed_day',$request->date)->where('status', 0)->exists())
            {
                throw ValidationException::withMessages([
                    'reserveCheck' => 'エラー：対象の日は、「曜日休診日設定」にて休診日に設定されています'
                ]);
            }
        }else{
            //システムエラー
        }
        //予約空き状況チェック
        //対象日のreservation_calendersのデータ取得
        $rCalenders = ReservationCalender::where('reservation_datetime','like' ,$request->date.'%' )
                                        ->where('staff_id', $request->staff)
                                        ->get();
        //対象曜日のreservation_timesのデータ取得
        $timeData = ReservationTime::where('week_no', $dayOfWeek)->first();
        $rtimes[] = unserialize($timeData->reservable_time);
        //メニューデータを取得
        $time_separator = Menu::getMenuTimeSeparator($request->menu);
        //日時データ作成
        $targetDateTime = Carbon::create($request->date.' '.$request->time);
        for($i=0 ; $i < $time_separator ; $i++){
            //対象の時間が予約可能時間に設定されている時間か判定する
            $timeKeyIndex = array_search($targetDateTime->format('H:i:s'), $rtimes[0]);
            //対象の時間が、予約可能時間にない場合
            if($timeKeyIndex === false){
                throw ValidationException::withMessages([
                    'reserveCheck' => 'エラー：対象の時間は、「予約時間設定」にて予約可能時間に設定されていません'
                ]);
            }
            //対象の日時に予約が入っていないか判定する
            if($rCalenders->isNotEmpty()){
                $dateKeyIndex = array_search($targetDateTime->toDateTimeString(), array_column($rCalenders->all(), 'reservation_datetime'));
                if($dateKeyIndex !== false){
                    throw ValidationException::withMessages([
                        'reserveCheck' => 'エラー：対象のスタッフと日時は、既に予約が埋まっています'
                    ]);
                }
            }
            $targetDateTime->addMinutes(30);
        }
        //予約カレンダーデータ削除
        $deleteResult = ReservationCalender::where('reservation_id', $request->reservation_id)->delete();
        if($deleteResult == 0){
            return view('admin.error',['errorMsg' => __('sentences.admin_error.reservation_calender_delete_auto') ]);
        }
        //予約データ更新
        $updateResult = Reservation::where('id', $request->reservation_id)->update([
            'menu_id' => $request->menu,
            'staff_id' => $request->staff,
            'reservation_datetime' => $request->date.' '.$request->time 
        ]);
        if($updateResult == 0){
            return view('admin.error',['errorMsg' => __('sentences.admin_error.reservation_update_auto') ]);
        }

        try{
            //予約カレンダーデータ作成
            $dt = Carbon::create($request->date . ' ' . $request->time);
            for($i=0;$i<$time_separator;$i++){
                $reservationCalender = ReservationCalender::create([
                    'reservation_datetime' => $dt->format('Y-m-d H:i'),
                    'staff_id' => $request->staff,
                    'reservation_id' => $request->reservation_id,
                ]);
                $dt->addMinutes(30);
            }
        }catch(QueryException $e){
            return view('admin.error',['errorMsg' => __('sentences.admin_error.reservation_create_auto') ]);
        }
        
        return redirect()->route('admin.reservation');
    }
    
    public function deleteExe(string $reservationId){
        //予約データ削除
        $rResult = Reservation::where('id', $reservationId)->delete();
        if($rResult == 0){
            return view('admin.error',['errorMsg' => __('sentences.admin_error.reservation_delete') ]);
        }
        return redirect()->route('admin.reservation');
    }
}
