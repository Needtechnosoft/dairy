<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        return view('admin.supplier.index');
    }

    public function supplierList(){
        $supplier = User::latest()->where('role',3)->get();
        return view('admin.supplier.list',['supplier'=>$supplier]);
    }

    public function addSupplier(Request $request)
    {
        $user = new User();
        $user->phone = $request->phone;
        $user->name = $request->name;
        $user->address = $request->address;
        $user->role = 3;
        $user->password = bcrypt($request->phone);
        $user->save();
        return view('admin.supplier.single', compact('user'));
    }

    public function updateSupplier(Request $request){
        $user = User::where('id',$request->id)->where('role',3)->first();
        $user->phone = $request->phone;
        $user->name = $request->name;
        $user->address = $request->address;
        $user->role = 3;
        $user->password = bcrypt($request->phone);
        $user->save();
        return view('admin.supplier.single', compact('user'));
    }

    public function deleteSupplier($id){
        $user = User::where('id',$id)->where('role',3)->first();
        $user->delete();
        return response()->json('Delete successfully !');
    }
}
