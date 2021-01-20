<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DistributorDashboardController extends Controller
{
    public function index(){
        return view('users.distributor.index');
    }

    public function changePassword(Request $request){
        $request->validate([
            'n_pass' =>'required|min:8'
            ],
            [
            'n_pass.min' => 'Password should be at least 8 characters !'
        ]);
        $user = User::where('id',Auth::user()->id)->where('role',2)->first();
       if(Hash::check($request->c_pass, $user->password)){
          $user->password = bcrypt($request->n_pass);
          $user->save();
          return redirect()->back()->with('message','Password changed successfully !');
       }else{
        return redirect()->back()->with('message_danger','Current password does not matched !');
       }
    }
}
