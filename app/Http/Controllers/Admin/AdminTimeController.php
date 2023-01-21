<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ReservationTime;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class AdminTimeController extends Controller
{
    public function index()
    {
        //予約可能時間取得
        $reservationTimes = ReservationTime::orderBy('week_no', 'asc')->get();
        //時間配列作成
        $starttime =  new Carbon('00:00:00');
        $endtime =  new Carbon('23:30:00');
        $allTimes[] = $starttime->format('H:i:s');
        while($starttime->format('H:i:s') !== $endtime->format('H:i:s')){
            $allTimes[] = $starttime->addMinutes(30)->format('H:i:s');
        }
        $results = array();
        //0:00～23：00のループ処理
        foreach($allTimes as $time){
            $timeArray = array();
            //曜日ごとに予約可能時間を確認
            foreach($reservationTimes->all() as $reservationTime){
                $availableTimes[] = unserialize($reservationTime->reservable_time);
                $keyIndex = array_search($time, $availableTimes[0]);
                if($keyIndex !== false){
                    array_push($timeArray,'〇');
                }elseif($keyIndex === false){
                    array_push($timeArray,'×');
                }
                $availableTimes = array();
            }
            $dt = new Carbon($time);
            $time = substr($time,0,5);
            $results += array($time.'～'.$dt->addMinutes(30)->format('H:i') => $timeArray);
        }
        return view('admin.available-time',compact('results'));
    }

    public function edit(Request $request)
    {
        $data  = $request->all();
        //不要データの削除
        unset($data['_token']);
        $availables = array_filter($data, function($value) {
            return $value == '〇';
        }, ARRAY_FILTER_USE_BOTH);
        $keys = array_keys($availables);
        //updateデータ定義
        $updateData = array();
        //Week_noごとにループ処理
        for($i=0 ; $i < 7 ; $i++){
            //'-(week_no)'を検索し対象曜日のデータを取り出す
            $result = array_filter($keys, function($value) use($i){
                return strpos($value,'-'.$i);
            },ARRAY_FILTER_USE_BOTH);
            //不要文字列の削除
            foreach($result as $key => $value){
                $result[$key] = mb_strstr($value ,'～',true).':00';
            }
            $updateData += array($i => array_values($result));
        }
        for($i=0 ; $i < 7 ; $i++){
            ReservationTime::where('week_no',$i)->update([
                'reservable_time' => serialize($updateData[$i])]
            );
        }

        return redirect()->route('admin.time');
    }
}
