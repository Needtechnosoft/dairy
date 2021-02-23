<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Expcategory;
use App\Models\Expense;
use App\NepaliDate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{

    // expe categories

    public function categoryIndex(){
        return view('admin.expense.category.index');
    }

    public function categoryAdd(Request $request){
        $expcat = new Expcategory();
        $expcat->name = $request->name;
        $expcat->save();
        return redirect()->back()->with('message','Category added successfully!');
    }

    public function categoryUpdate(Request $request){
        // dd($request->all());
        $expcat = Expcategory::where('id',$request->id)->first();
        $expcat->name = $request->name;
        $expcat->save();
        return redirect()->back()->with('message','Category updated successfully!');
    }

    public function categoryExpenses(Request $request){
        $exps = Expense::latest()->where('expcategory_id',$request->id)->get();
        return view('admin.expense.list',compact('exps'));
    }

    // expenses
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
        $exp->expcategory_id = $request->cat_id;
        $exp->user_id = Auth::user()->id;
        $exp->save();
        return view('admin.expense.single',compact('exp'));
    }

    public function editExpenses(Request $request){
        $date = str_replace('-','',$request->date);
        $exp = Expense::where('id',$request->id)->first();
        $exp->title = $request->title;
        $exp->amount = $request->amount;
        $exp->date = $date;
        $exp->payment_detail = $request->payment_detail;
        $exp->payment_by = $request->payment_by;
        $exp->remark = $request->remark;
        $exp->expcategory_id = $request->cat_id;
        $exp->user_id = Auth::user()->id;
        $exp->save();
        return view('admin.expense.single',compact('exp'));
    }

    public function listExpense(Request $request){
        $exps = Expense::latest()->get();
        return view('admin.expense.list',compact('exps'));
    }

    public function deleteExpense($id){
        $exp = Expense::find($id);
        $exp->delete();
    }

    public function loadExpense(Request $request){
        $range = [];
        $range=NepaliDate::getDateMonth($request->year,$request->month);
        // dd($range);
        $exps = Expense::latest()->where('date','>=',$range[1])->where('date','<=',$range[2])->get();
        return view('admin.expense.list',compact('exps'));

    }
}
