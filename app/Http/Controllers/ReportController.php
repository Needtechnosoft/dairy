<?php

namespace App\Http\Controllers;

use App\LedgerManage;
use App\Models\Advance;
use App\Models\Center;
use App\Models\Distributorsell;
use App\Models\Employee;
use App\Models\Farmer;
use App\Models\FarmerReport;
use App\Models\Ledger;
use App\Models\Milkdata;
use App\Models\Sellitem;
use App\Models\Snffat;
use App\Models\SessionWatch;
use App\Models\FarmerSession;
use App\Models\EmployeeAdvance;
use App\Models\EmployeeReport;
use App\NepaliDate;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB as DB;

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
            if(SessionWatch::where(['year'=>$year,'month'=>$month,'session'=>$session,'center_id'=>$center->id])->count()>0){
                $data=FarmerReport::where(['year'=>$year,'month'=>$month,'session'=>$session,'center_id'=>$center->id])->get();
                return view('admin.report.farmer.data1',compact('data','year','month','session','center'));

            }else{

                $data=[];
                foreach($farmers as $farmer){
                    if(FarmerReport::where(['year'=>$year,'month'=>$month,'session'=>$session,'user_id'=>$farmer->id])->count()>0){
                        $_data=FarmerReport::where(['year'=>$year,'month'=>$month,'session'=>$session,'user_id'=>$farmer->id])->first();
                        $farmer->snf=$_data->snf;
                        $farmer->fat=$_data->fat;
                        $farmer->rate=$_data->rate;
                        $farmer->milk=$_data->milk;
                        $farmer->bonus=$_data->bonus;
                        $farmer->total=$_data->total;
                        $farmer->prevdue=$_data->prevdue;
                        $farmer->due=$_data->due;
                        $farmer->advance=$_data->advance;
                        $farmer->nettotal=$_data->nettotal;
                        $farmer->advance=$_data->advance;
                        $farmer->old=true;

                    }else{

                        $m_amount=Milkdata::where('user_id',$farmer->id)->where('date','>=',$range[1])->where('date','<=',$range[2])->sum('m_amount');
                        $e_amount=Milkdata::where('user_id',$farmer->id)->where('date','>=',$range[1])->where('date','<=',$range[2])->sum('e_amount');

                        $snfavg=Snffat::where('user_id',$farmer->id)->where('date','>=',$range[1])->where('date','<=',$range[2])->avg('snf');
                        $fatavg=Snffat::where('user_id',$farmer->id)->where('date','>=',$range[1])->where('date','<=',$range[2])->avg('fat');



                        $farmer->snf=(float)truncate_decimals( $snfavg);
                        $farmer->fat=(float)truncate_decimals( $fatavg) ;
                        $farmer->milk=(float)($m_amount+$e_amount);


                        if($snfavg!=null || $fatavg!=null){
                            $rate=($center->snf_rate* $farmer->snf ) + ($center->fat_rate*  $farmer->fat );
                            $farmer->rate=(float)truncate_decimals($rate);
                            $farmer->total=(float)round( $rate*($farmer->milk));
                            $farmer->bonus=0;
                            if (env('hasextra',0)==1){
                                $farmer->bonus=(int)($farmer->total*$center->bonus/100);

                            }
                        }
                        $due=Sellitem::where('user_id',$farmer->id)->where('date','>=',$range[1])->where('date','<=',$range[2])->sum('due');
                        $farmer->due=(float)$due;
                        $previousMonth=Ledger::where('user_id',$farmer->id)->where('date','>=',$range[1])->where('date','<=',$range[2])->where('identifire','101')->sum('amount');
                        $farmer->prevdue=(float)$previousMonth;
                        $farmer->nettotal=(float)($farmer->total-$farmer->due-$farmer->prevdue);
                        $farmer->advance=(float)(Advance::where('user_id',$farmer->id)->where('date','>=',$range[1])->where('date','<=',$range[2])->sum('amount'));
                        $farmer->old=false;
                    }
                    array_push($data,$farmer);
                }
                return view('admin.report.farmer.data',compact('data','year','month','session','center'));
            }
        }else{

            return view('admin.report.farmer.index');
        }
    }

    public function farmerSingleSession(Request $request){
        $nextdate=NepaliDate::getNextDate($request->year,$request->month,$request->session);
        $lastdate=NepaliDate::getDate($request->year,$request->month,$request->session)[2];
        $ledger=new LedgerManage($request->id);


            if($request->due > ($request->total)){
                    $due = Sellitem::where('user_id',$request->id)->where('due','>',0)->get();
                    $paidmaount=$request->total;
                    foreach ($due as $key => $value) {
                        if($paidmaount<=0){
                            break;
                        }
                        if($paidmaount>=$value->due){
                            $paidmaount -= $value->due;
                            $value->due =0;
                            $value->save();
                        }else{
                            $value->due-=$paidmaount;
                            $paidmaount=0;
                            $value->save();
                        }
                    }


            }else{
                Sellitem::where('user_id',$request->id)->update([
                                    'due'=>0,
                                    'paid'=>DB::raw("`total`")
                                ]);
            }

            if($request->nettotal>0 ||$request->balance>0){

                $ledger->addLedger("Payment for milk (".($request->milk)."l X ".($request->rate??0).")",2,$request->total,$lastdate,'108');

                if($request->nettotal>0){
                        $ledger->addLedger("Payment Given To Farmer",1,$request->nettotal,$lastdate,'110');
                }else{
                    if($request->balance>0){
                        $ledger->addLedger("Closing Balance",2,$request->balance,$lastdate,'109');
                        $ledger->addLedger("Aalya",1,$request->balance,$nextdate,'101');
                    }
                }
            }
            $farmerreport=new FarmerReport();
            $farmerreport->user_id=$request->id;
            $farmerreport->milk=$request->milk;
            $farmerreport->snf=$request->snf??0;
            $farmerreport->fat=$request->fat??0;
            $farmerreport->rate=$request->rate??0;
            $farmerreport->total=$request->total??0;
            $farmerreport->due=$request->due??0;
            $farmerreport->bonus=$request->bonus??0;
            $farmerreport->prevdue=$request->prevdue??0;
            $farmerreport->advance=$request->advance??0;
            $farmerreport->nettotal=$request->nettotal??0;
            $farmerreport->balance=$request->balance??0;
            $farmerreport->year=$request->year;
            $farmerreport->month=$request->month;
            $farmerreport->session=$request->session;
            $farmer=Farmer::where('user_id',$request->id)->first();
            $farmerreport->center_id=$farmer->center_id;
            $farmerreport->save();
            return redirect()->back();
    }

    public function farmerSession(Request $request){
        // dd($request->all());
        $nextdate=NepaliDate::getNextDate($request->year,$request->month,$request->session);
        $lastdate=NepaliDate::getDate($request->year,$request->month,$request->session)[2];

        foreach($request->farmers as $farmer){
            $data=json_decode($farmer);

            $ledger=new LedgerManage($data->id);


            if($data->due > ($data->total)){
                    $due = Sellitem::where('user_id',$data->id)->where('due','>',0)->get();
                    $paidmaount=$data->total;
                    foreach ($due as $key => $value) {
                        if($paidmaount<=0){
                            break;
                        }
                        if($paidmaount>=$value->due){
                            $paidmaount -= $value->due;
                            $value->due =0;
                            $value->save();
                        }else{
                            $value->due-=$paidmaount;
                            $paidmaount=0;
                            $value->save();
                        }
                    }


            }else{
                Sellitem::where('user_id',$data->id)->update([
                                    'due'=>0,
                                    'paid'=>DB::raw("`total`")
                                ]);
            }

            if($data->nettotal>0 ||$data->balance>0){

                $ledger->addLedger("Payment for milk (".($data->milk)."l X ".($data->rate??0).")",2,$data->total,$lastdate,'108');

                if($data->nettotal>0){
                        $ledger->addLedger("Payment Given To Farmer",1,$data->nettotal,$lastdate,'110');
                }else{
                    if($data->balance>0){
                        $ledger->addLedger("Closing Balance",2,$data->balance,$lastdate,'109');
                        $ledger->addLedger("Aalya",1,$data->balance,$nextdate,'101');
                    }
                }
            }
            $farmerreport=new FarmerReport();
            $farmerreport->user_id=$data->id;
            $farmerreport->milk=$data->milk;
            $farmerreport->snf=$data->snf??0;
            $farmerreport->fat=$data->fat??0;
            $farmerreport->rate=$data->rate??0;
            $farmerreport->total=$data->total??0;
            $farmerreport->due=$data->due??0;
            $farmerreport->prevdue=$data->prevdue??0;
            $farmerreport->bonus=$data->bonus??0;
            $farmerreport->advance=$data->advance??0;
            $farmerreport->nettotal=$data->nettotal??0;
            $farmerreport->balance=$data->balance??0;
            $farmerreport->year=$request->year;
            $farmerreport->month=$request->month;
            $farmerreport->session=$request->session;
            $farmerreport->center_id=$request->center_id;
            $farmerreport->save();


        }

        $sessionwatch=new SessionWatch();
        $sessionwatch->year=$request->year;
        $sessionwatch->month=$request->month;
        $sessionwatch->session=$request->session;
        $sessionwatch->center_id=$request->center_id;
        $sessionwatch->save();

        //    foreach($request->ids as $user_id){

        //     if($request->input['balance.farmer_'.$user_id]<=0){

        //         Sellitem::where('user_id',$user_id)->update(
        //             [
        //                 'due'=>0,
        //                 'paid'=>DB::raw("`total`")
        //             ]
        //         );
        //     }else{
        //         $due = Sellitem::where('user_id',$user_id)->where('due','>',0)->get();
        //         $paidmaount=$request->input['total.farmer_'.$user_id];
        //         foreach ($due as $key => $value) {
        //             if($paidmaount<=0){
        //                 break;
        //             }
        //             if($paidmaount>=$value->due){
        //                 $paidmaount -= $value->due;
        //                 $value->due =0;
        //                 $value->save();
        //             }else{
        //                 $value->due-=$paidmaount;
        //                 $paidmaount=0;
        //                 $value->save();
        //             }
        //         }
        //     }

        //     $total = $request->input['nettotal.farmer_'.$user_id];
        //     $balance=$request->input['balance.farmer_'.$user_id];
        //     $ledger=new LedgerManage($user_id);
        //     $ledger->addLedger("Payment form milk (".$request->input['milk.farmer_'.$user_id]."l X ".$request->input['milk.farmer_'.$user_id].")",2,$total,$nextdate,'108',);




        //    }

        return redirect()->back();
    }

    public function milk(Request $request){
        if($request->getMethod()=="POST"){
            $year=$request->year;
            $month=$request->month;
            $week=$request->week;
            $session=$request->session;
            $type=$request->type;
            $range=[];
            $data=[];

            $milkdatas=MilkData::join('farmers','farmers.user_id','=','milkdatas.user_id')
            ->join('centers','centers.id','=','farmers.center_id')
            ->join('users','users.id','=','milkdatas.user_id');


            if($type==0){
                $range = NepaliDate::getDate($request->year,$request->month,$request->session);
                $milkdatas=$milkdatas->where('milkdatas.date','>=',$range[1])->where('milkdatas.date','<=',$range[2]);

            }elseif($type==1){
                $date=$date = str_replace('-','',$request->date1);
               $milkdatas=$milkdatas->where('milkdatas.date','=',$date);

            }elseif($type==2){
                $range=NepaliDate::getDateWeek($request->year,$request->month,$request->week);
               $milkdatas=$milkdatas->where('milkdatas.date','>=',$range[1])->where('milkdatas.date','<=',$range[2]);


            }elseif($type==3){
                $range=NepaliDate::getDateMonth($request->year,$request->month);
               $milkdatas=$milkdatas->where('milkdatas.date','>=',$range[1])->where('milkdatas.date','<=',$range[2]);
            }elseif($type==4){
                $range=NepaliDate::getDateYear($request->year);
               $milkdatas=$milkdatas->where('milkdatas.date','>=',$range[1])->where('milkdatas.date','<=',$range[2]);


            }elseif($type==5){
                $range[1]=str_replace('-','',$request->date1);;
                $range[2]=str_replace('-','',$request->date2);;
               $milkdatas=$milkdatas->where('milkdatas.date','>=',$range[1])->where('milkdatas.date','<=',$range[2]);
            }

            $hascenter=false;
            if($request->center_id!=-1){
                $hascenter=true;
               $milkdatas=$milkdatas->where('farmers.center_id',$request->center_id);

            }

            $datas=$milkdatas->select('milkdatas.m_amount','milkdatas.e_amount','milkdatas.user_id','milkdatas.date','farmers.center_id','users.name','users.no')->get();
            $data1=$milkdatas->select(DB::raw('(sum(milkdatas.m_amount)+sum(milkdatas.e_amount)) as milk ,milkdatas.user_id ,users.name,users.no,farmers.center_id'))->groupBy('milkdatas.user_id','users.name','users.no','farmers.center_id')->get()->groupBy('center_id');






            return view('admin.report.milk.data',compact('data1'));




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

    public function distributor(Request $request){
        if($request->getMethod()=="POST"){
            $range = NepaliDate::getDate($request->year,$request->month,$request->session);
            $data=Distributorsell::join('distributers','distributorsells.distributer_id','=',"distributers.id")
            ->join('users','users.id','=','distributers.user_id')
            ->where('distributorsells.date','>=',$range[1])
            ->where('distributorsells.date','<=',$range[2])
            ->select( DB::raw('distributers.id, sum(distributorsells.qty) as qty, users.name,sum(distributorsells.total) total'))->groupBy('id','name')->get();

            return view('admin.report.distributor.data',compact('data'));

        }else{
            return view('admin.report.distributor.index');
        }
    }

    public function employee(Request $request){
        if($request->getMethod()=="POST"){
            $range=NepaliDate::getDateMonth($request->year,$request->month);
            $year=$request->year;
            $month=$request->month;
            $employees=Employee::all();
            $data=[];
            foreach($employees as $employee){
                if(EmployeeReport::where('employee_id',$employee->id)->where('year',$request->year)->where('month',$request->month)->count()>0){
                    $report=EmployeeReport::where('employee_id',$employee->id)->where('year',$request->year)->where('month',$request->month)->first();
                    $employee->prevbalance=$report->prevbalance;
                    $employee->advance=$report->advance;
                    $employee->salary=$report->salary;
                    $employee->old=true;
                }else{
                    $employee->prevbalance=Ledger::where('user_id',$employee->user_id)->where('identifire','101')->where('date','>=',$range[1])->where('date','<=',$range[2])->sum('amount');
                    $employee->advance=EmployeeAdvance::where('employee_id',$employee->id)->where('date','>=',$range[1])->where('date','<=',$range[2])->sum('amount');
                    $employee->old=false;
                }

                array_push($data,$employee);
            }
            // $advance=EmployeeAdvance::where
            return view('admin.report.employee.data',compact('data','year','month'));


        }else{
            return view('admin.report.employee.index');

        }
    }

    public function employeeSession(Request $request){
            foreach($request->employees as $employee){
                $report=new EmployeeReport();
                $report->employee_id=$employee->id;
                $report->prebalance=$employee->prevbalance;
                $report->advance=$employee->advance;
                $report->salary=$employee->salary;
                $report->save();
            }

            return redirect()->back();
    }
}
