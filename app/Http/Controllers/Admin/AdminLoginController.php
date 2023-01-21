<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Validation\ValidationException;

class AdminLoginController extends Controller
{
    public function create(){
        return view('admin.login');
    }

    public function store(LoginRequest $request)
    {
        if (! Auth::attempt($request->only('email', 'password'))) {
            //ログイン失敗時
            throw ValidationException::withMessages([
                'authfail' => '認証に失敗しました。メール又はパスワードが違います。'
            ]);
        }
        $request->session()->regenerate();

        return redirect()->route('admin.top');
    }
}
