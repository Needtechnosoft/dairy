<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Daymgmt;
use App\Models\Fiscalyear;
use Illuminate\Http\Request;

class DaymgmtController extends Controller
{
    public function index(Request $request){
        if($request->isMethod('post')){
            // dd($request->all());
            $day = new Daymgmt();
            $day->date = $request->date;
            $day->fiscalyear_id = $request->fiscalyear;
            $day->save();
            return view('admin.daymgmt.single',compact('day'));
        }else{
            return view('admin.daymgmt.index');
        }
    }

    public function list(){
        $days = Daymgmt::latest()->get();
        return view('admin.daymgmt.list',compact('days'));
    }

    public function update(Request $request){
        $day = Daymgmt::where('id',$request->id)->first();
        $fiscal = Fiscalyear::where('status',1)->first();
        $day->fiscalyear_id = $fiscal->id;
        $day->date = $request->date;
        $day->save();
    }

    public function delete($id){
        $day = Daymgmt::where('id',$id)->first();
        $day->delete();
    }

    public function dayOpen($id){
        $f = Daymgmt::where('status',1)->first();
       if($f != null){
           $f->status = 0;
           $f->save();
       }
       Daymgmt::where('id',$id)->update(['status'=>1,'isopen'=>1]);
       return redirect()->back();
   }

}
