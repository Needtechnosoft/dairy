<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\LedgerManage;
use App\Models\Advance;
use App\Models\Center;
use App\Models\Farmer;
use App\Models\Farmerpayment;
use App\Models\FarmerReport;
use App\Models\Ledger;
use App\Models\Milkdata;
use App\Models\Sellitem;
use App\Models\Snffat;
use App\Models\User;
use App\NepaliDate;
use Illuminate\Http\Request;

class FarmerController extends Controller
{
    public function index(){
        return view('admin.farmer.list');
    }

    public function addFarmer(Request $request){
        if($request->isMethod('post')){
            // dd($request->advance);
                $max=User::join('farmers','farmers.user_id','=','users.id')->where('farmers.center_id',$request->center_id)->max('users.no')??0;
                // dd($max);
                // $max=User::max('no')??0;
                $user = new User();
                $user->phone = $request->phone??"9800000000";
                $user->name = $request->name;
                $user->address = $request->address;
                $user->role = 1;
                $user->password = bcrypt($request->phone);
                $user->no=$max+1;
                $user->save();

                $farmer=new Farmer();
                $farmer->user_id=$user->id;
                $farmer->center_id=$request->center_id;
                $farmer->save();


                if($request->has('advance') ){
                    if($request->advance>0){
                        $manager=new LedgerManage($user->id);
                        $manager->addLedger('Opening Balance',1,$request->advance,$request->date,'101');
                    }
                }
                return view('admin.farmer.single',compact('user'));
                // return response()->json("Farmer Created successfully !");
        }else{
            return view('admin.farmer.add');
        }
    }

    public function listFarmer(){
        $farmers = User::join('farmers','farmers.user_id','=','users.id')->where('farmers.center_id',1)->where('users.role',1)->select('users.*','farmers.center_id')->get();
        // return response()->json($farmers);
        return view('admin.farmer.list',['farmers'=>$farmers]);
    }

    public function listFarmerByCenter(Request $request){
        // dd($request->all());
        $farmers = User::join('farmers','farmers.user_id','=','users.id')->where('farmers.center_id',$request->center)->where('users.role',1)->select('users.*','farmers.center_id')->get();
        // dd($farmers);
        return view('admin.farmer.list',['farmers'=>$farmers]);
    }

    public function farmerDetail($id){
        $user = User::where('id',$id)->where('role',1)->first();
        return view('admin.farmer.detail',compact('user'));
    }

    public function loadDate(Request $r){
        $range=NepaliDate::getDate($r->year,$r->month,$r->session);
        $data=$r->all();
        $farmer1=User::where('id',$r->user_id)->first();

        $sellitem = Sellitem::where('user_id',$r->user_id)->where('date','>=',$range[1])->where('date','<=',$range[2])->get();
        $milkData = Milkdata::where('user_id',$r->user_id)->where('date','>=',$range[1])->where('date','<=',$range[2])->get();
        $snfFats = Snffat::where('user_id',$r->user_id)->where('date','>=',$range[1])->where('date','<=',$range[2])->get();
        $snfAvg = truncate_decimals(Snffat::where('user_id',$r->user_id)->where('date','>=',$range[1])->where('date','<=',$range[2])->avg('snf'),2);
        $fatAvg = truncate_decimals(Snffat::where('user_id',$r->user_id)->where('date','>=',$range[1])->where('date','<=',$range[2])->avg('fat'),2);
        $ledger = Ledger::where('user_id',$r->user_id)->where('date','>=',$range[1])->where('date','<=',$range[2])->orderBy('id','asc')->get();
        $farmer = Farmer::where('user_id',$r->user_id)->first();
        $fatsnfRate = Center::where('id',$farmer->center_id)->first();
        $fatAmount = truncate_decimals($fatAvg * $fatsnfRate->fat_rate);
        $snfAmount = truncate_decimals($snfAvg * $fatsnfRate->snf_rate);
        $perLiterAmount = $fatAmount + $snfAmount;

        $farmer1->old=FarmerReport::where(['year'=>$r->year,'month'=>$r->month,'session'=>$r->session,'user_id'=>$r->user_id])->count()>0;
        $farmer1->advance=(float)(Advance::where('user_id',$r->user_id)->where('date','>=',$range[1])->where('date','<=',$range[2])->sum('amount'));
        $farmer1->due=(float)(Sellitem::where('user_id',$r->user_id)->where('date','>=',$range[1])->where('date','<=',$range[2])->sum('due'));
        $previousMonth=Ledger::where('user_id',$r->user_id)->where('date','>=',$range[1])->where('date','<=',$range[2])->where('identifire','101')->sum('amount');
        $farmer1->prevdue=(float)$previousMonth;

        return view('admin.farmer.alldata',compact('data','farmer1','sellitem','milkData','milkData','snfFats','snfAvg','fatAvg','ledger','perLiterAmount'));
    }


    public function updateFarmer(Request $request){
        // dd($request->all());
        $user = User::where('id',$request->id)->where('role',1)->first();
        // dd($user);
        $user->phone = $request->phone;
        $user->name = $request->name;
        $user->address = $request->address;
        $user->save();
        return view('admin.farmer.single',compact('user'));
    }

    public function deleteFarmer($id){
        $user = User::where('id',$id)->where('role',1)->first();
        $user->delete();
        return response()->json('Delete successfully !');
    }


    // due payment controller
    public function due(){
        return view('admin.farmer.due.index');
    }

    public function dueLoad(Request $request){
            $user = User::join('farmers','users.id','=','farmers.user_id')->where('users.no',$request->no)->where('farmers.center_id',$request->center_id)->select('users.*','farmers.center_id')->first();
            // $user = User::where('no',$request->no)->first();
            $due = Sellitem::where('user_id',$user->id)->where('due','>',0)->get();
        // dd($due);
        return view('admin.farmer.due.due',compact('due'));
    }

    public function paymentSave(Request $request){
        $date = str_replace('-','',$request->date);
        $user = User::join('farmers','users.id','=','farmers.user_id')->where('users.no',$request->no)->where('farmers.center_id',$request->center_id)->select('users.*','farmers.center_id')->first();
        $farmerPay = new Farmerpayment();
        $farmerPay->amount = $request->pay;
        $farmerPay->date = $date;
        $farmerPay->payment_detail = $request->detail;
        $farmerPay->user_id = $user->id;
        $farmerPay->save();
        $due = Sellitem::where('user_id',$user->id)->where('due','>',0)->get();
        $paidmaount = $farmerPay->amount;

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
        $ledger = new LedgerManage($user->id);
        $ledger->addLedger('Farmer due amount paid',2,$paidmaount,$date,'107',$farmerPay->id);
    }
}
