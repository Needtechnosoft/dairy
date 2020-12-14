<?php
namespace App;
use App\Models\User;

class LedgerManage{
    private  $user;

    public function  __construct($user_id){
        $this->user=User::find($user_id);
    }

    /*
    *amounttype[1="CR",2="DR"]
    * "101"= Aalya
    * "102"= "farmer opening balance/advance"
    * "103" = "item sell"
    * "104" = "Farmer Advance"
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
