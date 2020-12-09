<?php
namespace App;

class NepaliDate{
    public $year;
    public $month;
    public $day;
    public $session;
    public function __construct($date)
    {
        $this->year=$date/10000;
        $date=$date%10000;
        $this->month=$date/100;
        $this->day=$date%100;
        if($this->day<16){
            $this->session=1;
        }else{
            $this->session=2;
        }
    }
}