<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Distributorsell;
use Illuminate\Http\Request;

class DistributorPaymentController extends Controller
{
    public function index(){
        return view('admin.distributer.payment.index');
    }

    public function due(Request $request){
        $bills=Distributorsell::where('distributer_id',$request->id)->where('deu','>',0)->get();
        return view('admin.distributer.payment.data',compact('bills'));
    }
}
