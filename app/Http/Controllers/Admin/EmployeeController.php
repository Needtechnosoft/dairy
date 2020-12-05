<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index(){
        return view('admin.emp.index');
    }

    public function addEmployee(Request $request){
        $user = new User();
        $user->phone = $request->phone;
        $user->name = $request->name;
        $user->address = $request->address;
        $user->role = 4;
        $user->password = bcrypt($request->phone);
        $user->save();
        $emp = new Employee();
        $emp->user_id = $user->id;
        $emp->salary = $request->salary;
        $emp->save();
        return view('admin.emp.single',compact('user'));
    }

    public function updateEmployee(Request $request){
        $user = User::where('id',$request->id)->where('role',4)->first();
        $user->phone = $request->phone;
        $user->name = $request->name;
        $user->address = $request->address;
        $user->role = 4;
        $user->password = bcrypt($request->phone);
        $user->save();
        $emp = Employee::where('user_id',$user->id)->first();
        $emp->salary = $request->salary;
        $emp->save();
        return view('admin.emp.single',compact('user'));
    }

    public function employeeList(){
        $emp = User::latest()->where('role',4)->get();
        return view('admin.emp.list',compact('emp'));
    }

    public function employeeDelete($id){
        $user = User::where('id',$id)->where('role',4)->first();
        $user->delete();
    }
}
