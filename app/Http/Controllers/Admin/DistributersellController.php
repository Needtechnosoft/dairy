<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\LedgerManage;
use App\Models\Distributer;
use App\Models\Distributorsell;
use App\Models\Ledger;
use App\Models\User;
use Illuminate\Http\Request;

class DistributersellController extends Controller
{
    public function index(){
        return view('admin.distributer.sell.index');
    }

    public function addDistributersell(Request $request){
        $date = str_replace('-','',$request->date);
        $sell = new Distributorsell();
        $sell->distributer_id = $request->user_id;
        $sell->date = $date;
        $sell->rate = $request->rate;
        $sell->qty = $request->qty;
        $sell->total = $request->total;
        $sell->paid = $request->paid;
        $sell->deu = $request->due;
        $sell->save();
        $user = Distributer::where('id',$request->user_id)->first();
        $ledger = new LedgerManage($user->user_id);
        $ledger->addLedger('Sold to distributer ('.$request->rate .' X '.$request->qty.')',1,$request->total,$date,'105',$sell->id);
        if($request->paid >0){
            $ledger->addLedger('Paid amount received',2,$request->paid,$date,'105',$sell->id);
        }
        return view('admin.distributer.sell.single',compact('sell'));
    }

    public function listDistributersell(Request $r){
        $date = str_replace('-','',$r->date);
        $sells = Distributorsell::where('date',$date)->get();
        return view('admin.distributer.sell.list',compact('sells'));
    }

    public function deleteDistributersell($id){
        $sell = Distributorsell::find($id);
        $sell->delete();
        Ledger::where('foreign_key',$id)->delete();
    }



}
