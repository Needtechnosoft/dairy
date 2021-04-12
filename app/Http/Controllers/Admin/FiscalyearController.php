<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fiscalyear;
use Illuminate\Http\Request;

class FiscalyearController extends Controller
{
    public function index(Request $request){
        if($request->isMethod('post')){
            // dd($request->all());
            $fiscal = new Fiscalyear();
            $fiscal->title = $request->title;
            $fiscal->s_date = $request->sdate;
            $fiscal->e_date = $request->edate;
            $fiscal->save();
            return view('admin.fiscal.single',compact('fiscal'));
        }else{
            return view('admin.fiscal.index');
        }
    }


    public function list(){
        $fiscals = Fiscalyear::all();
        return view('admin.fiscal.list',compact('fiscals'));
    }

    public function update(Request $request){
        $fiscal = Fiscalyear::where('id',$request->id)->first();
        $fiscal->title = $request->title;
        $fiscal->s_date = $request->sdate;
        $fiscal->e_date = $request->edate;
        $fiscal->save();
    }

    public function delete($id){
        // dd($id);
        $fiscal = Fiscalyear::where('id',$id)->first();
        $fiscal->delete();
    }

    public function makeDefault($id){
         $f = Fiscalyear::where('status',1)->first();
        if($f != null){
            $f->status = 0;
            $f->save();
        }
        Fiscalyear::where('id',$id)->update(['status'=>1]);
        return redirect()->back();
    }

}
