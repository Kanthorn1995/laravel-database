<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DepartmentController extends Controller
{
    public function index()
    {
        //Eloquent
        $departments = Department::paginate(5);
        $trashDepartments = Department::onlyTrashed()->paginate(3);
        //query builder
        // $departments = DB::table('departments')->paginate(5);

        // $departments = DB::table('departments')->join('users', 'departments.user_id', 'users.id')->select('departments.*', 'users.name')->paginate(5);
        return view('admin.departments.index', compact('departments', 'trashDepartments'));
    }

    public function store(Request $request)
    {
        //ตรวจสอบข้อมูล
        // dd($request->department_name);
        $request->validate([
            'department_name' => 'required|unique:departments|max:255',
        ],
            ['department_name.required' => 'กรุณาป้อนชื่อแผนก',
                'department_name.max' => 'ป้อนอักขระได้ไม่เกิน 255 ตัวอักษร',
                'department_name.unique' => 'ชื่อแผนกซ้ำ',
            ]
        );
        //บันทึกข้อมูล
        //Eloquent
        // $department = new Department;
        // $department->department_name = $request->department_name;
        // $department->user_id = Auth::user()->id;
        // $department->save();

        //query builder
        $timestamps = \Carbon\Carbon::now();
        $data = array();
        $data["department_name"] = $request->department_name;
        $data["user_id"] = Auth::user()->id;
        $data["created_at"] = $timestamps;
        $data["updated_at"] = $timestamps;
        DB::table('departments')->insert($data);
        return redirect()->back()->with('success', 'บันทึกข้อมูลสำเร็จ');
    }

    public function edit($id)
    {
        $department = Department::find($id);
        return view('admin.departments.edit', compact('department'));
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'department_name' => 'required|unique:departments|max:255',
        ],
            ['department_name.required' => 'กรุณาป้อนชื่อแผนก',
                'department_name.max' => 'ป้อนอักขระได้ไม่เกิน 255 ตัวอักษร',
                'department_name.unique' => 'ชื่อแผนกซ้ำ',
            ]
        );
        Department::find($id)->update([
            'department_name' => $request->department_name,
            'user_id' => Auth::user()->id,
        ]);
        return redirect()->route('department')->with('success', 'แก้ไขข้อมูลสำเร็จ');
    }

    public function softdelete($id)
    {
        $delete = Department::find($id)->delete();
        return redirect()->route('department')->with('success', 'ลบข้อมูลสำเร็จ');

    }

    public function restore($id)
    {
        $restore = Department::withTrashed()->find($id)->restore();
        return redirect()->route('department')->with('success', 'กู้คืนข้อมูลสำเร็จ');
    }

    public function delete($id)
    {
        $delete = Department::onlyTrashed()->find($id)->forceDelete();
        return redirect()->route('department')->with('success', 'ลบข้อมูลถาวรสำเร็จ');
    }

}
