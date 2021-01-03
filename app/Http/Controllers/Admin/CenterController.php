<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Center;
use Illuminate\Http\Request;

class CenterController extends Controller
{
    public function index(Request $request){
            return view('admin.center.index',['centers'=>Center::latest()->get()]);
    }

    public function addCollectionCenter(Request $request){
        $center = new Center();
        $center->name = $request->name;
        $center->addresss = $request->address;
        $center->fat_rate = $request->fat_rate;
        $center->cc = $request->cc;
        $center->tc = $request->tc;
        $center->snf_rate = $request->snf_rate;
        $center->bonus = $request->bonus??0;
        $center->save();
        return view('admin.center.single')->with(compact('center'));
    }

    public function updateCollectionCenter(Request $request){
        // dd($request->all());
        $center = Center::where('id',$request->id)->first();
        $center->name = $request->name;
        $center->addresss = $request->address;
        $center->fat_rate = $request->fat_rate;
        $center->snf_rate = $request->snf_rate;
        $center->cc = $request->cc;
        $center->tc = $request->tc;
        $center->bonus = $request->bonus??0;
        $center->save();
        return view('admin.center.single')->with(compact('center'));
    }

    public function listCenter(){
        $centers = Center::latest()->get();
        return response()->json($centers);
        // return view('admin.center.list',compact('centers'));
    }

    public function deleteCenter($id){
        $center = Center::where('id',$id)->first();
        $center->delete();
    }
}
