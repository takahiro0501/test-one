<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Guest;
use App\Models\Menu;
use App\Models\Staff;
use App\Models\ReservationCalender;
use App\Models\ReservationTime;
use App\Models\Reservation;
use App\Models\MultipleClosedDay;
use App\Models\SingleClosedDay;
use App\Http\Requests\Admin\UserEditRequest;
use App\Http\Requests\Admin\ReservationEditRequest;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\RegisteRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Carbon;
use Illuminate\Database\QueryException;

class AdminUserController extends Controller
{
    public function index()
    {
        $results = User::where('id','!=',1)->orderby('created_at','desc')->get();
        $inputKarte = 1;
        $guest = 1;

        return view('admin.user-list',compact('results','inputKarte','guest'));
    }

    public function search(Request $request){
        //検索条件定義
        $karte = mb_convert_kana(trim($request->karte), 'kvrn');
        $name = mb_convert_kana(trim($request->name), 'kvrn');
        $phone = mb_convert_kana(trim($request->phone), 'kvrn');
        $email = mb_convert_kana(trim($request->email), 'kvrn');
        $guest = $request->guest;
        $inputKarte = $request->inputKarte;

        if($request->guest == 1){
            //クエリ準備
            $query = User::query();
            //管理者以外
            $query->where('id','!=',1);
            //カルテ番号検索
            if(!empty($karte)){
                $query->where('karte_no', 'like', '%'.$karte.'%');
            }
            //名前検索
            if(!empty($name)){
                $query->where('name', 'like', '%'.$name.'%');
            }
            //電話番号検索
            if(!empty($phone)){
                $query->where('phone', 'like', '%'.$phone.'%');
            }
            //メール検索
            if(!empty($email)){
                $query->where('email', 'like', '%'.$email.'%');
            }
            //カルテ番号入力有無検索
            if($request->inputKarte == 2){
                $query->where('karte_no', null);
            }
        }elseif($request->guest == 2){
            //クエリ準備
            $query = Guest::query();
            //名前検索
            if(!empty($name)){
                $query->where('name', '%'.$name.'%');
            }
            //電話番号検索
            if(!empty($phone)){
                $query->where('phone', '%'.$phone.'%');
            }
            $karte = null;
            $email = null;
            $inputKarte = 2;
        }
        //クエリ実行
        $results = $query->orderby('created_at','desc')->get();
        return view('admin.user-list',compact('results','karte','name','phone','email','inputKarte','guest'));
    }

    public function edit(string $userId)
    {
        $user = User::find($userId);
        return view('admin.user-edit',compact('user'));
    }

    public function editExe(UserEditRequest $request)
    {
        //カルテ番号重複チェック
        $karte = null;
        if(!empty($request->karte)){
            $karte = mb_convert_kana(trim($request->karte), 'kvrn');
            $resultKarte = User::where('id', '!=' ,$request->id)
                ->where('karte_no',$karte)
                ->exists();
            if($resultKarte === true){
                throw ValidationException::withMessages([
                    'karte' => '既に他ユーザで使用されているカルテ番号です。'
                ]);
            }
        }
        //email重複チェック
        $email = null;
        if(!empty($request->email)){
            $email = mb_convert_kana(trim($request->email), 'kvrn');
            $resultEmail = User::where('id', '!=' ,$request->id)
                ->where('email',$email)
                ->exists();
            if($resultEmail === true){
                throw ValidationException::withMessages([
                    'email' => '既に他ユーザで使用されているメールアドレスです。'
                ]);
            }
        }
        //パスワードチェック
        $password = mb_strlen($request->password);
        if($request->password !== null && $password < 8){
            throw ValidationException::withMessages([
                'password' => '8文字以上で入力してください'
            ]);
        }
        try{
            //顧客データ更新
            $updateResult = User::where('id', $request->id)->update([
                'karte_no' => $karte,         
                'first_day' => $request->first,
                'name' => mb_convert_kana(trim($request->lastname.' '.$request->firstname), 'kvrn'),
                'name_kana' => mb_convert_kana(trim($request->lastnamekana.' '.$request->firstnamekana), 'kvrn'),
                'gender' => $request->gender,
                'birthday' => $request->birth,
                'postcode' => mb_convert_kana(trim($request->postcode), 'kvrn'),
                'prefecture' =>  $request->prefecture,
                'city' =>  mb_convert_kana(trim($request->city), 'kvrn'),
                'address' =>  mb_convert_kana(trim($request->address), 'kvrn'),
                'phone' =>  mb_convert_kana(trim($request->phone), 'kvrn'),
                'cellphone' =>  mb_convert_kana(trim($request->cellphone), 'kvrn'),
                'email' =>  $email
            ]);
            //パスワード更新
            $password = mb_strlen($request->password);
            if($request->password !== null){
                $updateResult = User::where('id', $request->id)->update([
                    'password' => Hash::make($request->password)      
                ]);
            }
        }catch(QueryException $e){
            //dd($e);
            return view('admin.error',['errorMsg' => __('sentences.admin_error.user_update') ]);
        }
        return redirect()->route('admin.user');
    }

    public function deleteExe(string $userId)
    {
        //ゲストデータ削除
        $deleteResult = User::where('id',$userId)->delete();
        if($deleteResult == 0){
            return view('admin.error',['errorMsg' => __('sentences.admin_error.guest_delete') ]);
        }
        return redirect()->route('admin.user');
    }

    public function editGuest(string $guestId)
    {
        $guest = Guest::find($guestId);
        return view('admin.user-guest-edit',compact('guest'));
    }

    public function editGuestExe(UserEditRequest $request)
    {
        //名前・電話番号の重複チェック処理
        $name = mb_convert_kana(trim($request->lastname.' '.$request->firstname), 'kvrn');
        $phone = mb_convert_kana(trim($request->phone), 'kvrn');
        if( User::where('name',$name)->exists() && User::where('phone',$phone)->exists()){
            throw ValidationException::withMessages([
                'guestCheck' => '氏名と電話番号が既に顧客として登録されています。'
            ]);
        }
        //カルテ番号重複チェック
        $karte = null;
        if(!empty($request->karte)){
            $karte = mb_convert_kana(trim($request->karte), 'kvrn');
            if(User::where('karte_no',$karte)->exists()){
                throw ValidationException::withMessages([
                    'karte' => '既に他ユーザで使用されているカルテ番号です。'
                ]);
            }
        }
        //email重複チェック
        $email = null;
        if(!empty($request->email)){
            $email = mb_convert_kana(trim($request->email), 'kvrn');
            if(User::where('email',$email)->exists()){
                throw ValidationException::withMessages([
                    'email' => '既に他ユーザで使用されているメールアドレスです。'
                ]);
            }
        }
        //パスワードチェック
        $password = mb_strlen($request->password);
        if($request->password !== null && $password < 8){
            throw ValidationException::withMessages([
                'password' => '8文字以上で入力してください'
            ]);
        }
        try{
            //顧客データ作成
            $createResult = User::create([
                'role_id' => 2,
                'karte_no' => $karte,         
                'name' => $name,
                'name_kana' => mb_convert_kana(trim($request->lastnamekana.' '.$request->firstnamekana), 'kvrn'),
                'gender' => $request->gender,
                'birthday' => $request->birth,
                'postcode' => mb_convert_kana(trim($request->postcode), 'kvrn'),
                'prefecture' =>  $request->prefecture,
                'city' =>  mb_convert_kana(trim($request->city), 'kvrn'),
                'address' =>  mb_convert_kana(trim($request->address), 'kvrn'),
                'phone' =>  $phone,
                'cellphone' =>  mb_convert_kana(trim($request->cellphone), 'kvrn'),
                'email' =>  $email
            ]);
            //パスワード更新
            if($request->password !== null){
                $updateResult = User::where('id', $request->id)->update([
                    'password' => Hash::make($request->password)      
                ]);
            }
            //予約データ更新
            $updateResult = Reservation::where('guest_id',$request->id)
                ->update([
                    'guest_id' => null,
                    'user_id' => $createResult->id,
                ]);
            //ゲストデータ削除
            $rResult = Guest::where('id', $request->id)->delete();
        }catch(QueryException $e){
            //dd($e);
            return view('admin.error',['errorMsg' => __('sentences.admin_error.guest_create') ]);
        }

        return redirect()->route('admin.user');
    }

    public function deleteGuestExe(string $guestId)
    {
        //ゲストデータ削除
        $deleteResult = Guest::where('id',$guestId)->delete();
        if($deleteResult == 0){
            return view('admin.error',['errorMsg' => __('sentences.admin_error.guest_delete') ]);
        }
        return redirect()->route('admin.user');
    }

    public function csvOutput(Request $request)
    {
        $csv = json_decode($request->csv);
        $callback = function () use ($csv) {
            $stream = fopen('php://output', 'w');
            stream_filter_prepend($stream, 'convert.iconv.utf-8/cp932//TRANSLIT');
            //ヘッダー作成
            fputcsv($stream, [
                'カルテID',
                '初診日',
                '姓',
                '名',
                'セイ',
                'ナ',
                '性別',
                '生年月日',
                '郵便番号',
                '都道府県名',
                '市区町村名',
                '住所',
                '電話番号',
                '携帯番号',
            ]);
            foreach($csv as $data){
                if($data->gender == 0){
                    $data->gender = '男';
                }elseif($data->gender == 1){
                    $data->gender = '女';
                }elseif($data->gender == 2){
                    $data->gender = '';
                }
                fputcsv($stream, [
                    $data->karte_no,
                    $data->first_day,
                    trim(mb_strstr($data->name,' ',true)),
                    trim(mb_strstr($data->name,' ')),
                    trim(mb_strstr($data->name_kana,' ',true)),
                    trim(mb_strstr($data->name_kana,' ')),
                    $data->gender,
                    $data->birthday,
                    $data->postcode,
                    $data->prefecture,
                    $data->city,
                    $data->address,
                    '="'.$data->phone.'"',
                    '="'.$data->cellphone.'"',
                ]);
            }
            fclose($stream);
        };
        $filename = sprintf('user-%s.csv', date('YmdHis'));
        $header = [
            'Content-Type' => 'application/octet-stream',
        ];
        return response()->streamDownload($callback, $filename, $header);
    }

    public function register(){
        return view('admin.user-register');
    }

    public function registerExe(UserEditRequest $request)
    {
        //カルテ番号重複チェック
        $karte = null;
        if(!empty($request->karte)){
            $karte = mb_convert_kana(trim($request->karte), 'kvrn');
            if(User::where('karte_no',$karte)->exists()){
                throw ValidationException::withMessages([
                    'karte' => '既に他ユーザで使用されているカルテ番号です。'
                ]);
            }
        }
        //email重複チェック
        $email = null;
        if(!empty($request->email)){
            $email = mb_convert_kana(trim($request->email), 'kvrn');
            if(User::where('email',$email)->exists()){
                throw ValidationException::withMessages([
                    'email' => '既に他ユーザで使用されているメールアドレスです。'
                ]);
            }
        }
        //パスワードチェック
        $password = mb_strlen($request->password);
        if($request->password !== null && $password < 8){
            throw ValidationException::withMessages([
                'password' => '8文字以上で入力してください'
            ]);
        }
        try{
            //ユーザ登録処理
            $user = User::create([
                'role_id' => 2,
                'karte_no' => $karte,
                'name' => mb_convert_kana(trim($request->lastname) .' '. trim($request->firstname), 'kvrn'),
                'name_kana' => mb_convert_kana(trim($request->firstnamekana) .' '. trim($request->lastnamekana), 'kvrn'),
                'gender' => $request->gender,
                'birthday' => $request->birth,
                'postcode' => mb_convert_kana(trim($request->postcode), 'kvrn'),
                'prefecture' => mb_convert_kana(trim($request->prefecture), 'kvrn'),
                'city' => mb_convert_kana(trim($request->city), 'kvrn'),
                'address' => mb_convert_kana(trim($request->address), 'kvrn'),
                'phone' => mb_convert_kana(trim($request->phone), 'kvrn'),
                'cellphone' => mb_convert_kana(trim($request->cellphone), 'kvrn'),
                'email' => $email,
                'password' => Hash::make(trim($request->password)),
            ]);
            //パスワード更新
            if($request->password !== null){
                User::where('id', $request->id)->update([
                    'password' => Hash::make($request->password)      
                ]);
            }
        }catch(QueryException $e){
            //dd($e);
            return view('admin.error',['errorMsg' => __('sentences.admin_error.user_create') ]);
        }

        return redirect()->route('admin.user');
    }

    public function agency(string $UserId)
    {
        $user = User::find($UserId);
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
        return view('admin.user-agency',['user' => $user,'menus' => $menus ,'staffs' => $staffs ,'times' => $times]);
    }

    public function agencyExe(ReservationEditRequest $request)
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
        try{
            //予約データ作成
            $newReservation = Reservation::create([
                'user_id' => $request->user_id,
                'menu_id' => $request->menu,
                'staff_id' => $request->staff,
                'reservation_datetime' => $request->date.' '.$request->time 
            ]);
            //予約カレンダーデータ作成
            $dt = Carbon::create($request->date . ' ' . $request->time);
            for($i=0;$i<$time_separator;$i++){
                $reservationCalender = ReservationCalender::create([
                    'reservation_datetime' => $dt->format('Y-m-d H:i'),
                    'staff_id' => $request->staff,
                    'reservation_id' => $newReservation->id
                ]);
                $dt->addMinutes(30);
            }
        }catch(QueryException $e){
            //dd($e);
            return view('admin.error',['errorMsg' => __('sentences.admin_error.reservation_create_auto') ]);
        }        
        return redirect()->route('admin.user');
    }
}