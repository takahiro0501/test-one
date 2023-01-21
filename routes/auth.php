<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\MypageLoginController;
use Illuminate\Support\Facades\Route;

//ログイン
Route::get('reserversion/login', [AuthenticatedSessionController::class, 'create'])->name('reservation.login');
Route::post('reserversion/login', [AuthenticatedSessionController::class, 'create'])->name('reservation.login');
Route::post('login', [AuthenticatedSessionController::class, 'store'])->name('login');
//カルテ番号でログイン
Route::get('reserversion/login/karte', [AuthenticatedSessionController::class, 'createKarte'])->name('reservation.loginKarte');
Route::post('reserversion/login/karte', [AuthenticatedSessionController::class, 'createKarte'])->name('reservation.loginKarte');
Route::post('login/karte', [AuthenticatedSessionController::class, 'storeKarte'])->name('login.karte');
//ユーザ登録（メールアドレス）
Route::get('reservation/register', [RegisteredUserController::class, 'create'])->name('reservation.register');
Route::post('reservation/register', [RegisteredUserController::class, 'create'])->name('reservation.register');
Route::post('register', [RegisteredUserController::class, 'store'])->name('register');
//Lineログイン
Route::prefix('reservation/login')->name('reservation.login.')->group(function() {
    Route::post('/line/redirect', [AuthenticatedSessionController::class, 'redirectToProvider'])->name('line.redirect');
    Route::get('/line/callback', [AuthenticatedSessionController::class, 'handleProviderCallback'])->name('line.callback');
    Route::get('/line/create', [AuthenticatedSessionController::class, 'createLine'])->name('line');
    Route::post('/line/create/exe', [AuthenticatedSessionController::class, 'createLineExe'])->name('line.exe');
});
//パスワードリセット
Route::get('/reservation/forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
Route::post('/reservation/forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
Route::get('reset-password/{token}/{id}', [NewPasswordController::class, 'create'])->name('password.reset');
Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.update');
//マイページ：メールアドレスログイン
Route::get('/reservation/mypage/mail', [MypageLoginController::class, 'mailCreate'])->name('reservation.mypage.mail');  
Route::post('/reservation/mypage/mail/login', [MypageLoginController::class, 'mailStore'])->name('reservation.mypage.mail.login');
//マイページ：パスワードリセット
Route::get('/reservation/mypage/password', [MypageLoginController::class, 'passwordCreate'])->name('reservation.mypage.password');  
Route::post('forgot-password/mypage', [MypageLoginController::class, 'passwordStore'])->name('password.email.mypage');
//マイページ：カルテ番号ログイン
Route::get('/reservation/mypage/karte', [MypageLoginController::class, 'karteCreate'])->name('reservation.mypage.karte');  
Route::post('/reservation/mypage/karte/login', [MypageLoginController::class, 'karteStore'])->name('reservation.mypage.karte.login');
//Lineログイン
Route::prefix('reservation/mypage/login')->name('reservation.mypage.login.')->group(function() {
    Route::get('/line/redirect', [MypageLoginController::class, 'redirectToProvider'])->name('line.redirect');
});
Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('logout');
});
