<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Counter;
use Illuminate\Http\Request;

class CounterController extends Controller
{
    public function index(Request $request){
        if($request->isMethod('post')){
            // dd($request->all());
            $counter = new Counter();
            $counter->name = $request->title;
            $counter->save();
            return view('admin.counter.single',compact('counter'));
        }else{
            return view('admin.counter.index');
        }
    }

    public function list(){
        $counter = Counter::latest()->get();
        return view('admin.counter.list',compact('counter'));
    }

    public function update(Request $request){
        $counter = Counter::where('id',$request->id)->first();
        $counter->name = $request->title;
        $counter->save();
    }

    public function delete($id){
        $counter = Counter::where('id',$id)->first();
        $counter->delete();
    }

    public function counterActive($id){
        $counter = Counter::where('id',$id)->first();
        $counter->status = 1;
        $counter->save();
        return redirect()->back();
    }

    public function counterInactive($id){
        $counter = Counter::where('id',$id)->first();
        $counter->status = 0;
        $counter->save();
        return redirect()->back();
    }
}
