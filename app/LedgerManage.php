<?php
namespace App;

use App\Models\Distributorsell;
use App\Models\Ledger;
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
    * "106" = "Farmer amount paid at Selling item"
    * "107" = "Due amount paid by farmer"
    * "108" = "Famer milk Money Adjustment"
    * "109" = "Money given to farmer"
    * "110" = "farmer closing Balance"
    * "116" = "Farmer item return"
    * "117" = "Farmer item return paid cancel"

    * "105" = "Sold to distributer"
    * "114" = "distributer Payment"
    * "115" = "distributer sell cancel"
    * "118" = "Account Adjustment"
    * "119" = "Distributor opening balance"
    * "120" = ""

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



    public static  function delLedger( $ledgers){
        foreach($ledgers as $ledger ){
        $user=User::find($ledger->user_id);
        $ledgers=Ledger::where('id','>',$ledger->id)->where('user_id',$ledger->user_id)->orderBy('id','asc')->get();
        $track=0;
        //find first point
        if($ledger->cr>0){
            $track=(-1)*$ledger->cr;
        }
        if($ledger->dr>0){
            $track=$ledger->dr;
        }
        echo 'first'.$track."<br>";

        //find old data

        if($ledger->type==1){
            $track+=$ledger->amount;
        }else{
            $track-=$ledger->amount;
        }


        $ledger->delete();

        foreach($ledgers as $l){

            if($l->type==1){
                $track-=$l->amount;
            }else{
                $track+=$l->amount;
            }

            if($track<0){
                $l->cr=(-1)*$track;
                $l->dr=0;
            }else{
                $l->dr=$track;
                $l->cr=0;
            }
            $l->save();


        }

        $t=0;
        if($track>0){
            $t=2;

        }else if($track<0){
            $t=1;
            $track=(-1)*$track;

        }


        $user->amount=$track;
        $user->amounttype=$t;
        $user->save();
        }
    }


}


