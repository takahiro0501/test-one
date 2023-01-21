<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Http\Requests\Admin\MenuCreateRequest;


class AdminMenuController extends Controller
{
    public function index()
    {
        $menus = Menu::orderByRaw("delete_flg ASC, priority ASC ,name ASC")->get();

        return view('admin.menu-list',compact('menus'));
    }

    public function create(MenuCreateRequest $request)
    {
        $count = Menu::where('delete_flg','0')->count();

        Menu::create([
            'name' => $request->name ,
            'overview' => $request->overview ,
            'time' => $request->time ,
            'money' => $request->money ,
            'time_separator' => ceil($request->time / 30) ,
            'delete_flg' => 0 ,
            'priority' => $count+1
        ]);
        return redirect()->route('admin.menu');
    }

    public function edit(string $menuId)
    {
        $menu = Menu::find($menuId);
        $count = Menu::where('delete_flg','0')->count();
        return view('admin.menu-edit',compact('menu','count'));
    }

    public function editExe(MenuCreateRequest $request)
    {
        Menu::where('id',$request->id)->update([
            'name' => $request->name ,
            'overview' => $request->overview ,
            'time' => $request->time ,
            'money' => $request->money ,
            'time_separator' => ceil($request->time / 30) ,
            'priority' => $request->priority
        ]);
        return redirect()->route('admin.menu');
    }

    public function deleteExe(string $menuId)
    {
        Menu::where('id',$menuId)->update([
            'delete_flg' => 1 
        ]);
        return redirect()->route('admin.menu');
    }

    public function revivalExe(string $menuId)
    {
        Menu::where('id',$menuId)->update([
            'delete_flg' => 0
        ]);
        return redirect()->route('admin.menu');
    }

    public function priorityUpdate(Request $request)
    {
        dd($request->all());
    }
    
}
