<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\PasswordReset as PasswordResetModel;
use App\Http\Requests\Auth\PasswordUpdateRequest;
use Illuminate\Support\Facades\Log;


class NewPasswordController extends Controller
{
    /**
     * Display the password reset view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function create(Request $request)
    {
        $user = User::find($request->id,'email');
        $request->merge(['email' => $user->email]);
        return view('auth.reset-password', ['request' => $request]);
    }

    /**
     * Handle an incoming new password request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(PasswordUpdateRequest $request)
    {
        $resetData = PasswordResetModel::where('email',$request->email)->first();

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();
                
                event(new PasswordReset($user));
            }
        );
        if($status == Password::PASSWORD_RESET){
            if(is_null($resetData->menu_id)){
                return view('users.mypage.login-password-done');
            }else{
                return redirect()->route('reservation.confirm')->with([
                    'menu' => $resetData->menu_id, 
                    'menuName' => $resetData->menu_name, 
                    'staff' => $resetData->staff_id , 
                    'staffName' => $resetData->staff_name, 
                    'date' => substr($resetData->reservation_datetime,0,10),
                    'time' => substr($resetData->reservation_datetime,11)
                ]);
            }
        }else{
            return view('users.error',['errorMsg' =>  __('sentences.user_error.password_reset') ]);
        }
    }
}
