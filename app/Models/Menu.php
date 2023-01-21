<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = [
        'name',
        'overview',
        'time',
        'money',
        'time_separator',
        'priority',
        'delete_flg'
    ];
    //有効なメニューの取得
    public static function getMenuAll(){
        return Menu::where('delete_flg',0)->orderBy('priority','asc')->get();
    }
    //有効無効含むすべてのメニューの取得
    public static function getMenuDelAll(){
        return Menu::orderBy('id','asc')->get();
    }
    //タイムセパレータ取得
    public static function getMenuTimeSeparator(int $menuId):int
    {
        $menu = Menu::find($menuId);
        return $menu->time_separator;
    }
}
