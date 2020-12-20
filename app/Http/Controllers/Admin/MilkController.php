<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\LedgerManage;
use App\Models\Milkdata;
use App\Models\User;
use Illuminate\Http\Request;

class MilkController extends Controller
{
    public function index(){
        return view('admin.milk.index');
    }

    public function saveMilkData(Request $request,$type){
        // dd($request->all());
        $actiontype=0;
        $date = str_replace('-', '', $request->date);
        $user = User::join('farmers','users.id','=','farmers.user_id')->where('users.no',$request->user_id)->where('farmers.center_id',$request->center_id)->select('users.*','farmers.center_id')->first();
        // $user=User::where('no',$request->user_id)->first();
        // dd($user,$request);
        if($user==null ){
            return response("Farmer Not Found",400);
        }else{
            if($user->no==null){
            return response("Farmer Not Found",500);

            }
        }

        $milkData=Milkdata::where('user_id',$user->id)->where('date',$date)->first();

        if($milkData==null){
            $milkData = new Milkdata();
            $milkData->date = $date;
            $milkData->user_id = $user->id;
            $milkData->center_id = $request->center_id;
            $actiontype=1;
        }

        //request->type 1=save/replace type=2 add

        if($request->session == 0){
            if($type==0){

                $milkData->m_amount = $request->milk_amount;
            }else{
                $milkData->m_amount += $request->milk_amount;
            }
        }else{
            if($type==0){
                $milkData->e_amount = $request->milk_amount;
            }else{
                $milkData->e_amount += $request->milk_amount;
            }
        }
        $milkData->save();
        $milkData->no=$user->no;
        if($actiontype==1){
            return view('admin.milk.single',['d'=>$milkData]);
        }else{
            return response()->json($milkData->toArray());
        }
    }

    public function milkDataLoad(Request $request){
        $date = str_replace('-', '', $request->date);
        $milkData = Milkdata::where(['date'=>$date,'center_id'=>$request->center_id])->get();
        return view('admin.milk.dataload',['milkdatas'=>$milkData]);
    }

    public function loadFarmerData(Request $request){
        $farmers = User::join('farmers','farmers.user_id','=','users.id')->where('farmers.center_id',$request->center)->where('users.role',1)->select('users.*','farmers.center_id')->get();
        return view('admin.farmer.minlist',compact('farmers'));
    }

}
