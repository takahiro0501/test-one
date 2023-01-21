<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Users\TopController;
use App\Http\Controllers\Users\CalenderController;
use App\Http\Controllers\Users\TimeController;
use App\Http\Controllers\Users\StaffController;
use App\Http\Controllers\Users\MenuController;
use App\Http\Controllers\Users\ConfirmController;
use App\Http\Controllers\Users\GuestController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\ErrorController;


Route::get('reservation', [TopController::class, 'index'])->name('reservation.top');
Route::prefix("reservation")->group(function() {
  //カレンダー予約データ取得
  Route::post('show', [CalenderController::class, 'show'])->name('show');
  Route::post('menu/staff/show', [CalenderController::class, 'show']);
  Route::post('staff/menu/show', [CalenderController::class, 'show']);
  //カレンダーから予約ルート
  Route::get('calender', [CalenderController::class, 'firstCalender'])->name('reservation.firstCalender');
  Route::get('calender/time', [TimeController::class, 'secondTime'])->name('reservation.secondTime');
  Route::post('calender/time', [TimeController::class, 'secondTime'])->name('reservation.secondTime');
  Route::get('calender/time/staff', [StaffController::class, 'thirdStaff'])->name('reservation.thirdStaff');
  Route::post('calender/time/staff', [StaffController::class, 'thirdStaff'])->name('reservation.thirdStaff');
  Route::get('calender/time/staff/menu', [MenuController::class, 'forthMenu'])->name('reservation.forthMenu');
  Route::post('calender/time/staff/menu', [MenuController::class, 'forthMenu'])->name('reservation.forthMenu');
  //施術内容からの予約ルート
  Route::get('menu', [menuController::class, 'menuFirst'])->name('reservation.menuFirst');
  Route::get('menu/staff', [StaffController::class, 'staffSecond'])->name('reservation.staffSecond');
  Route::post('menu/staff', [StaffController::class, 'staffSecond'])->name('reservation.staffSecond');
  Route::get('menu/staff/calender', [CalenderController::class, 'thirdCalender'])->name('reservation.thirdCalender');
  Route::post('menu/staff/calender', [CalenderController::class, 'thirdCalender'])->name('reservation.thirdCalender');
  Route::get('menu/staff/calender/time', [TimeController::class, 'fourthTime'])->name('reservation.fourthTime');
  Route::post('menu/staff/calender/time', [TimeController::class, 'fourthTime'])->name('reservation.fourthTime');
  //スタッフからの予約ルート
  Route::get('staff', [StaffController::class, 'staffFirst'])->name('reservation.staffFirst');
  Route::get('staff/menu', [MenuController::class, 'secondMenu'])->name('reservation.secondMenu');
  Route::post('staff/menu', [MenuController::class, 'secondMenu'])->name('reservation.secondMenu');
  Route::get('staff/menu/calender', [CalenderController::class, 'thirdCalender'])->name('reservation.thirdStaffCalender');
  Route::post('staff/menu/calender', [CalenderController::class, 'thirdCalender'])->name('reservation.thirdStaffCalender');
  Route::get('staff/menu/calender/time', [TimeController::class, 'fourthTime'])->name('reservation.fourthStaffTime');
  Route::post('staff/menu/calender/time', [TimeController::class, 'fourthTime'])->name('reservation.fourthStaffTime');
  //ゲスト予約
  Route::get('guest', [GuestController::class, 'index'])->name('reservation.guest');  
  Route::post('guest', [GuestController::class, 'index'])->name('reservation.guest'); 
  Route::post('guest/complete', [GuestController::class, 'guestExe'])->name('reservation.guestExe');  
  //確認画面
  Route::get('confirm', [ConfirmController::class, 'index'])->name('reservation.confirm');  
  Route::post('complete', [ConfirmController::class, 'confirmExe'])->name('reservation.confirmExe');  
  //マイページ
  Route::get('/mypage', [MypageController::class, 'index'])->name('reservation.mypage');  
  //エラーページ
  Route::get('error', [ErrorController::class, 'index'])->name('reservation.error');

});

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
