<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\LedgerManage;
use App\Models\Advance;
use App\Models\Milkdata;
use App\Models\Sellitem;
use App\Models\Snffat;
use App\Models\User;
use App\NepaliDate;
use Illuminate\Http\Request;

class FarmerController extends Controller
{
    public function index(){
        return view('admin.farmer.list');
    }

    public function addFarmer(Request $request){
        if($request->isMethod('post')){
            // dd($request->advance);

                $max=User::max('no')??0;
                $user = new User();
                $user->phone = $request->phone;
                $user->name = $request->name;
                $user->address = $request->address;
                $user->role = 1;
                $user->password = bcrypt($request->phone);
                $user->no=$max+1;
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

    public function farmerDetail($id){
        $user = User::where('id',$id)->where('role',1)->first();
        return view('admin.farmer.detail',compact('user'));
    }

    public function loadDate(Request $r){
        $range=NepaliDate::getDate($r->year,$r->month,$r->session);
        $sellitem = Sellitem::where('user_id',$r->user_id)->where('date','>=',$range[1])->where('date','<=',$range[2])->get();
        $milkData = Milkdata::where('user_id',$r->user_id)->where('date','>=',$range[1])->where('date','<=',$range[2])->get();
        $snfFats = Snffat::where('user_id',$r->user_id)->where('date','>=',$range[1])->where('date','<=',$range[2])->get();
        $snfAvg = Snffat::where('user_id',$r->user_id)->where('date','>=',$range[1])->where('date','<=',$range[2])->avg('snf');
        $fatAvg = Snffat::where('user_id',$r->user_id)->where('date','>=',$range[1])->where('date','<=',$range[2])->avg('fat');
        return view('admin.farmer.alldata',compact('sellitem','milkData','milkData','snfFats','snfAvg','fatAvg'));
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
