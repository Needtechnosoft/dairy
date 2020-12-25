<?php

namespace App\Http\Controllers;

use App\Models\Advance;
use App\Models\Center;
use App\Models\Farmer;
use App\Models\Ledger;
use App\Models\Milkdata;
use App\Models\Sellitem;
use App\Models\Snffat;
use App\NepaliDate;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(){
        return view('admin.report.index');
    }

    public function farmer(Request $request){
        if($request->getMethod()=="POST"){
            $farmers=Farmer::join('users','users.id','=','farmers.user_id')->where('farmers.center_id',$request->center_id)->select('users.id','users.name','users.no','farmers.center_id')->get();
            $center=Center::find($request->center_id);
            $year=$request->year;
            $month=$request->month;
            $session=$request->session;
            $range = NepaliDate::getDate($request->year,$request->month,$request->session);
            $data=[];
            foreach($farmers as $farmer){
                $m_amount=Milkdata::where('user_id',$farmer->id)->where('date','>=',$range[1])->where('date','<=',$range[2])->sum('m_amount');
                $e_amount=Milkdata::where('user_id',$farmer->id)->where('date','>=',$range[1])->where('date','<=',$range[2])->sum('e_amount');

                $snfavg=Snffat::where('user_id',$farmer->id)->where('date','>=',$range[1])->where('date','<=',$range[2])->avg('snf');
                $fatavg=Snffat::where('user_id',$farmer->id)->where('date','>=',$range[1])->where('date','<=',$range[2])->avg('fat');



                $farmer->snf=(float)round( $snfavg, 2);
                $farmer->fat=(float)round( $fatavg,2) ;
                $farmer->m_milk=(float)$m_amount;
                $farmer->e_milk=(float)$e_amount;

                if($snfavg!=null || $fatavg!=null){
                    $rate=($center->snf_rate* round( $snfavg, 2) ) + ($center->fat_rate*  round( $fatavg,2) );
                    $farmer->rate=(float)round($rate,2);
                    $farmer->total=(float)round( $rate*($m_amount+$e_amount),2);
                }
                $due=Sellitem::where('user_id',$farmer->id)->sum('due');

                $farmer->due=(float)$due;
                $previousMonth=Ledger::where('user_id',$farmer->id)->where('date','>=',$range[1])->where('date','<=',$range[2])->where('identifire','101')->sum('amount');
                $farmer->prevdue=(float)$previousMonth;
                $farmer->nettotal=(float)($farmer->total-$farmer->due-$farmer->prevdue);
                $farmer->advance=(float)(Advance::where('user_id',$farmer->id)->where('date','>=',$range[1])->where('date','<=',$range[2])->sum('amount'));

                array_push($data,$farmer);
            }
            return view('admin.report.farmer.data',compact('data','year','month','session','center'));
        }else{

            return view('admin.report.farmer.index');
        }
    }
}
