<?php

namespace App\Http\Controllers;

use App\Models\Advance;
use App\Models\Center;
use App\Models\Distributorsell;
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

    public function milk(Request $request){
        if($request->getMethod()=="POST"){
            $year=$request->year;
            $month=$request->month;
            $session=$request->session;

            // ->where('date','>=',$range[1])->where('date','<=',$range[2]);

            if($request->filled('center_id')){
                $range = NepaliDate::getDate($request->year,$request->month,$request->session);

            }
            // $center=Center::find($request->center_id);

        }else{
            return view('admin.report.milk.index');
        }
    }

    public function sales(Request $request){
        if($request->getMethod()=="POST"){
            // dd($request->all());
            $year=$request->year;
            $month=$request->month;
            $week=$request->week;
            $session=$request->session;
            $type=$request->type;
            $range=[];
            $data=[];
            $sellitem=Sellitem::join('farmers','farmers.user_id','=','sellitems.user_id')
            ->join('users','users.id','=','farmers.user_id')
            ->join('items','items.id','sellitems.item_id')
            ;

            $sellmilk=Distributorsell::join('distributers','distributers.id','=','distributorsells.distributer_id')
            ->join('users','users.id','=','distributers.user_id');

            if($type==0){
                $range = NepaliDate::getDate($request->year,$request->month,$request->session);
                 $sellitem=$sellitem->where('sellitems.date','>=',$range[1])->where('sellitems.date','<=',$range[2]);
                 $sellmilk=$sellmilk->where('distributorsells.date','>=',$range[1])->where('distributorsells.date','<=',$range[2]);
            }elseif($type==1){
                $date=$date = str_replace('-','',$request->date1);
                $sellitem=$sellitem->where('sellitems.date','=',$date);
                $sellmilk=$sellmilk->where('distributorsells.date','=',$date);
            }elseif($type==2){
                $range=NepaliDate::getDateWeek($request->year,$request->month,$request->week);
                $sellitem=$sellitem->where('sellitems.date','>=',$range[1])->where('sellitems.date','<=',$range[2]);
                $sellmilk=$sellmilk->where('distributorsells.date','>=',$range[1])->where('distributorsells.date','<=',$range[2]);

            }elseif($type==3){
                $range=NepaliDate::getDateMonth($request->year,$request->month);
                $sellitem=$sellitem->where('sellitems.date','>=',$range[1])->where('sellitems.date','<=',$range[2]);
                $sellmilk=$sellmilk->where('distributorsells.date','>=',$range[1])->where('distributorsells.date','<=',$range[2]);

            }elseif($type==4){
                $range=NepaliDate::getDateYear($request->year);
                $sellitem=$sellitem->where('sellitems.date','>=',$range[1])->where('sellitems.date','<=',$range[2]);
                $sellmilk=$sellmilk->where('distributorsells.date','>=',$range[1])->where('distributorsells.date','<=',$range[2]);

            }elseif($type==5){
                $range[1]=str_replace('-','',$request->date1);;
                $range[2]=str_replace('-','',$request->date2);;
                $sellitem=$sellitem->where('sellitems.date','>=',$range[1])->where('sellitems.date','<=',$range[2]);
                $sellmilk=$sellmilk->where('distributorsells.date','>=',$range[1])->where('distributorsells.date','<=',$range[2]);

            }

            if($request->center_id!=-1){
                $sellitem=$sellitem->where('farmers.center_id',$request->center_id);

            }

            $data['sellitem']=$sellitem->select('sellitems.date','sellitems.rate','sellitems.qty','sellitems.total','sellitems.due','users.name','items.title','users.no')->orderBy('sellitems.date','asc')->get();
            $data['sellmilk']=$sellmilk->select('distributorsells.*','users.name')->get();

            return view('admin.report.sales.data',compact('data'));
        }else{
            return view('admin.report.sales.index');

        }
    }
}
