<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\LedgerManage;
use App\Models\Item;
use App\Models\Sellitem;
use App\Models\User;
use Illuminate\Http\Request;

class SellitemController extends Controller
{
    public function index(){
        return view('admin.sellitem.index');
    }

    public function addSellItem(Request $request){
        $date = str_replace('-','',$request->date);
        $item_id = Item::where('number',$request->number)->first();
        if($item_id->stock>0){
            $item_id->stock = $item_id->stock - 1;

            $sell_item = new Sellitem();
            $sell_item->total = $request->total;
            $sell_item->qty = $request->qty;
            $sell_item->rate = $request->rate;
            $sell_item->due = $request->due;
            $sell_item->paid = $request->paid;
            $user = User::where('no',$request->user_id)->first();
            $sell_item->user_id = $user->id;
            $sell_item->item_id = $item_id->id;
            $sell_item->date = $date;
            $item_id->save();
            $sell_item->save();
            $manager=new LedgerManage($user->id);
            $manager->addLedger($item_id->title.'('.$sell_item->rate.'x'.$sell_item->qty.')',1,$request->total,$date,'103',$sell_item->id);
            if($request->paid>0){
                $manager->addLedger('Paid amount',2,$request->paid,$date,'103',$sell_item->id);
            }
            return view('admin.sellitem.single',compact('sell_item'));
        }else{
            return response()->json('Item Stok is not available');
        }
        // LedgerManage::addLedger('Sell Item', 1,$request->total,$date,'101');
    }

    public function updateSellItem(Request $request){
        $date = str_replace('-','',$request->date);
        $sell_item = Sellitem::where('id',$request->id)->first();
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

    public function sellItemList(Request $request){
        $date = str_replace('-','',$request->date);
        $sell = Sellitem::where('date',$date)->get();
        return view('admin.sellitem.list',compact('sell'));
    }

    public function deleteSellitem($id){
        $sell = Sellitem::find($id);
        $sell->delete();
    }
}
