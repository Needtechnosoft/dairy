<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseInvoiceItem extends Model
{
    use HasFactory;

    public function purchaseInvoice(){
        return $this->belongsTo(PurchaseInvoice::class);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function expireAlert(){
            $exp_info = Product::where('id',$this->product_id)->first();
            $date = Carbon::parse($this->expire_date);
            $currentDate = Carbon::now()->format('Y-m-d');
            $diff = $date->diffInDays($currentDate);
            if($diff <= $exp_info->expire_alert ){
                return true;
            }else{
                return false;
            }
    }

}
