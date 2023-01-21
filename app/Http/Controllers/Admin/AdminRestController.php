<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MultipleClosedDay;
use App\Models\SingleClosedDay;
use App\Models\Staff;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class AdminRestController extends Controller
{
    public function MultiIndex(Request $request)
    {
        //全スタッフデータ取得
        $staffs = Staff::getStaffAll();
        //対象スタッフデータ取得
        $firstStaff = null;
        if(empty($request->staff)){
            $firstStaff = Staff::getFirstStaffId();
        }else{
            $firstStaff = $request->staff;
        }
        //休日データ取得
        $multiRests = MultipleClosedDay::getMultiRestStaff($firstStaff);
        $rests = array();
        foreach($multiRests as $rest){
            if($rest->week_no == 0){
                $rests += array('0' => $rest->status);
            }elseif($rest->week_no == 1){
                $rests += array('1' => $rest->status);
            }elseif($rest->week_no == 2){
                $rests += array('2' => $rest->status);
            }elseif($rest->week_no == 3){
                $rests += array('3' => $rest->status);
            }elseif($rest->week_no == 4){
                $rests += array('4' => $rest->status);
            }elseif($rest->week_no == 5){
                $rests += array('5' => $rest->status);
            }elseif($rest->week_no == 6){
                $rests += array('6' => $rest->status);
            }
        }
        return view('admin.rest-multi',compact('rests','staffs','firstStaff'));
    }

    public function multiEdit(Request $request)
    {
        $rests  = $request->all();
        $staff = $request->staff;
        unset($rests['_token']);
        unset($rests['staff']);

        //一括休日データの更新
        foreach($rests as $key => $value){
            MultipleClosedDay::where([
                    'week_no' => $key,
                    'staff_id'=> $staff
                ])
                ->update(['status' => $value]);
        }
        //個別休日データのクリア
        SingleClosedDay::where('staff_id',$staff)->delete();

        return redirect()->route('admin.rest.multi' , ['staff' => $staff]);
    }
    
    public function singleIndex(Request $request)
    {
        //全スタッフデータ取得
        $staffs = Staff::getStaffAll();
        //対象スタッフデータ取得
        $firstStaff = null;
        if(empty($request->staff)){
            $firstStaff = Staff::getFirstStaffId();
        }else{
            $firstStaff = $request->staff;
        }
        return view('admin.rest-single',compact('staffs','firstStaff'));
    }

    public function getRestDatas(Request $request)
    {
        //リクエスト処理
        $json = $request->getContent();
        $data = json_decode($json,true);
        //月初、月末、曜日の取得、
        $dt = Carbon::create($data['date'] . '-01');
        $firstDate = $dt->firstOfMonth()->toDateString();
        $endDate = $dt->lastOfMonth()->toDateString();
        $dayOfWeek = Carbon::create($data['date'] . '-01')->dayOfWeek;

        //休日の取得
        $multiRests = MultipleClosedDay::where('staff_id',$data['staff'])
                        ->orderBy('week_no', 'asc')
                        ->get();
        $singles = SingleClosedDay::where('closed_day','like', $data['date'].'%')
                ->where('staff_id', $data['staff'])                            
                ->get();
        $toAvailable = array();
        $toRest = array();
        //休日→稼働日へ変更：$toAvailable、稼働日→休日へ変更：$toRest
        foreach($singles as $single){
            if($single->status == 0){
                array_push($toAvailable,'d'.(int)substr($single->closed_day,8));
            }elseif($single->status == 1){
                array_push($toRest,'d'.(int)substr($single->closed_day,8));
            }
        }
        //レスポンスデータ定義
        $rests = array();
        $loopFrom = (int)substr($firstDate,8);
        $loopTo = (int)substr($endDate,8);
        while ($loopFrom <= $loopTo){
            $key = 'd'.$loopFrom;
            //個別休日設定の判定
            if(in_array($key, $toRest)){
                $rests += array($key => 'rest');
            //一括休日設定の判定
            }elseif($multiRests[$dayOfWeek]->status == 1 && !in_array($key, $toAvailable)){
                $rests += array($key => 'rest');
            //上記以外は営業日
            }else{
                $rests += array($key => 'business');
            }
            $loopFrom++;
            $dayOfWeek++;
            if($dayOfWeek == 7) $dayOfWeek = 0;
        }
        //レスポンスデータ送信
        header('Content-type: application/json');
        echo json_encode($rests);
    }

    public function singleEdit(Request $request)
    {
        //データ取得
        if(!is_null($request->restdata)){
            $restdata = json_decode($request->restdata);
            foreach($restdata as $rest){
                $single = SingleClosedDay::where('closed_day',$rest->date)
                            ->where('staff_id',$request->staff)
                            ->get();
                //日付けデータが存在していなければ、Insert
                if ($single->isEmpty()) {
                    SingleClosedDay::create([
                        'staff_id' => $request->staff,
                        'closed_day' => $rest->date,
                        'status' =>  $rest->status,
                    ]);
                //日付けデータが存在していれば、delete
                }else{
                    SingleClosedDay::where('closed_day', $rest->date)
                        ->where('staff_id',$request->staff)
                        ->delete();
                }
            }
        }
        return redirect()->route('admin.rest.single', ['staff' => $request->staff]);
    }
}
