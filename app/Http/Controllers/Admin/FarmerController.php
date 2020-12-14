<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\LedgerManage;
use App\Models\Advance;
use App\Models\User;
use Illuminate\Http\Request;

class FarmerController extends Controller
{
    public function index(){
        return view('admin.farmer.list');
    }

    public function addFarmer(Request $request){
        if($request->isMethod('post')){
            // dd($request->advance);
                $user = new User();
                $user->phone = $request->phone;
                $user->name = $request->name;
                $user->address = $request->address;
                $user->role = 1;
                $user->password = bcrypt($request->phone);
                $user->save();
                $manager=new LedgerManage($user->id);
                $manager->addLedger('Opening Balance',1,$request->advance,$request->date,'102');
                return view('admin.farmer.single',compact('user'));
                // return response()->json("Farmer Created successfully !");
        }else{
            return view('admin.farmer.add');
        }
    }

    public function listFarmer(){
        $farmers = User::latest()->where('role',1)->get();
        // return response()->json($farmers);
        return view('admin.farmer.list',['farmers'=>$farmers]);
    }


    public function updateFarmer(Request $request){
        $user = User::where('id',$request->id)->where('role',1)->first();
        $user->phone = $request->phone;
        $user->name = $request->name;
        $user->address = $request->address;
        $user->save();
        return view('admin.farmer.single',compact('user'));
    }

    public function deleteFarmer($id){
        $user = User::where('id',$id)->where('role',1)->first();
        $user->delete();
        return response()->json('Delete successfully !');
    }
}
