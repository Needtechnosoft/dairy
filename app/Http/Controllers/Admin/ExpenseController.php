<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    public function index(){
        return view('admin.expense.index');
    }

    public function addExpense(Request $request){
        $date = str_replace('-','',$request->date);
        $exp = new Expense();
        $exp->title = $request->title;
        $exp->amount = $request->amount;
        $exp->date = $date;
        $exp->payment_detail = $request->payment_detail;
        $exp->payment_by = $request->payment_by;
        $exp->remark = $request->remark;
        $exp->user_id = Auth::user()->id;
        $exp->save();
        return view('admin.expense.single',compact('exp'));
    }

    public function listExpense(){
        $exps = Expense::latest()->get();
        return view('admin.expense.list',compact('exps'));
    }

    public function deleteExpense($id){
        $exp = Expense::find($id);
        $exp->delete();
    }
}
