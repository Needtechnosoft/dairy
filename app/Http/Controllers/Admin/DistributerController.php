<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Distributer;
use App\Models\Distributorsell;
use App\Models\Ledger;
use App\Models\User;
use App\NepaliDate;
use Illuminate\Http\Request;

class DistributerController extends Controller
{
    public function index(){
        return view('admin.distributer.index');
    }

    public function addDistributer(Request $request){
        $user = new User();
        $user->phone = $request->phone;
        $user->name = $request->name;
        $user->address = $request->address;
        $user->role = 2;
        $user->password = bcrypt($request->phone);
        $user->save();
        $dis = new Distributer();
        $dis->user_id = $user->id;
        $dis->rate = $request->rate??0;
        $dis->amount = $request->amount??0;
        $dis->save();
        return view('admin.distributer.single',compact('user'));
    }

    public function DistributerList(){
        $distributer = User::latest()->where('role',2)->get();
        return view('admin.distributer.list',compact('distributer'));
    }

    public function updateDistributer(Request $request){
        $user = User::where('id',$request->id)->where('role',2)->first();
        $user->phone = $request->phone;
        $user->name = $request->name;
        $user->address = $request->address;
        $user->role = 2;
        $user->password = bcrypt($request->phone);
        $user->save();
        $dis = Distributer::where('user_id',$user->id)->first();
        $dis->rate = $request->rate??0;
        $dis->amount = $request->amount??0;
        $dis->save();
        return view('admin.distributer.single',compact('user'));

    }

    public function distributerDetail($id){
        $user = User::where('id',$id)->where('role',2)->first();
        return view('admin.distributer.detail',compact('user'));
    }

    public function distributerDetailLoad(Request $r){
        $range=NepaliDate::getDate($r->year,$r->month,$r->session);
        $ledger = Ledger::where('user_id',$r->user_id)->where('date','>=',$range[1])->where('date','<=',$range[2])->orderBy('ledgers.id','asc')->get();
        $d = Distributer::where('user_id',$r->user_id)->first();
        $sell = Distributorsell::where('distributer_id',$d->id)->where('date','>=',$range[1])->where('date','<=',$range[2])->get();
        return view('admin.distributer.data',compact('ledger','sell'));

    }

    public function DistributerDelete($id){
        $user = User::where('id',$id)->where('role',2)->first();
        $user->delete();
    }
}
