<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Models\MultipleClosedDay;
use App\Http\Requests\Admin\StaffCreateRequest;

class AdminStaffController extends Controller
{
    public function index()
    {
        $staffs = Staff::orderByRaw("delete_flg ASC, priority ASC, name ASC")->get();
        return view('admin.staff-list',compact('staffs'));
    }

    public function create(StaffCreateRequest $request)
    {
        //スタッフデータの追加
        $count = Staff::where('delete_flg','0')->count();
        $staff = Staff::create([
            'name' => $request->name,
            'priority' => $count+1,
            'delete_flg' => 0
        ]);

        //スタッフ別一括休日データ追加
        for($i=0;$i < 7 ; $i++){
            MultipleClosedDay::create([
                'staff_id' => $staff->id,
                'week_no' => $i,
                'status' => 0
            ]);
        }
        
        return redirect()->route('admin.staff');
    }

    public function edit(string $staffId)
    {
        $staff = Staff::find($staffId);
        $count = Staff::where('delete_flg','0')->count();
        return view('admin.staff-edit',compact('staff','count'));
    }

    public function editExe(StaffCreateRequest $request)
    {
        Staff::where('id',$request->id)->update([
            'name' => $request->name ,
            'priority' => $request->priority ,
        ]);
        return redirect()->route('admin.staff');
    }

    public function deleteExe(string $staffId)
    {
        Staff::where('id',$staffId)->update([
            'delete_flg' => 1 
        ]);
        return redirect()->route('admin.staff');
    }

    public function revivalExe(string $staffId)
    {
        Staff::where('id',$staffId)->update([
            'delete_flg' => 0
        ]);
        return redirect()->route('admin.staff');
    }
}
