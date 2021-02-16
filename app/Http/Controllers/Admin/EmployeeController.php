<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\LedgerManage;
use App\Models\Employee;
use App\Models\EmployeeAdvance;
use App\Models\Ledger;
use App\Models\SalaryPayment;
use App\Models\User;
use App\NepaliDate;
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
        $tempamount=$advance->amount;
        $advance->amount=$request->amount;
        $advance->save();
        $ledger=new LedgerManage($advance->employee->user_id);
        $ledger->addLedger('Advance Canceled',2,$tempamount,$date,'113',$advance->id);
        $ledger->addLedger('Advance Updated',1,$request->amount,$date,'112',$advance->id);
        return response()->json(['status'=>'success']);
    }

    public function delAdvance(Request $request){
        $date = str_replace('-','', $request->date);

        $advance=EmployeeAdvance::find($request->id);
        $tempamount=$advance->amount;
        $advance->delete();
        $ledger=new LedgerManage($advance->employee->user_id);
        $ledger->addLedger('Advance Canceled',2,$tempamount,$date,'113',$advance->id);
        return response()->json(['status'=>'success']);
    }

    public function employeeDetail($id){
        $user = User::where('id',$id)->where('role',4)->first();
        return view('admin.emp.detail',compact('user'));
    }

    public function loadEmployeeData(Request $request){
        $range=[];
        // dd($request->all());
        $salary = SalaryPayment::where('user_id',$request->user_id);
        $employee = EmployeeAdvance::join('employees','employees.id','=','employee_advances.employee_id')->where('employees.user_id',$request->user_id);
        if($request->type == 1){
            $range=NepaliDate::getDateYear($request->year);
            $employee = $employee->where('employee_advances.date','>=',$range[1])->where('employee_advances.date','<=',$range[2])->get();
            $salary = $salary->where('year',$request->year)->get();
        }
        if($request->type == 2){
            $range=NepaliDate::getDateMonth($request->year,$request->month);
            $employee = $employee->where('employee_advances.date','>=',$range[1])->where('employee_advances.date','<=',$range[2])->get();
            $salary = $salary->where('year',$request->year)->where('month',$request->month)->get();
        }
        return view('admin.emp.data',compact('salary','employee'));

    }

    // employee salary pay

    public function salaryIndex(){
        return view('admin.emp.salarypay.index');
    }

    public function loadEmpData(Request $request){
        // dd($request->all());
        $range=[];
        $employee = EmployeeAdvance::join('employees','employees.id','=','employee_advances.employee_id')->where('employees.id',$request->emp_id);
        // dd($employee->count());
        $salary = Employee::where('id',$request->emp_id)->select('salary')->first();
        if($employee->count()>0){
            $range=NepaliDate::getDateMonth($request->year,$request->month);
            $employee = $employee->where('employee_advances.date','>=',$range[1])->where('employee_advances.date','<=',$range[2])->get();
            // dd($employee);
            return view('admin.emp.salarypay.data',compact('employee','salary'));
        }else{
            $salary = Employee::where('id',$request->emp_id)->select('salary')->first();
            $employee=[];
            return view('admin.emp.salarypay.data',compact('employee','salary'));
        }

    }

    public function storeSalary(Request $request){
        // dd($request->all());
        $date = str_replace('-','',$request->date);
        $employee = Employee::where('id',$request->emp_id)->first();
        $checkUser = SalaryPayment::where('year',$request->year)->where('month',$request->month)->where('user_id',$employee->user_id)->count();
        if($checkUser>0){
            echo 'notok';
        }else{
            $salaryPay = new SalaryPayment();
            $salaryPay->date = $date;
            $salaryPay->year = $request->year;
            $salaryPay->month = $request->month;
            $salaryPay->amount = $request->pay;
            $salaryPay->payment_detail = $request->desc;
            $salaryPay->user_id = $employee->user_id;
            $salaryPay->save();
            $ledger=new LedgerManage($employee->user_id);
            $ledger->addLedger('Salary Paid',1,$request->pay,$date,'124',$salaryPay->id);
            echo 'ok';
        }
    }

    public function paidList(Request $request){
        // dd($request->all());
        if($request->emp_id != -1 ){
            $employee = Employee::where('id',$request->emp_id)->first();
            $salary = SalaryPayment::where('year',$request->year)->where('month',$request->month)->where('user_id',$employee->user_id)->get();
        }else{
            $salary = SalaryPayment::where('year',$request->year)->where('month',$request->month)->get();
        }
        return view('admin.emp.salarypay.list',compact('salary'));
    }
}
