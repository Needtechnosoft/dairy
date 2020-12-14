<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\LedgerManage;
use App\Models\Advance;
use App\Models\Ledger;
use App\Models\User;
use Illuminate\Http\Request;

class AdvanceController extends Controller
{
    public function index(){
       return view('admin.farmer.advance.index');
    }

    public function addFormerAdvance(Request $request){
        $adv = new Advance();
        $adv->user_id = $request->user_id;
        $adv->amount = $request->amount;
        $adv->save();
        $ledger = new LedgerManage($request->user_id);
        $ledger->addLedger('Advance to Farmer',1,$request->amount,$request->date,'104',$adv->id);
        return view('admin.farmer.advance.single',compact('adv'));
    }

    public function listFarmerAdvance(){
        $advs = Advance::join('users','users.id','=','advances.user_id')->where('role',1)->select('advances.id','advances.user_id','advances.amount')->get();
        return view('admin.farmer.advance.list',compact('advs'));
    }


    public function updateFormerAdvance(Request $request){
        $adv = Advance::find($request->id);

    }



   public function deleteFarmerAdvance($id){
        $adv = Advance::find($id);
        $ledger = Ledger::where(['user_id' => $adv->user_id, 'identifire' => '104', 'foreign_key' => $adv->id])->first();
        $user = User::where('id',$adv->user_id)->first();
        $user->amount = $user->amount - $adv->amount;
        $user->save();
        $ledger->delete();
        $adv->delete();
    }
}
