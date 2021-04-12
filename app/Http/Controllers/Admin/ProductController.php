<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCat;
use App\Models\ProductPurchase;
use App\Models\ProductPurchaseItem;
use App\Models\PurchaseInvoiceItem;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\FuncCall;

class ProductController extends Controller
{
    public function index(){
        $products=Product::all();
        return view('admin.products.index',compact('products'));
    }

    public function add(Request $request){
        // dd($request->all());
        $product=new Product();
        $product->product_cat_id = $request->category_id;

        $product->name=$request->name;
        $product->price=0;
        $product->cost_price = $request->costprice;
        $product->selling_price = $request->sellprice;
        $product->wholesale_rate = $request->wholesaleprice;
        $product->barcode = $request->barcode;
        $product->sku = $request->sku;
        $product->alertqty = $request->alertqty;
        $product->expire_alert = $request->expiredays;
        $product->unit=$request->unit;
        $product->image='';
        $product->minqty=0;
        $product->desc='';

        if($request->has('onsale')){
            $product->onsale = 1;
        }

        if($request->has('hasdiscount')){
            $product->hasdiscount =1;
            if($request->discount_type == 1){
                $product->discount_type = 1;
                $product->discount = $request->dis_value;
                $product->minqty = $request->minqty;
                $product->maxqty = $request->maxqty;
            }else{
                $product->discount_type = 2;
                $product->discount_percentage = $request->dis_value;
                $product->minqty = $request->minqty;
                $product->maxqty = $request->maxqty;
            }
        }

        if($request->has('single_batch')){
            $product->stock= $request->stock;
        }else{
            $product->batch_type = 1;
            $product->stock = 0;
        }

        $product->save();
        return view('admin.products.single',compact('product'));
    }

    public function edit($id){
        $product = Product::where('id',$id)->first();
        return view('admin.products.edit',compact('product'));
    }

    public function update(Request $request, $id){
        // dd($request->all());
        $product=Product::find($id);
        $product->product_cat_id = $request->category_id;

        $product->name=$request->name;
        $product->price=0;
        $product->cost_price = $request->costprice;
        $product->selling_price = $request->sellprice;
        $product->wholesale_rate = $request->wholesaleprice;
        $product->barcode = $request->barcode;
        $product->sku = $request->sku;
        $product->alertqty = $request->alertqty;
        $product->expire_alert = $request->expiredays;
        $product->unit=$request->unit;
        $product->image='';
        $product->minqty=0;
        $product->desc='';

        if($request->has('onsale')){
            $product->onsale = 1;
        }

        if($request->has('hasdiscount')){
            $product->hasdiscount =1;
            if($request->discount_type == 1){
                $product->discount_type = 1;
                $product->discount = $request->dis_value;
                $product->minqty = $request->minqty;
                $product->maxqty = $request->maxqty;
            }else{
                $product->discount_type = 2;
                $product->discount_percentage = $request->dis_value;
                $product->minqty = $request->minqty;
                $product->maxqty = $request->maxqty;
            }
        }else{
                $product->hasdiscount =0;
                $product->discount_type = 0;
                $product->discount = 0;
                $product->minqty = 0;
                $product->maxqty = 0;
        }
        if($request->has('single_batch')){
            $product->stock= $request->stock;
            $product->batch_type = 0;
        }else{
            $product->batch_type = 1;
        }
        $product->save();
    }



    public function del(Request $request){
        $product=Product::find($request->id);
        $product->delete();
        return response('ok');
    }


    // product purchase
    public function productPurchase(){
        return view('admin.products.purchase.index');
    }

    // public function productPurchaseStore(Request $request){
    //     // dd($request->all());
    //     $date = str_replace('-','',$request->date);
    //     $purchase = new ProductPurchase();
    //     $purchase->billno = $request->billno;
    //     $purchase->total = $request->gtotal;
    //     $purchase->date = $date;
    //     $purchase->save();
    //     $traker = explode(',',$request->counter);

    //     foreach ($traker as  $value) {
    //         $item = new ProductPurchaseItem();
    //         $item->product_purchase_id = $purchase->id;
    //         // dd($request->input("productid_".$value));
    //         $item->title = $request->input('productname_'.$value);
    //         $item->rate = $request->input('rate_'.$value);
    //         $item->product_id = $request->input("productid_".$value);
    //         $item->qty = $request->input('qty_'.$value);
    //         $item->save();
    //             $stock = Product::where('id',$request->input("productid_".$value))->first();
    //             $stock->stock += $request->input('qty_'.$value);
    //             $stock->save();
    //     }
    //     return redirect()->back()->with('message','Purchase item added successfully !');
    // }

    public function categoryIndex(){
        return view('admin.products.category.index');
    }

    public function categorySave(Request $request){
        // dd($request->all());
        $cat = new ProductCat();
        $cat->name = $request->title;
        $cat->save();
        return view('admin.products.category.single',compact('cat'));
    }

    public function categoryList(){
        $cat = ProductCat::latest()->get();
        return view('admin.products.category.list',compact('cat'));
    }

    public function categoryUpdate(Request $request){
        $cat = ProductCat::where('id',$request->id)->first();
        $cat->name = $request->title;
        $cat->save();
    }

    public function categoryDelete($id){
        $cat = ProductCat::where('id',$id)->first();
        $cat->delete();
    }


    public function manageBatch($id){
        $batchItem = PurchaseInvoiceItem::where('product_id',$id)->get();
        // dd($batchItem);
        return view('admin.products.batch',compact('batchItem'));
    }

}
