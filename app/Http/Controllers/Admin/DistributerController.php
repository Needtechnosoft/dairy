<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Distributer;
use App\Models\User;
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
        $dis->rate = $request->rate;
        $dis->amount = $request->amount;
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
        $dis->rate = $request->rate;
        $dis->amount = $request->amount;
        $dis->save();
        return view('admin.distributer.single',compact('user'));

    }

    public function DistributerDelete($id){
        $user = User::where('id',$id)->where('role',2)->first();
        $user->delete();
    }
}
