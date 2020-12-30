<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\LedgerManage;
use App\Models\Employee;
use App\Models\EmployeeAdvance;
use App\Models\Ledger;
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

    public function advance(){
        return view('admin.emp.advance.index');
    }

    public function getAdvance(Request $request){
        $date = str_replace('-', '', $request->date);
        $advances=EmployeeAdvance::where('date',$date)->get();

        return view('admin.emp.advance.list',compact('advances'));

    }
    public function addAdvance(Request $request){
        $date = str_replace('-', '', $request->date);

        $advance=new EmployeeAdvance();
        $advance->employee_id=$request->employee_id;
        $advance->amount=$request->amount;
        $advance->date=$date;
        $advance->save();

        $ledger=new LedgerManage($advance->employee->user_id);
        $ledger->addLedger('Advance Given',1,$request->amount,$date,'112',$advance->id);
        return view('admin.emp.advance.single',compact('advance'));
    }

    public function updateAdvance(Request $request){
        $date = str_replace('-', '', $request->date);

        $advance=EmployeeAdvance::find($request->id);
        $tempamount=$advance->ammount;
        $advance->amount=$request->amount;
        $advance->save();

        $ledger=new LedgerManage($advance->employee->user_id);
        $ledger->addLedger('Advance Canceled',2,$tempamount,$date,'113',$advance->id);
        $ledger->addLedger('Advance Updated',1,$request->amount,$date,'112',$advance->id);
        return response()->json(['status'=>'success']);
    }

    public function delAdvance(Request $request){
        $date = str_replace('-', '', $request->date);

        $advance=EmployeeAdvance::find($request->id);
        $tempamount=$advance->ammount;

        $advance->save();

        $ledger=new LedgerManage($advance->employee->user_id);
        $ledger->addLedger('Advance Canceled',2,$tempamount,$date,'113',$advance->id);

        return response()->json(['status'=>'success']);
    }

    public function employeeDetail($id){

    }
}
