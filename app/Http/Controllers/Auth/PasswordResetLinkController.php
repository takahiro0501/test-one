<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Http\Requests\Auth\PasswordResetRequest;
use App\Models\PasswordReset;
use Illuminate\Support\Facades\Log;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     * @param Request
     * @return \Illuminate\View\View
     */
    public function create(Request $request)
    {
//        Log::debug($request->all());
//        Log::debug($request->session()->all());
        //パラメータチェック
        if(!$request->has('menu','menuName','staff','staffName','date','time') && 
            !$request->session()->has('_old_input') ){
            return view('users.error',['errorMsg' =>  __('sentences.user_error.param') ]);
        }
        return view('auth.forgot-password',[
                                    'menu' => $request->menu, 
                                    'menuName' => $request->menuName, 
                                    'staff' => $request->staff , 
                                    'staffName' => $request->staffName, 
                                    'date' => $request->date,
                                    'time' => $request->time
                                ]);
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(PasswordResetRequest $request)
    {
        if(!$request->has('menu','menuName','staff','staffName','date','time','email')){
            return view('users.error',['errorMsg' =>  __('sentences.user_error.param') ]);
        }
        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink(
            $request->only('email')
        );

        if($status == Password::RESET_LINK_SENT){
            //予約情報をpassword_resetsテーブルに一時保存
            $data = PasswordReset::where('email', $request->email)
                    ->update([
                        'menu_id' => $request->menu,
                        'menu_name' => $request->menuName,
                        'staff_id' => $request->staff,
                        'staff_name' => $request->staffName,
                        'reservation_datetime' => $request->date . ' ' . $request->time
                    ]);
                if($data == 1){
                    return view('auth.forgot-mail-done',['email' => $request->email ]);
                }else{
                    return view('users.error',['errorMsg' =>  __('sentences.user_error.password_update') ]);
                }
        }else{
            return view('users.error',['errorMsg' =>  __('sentences.user_error.password_reset') ]);
        }
    }
}
