<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    //
    public function index(){
        $items = Item::latest()->get();
        return view('admin.item.index',compact('items'));
    }


    public function saveItems(Request $request){
        $item = new Item();
        $item->title = $request->name;
        $item->cost_price = $request->cost_price;
        $item->sell_price = $request->sell_price;
        $item->stock = $request->stock;
        $item->unit = $request->unit;
        $item->save();
        return view('admin.item.single',compact('item'));
    }

    public function updateItem(Request $request){
        $item = Item::where('id',$request->id)->first();
        $item->title = $request->name;
        $item->cost_price = $request->cost_price;
        $item->sell_price = $request->sell_price;
        $item->stock = $request->stock;
        $item->unit = $request->unit;
        $item->save();
        return view('admin.item.single',compact('item'));
    }

    public function deleteItem($id){
        $item = Item::find($id);
        $item->delete();
    }
}
