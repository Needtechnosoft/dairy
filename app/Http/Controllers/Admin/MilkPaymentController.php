<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\LedgerManage;
use App\Models\MilkPayment;
use App\Models\User;
use Illuminate\Http\Request;

class MilkPaymentController extends Controller
{
    public function index(Request $request){
        if($request->getMethod()=="POST"){
            $payments=MilkPayment::join('users','users.id','milk_payments.user_id')->where(
                [
                    'milk_payments.session'=>$request->session,
                    'milk_payments.center_id'=>$request->center_id,
                    'milk_payments.year'=>$request->year,
                    'milk_payments.month'=>$request->month,
                ])->select('milk_payments.*','users.no','users.name')->get();
            // dd($payments);
            return view('admin.milk.payment.list',compact('payments'));
        }else{
            return view('admin.milk.payment.index');
        }
    }

    public function add(Request $request){

        $date = str_replace('-', '', $request->date);

        $user = User::join('farmers','users.id','=','farmers.user_id')->where('users.no',$request->no)->where('farmers.center_id',$request->center_id)->select('users.name','users.id','users.no','farmers.center_id')->first();
        $payment=new MilkPayment();
        $payment->session=$request->session;
        $payment->year=$request->year;
        $payment->month=$request->month;
        $payment->center_id=$request->center_id;
        $payment->amount=$request->amount;
        $payment->user_id=$user->id;
        $payment->save();
        $payment->name=$user->name;
        $payment->no=$user->no;
        $ledger=new LedgerManage($user->id);
        $ledger->addLedger('Payment For Milk',1,$request->amount,$date,'109',$payment->id);
        return view('admin.milk.payment.single',compact('payment'));
    }

    public function update(Request $request){
        $date = str_replace('-', '', $request->date);
        $payment=MilkPayment::find($request->id);
        $oldamount=$payment->amount;

        $payment->amount=$request->amount;
        $payment->save();

        $ledger=new LedgerManage($payment->user_id);
        $ledger->addLedger('Payment For Milk canceled',2,$oldamount,$date,'108',$payment->id);
        $ledger->addLedger('Payment For Milk',1,$request->amount,$date,'109',$payment->id);
        return response('ok');
    }
}
