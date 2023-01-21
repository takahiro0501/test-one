<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\KarteLoginRequest;
use App\Http\Requests\Auth\LineLoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Log;

class AuthenticatedSessionController extends Controller
{
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create(Request $request)
    {
        //パラメータチェック
        if(!$request->has('menu','menuName','staff','staffName','date','time') && 
            !$request->session()->has('_old_input') ){
            return view('users.error',['errorMsg' =>  __('sentences.user_error.param') ]);
        }

        return view('auth.login',[
            'menu' => $request->menu, 
            'menuName' => $request->menuName, 
            'staff' => $request->staff , 
            'staffName' => $request->staffName, 
            'date' => $request->date,
            'time' => $request->time,
        ]);
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        if (! Auth::attempt($request->only('email', 'password'))) {
            //ログイン失敗時
            throw ValidationException::withMessages([
                'authfail' => '認証に失敗しました。メール又はパスワードが違います。'
            ]);
        }
        //パラメータチェック
        if(!$request->has('menu','menuName','staff','staffName','date','time')){
            return view('users.error',['errorMsg' =>  __('sentences.user_error.param') ]);
        }
        $request->session()->regenerate();

        return redirect()->route('reservation.confirm')->with([
            'menu' => $request->menu, 
            'menuName' => $request->menuName, 
            'staff' => $request->staff , 
            'staffName' => $request->staffName, 
            'date' => $request->date,
            'time' => $request->time
        ]);
    }

    public function createKarte(Request $request)
    {
        //パラメータチェック
        if(!$request->has('menu','menuName','staff','staffName','date','time') && 
            !$request->session()->has('_old_input') ){
            return view('users.error',['errorMsg' =>  __('sentences.user_error.param') ]);
        }

        return view('auth.login-karteno',[
            'menu' => $request->menu, 
            'menuName' => $request->menuName, 
            'staff' => $request->staff , 
            'staffName' => $request->staffName, 
            'date' => $request->date,
            'time' => $request->time,
        ]);

    }

    public function storeKarte(KarteLoginRequest $request)
    {
        $user = User::where([
                ['karte_no' , mb_convert_kana(trim($request->karte_no),'kvrn')],
                ['name' , trim($request->lastname) .' '. trim($request->firstname)]
            ])->first();
        if (!is_null($user)) {
            Auth::login($user);
        }else{
            throw ValidationException::withMessages([
                'authfail' => '認証に失敗しました。カルテ番号又は氏名が違います。'
            ]);
        }
        //パラメータチェック
        if(!$request->has('menu','menuName','staff','staffName','date','time')){
            return view('users.error',['errorMsg' =>  __('sentences.user_error.param') ]);
        }
        $request->session()->regenerate();

        return redirect()->route('reservation.confirm')->with([
            'menu' => $request->menu, 
            'menuName' => $request->menuName, 
            'staff' => $request->staff , 
            'staffName' => $request->staffName, 
            'date' => $request->date,
            'time' => $request->time
        ]);
    }



    public function redirectToProvider(Request $request) {
        //パラメータチェック
        if(!$request->has('menu','menuName','staff','staffName','date','time')){
            return view('users.error',['errorMsg' =>  __('sentences.user_error.param') ]);
        }
        session()->put('reservationData',[
            'menu' => $request->menu, 
            'menuName' => $request->menuName, 
            'staff' => $request->staff , 
            'staffName' => $request->staffName, 
            'date' => $request->date,
            'time' => $request->time,
            'name' => mb_convert_kana(trim($request->lastname) . ' ' . trim($request->firstname), 'kvrn'),
            'tel' => mb_convert_kana(trim($request->tel), 'kvrn'),
            'route' => 'reservation'
        ]);
        return Socialite::driver('line')->redirect();
    }

    /**
     * 外部サービスからユーザー情報を取得し、ログインする。
     */
    public function handleProviderCallback(Request $request) 
    {
        //Lineからデータ受け取り
        $line_user = Socialite::driver('line')->user();
        //ユーザモデル取得
        $user = User::where('line_user_id', $line_user->id)->first();
        $route = session()->get('reservationData.route');
        //予約時
        if($route =='reservation'){
            //予約データ退避とLine情報退避
            $param = [
                'menu' => session()->get('reservationData.menu'), 
                'menuName' => session()->get('reservationData.menuName'), 
                'staff' => session()->get('reservationData.staff') , 
                'staffName' => session()->get('reservationData.staffName'), 
                'date' => session()->get('reservationData.date'),
                'time' => session()->get('reservationData.time'),
                'Line' => $line_user->id
            ];
            //予約データ破棄
            $request->session()->forget('reservationData');
            //LINE登録済みユーザの場合、
            if(!is_null($user)){
                //ログイン後に予約確認画面へ遷移
                Auth::login($user);
                return redirect()->route('reservation.confirm')->with($param);
            //LINE未登録ユーザの場合、
            }else{
                $param += array('line' => $line_user->id);
                return redirect()->route('reservation.login.line')->with($param);
            }
        //マイページ時
        }elseif($route == 'mypage'){
            if(!is_null($user)){
                Auth::login($user);
                $request->session()->forget('reservationData');
                return redirect()->route('reservation.mypage');
            }else{
                return view('users.error',['errorMsg' =>  __('sentences.user_error.mypage_line') ]);
            }
        }else{
            return view('users.error',['errorMsg' =>  __('sentences.user_error.param') ]);
        }
    }

    /**
     * Lineログイン新規ユーザ登録画面表示
     */
    public function createLine(Request $request) 
    {
        //パラメータチェック
        if(!$request->session()->has('menu','menuName','staff','staffName','date','time','line') && 
            !$request->session()->has('_old_input') ){
            return view('users.error',['errorMsg' =>  __('sentences.user_error.param') ]);
        }
        return view('auth.login-line',[
            'menu' => $request->session()->get('menu'), 
            'menuName' => $request->session()->get('menuName'), 
            'staff' => $request->session()->get('staff'), 
            'staffName' => $request->session()->get('staffName'), 
            'date' => $request->session()->get('date'),
            'time' => $request->session()->get('time'),
            'line' => $request->session()->get('line'),
        ]);
    }
    /**
     * Lineログイン新規ユーザ登録画面表示
     */
    public function createLineExe(LineLoginRequest $request) 
    {
        //パラメータチェック
        if(!$request->has('menu','menuName','staff','staffName','date','time','line')){
            return view('users.error',['errorMsg' =>  __('sentences.user_error.param') ]);
        }
        $user = User::create([
            'role_id' => 2,
            'line_user_id' => $request->line,
            'name' => mb_convert_kana(trim($request->lastname) .' '. trim($request->firstname), 'kvrn'),
            'phone' => mb_convert_kana(trim($request->tel), 'kvrn')
        ]);
        //ユーザログイン
        Auth::login($user);
        return redirect()->route('reservation.confirm')->with([
            'menu' => $request->menu, 
            'menuName' => $request->menuName, 
            'staff' => $request->staff , 
            'staffName' => $request->staffName, 
            'date' => $request->date,
            'time' => $request->time
        ]);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/reservation');
    }
}
