<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fiscalyear;
use App\Models\Product;
use App\Models\PurchaseExpense;
use App\Models\PurchaseInvoice;
use App\Models\PurchaseInvoiceItem;
use App\NepaliDate;
use Illuminate\Http\Request;

class PurchaseinvoiceController extends Controller
{
    public function index(){
        return view('admin.products.purchase.invoice');
    }

    public function store(Request $request){
        // dd($request->all());
        $date = str_replace('-','',$request->date);
        $invoice = new PurchaseInvoice();
        $invoice->date = $date;
        $invoice->bill_no = $request->billno;
        $invoice->transaction_mode = "";
        $invoice->supplier_id = $request->supplier_id;
        $invoice->gross_total = $request->gtotal;
        $invoice->net_total = $request->nettotal;
        $invoice->discount = $request->discount;
        $invoice->tax = $request->tax;
        $invoice->due = $request->due;
        $invoice->paid = $request->payment;
        $invoice->taxable_amount = $request->taxable;
        $fis = Fiscalyear::where('status',1)->first();
        $invoice->fiscalyear_id = $fis->id;
        $invoice->save();

        $tracker = explode(',',$request->counter);
        foreach ($tracker as  $value) {
            $item = new PurchaseInvoiceItem();
            $item->purchase_invoice_id = $invoice->id;
            $item->product_id = $request->input("productid_".$value);
            $item->rate = $request->input('rate_'.$value);
            $item->qty = $request->input('qty_'.$value);
            $item->date = $date;
            $item->expire_date = $request->input('exp_date_'.$value);
                $stock = Product::where('id',$request->input("productid_".$value))->first();
                $item->old_stock = $stock->stock;
                $item->save();
                $stock->stock += $request->input('qty_'.$value);
                $stock->batch_type = 1;
                $stock->save();
        }

        if($request->has('exp_status')){
            $conter = explode(',',$request->exp_counter);
            foreach($conter as $value){
                $exp = new PurchaseExpense();
                $exp->title = $request->input('exp_title_'.$value);
                $exp->amount = $request->input('exp_amount_'.$value);
                $exp->purchase_invoice_id = $invoice->id;
                $exp->save();
            }

        }
        return redirect()->back()->with('message','Purchase invoice addedd successfully!');
    }

    public function list(){
        $invoices = PurchaseInvoice::latest()->get();
        return view('admin.products.purchase.list')->with(compact('invoices'));
    }

    public function invoiceItems($id){
        $items = PurchaseInvoiceItem::where('purchase_invoice_id',$id)->get();
        return view('admin.products.purchase.invoiceitem',compact('items'));
    }

    public function purchaseExpense($id){
        $expense = PurchaseExpense::where('id',$id)->get();
        return view('admin.products.purchase.expense',compact('expense'));
    }


    public function filterData(Request $request){
        $type = $request->type;
        $range=[];
        $invoice = PurchaseInvoice::latest();
       if($type==1){

            $date=$date = str_replace('-','',$request->date1);
            $invoice=$invoice->where('date','=',$date);

        }elseif($type==2){

            $range=NepaliDate::getDateWeek($request->year,$request->month,$request->week);
            $invoice=$invoice->where('date','>=',$range[1])->where('date','<=',$range[2]);

        }elseif($type==3){

            $range=NepaliDate::getDateMonth($request->year,$request->month);
            $invoice=$invoice->where('date','>=',$range[1])->where('date','<=',$range[2]);

        }elseif($type==4){

            $range=NepaliDate::getDateYear($request->year);
            $invoice=$invoice->where('date','>=',$range[1])->where('date','<=',$range[2]);

        }elseif($type==5){
            $range[1]=str_replace('-','',$request->date1);;
            $range[2]=str_replace('-','',$request->date2);;
            $invoice=$invoice->where('date','>=',$range[1])->where('date','<=',$range[2]);
        }

        $data = $invoice->get();
        return view('admin.products.purchase.data',compact('data'));
    }
}
