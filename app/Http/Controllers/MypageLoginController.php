<?php

namespace App\Http\Controllers;

use App\Http\Requests\MypageLoginMailRequest;
use App\Http\Requests\Auth\PasswordResetRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Password;
use App\Http\Requests\Auth\KarteLoginRequest;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;

class MypageLoginController extends Controller
{
    public function mailCreate()
    {
        return view('users.mypage.login-mail');
    }

    public function mailStore(MypageLoginMailRequest $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            //ログイン失敗時
            throw ValidationException::withMessages([
                'authfail' => '認証に失敗しました。メール又はパスワードが違います。'
            ]);
        }
        $request->session()->regenerate();
        return redirect()->route('reservation.mypage');
    }

    public function passwordCreate()
    {
        return view('users.mypage.login-password');
    }

    public function passwordStore(PasswordResetRequest $request)
    {
        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink(
            $request->only('email')
        );

        if($status == Password::RESET_LINK_SENT){
            return view('auth.forgot-mail-done',['email' => trim($request->email) ]);
        }else{
            return view('users.error',['errorMsg' =>  __('sentences.user_error.password_reset') ]);
        }
    }
    public function karteCreate()
    {
        return view('users.mypage.login-karte');
    }
    public function karteStore(KarteLoginRequest $request)
    {
        $user = User::where([
                ['karte_no' , trim($request->karte_no)],
                ['name' , trim($request->lastname) .' '. trim($request->firstname) ]
            ])->first();
        if (!is_null($user)) {
            Auth::login($user);
        }else{
            throw ValidationException::withMessages([
                'authfail' => '認証に失敗しました。カルテ番号又は氏名が違います。'
            ]);
        }

        $request->session()->regenerate();

        return redirect()->route('reservation.mypage');

    }

    public function redirectToProvider() {
        session()->put('reservationData',[
            'route' => 'mypage',
        ]);
        return Socialite::driver('line')->redirect();
    }
}
