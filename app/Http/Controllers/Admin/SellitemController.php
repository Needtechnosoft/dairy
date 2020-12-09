<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Sellitem;
use Illuminate\Http\Request;

class SellitemController extends Controller
{
    public function index(){
        return view('admin.sellitem.index');
    }

    public function addSellItem(Request $request){
        $date = str_replace('-','',$request->date);
        $sell_item = new Sellitem();
        $sell_item->total = $request->total;
        $sell_item->qty = $request->qty;
        $sell_item->rate = $request->rate;
        $sell_item->due = $request->due;
        $sell_item->paid = $request->paid;
        $sell_item->user_id = $request->user_id;
        $item_id = Item::where('number',$request->number)->first();
        $sell_item->item_id = $item_id->id;
        $sell_item->date = $date;
        $sell_item->save();
        return view('admin.sellitem.single',compact('sell_item'));
    }

    public function sellItemList(){
        $sell = Sellitem::all();
        return view('admin.sellitem.list',compact('sell'));
    }
}
