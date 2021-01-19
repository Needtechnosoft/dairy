<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request){
        if($request->isMethod('post')){
            // dd($request->all());
            // dd($request->all());

            $request->validate([
                'phone' => 'required|numeric',
                'password' => 'required|string',

            ]);
            $phone=$request->phone;
            $password=$request->password;
            if (Auth::attempt(['phone' => $phone, 'password' => $password], true)) {
                   if(Auth::user()->role == 1){
                       return redirect()->route('user.dashboard');
                   }
                   if(Auth::user()->role == 2){
                      return redirect()->route('distributor.dashboard');
                   }
            }else{
                return redirect()->back()->withErrors('Credential do not match');
            }
        }else{
            return view('users.auth.login');
        }
    }
}
