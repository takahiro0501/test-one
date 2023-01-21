<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\AdminTopController;
use App\Http\Controllers\Admin\AdminReservationController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminMenuController;
use App\Http\Controllers\Admin\AdminStaffController;
use App\Http\Controllers\Admin\AdminTimeController;
use App\Http\Controllers\Admin\AdminRestController;
use App\Http\Controllers\Admin\AdminDesignController;


//管理者ログイン
Route::get('admin/login', [AdminLoginController::class, 'create'])->name('admin.login');
Route::post('admin/login', [AdminLoginController::class, 'store'])->name('admin.login');
//管理者メニュー
Route::group(['middleware' => 'permission:manager'], function () {
    //管理画面トップ
    Route::get('admin/top', [AdminTopController::class, 'index'])->name('admin.top');
    //予約一覧
    Route::get('admin/reservation', [AdminReservationController::class, 'index'])->name('admin.reservation');
    Route::get('admin/reservation/search', [AdminReservationController::class, 'search'])->name('admin.reservation.search');
    //予約編集・削除
    Route::get('admin/reservation/edit/{reservationId}', [AdminReservationController::class, 'edit'])->name('admin.reservation.edit');
    Route::post('admin/reservation/edit/exe', [AdminReservationController::class, 'editExe'])->name('admin.reservation.edit.exe');
    Route::get('admin/reservation/delete/{reservationId}', [AdminReservationController::class, 'deleteExe'])->name('admin.reservation.delete');
    //顧客一覧
    Route::get('admin/user', [AdminUserController::class, 'index'])->name('admin.user');
    Route::get('admin/user/search', [AdminUserController::class, 'search'])->name('admin.user.search');
    //顧客編集・削除
    Route::get('admin/user/edit/{userId}', [AdminUserController::class, 'edit'])->name('admin.user.edit');
    Route::post('admin/user/edit/exe', [AdminUserController::class, 'editExe'])->name('admin.user.edit.exe');
    Route::get('admin/user/delete/{userId}', [AdminUserController::class, 'deleteExe'])->name('admin.user.delete');
    //顧客登録
    Route::get('admin/user/register', [AdminUserController::class, 'register'])->name('admin.user.register');
    Route::post('admin/user/register/exe', [AdminUserController::class, 'registerExe'])->name('admin.user.registerExe');
    //代行予約
    Route::get('admin/user/agency/{userId}', [AdminUserController::class, 'agency'])->name('admin.user.agency');
    Route::post('admin/user/agency', [AdminUserController::class, 'agencyExe'])->name('admin.user.agency.exe');
    //ゲスト編集・削除
    Route::get('admin/user/guset/edit/{guestId}', [AdminUserController::class, 'editGuest'])->name('admin.user.guest.edit');
    Route::post('admin/user/guest/edit/exe', [AdminUserController::class, 'editGuestExe'])->name('admin.user.guest.edit.exe');
    Route::get('admin/user/guset/delete/{guestId}', [AdminUserController::class, 'deleteGuestExe'])->name('admin.user.guest.delete');
    //顧客csv出力
    Route::post('admin/user/csv', [AdminUserController::class, 'csvOutput'])->name('admin.user.csv');
    //施術内容設定
    Route::get('admin/menu', [AdminMenuController::class, 'index'])->name('admin.menu');
    Route::post('admin/menu/create', [AdminMenuController::class, 'create'])->name('admin.menu.create');
    Route::get('admin/menu/edit/{menuId}', [AdminMenuController::class, 'edit'])->name('admin.menu.edit');
    Route::post('admin/menu/edit/exe', [AdminMenuController::class, 'editExe'])->name('admin.menu.edit.exe');
    Route::get('admin/menu/delete/{menuId}', [AdminMenuController::class, 'deleteExe'])->name('admin.menu.delete');
    Route::get('admin/menu/revival/{menuId}', [AdminMenuController::class, 'revivalExe'])->name('admin.menu.revival');
    //スタッフ設定
    Route::get('admin/staff', [AdminStaffController::class, 'index'])->name('admin.staff');
    Route::post('admin/staff/create', [AdminStaffController::class, 'create'])->name('admin.staff.create');
    Route::get('admin/staff/edit/{staffId}', [AdminStaffController::class, 'edit'])->name('admin.staff.edit');
    Route::post('admin/staff/edit/exe', [AdminStaffController::class, 'editExe'])->name('admin.staff.edit.exe');
    Route::get('admin/staff/delete/{staffId}', [AdminStaffController::class, 'deleteExe'])->name('admin.staff.delete');
    Route::get('admin/staff/revival/{staffId}', [AdminStaffController::class, 'revivalExe'])->name('admin.staff.revival');
    //予約可能時間設定
    Route::get('admin/time', [AdminTimeController::class, 'index'])->name('admin.time');
    Route::post('admin/edit', [AdminTimeController::class, 'edit'])->name('admin.edit');
    //曜日休診日設定
    Route::get('admin/rest/multi', [AdminRestController::class, 'multiIndex'])->name('admin.rest.multi');
    Route::post('admin/rest/multi', [AdminRestController::class, 'multiIndex'])->name('admin.rest.multi');
    Route::post('admin/rest/multi/edit', [AdminRestController::class, 'multiEdit'])->name('admin.rest.multi.edit');
    //個別休診日設定
    Route::get('admin/rest/single', [AdminRestController::class, 'singleIndex'])->name('admin.rest.single');
    Route::post('admin/rest/single', [AdminRestController::class, 'singleIndex'])->name('admin.rest.single');
    Route::post('admin/rest/calender', [AdminRestController::class, 'getRestDatas']);
    Route::post('admin/rest/single/edit', [AdminRestController::class, 'singleEdit'])->name('admin.rest.single.edit');
    //ヘッダー設定
    Route::get('admin/header', [AdminDesignController::class, 'header'])->name('admin.header');
    Route::post('admin/header/exe', [AdminDesignController::class, 'headerExe'])->name('admin.header.exe');
    //フッター設定
    Route::get('admin/footer', [AdminDesignController::class, 'footer'])->name('admin.footer');
    Route::post('admin/footer/exe', [AdminDesignController::class, 'footerExe'])->name('admin.footer.exe');
});
