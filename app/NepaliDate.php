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

    public static function getDate($year,$month,$session){
        $data=[];
        $date=$year*10000+$month*100;
        $data[1]=$date+($session==1?0:16);
        $data[2]=$date+($session==1?15:32);
        return $data;
    }
}
