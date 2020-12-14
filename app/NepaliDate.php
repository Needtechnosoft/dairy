<?php
namespace App;

class NepaliDate{
    public $year;
    public $month;
    public $day;
    public $session;
    public function __construct($date)
    {
        $this->year=(int)($date/10000);
        $date=$date%10000;
        $this->month=(int)($date/100);
        $this->day= (int)($date%100);
        if($this->day<16){
            $this->session=1;
        }else{
            $this->session=2;
        }
    }
}
