<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Reservation;
use Illuminate\Support\Carbon;

class MypageController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $now = Carbon::now()->toDateTimeString();
        $pasts = Reservation::where([
            ['user_id', '=' , $user->id],
            ['reservation_datetime', '<' , $now ]])
        ->with(['menu','staff'])
        ->orderBy('reservation_datetime', 'asc')
        ->get();
        $futures = Reservation::where([
            ['user_id', '=' , $user->id],
            ['reservation_datetime', '>=' , $now ]])
        ->with(['menu','staff'])
        ->orderBy('reservation_datetime', 'asc')
        ->get();
        return view('users.mypage.mypage',compact('user','pasts','futures'));
    }
}
