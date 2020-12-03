<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Milkdata;
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
        $milkData=Milkdata::where('user_id',$request->user_id)->where('date',$date)->first();
        
        if($milkData==null){
            $milkData = new Milkdata();
            $milkData->date = $date;
            $milkData->user_id = $request->user_id;
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

}
