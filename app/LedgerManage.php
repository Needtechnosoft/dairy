<?php
namespace App;
use App\Models\User;

class LedgerManage{
    public  $user;

    public function  __construct($user_id){
        $this->user=User::find($user_id);
    }

    /*
    *amounttype[1="CR",2="DR"]
    * "101"= Aalya
    * "102"= "farmer opening balance/advance"
    * "103" = "item sell"
    * "104" = "Farmer Advance"
    * "105" = "Sold to distributer"
    * "106" = "Farmer amount paid at Selling item"
    * "107" = "Due amount paid by farmer"
    * "108" = "Famer milk Money Adjustment"
    * "109" = "Money given to farmer"
    * "110" = "farmer closing Balance"
    * "111" = "Distributor Payment"
    * "112" = "Employee Advaance payment"
    * "113" = "Employee Advaance payment cancel"

    */
    public function addLedger($particular, $type,$amount,$date,$identifier,$foreign_id=null){
        $nepalidate=new NepaliDate($date);
        $_amount=$this->user->amount;
        $amounttype=$this->user->amounttype??1;

        if($amounttype==1){
            $_amount=-1*$_amount;
        }

        if($type==1){
            $_amount-=$amount;

        }else{
            $_amount+=$amount;
        }

        $l=new \App\Models\Ledger();
        $l->amount = $amount;
        $l->title = $particular;
        $l->date = $date;
        $l->identifire = $identifier;
        $l->foreign_key = $foreign_id;
        $l->user_id = $this->user->id;
        $l->year = $nepalidate->year;
        $l->month = $nepalidate->month;
        $l->session = $nepalidate->session;
        $l->type = $type;
        $t=1;

        if($_amount>0){
            $t=2;
            $l->dr=$_amount;
        }else if($_amount<0){
            $t=1;
            $_amount=-1*$_amount;
            $l->cr=$_amount;
        }


        $this->user->amount=$_amount;
        $this->user->amounttype=$t;
        $this->user->save();
        $l->save();
        return $l;
    }



}
