<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\RegisteRequest;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
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

        return view('auth.register',[
                                    'menu' => $request->menu, 
                                    'menuName' => $request->menuName, 
                                    'staff' => $request->staff , 
                                    'staffName' => $request->staffName, 
                                    'date' => $request->date,
                                    'time' => $request->time
                                ]);        
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(RegisteRequest $request)
    {
        //パラメータチェック
        if(!$request->has('menu','menuName','staff','staffName','date','time')){
            return view('users.error',['errorMsg' =>  __('sentences.user_error.param') ]);
        }
        $user = User::create([
            'role_id' => 2,
            'name' => mb_convert_kana(trim($request->lastname) .' '. trim($request->firstname), 'kvrn'),
            'name_kana' => mb_convert_kana(trim($request->firstnamekana) .' '. trim($request->lastnamekana), 'kvrn'),
            'gender' => $request->gender,
            'birthday' => $request->birth,
            'postcode' => mb_convert_kana(trim($request->postcode), 'kvrn'),
            'prefecture' => mb_convert_kana(trim($request->prefecture), 'kvrn'),
            'city' => mb_convert_kana(trim($request->city), 'kvrn'),
            'address' => mb_convert_kana(trim($request->address), 'kvrn'),
            'phone' => mb_convert_kana(trim($request->tel), 'kvrn'),
            'cellphone' => mb_convert_kana(trim($request->phone), 'kvrn'),
            'email' => mb_convert_kana(trim($request->email), 'kvrn'),
            'password' => Hash::make(trim($request->password)),
        ]);
//        event(new Registered($user));

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
}
