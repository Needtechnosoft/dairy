<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\LedgerManage;
use App\Models\Distributer;
use App\Models\Distributorsell;
use App\Models\Ledger;
use App\Models\User;
use App\NepaliDate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DistributerController extends Controller
{
    public function index(){
        return view('admin.distributer.index');
    }

    public function addDistributer(Request $request){
        $user = new User();
        $user->phone = $request->phone;
        $user->name = $request->name;
        $user->address = $request->address;
        $user->role = 2;
        $user->password = bcrypt($request->phone);
        $user->save();
        $dis = new Distributer();
        $dis->user_id = $user->id;
        $dis->rate = $request->rate??0;
        $dis->amount = $request->amount??0;
        $dis->save();
        return view('admin.distributer.single',compact('user'));
    }

    public function DistributerList(){
        $distributer = User::join('distributers','distributers.user_id','=','users.id')->select('users.*',DB::raw('distributers.id as dis_id'))->where('users.role',2)->orderBy('distributers.id','asc')->get();
        // dd($distributer);
        return view('admin.distributer.list',compact('distributer'));
    }

    public function updateDistributer(Request $request){
        $user = User::where('id',$request->id)->where('role',2)->first();
        $user->phone = $request->phone;
        $user->name = $request->name;
        $user->address = $request->address;
        $user->role = 2;
        $user->password = bcrypt($request->phone);
        $user->save();
        $dis = Distributer::where('user_id',$user->id)->first();
        $dis->rate = $request->rate??0;
        $dis->amount = $request->amount??0;
        $dis->save();
        return view('admin.distributer.single',compact('user'));

    }

    public function distributerDetail($id){
        $user = User::where('id',$id)->where('role',2)->first();
        return view('admin.distributer.detail',compact('user'));
    }

    public function distributerDetailLoad(Request $request){
        // $range=NepaliDate::getDate($r->year,$r->month,$r->session);
        // $ledger = Ledger::where('user_id',$r->user_id)->where('date','>=',$range[1])->where('date','<=',$range[2])->orderBy('ledgers.id','asc')->get();
        // $d = Distributer::where('user_id',$r->user_id)->first();
        // $sell = Distributorsell::where('distributer_id',$d->id)->where('date','>=',$range[1])->where('date','<=',$range[2])->get();
            $year=$request->year;
            $month=$request->month;
            $week=$request->week;
            $session=$request->session;
            $type=$request->type;
            $range=[];
            $data=[];
            $date=1;

            $ledger=Ledger::where('user_id',$request->user_id);
            if($type==0){
                $range = NepaliDate::getDate($request->year,$request->month,$request->session);
                $ledger=$ledger->where('date','>=',$range[1])->where('date','<=',$range[2]);

            }elseif($type==1){
                $date=$date = str_replace('-','',$request->date1);
               $ledger=$ledger->where('date','=',$date);

            }elseif($type==2){
                $range=NepaliDate::getDateWeek($request->year,$request->month,$request->week);
               $ledger=$ledger->where('date','>=',$range[1])->where('date','<=',$range[2]);


            }elseif($type==3){
                $range=NepaliDate::getDateMonth($request->year,$request->month);
               $ledger=$ledger->where('date','>=',$range[1])->where('date','<=',$range[2]);
            }elseif($type==4){
                $range=NepaliDate::getDateYear($request->year);
                $ledger=$ledger->where('date','>=',$range[1])->where('date','<=',$range[2]);


            }elseif($type==5){
                $range[1]=str_replace('-','',$request->date1);;
                $range[2]=str_replace('-','',$request->date2);;
                 $ledger=$ledger->where('date','>=',$range[1])->where('date','<=',$range[2]);
            }
            $ledgers=$ledger->get();
            $user=User::find($request->user_id);
        return view('admin.distributer.data',compact('ledgers','type','range','user','date'));

    }

    public function DistributerDelete($id){
        $user = User::where('id',$id)->where('role',2)->first();
        $user->delete();
    }

    public function opening(){
        return view('admin.distributer.balance.index');
    }

    public function loadLedger(Request $request){
        $date = str_replace('-','',$request->date);
        $ledgers=Ledger::where('date',$date)->where('identifire','119')->get();
        return view('admin.distributer.balance.list',compact('ledgers'));

    }
    public function ledger(Request $request){
        $date = str_replace('-','',$request->date);
        $dis=Distributer::where('id',$request->id)->first();
        $ledger=new LedgerManage($dis->user_id);
        $d=$ledger->addLedger("Opening Balance",$request->type,$request->amount,$date,'119');
        return view('admin.distributer.balance.single',compact('d'));

    }

}
