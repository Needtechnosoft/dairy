<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Snffat;
use Illuminate\Http\Request;

class SnffatController extends Controller
{
    public function index(){
        return view('admin.snf.index');
    }

    public function saveSnffatData(Request $request){
        $date = str_replace('-', '', $request->date);
        $checkData = Snffat::where(['date'=>$date,'user_id'=>$request->user_id,'center_id'=>$request->center_id])->first();
        if($checkData == null){
            $snffat = new Snffat();
            $snffat->snf = $request->snf;
            $snffat->fat = $request->fat;
            $snffat->date = $date;
            $snffat->user_id = $request->user_id;
            $snffat->center_id = $request->center_id;
            $snffat->save();
            return view('admin.snf.single',compact('snffat'));
        }else{
            $checkData->snf = $request->snf;
            $checkData->fat = $request->fat;
            $checkData->save();
            return response()->json($checkData);
        }
  
    }

    public function snffatDataLoad(Request $request){
        $date = str_replace('-', '', $request->date);
        $data = Snffat::where(['date'=>$date, 'user_id'=>$request->user_id, 'center_id'=>$request->center_id])->get();
        return view('admin.snf.dataload',['data'=>$data]);
    }

}
