<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(){
        $products=Product::all();
        return view('admin.products.index',compact('products'));
    }

    public function add(Request $request){
        $product=new Product();
        $product->name=$request->name;
        $product->price=$request->price;
        $product->unit=$request->unit;
        $product->image='';
        $product->minqty=0;
        $product->desc='';
        $product->stock=0;
        $product->save();
        return view('admin.products.single',compact('product'));
    }

    public function update(Request $request){
        $product=Product::find($request->id);
        $product->name=$request->name;
        $product->price=$request->price;
        $product->unit=$request->unit;
        $product->image='';
        $product->minqty=0;
        $product->desc='';
        $product->stock=0;
        $product->save();
        return response('ok');
    }

    public function del(Request $request){
        $product=Product::find($request->id);
        $product->delete();
        return response('ok');

    }

}
