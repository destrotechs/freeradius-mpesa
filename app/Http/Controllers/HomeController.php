<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Hash;
use Validator;
use Route;
use Auth;
use App\SendMessage;
use App\UserGroups;
use RealRashid\SweetAlert\Facades\Alert;
use App\Charts\userChart;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {       
            $sales=DB::table('transactions')->sum('amount');
            $customers=count(DB::table('customers')->get());
            $plans=DB::table('bundle_plans')->pluck('plantitle');
            $planscost=DB::table('bundle_plans')->pluck('cost');
            $onlineusers=DB::table('radacct')->where('acctstoptime','=',NULL)->count();
            $users=DB::table('customers')->count();
            $plansnum=DB::table('bundle_plans')->count();
            $transactions=DB::table('transactions')->count();
            $usersChart = new userChart;
        $usersChart->labels(['users','plans','transactions']);
        $usersChart->dataset('count', 'bar', [$users,$plansnum,$transactions])->options(['fill'=>'true','borderColor'=>'lightblue','backgroundColor'=>'skyblue']);
        $nas=DB::table('nas')->get();
        $planpurchases=array();
        $planpurchasecount=0;
        $plannames=DB::table('bundle_plans')->pluck('planname');
        foreach ($plannames as $key => $p) {
            $planpurchasecount=DB::table('transactions')->where('plan','=',$p)->count();
            array_push($planpurchases, $planpurchasecount);
        }


        $purchaseChart=new userChart;
        $purchaseChart->labels($plans);
        $purchaseChart->dataset('purchases','line',$planpurchases)->options(['fill'=>'true','borderColor'=>'red','backgroundColor'=>'skyblue']);

        return view('home',compact('sales','customers','usersChart','onlineusers','purchaseChart','nas'));
    }
    public function paymentGraphs(Request $request){
        $planpurchases=array();
        $planContrib=array();
        $singleplancontrib=0;
        $planpurchasecount=0;
        
        $plans=DB::table('bundle_plans')->pluck('plantitle');
        $plannames=DB::table('bundle_plans')->pluck('planname');
        $planamount=array();
        foreach ($plannames as $key => $p) {
            $planpurchasecount=DB::table('transactions')->where('plan','=',$p)->count();
            $planamount=DB::table('bundle_plans')->where('planname','=',$p)->pluck('cost');
            //$singleplancontrib=$planamount[$key]*$planpurchasecount;
            array_push($planpurchases, $planpurchasecount);
            //array_push($planContrib, $singleplancontrib);
        }

        $purchaseChart=new userChart;
        $purchaseChart->labels($plans);
        $purchaseChart->dataset('purchases','bar',$planpurchases)->options(['fill'=>'true','borderColor'=>'blue','backgroundColor'=>'skyblue']);

        return view('pages.paymentgraphs',compact('purchaseChart','plans','planContrib','planpurchasecount','planamount'));

    }
    public function getAllCustomers(Request $request){
        $purchases=array();
        $pcount=0;
        $customers=DB::table('customers')->paginate(20);
                    // ->leftjoin('radcheck','radcheck.username','=','customers.username')
                    // ->leftjoin('radreply','radreply.username','=','customers.username')->get();
        foreach ($customers as $key => $c) {
            $pcount=DB::table('transactions')->where('username','=',$c->username)->count();
            array_push($purchases, $pcount);
        }
        return view('pages.allcustomers',compact('customers','purchases'));
    }
    public function getNewCustomer(Request $request){
        if($request->session()->has('success_message')){
            toast($request->session()->get('success_message'),'success','top-end');  
        }
        if($request->session()->has('error')){
            toast($request->session()->get('error'),'error','top-end');  
        }
        $radgroupcheck=DB::table('radgroupcheck')->distinct()->get();
        $radgroupreply=DB::table('radgroupreply')->distinct()->get();
        $limitattributes=DB::table('limitattributes')->distinct()->get();
        $groups=DB::table('user_groups')->get();
        return view('pages.newcustomer',compact('radgroupcheck','radgroupreply','limitattributes','groups'));
    }
    public function postNewCustomer(Request $request){
        //validate info
        $request->validate([
            'username'=>['required','unique:radcheck','unique:customers'],
            'cleartextpassword'=>['required','min:4','max:8'],
            'name'=>['required'],
            'phone'=>['required','max:10','min:10']
        ]);

        //details
        $attribute=$request->get('attribute');
        $username=$request->get('username');
        $attributevalue=$request->get('value');
        $op=$request->get('op');
        $type=$request->get('type');
        $hashedpassword=Hash::make($request->get('cleartextpassword'));
        //add user to customers table

        $customer=DB::table('customers')->insert([
            'name'=>$request->get('name'),'username'=>$request->get('username'),'password'=>$hashedpassword,'cleartextpassword'=>$request->get('cleartextpassword'),'phone'=>$request->get('phone'),'email'=>$request->get('email'),
        ]);

        //add user to radcheck
        $raduser=DB::table('radcheck')->insert([
            'username'=>$username,'attribute'=>'Cleartext-Password','op'=>':=','value'=>$request->get('cleartextpassword'),
        ]);
        if(isset($attribute)){
        for ($i=0; $i < count($attribute); $i++) { 
                if($type[$i]=='reply'){
                    DB::table('radreply')->updateOrInsert(
                        ['username'=>$username,'attribute'=>$attribute[$i]],
                        ['op'=>$op[$i],'value'=>$attributevalue[$i]]
                    );  
                }else{
                    DB::table('radcheck')->updateOrInsert(
                        ['username'=>$username,'attribute'=>$attribute[$i]],
                        ['op'=>$op[$i],'value'=>$attributevalue[$i]]
                    );
                }
            
         }
     }
        //if usergroupnot empty,add user to group
     $radusergroup=$request->get('radusergroup');
     if(isset($radusergroup) && $radusergroup!=" "){
        for($i=0;$i<count($radusergroup);$i++){
            if ($radusergroup[$i]!=NULL) {
                $groupuser=DB::table('radusergroup')->updateOrInsert(
                    ['username'=>$username],
                    ['groupname'=>$radusergroup[$i],'priority'=>0]
                );
            }
            
        }
        
     }
        //assign user attributes if given
        return redirect()->back()->with("success","Customer created successfully");
    }
    public function fetchCustomer(){
        return view('pages.editcustomer');
    }
    public function getSpecificCustomer(Request $request,$username){
        $customerinfo=DB::table('customers')->where('username','=',$username)->get();
        $checkattributes=DB::table('radcheck')->where('username','=',$username)->get();
        $replyattributes=DB::table('radreply')->where('username','=',$username)->get();
        $limitattributes=DB::table('limitattributes')->distinct()->get();
        $groups=DB::table('radusergroup')->where('username','=',$username)->get();
        $checkgroups=DB::table('radgroupcheck')->distinct()->get();
        $allgroups=DB::table('radgroupreply')->distinct()->get();
        //$allgroups=array_merge($checkgroups,$replygroups);
        return view('pages.specificcustomer',compact('customerinfo','groups','replyattributes','checkattributes','limitattributes','allgroups'));
    }
    public function postFetchCustomer(Request $request){
        $username=$request->get('username');
        $customerdetails=DB::table('customers')->where('customers.username','=',$username)->get();
        $customercheck=DB::table('radcheck')->where('username','=',$username)->get();
        if (count($customerdetails)>0 || count($customercheck)>0) {
            return redirect()->route('specificcustomer',['username'=>$username]);
        }else{
            return redirect()->back()->with("error","No customer found under username ".$username);
            //self::getSpecificCustomer2($username);
        }

    }

    public static function getSpecificCustomer2($username){
        $customerinfo=array();
        $checkattributes=DB::table('radcheck')->where('username','=',$username)->get();
        $replyattributes=DB::table('radreply')->where('username','=',$username)->get();
        $limitattributes=DB::table('limitattributes')->distinct()->get();
        $groups=DB::table('radusergroup')->where('username','=',$username)->get();
        $checkgroups=DB::table('radgroupcheck')->distinct()->get();
        $allgroups=DB::table('radgroupreply')->distinct()->get();
        //$allgroups=array_merge($checkgroups,$replygroups);
        return view('pages.specificcustomer',compact('customerinfo','groups','replyattributes','checkattributes','limitattributes','allgroups'));
    }
    public function getNasList(Request $request){
        $nas=DB::table('nas')->get();
        return view('pages.listnas',compact('nas'));
    }
    public function getNewNas(Request $request){
        return view('pages.newnas');
    }
    public function postNewNas(Request $request){
        $request->validate([
            'secret'=>['required'],
            'nasname'=>['required'],
            'shortname'=>['required'],
        ]);
        $newnas=DB::table('nas')->insert([
            'secret'=>$request->get('secret'),'nasname'=>$request->get('nasname'),'shortname'=>$request->get('shortname'),
        ]);
        return redirect()->back()->with("success","Nas saved successfully");
    }
    public function getEditNas(Request $rquest,$id){
        $nas=DB::table('nas')->where('id','=',$id)->get();

        return view('pages.editnas',compact('nas'));
    }
    public function postEditedNas(Request $request){
        $id=$request->get('id');
        $updatenas=DB::table('nas')->where('id','=',$id)->update(['nasname'=>$request->get('nasname'),'secret'=>$request->get('secret'),'shortname'=>$request->get('shortname')]);

        return redirect()->back()->with("success","nas details updated successfully");
    }
    public function getNewLimitAttr(Request $request){
        return view('pages.createlimit');
    }
    public function postNewLimit(Request $request){
        $request->validate([
            'vendor'=>['required'],
            'limitname'=>['required','unique:limitattributes'],
            'type'=>['required'],
            'table'=>['required'],
            'op'=>['required'],
            'description'=>['required'],
        ]);

        $newlimit=DB::table('limitattributes')->insert([
            'vendor'=>$request->get('vendor'),'limitname'=>$request->get('limitname'),'type'=>$request->get('type'),'table'=>$request->get('table'),'op'=>$request->get('op'),'description'=>$request->get('description'),
        ]);
        if ($newlimit) {
            return redirect()->back()->with('success','New Limit created successfully');
        }else{
            return redirect()->back()->with('error','New Limit could not be saved, try again');
        }
    }
    public function getUserlimitGroups(Request $request){
         $limitattributes=DB::table('limitattributes')->distinct()->get();
         $groupscheck=DB::table('radgroupcheck')->distinct()->get();
         $groupsreply=DB::table('radgroupreply')->distinct()->get();
         $groups=DB::table('user_groups')->get();
        return view('pages.userlimitgroups',compact('limitattributes','groupscheck','groupsreply','groups'));
    }
    public function postNewLimitGroup(Request $request){
        $request->validate([
            'groupname'=>['required','unique:radgroupcheck','unique:radgroupreply','unique:user_groups'],
        ]);
        
        $attribute=$request->get('attribute');
        $attributevalue=$request->get('value');
        $op=$request->get('op');
        $type=$request->get('type');
        $groupname=$request->get('groupname');
        $userg=new UserGroups;
        $userg->groupname=$groupname;
        $userg->createdby=Auth::user()->email;
        $userg->save();
        if(isset($attribute)){
        for ($i=0; $i < count($attribute); $i++) { 
                if($type[$i]=='reply'){
                    DB::table('radgroupreply')->updateOrInsert(
                        ['groupname'=>$groupname,'attribute'=>$attribute[$i]],
                        ['op'=>$op[$i],'value'=>$attributevalue[$i]]
                    );  
                }else{
                    DB::table('radgroupcheck')->updateOrInsert(
                        ['groupname'=>$groupname,'attribute'=>$attribute[$i]],
                        ['op'=>$op[$i],'value'=>$attributevalue[$i]]
                    );
                }
            
         }
     }
     return redirect()->back()->with("success","Group created successfully");
    }
    public function getAllPayments(Request $request){
        $payments=DB::table('transactions')->paginate(15);

        return view('pages.allpayments',compact('payments'));
    }
    public function getInitializePayment(){
        $plans=DB::table('bundle_plans')->get();
        return view('pages.initiatepayment',compact('plans'));
    }
    public function getLastConnectionAtt(Request $request){
        $attempts=DB::table('radpostauth')->orderBy('id','desc')->paginate(15);
        return view('pages.connectionattempts',compact('attempts'));
    }
    public function getOnlineusers(){
        $onlineusers=DB::table('radacct')->where('acctstoptime','=',NULL)->orWhere('acctstoptime','=','0000-00-00 00:00:00')->paginate(15);
        return view('pages.onlineusers',compact('onlineusers'));
    }
    public function getUserAccounting(){
        return view('pages.useraccounting');
    }
    public function userAccounting(Request $request){
        $username=$request->get('username');
        $useraccounting=DB::table('radacct')->where('username','=',$username)->get();
        $totalsessiontime=DB::table('radacct')->where('username','=',$username)->sum('acctsessiontime');
        $totaldownload=DB::table('radacct')->where('username','=',$username)->sum('AcctInputOctets');
        $totaldownload=round($totaldownload/(1024*1024),2);
        $totalupload=DB::table('radacct')->where('username','=',$username)->sum('AcctOutputOctets');
        $totalupload=round($totalupload/(1024*1024));

        $totalbandwidth=$totalupload+$totaldownload;

        if ($totalsessiontime>=60 && $totalsessiontime<3600) {
            $totalsessiontime=($totalsessiontime/60);
            $totalsessiontime.=" Minutes";
        }else if ($totalsessiontime>=3600) {
            $totalsessiontime=$totalsessiontime/3600;
            $totalsessiontime.= " Hours";
        }else{
            $totalsessiontime.=" Seconds";
        }
        $output='<table class="table table-striped table-bordered table-sm"><thead><tr><th>ID</th><th>username</th><th>Ip Address</th><th>Start Time</th><th>End Time</th><th>Total Time</th><th>Uplaod</th><th>Download</th><th>Termination Cause</th><th>Nas IP address</th></tr></thead><tbody>';
        if (count($useraccounting)>0) {
           foreach ($useraccounting as $key => $o) {
            $timespent=$o->acctsessiontime;
            if ($timespent<60) {
                $timespent.=" Seconds";
            }
            else if ($timespent>=60 && $timespent<3600) {
                $timespent=($timespent/60);
                $timespent.=" Minutes";
            }else {
                $timespent=($timespent/3600);
                $timespent.=" Hours";
            }
            $output.='<tr><td>'.$o->radacctid.'</td><td>'.$o->username.'</td><td>'.$o->framedipaddress.'</td><td>'.$o->acctstarttime.'</td><td>'.$o->acctstoptime.'</td><td>'.$timespent.'</td><td>'.$o->acctoutputoctets.'</td><td>'.$o->acctinputoctets.'</td><td>'.$o->acctterminatecause.'</td><td>'.$o->nasipaddress.'</td></tr>';
            }
        }else{
            $output.='<tr><td colspan="10" class="alert alert-danger">No accounting records for this user</td></tr>';
        }
        
        $output.='</tbody><tfoot><tr><td colspan="4">Total Session Time '.$totalsessiontime.'</td><td colspan="2">Total Download Bandwidth '.$totaldownload.' Mbs</td><td colspan="2">Total Upload Bandwidth '.$totalupload.' Mbs</td><td colspan="2">Total Bandwidth '.$totalbandwidth.' Mbs</td></tr></tfoot></table>';
        echo $output;

    }
    public function getIpAccounting(){
        return view('pages.ipaccounting');
    }
    public function ipAccounting(Request $request){
        $ip=$request->get('ip');
        $useraccounting=DB::table('radacct')->where('framedipaddress','=',$ip)->get();
        $totalsessiontime=DB::table('radacct')->where('framedipaddress','=',$ip)->sum('acctsessiontime');
        $totaldownload=DB::table('radacct')->where('framedipaddress','=',$ip)->sum('AcctInputOctets');
        $totaldownload=round($totaldownload/(1024*1024),2);
        $totalupload=DB::table('radacct')->where('framedipaddress','=',$ip)->sum('AcctOutputOctets');
        $totalupload=round($totalupload/(1024*1024));

        $totalbandwidth=$totalupload+$totaldownload;


        if ($totalsessiontime>=60 && $totalsessiontime<3600) {
            $totalsessiontime=($totalsessiontime/60);
            $totalsessiontime.=" Minutes";
        }else if ($totalsessiontime>=3600) {
            $totalsessiontime=$totalsessiontime/3600;
            $totalsessiontime.= " Hours";
        }else{
            $totalsessiontime.=" Seconds";
        }
        $output='<table class="table table-striped table-bordered table-sm"><thead><tr><th>ID</th><th>username</th><th>Ip Address</th><th>Start Time</th><th>End Time</th><th>Total Time</th><th>Uplaod</th><th>Download</th><th>Termination Cause</th><th>Nas IP address</th></tr></thead><tbody>';
        if (count($useraccounting)>0) {
           foreach ($useraccounting as $key => $o) {
            $timespent=$o->acctsessiontime;
            if ($timespent<60) {
                $timespent.=" Seconds";
            }
            else if ($timespent>=60 && $timespent<3600) {
                $timespent=($timespent/60);
                $timespent.=" Minutes";
            }else {
                $timespent=($timespent/3600);
                $timespent.=" Hours";
            }
            
            $output.='<tr><td>'.$o->radacctid.'</td><td>'.$o->username.'</td><td>'.$o->framedipaddress.'</td><td>'.$o->acctstarttime.'</td><td>'.$o->acctstoptime.'</td><td>'.$timespent.'</td><td>'.$o->acctoutputoctets.'</td><td>'.$o->acctinputoctets.'</td><td>'.$o->acctterminatecause.'</td><td>'.$o->nasipaddress.'</td></tr>';
            }
        }else{
            $output.='<tr><td colspan="10" class="alert alert-danger">No accounting records for this ip</td></tr>';
        }
        
        $output.='</tbody><tfoot><tr><td colspan="4">Total Session Time '.$totalsessiontime.'</td><td colspan="2">Total Download Bandwidth '.$totaldownload.' Mbs</td><td colspan="2">Total Upload Bandwidth '.$totalupload.' Mbs</td><td colspan="2">Total Bandwidth '.$totalbandwidth.' Mbs</td></tr></tfoot></table>';
        echo $output;
    }
    public function getNasAccounting(){
        return view('pages.nasaccounting');
    }
    public function nasAccounting(Request $request){
        $ip=$request->get('ip');
        $useraccounting=DB::table('radacct')->where('nasipaddress','=',$ip)->get();
        $totalsessiontime=DB::table('radacct')->where('nasipaddress','=',$ip)->sum('acctsessiontime');
        $totaldownload=DB::table('radacct')->where('nasipaddress','=',$ip)->sum('AcctInputOctets');
        $totaldownload=round($totaldownload/(1024*1024),2);
        $totalupload=DB::table('radacct')->where('nasipaddress','=',$ip)->sum('AcctOutputOctets');
        $totalupload=round($totalupload/(1024*1024));

        $totalbandwidth=$totalupload+$totaldownload;

        
        if ($totalsessiontime>=60 && $totalsessiontime<3600) {
            $totalsessiontime=($totalsessiontime/60);
            $totalsessiontime.=" Minutes";
        }else if ($totalsessiontime>=3600) {
            $totalsessiontime=$totalsessiontime/3600;
            $totalsessiontime.= " Hours";
        }else{
            $totalsessiontime.=" Seconds";
        }
        $output='<table class="table table-striped table-bordered table-sm"><thead><tr><th>ID</th><th>username</th><th>Ip Address</th><th>Start Time</th><th>End Time</th><th>Total Time</th><th>Uplaod</th><th>Download</th><th>Termination Cause</th><th>Nas IP address</th></tr></thead><tbody>';
        if (count($useraccounting)>0) {
           foreach ($useraccounting as $key => $o) {
            $timespent=$o->acctsessiontime;
            if ($timespent<60) {
                $timespent.=" Seconds";
            }
            else if ($timespent>=60 && $timespent<3600) {
                $timespent=($timespent/60);
                $timespent.=" Minutes";
            }else {
                $timespent=($timespent/3600);
                $timespent.=" Hours";
            }
            
            $output.='<tr><td>'.$o->radacctid.'</td><td>'.$o->username.'</td><td>'.$o->framedipaddress.'</td><td>'.$o->acctstarttime.'</td><td>'.$o->acctstoptime.'</td><td>'.$timespent.'</td><td>'.$o->acctoutputoctets.'</td><td>'.$o->acctinputoctets.'</td><td>'.$o->acctterminatecause.'</td><td>'.$o->nasipaddress.'</td></tr>';
            }
        }else{
            $output.='<tr><td colspan="10" class="alert alert-danger">No accounting records for this ip</td></tr>';
        }
        
        $output.='</tbody><tfoot><tr><td colspan="4">Total Session Time '.$totalsessiontime.'</td><td colspan="2">Total Download Bandwidth '.$totaldownload.' Mbs</td><td colspan="2">Total Upload Bandwidth '.$totalupload.' Mbs</td><td colspan="2">Total Bandwidth '.$totalbandwidth.' Mbs</td></tr></tfoot></table>';
        echo $output;
    }
    public function getPlans(Request $request){
        if($request->session()->has('success_message')){
            toast($request->session()->get('success_message'),'success','top-end');  
        }
        if($request->session()->has('error')){
            toast($request->session()->get('error'),'error','top-end');  
        }
        $plans=DB::table('bundle_plans')->get();
        return view('pages.plans',compact('plans'));
    }
    public function postPlan(Request $request){
        $request->validate([
            'plantitle'=>['required','unique:bundle_plans'],
            'planname'=>['required','unique:bundle_plans'],
            'cost'=>['required'],
            'desc'=>['required']
        ]);
    
        $p=DB::table('bundle_plans')->insert([
            ['plantitle'=>$request->get('plantitle'),'planname'=>$request->get('planname'),'cost'=>$request->get('cost'),'desc'=>$request->get('desc')]
        ]);
        if ($p) {
            return redirect()->back()->with("success_message","plan created successfully");
        }
    }
    public function getDeleteRec(){
        return view('pages.deleteaccrec');
    }
    public function postDeleteAcctRec(Request $request){
        $username=$request->get('username');
        $deleterec=DB::table('radacct')->where('username','=',$username)->delete();
        if ($deleterec) {
            echo"success";
        }else{
             echo"Accounting record for ".$username." were not found";
        }
       
    }
    public function getOperators(){
        $operators=DB::table('users')->get();
        return view('pages.operators',compact('operators'));
    }
    public function postOperator(Request $request){
        $request->validate([
            'name'=>['required','string','max:50'],
            'email'=>['unique:users','required','email','string','max:50'],
            'password'=>['required','confirmed','min:6','string','max:20'],
        ]);
        $password=Hash::make($request->get('password'));
        $operator=DB::table('users')->insert(['name'=>$request->get('name'),'email'=>$request->get('email'),'password'=>$password,'created_by'=>$request->get('created_by')]);
        if ($operator) {
           return redirect()->back()->with("success","operator has been added successfully");
        }else{
             return redirect()->back()->with("error","There was trouble creating the new operator, try again");
        }
    }
    public function editOperator(Request $request,$id){
        $operator=DB::table('users')->where('id','=',$id)->get();
        return view('pages.editoperator',compact('operator'));
    }
    public function postEditOperator(Request $request){
        $id=$request->get('id');
        $request->validate([
            'name'=>['required','string','max:50'],
            'email'=>['required','email','string','max:50'],
            'password'=>['required','min:6','string','max:20'],
        ]);
        $password=Hash::make($request->get('password'));
        $operator=DB::table('users')->where('id','=',$id)->update(['name'=>$request->get('name'),'email'=>$request->get('email'),'password'=>$password,'created_by'=>$request->get('created_by')]);
        if ($operator) {
           return redirect()->back()->with("success","operator has been updated successfully");
        }else{
             return redirect()->back()->with("error","There was trouble updating the operator, try again");
        }
    }
    public function deleteOperator(Request $request,$id){
        $user=\App\User::find($id);
        $user->delete();
        return redirect()->back()->with("success","operator deleted successfully");
    }
    public function getPlanEdit(Request $request,$id){
        $plan=DB::table('bundle_plans')->where('id','=',$id)->get();
        return view('pages.editplan',compact('plan'));
    }
    public function postEditPlan(Request $request){
        $id=$request->get('id');
         $request->validate([
            'plantitle'=>['required'],
            'planname'=>['required'],
            'cost'=>['required'],
        ]);
    
        $p=DB::table('bundle_plans')->where('id','=',$id)->update(
            ['plantitle'=>$request->get('plantitle'),'planname'=>$request->get('planname'),'cost'=>$request->get('cost'),'desc'=>$request->get('desc')]
        );
        if ($p) {
            return redirect()->back()->with("success","plan updated successfully");
        }else{
             return redirect()->back()->with("error","plan could not be updated");
        }
    }
    public function deletePlan(Request $request,$id){
        $plan=DB::table('bundle_plans')->where('id','=',$id)->delete();
        if ($plan) {
            return redirect()->back()->with("success","plan deleted successfully");
        }
    }
    public function getCleanStale(){
        return view('pages.cleanstale');
    }
    public function cleanStaleConn(Request $request){
        $username=$request->get('username');
        $staleconn=DB::table('radacct')->where([['username','=',$username],['acctstoptime','=',NULL]])->delete();
        if ($staleconn) {
            echo "success";
        }else{
            echo "failed";
        }
    }
    public function getServiceStatus()
    {
        return view('pages.servicestatus');
    }
    public function saveCustomerChanges(Request $request){
        //dd($request->all());
        $username=$request->get('username');
        $password=Hash::make($request->get('cleartextpassword'));
        $cleartextpassword=$request->get('cleartextpassword');
        $name=$request->get('name');
        $email=$request->get('email');
        $attributes=$request->get('attribute');
        $type=$request->get('type');
        $phone=$request->get('phone');
        $op=$request->get('op');
        $value=$request->get('value');
        $groups=$request->get('groupname');
        //update customer basic info
        if (isset($phone)) {
          $userinfo=DB::table('customers')->updateOrInsert(
                ['username'=>$username],
                ['name'=>$name,'password'=>$password,'phone'=>$phone,'email'=>$email,'cleartextpassword'=>$cleartextpassword]
            );  
        }        

        //assign user limit attributes 
        if(isset($attributes)){
            for ($i=0; $i < count($attributes); $i++) { 
                if ($type[$i]=='check') {
                    $customercheckattr=DB::table('radcheck')->updateOrInsert(
                        ['username'=>$username,'attribute'=>$attributes[$i]],
                        ['op'=>$op[$i],'value'=>$value[$i]]
                    );
                }else{
                     $customerreplyattr=DB::table('radreply')->updateOrInsert(
                        ['username'=>$username,'attribute'=>$attributes[$i]],
                        ['op'=>$op[$i],'value'=>$value[$i]]
                    );
                }
            }   
        }

        //assign user to groups
         if (isset($groups) && $groups!=" " && count($groups)>0) {
            for ($i=0; $i <count($groups) ; $i++) {
                if ($groups[$i]!=null && $groups[$i]!=" ") {
                    $usergroup=DB::table('radusergroup')->updateOrInsert(
                        ['username'=>$username,'groupname'=>$groups[$i]],
                        ['priority'=>'0']
                    );
                 }                 
            }
        }
        //redirect back

        return redirect()->back()->with("success","Customer details updated successfully");
    }
    public function getUserConnectivity(){
        return view('pages.testconnectivity');
    }
    public function postTestConn(Request $request){
        //radtest testing password localhost 0 testing123
        $cmd="radtest ".escapeshellarg($request->get('username'))." ".escapeshellarg($request->get('password'))." ".escapeshellarg($request->get('server'))." ".escapeshellarg($request->get('nasport'))." ".escapeshellarg($request->get('nassecret'));
        $res=system($cmd);
        if($res==" " || $res==NULL){
            echo "The command was not executed successfully";

        }else{
            echo $res;
        }
    }
    public function getUserLimits(){
        $userlimits=DB::table('limitattributes')->paginate(20);
        return view('pages.userlimits',compact('userlimits'));
    }
    public function removeuser(Request $request){
        $id = Route::current()->parameter('id');
        if ($id!=0 && $id!="") {
            $customer=DB::table('customers')->where('id','=',$id)->get();
            return view('pages.deletecustomer',compact('customer'));
        }
        else{
            return view('pages.deletecustomer');
        }
    }
    public function postRemoveUser(Request $request){
        $username=$request->get('username');
        $deleterecords=$request->get('deleterecords');
        $usercount=DB::table('customers')->where('username','=',$username)->count();
        if ($usercount>0) {
            //delete radcheck
        $user=DB::table('radcheck')->where('username','=',$username)->delete();

        //delete radreply
        $user=DB::table('radreply')->where('username','=',$username)->delete();


        //delete user from groups
       $user=DB::table('radusergroup')->where('username','=',$username)->delete();
       if ($deleterecords=="yes") {
            $user=DB::table('radacct')->where('username','=',$username)->delete();

       }
       //delete from customers
        $user=DB::table('customers')->where('username','=',$username)->delete();

       return redirect()->route('allcustomers')->with("success",$username." has been removed successfully");
        }else{
            return redirect()->back()->with("error","User ".$username." could not be found on radius database");
        }
        

    }
    public function deleteNas(Request $request,$id){
        $nas=DB::table('nas')->where('id','=',$id)->delete();
        if ($nas==true) {
           return redirect()->back()->with("success","Nas has been removed successfully");
        }else{
            return redirect()->back()->with("error","Nas could not be removed, try again");
        }
    }
    public function getTopUser(){
        $users=DB::table('radcheck')->distinct()->get(['username']);
       
        return view('pages.topuser');
    }
    public function getVouchers(){
        $plans=DB::table('bundle_plans')->get();
        return view('pages.vouchers',compact('plans'));
    }
     public function getSendsms(){
        return view('pages.sendsms');
    }
    public function saveVouchers(Request $request){
        $username=$request->get('username');
        $password=$request->get('password');
        $plan=$request->get('plan');
        $serialnumber=$request->get('serialnumber');
        $created_by=Auth::user()->email;
        $cost=$request->get('cost');
        foreach($username as $key=> $u){
            //save voucher data
            $voucher=DB::table('vouchers')->insert(['username'=>$u,'password'=>$password[$key],'serialnumber'=>$serialnumber[$key],'plan'=>$plan[$key],'created_by'=>$created_by,'cost'=>$cost]);

            //add user details to radius
            self::createUserPlan($u,$password[$key],$plan[$key]);
        }
        return redirect()->back()->with("success","Vouchers activated successfully");
    }
    public function getAutomatedCustomer(Request $request){
        $plans=DB::table('bundle_plans')->get();
        return view('pages.automateduser', compact('plans'));
    }
    public function automatedUser(Request $request){
        $username=$request->get('username');
        $password=$request->get('password');
        $plan=$request->get('plan');
        $phone=$request->get('phone');
        $phone='254'.substr($phone, 1);
        $res=self::createUserPlan($username,$password,$plan);
        if ($res==true) {
            $message="Your HewaNetWifi ".$plan." internet access credentials are, Username : ".$username." , Password : ".$password;
            self::createUserPlan($username,$password,$plan);
            $res=SendMessage::sendMessage($phone,$message);
            if ($res==true) {
                return redirect()->back()->with("success","customer created successfully and confirmation message sent to the customer.");
            }else{
                return redirect()->back()->with("success","customer created successfully but confirmation message wasn't sent to the customer.");
            }
        }
        else{
            return redirect()->back()->with("error",$res);
        }
    }
    public static function createUserPlan($username,$password,$plan){
        try{

        $userexist=DB::table('radcheck')->where('username','=',$username)->get();

                if (count($userexist)==0) {
                    //if yes, dont insert another record
                    $user=DB::table('radcheck')->insert(['username'=>$username,'attribute'=>'Cleartext-Password','op'=>':=','value'=>$password]);
                }
                
                //query if user has ever bought bundles
                $userhasboughtmbsbefore=DB::table('radreply')->where([['username','=',$username],['attribute','=','Max-All-MB']])->get();
            
                //if no, insert new record in radreply,radcheck with attributes max-all-mb,session-timeout,acct-interm interval


                //add user to the group of these purchased mbs
                if($plan=='50mbs'){
                    $initialbundle=0;                   
                    $bundlebought=(50*1024*1024);
                    $totalbundle=$bundlebought;
                    $remainder=0;

                    if (count($userhasboughtmbsbefore)>0) {
                        //if yes, query the max-all-mb value in radreply and radcheck,session-timeout in radreply andacct-interim interval in radreply and add the newly purchased bundle
                        foreach ($userhasboughtmbsbefore as $key => $mb) {
                            $initialbundle=$mb->value;
                        }
                        $deleteuser=DB::table('radreply')->where('username','=',$username)->delete();

                        //reduce the accounting data by whats bought
                        $userdownloads=DB::table('radacct')->where('username','=',$username)->sum('AcctInputOctets');
                        $useruploads=DB::table('radacct')->where('username','=',$username)->sum('AcctOutputOctets');
                        $totalAccounted=$userdownloads+$userdownloads;
                        $newAccounted=$totalAccounted-$bundlebought;
                        if ($totalAccounted>=$initialbundle) {
                            $deleteuseraccounts=DB::table('radacct')->where('username','=',$username)->delete();
                            $totalbundle=$bundlebought;
                        }else{
                            $deleteuseraccounts=DB::table('radacct')->where('username','=',$username)->delete();
                            $remainder=$initialbundle-$totalAccounted;
                            $totalbundle=$bundlebought+$remainder;
                        }
                        
                        
                    }
                    //update the record by creating a new record
                        $userupdatereply=DB::table('radreply')->insert([
                            ['username'=>$username,'attribute'=>'Max-All-MB','op'=>':=','value'=>$totalbundle],
                        ]);
                        $userupdatecheck=DB::table('radcheck')->updateOrInsert(
                            ['username'=>$username,'attribute'=>'Max-All-MB'],
                            ['op'=>':=','value'=>$totalbundle]
                        );
                        
                }
                else if($plan=='100mbs'){
                    $initialbundle=0;                   
                    $bundlebought=(100*1024*1024);
                    $totalbundle=$bundlebought;
                    $remainder=0;

                    if (count($userhasboughtmbsbefore)>0) {
                        //if yes, query the max-all-mb value in radreply and radcheck,session-timeout in radreply andacct-interim interval in radreply and add the newly purchased bundle
                        foreach ($userhasboughtmbsbefore as $key => $mb) {
                            $initialbundle=$mb->value;
                        }
                        $deleteuser=DB::table('radreply')->where('username','=',$username)->delete();

                        //reduce the accounting data by whats bought
                        $userdownloads=DB::table('radacct')->where('username','=',$username)->sum('AcctInputOctets');
                        $useruploads=DB::table('radacct')->where('username','=',$username)->sum('AcctOutputOctets');
                        $totalAccounted=$userdownloads+$userdownloads;
                        $newAccounted=$totalAccounted-$bundlebought;
                        if ($totalAccounted>=$initialbundle) {
                            $deleteuseraccounts=DB::table('radacct')->where('username','=',$username)->delete();
                            $totalbundle=$bundlebought;
                        }else{
                            $deleteuseraccounts=DB::table('radacct')->where('username','=',$username)->delete();
                            $remainder=$initialbundle-$totalAccounted;
                            $totalbundle=$bundlebought+$remainder;
                        }
                        
                        
                    }
                    //update the record by creating a new record
                        $userupdatereply=DB::table('radreply')->insert([
                            ['username'=>$username,'attribute'=>'Max-All-MB','op'=>':=','value'=>$totalbundle],
                            ]);
                        $userupdatecheck=DB::table('radcheck')->updateOrInsert(
                            ['username'=>$username,'attribute'=>'Max-All-MB'],
                            ['op'=>':=','value'=>$totalbundle]
                        );
                    
                }
                else if($plan=='250mbs'){
                    $initialbundle=0;                   
                    $bundlebought=(250*1024*1024);
                    $totalbundle=$bundlebought;
                    $remainder=0;

                    if (count($userhasboughtmbsbefore)>0) {
                        //if yes, query the max-all-mb value in radreply and radcheck,session-timeout in radreply andacct-interim interval in radreply and add the newly purchased bundle
                        foreach ($userhasboughtmbsbefore as $key => $mb) {
                            $initialbundle=$mb->value;
                        }
                        $deleteuser=DB::table('radreply')->where('username','=',$username)->delete();

                        //reduce the accounting data by whats bought
                        $userdownloads=DB::table('radacct')->where('username','=',$username)->sum('AcctInputOctets');
                        $useruploads=DB::table('radacct')->where('username','=',$username)->sum('AcctOutputOctets');
                        $totalAccounted=$userdownloads+$userdownloads;
                        $newAccounted=$totalAccounted-$bundlebought;
                        if ($totalAccounted>=$initialbundle) {
                            $deleteuseraccounts=DB::table('radacct')->where('username','=',$username)->delete();
                            $totalbundle=$bundlebought;
                        }else{
                            $deleteuseraccounts=DB::table('radacct')->where('username','=',$username)->delete();
                            $remainder=$initialbundle-$totalAccounted;
                            $totalbundle=$bundlebought+$remainder;
                        }
                        
                        
                    }
                    //update the record by creating a new record
                        $userupdatereply=DB::table('radreply')->insert([
                            ['username'=>$username,'attribute'=>'Max-All-MB','op'=>':=','value'=>$totalbundle],
                        ]);
                        $userupdatecheck=DB::table('radcheck')->updateOrInsert(
                            ['username'=>$username,'attribute'=>'Max-All-MB'],
                            ['op'=>':=','value'=>$totalbundle]
                        );
                    
                }
                else if($plan=='500mbs'){
                    $initialbundle=0;                   
                    $bundlebought=(500*1024*1024);
                    $totalbundle=$bundlebought;
                    $remainder=0;

                    if (count($userhasboughtmbsbefore)>0) {
                        //if yes, query the max-all-mb value in radreply and radcheck,session-timeout in radreply andacct-interim interval in radreply and add the newly purchased bundle
                        foreach ($userhasboughtmbsbefore as $key => $mb) {
                            $initialbundle=$mb->value;
                        }
                        $deleteuser=DB::table('radreply')->where('username','=',$username)->delete();

                        //reduce the accounting data by whats bought
                        $userdownloads=DB::table('radacct')->where('username','=',$username)->sum('AcctInputOctets');
                        $useruploads=DB::table('radacct')->where('username','=',$username)->sum('AcctOutputOctets');
                        $totalAccounted=$userdownloads+$userdownloads;
                        $newAccounted=$totalAccounted-$bundlebought;
                        if ($totalAccounted>=$initialbundle) {
                            $deleteuseraccounts=DB::table('radacct')->where('username','=',$username)->delete();
                            $totalbundle=$bundlebought;
                        }else{
                            $deleteuseraccounts=DB::table('radacct')->where('username','=',$username)->delete();
                            $remainder=$initialbundle-$totalAccounted;
                            $totalbundle=$bundlebought+$remainder;
                        }
                        
                        
                    }
                    //update the record by creating a new record
                        $userupdatereply=DB::table('radreply')->insert([
                            ['username'=>$username,'attribute'=>'Max-All-MB','op'=>':=','value'=>$totalbundle],
                            ['username'=>$username,'attribute'=>'Session-Timeout','op'=>':=','value'=>3600],
                            ['username'=>$username,'attribute'=>'Acct-Interim-Interval','op'=>':=','value'=>60]
                        ]);
                        $userupdatecheck=DB::table('radcheck')->updateOrInsert(
                            ['username'=>$username,'attribute'=>'Max-All-MB'],
                            ['op'=>':=','value'=>$totalbundle]
                        );
                        
                    
                }
                else if($plan=='1gb'){
                    $initialbundle=0;                   
                    $bundlebought=(1024*1024*1024);
                    $totalbundle=$bundlebought;
                    $remainder=0;

                    if (count($userhasboughtmbsbefore)>0) {
                        //if yes, query the max-all-mb value in radreply and radcheck,session-timeout in radreply andacct-interim interval in radreply and add the newly purchased bundle
                        foreach ($userhasboughtmbsbefore as $key => $mb) {
                            $initialbundle=$mb->value;
                        }
                        $deleteuser=DB::table('radreply')->where('username','=',$username)->delete();

                        //reduce the accounting data by whats bought
                        $userdownloads=DB::table('radacct')->where('username','=',$username)->sum('AcctInputOctets');
                        $useruploads=DB::table('radacct')->where('username','=',$username)->sum('AcctOutputOctets');
                        $totalAccounted=$userdownloads+$userdownloads;
                        $newAccounted=$totalAccounted-$bundlebought;
                        if ($totalAccounted>=$initialbundle) {
                            $deleteuseraccounts=DB::table('radacct')->where('username','=',$username)->delete();
                            $totalbundle=$bundlebought;
                        }else{
                            $deleteuseraccounts=DB::table('radacct')->where('username','=',$username)->delete();
                            $remainder=$initialbundle-$totalAccounted;
                            $totalbundle=$bundlebought+$remainder;
                        }
                        
                        
                    }
                    //update the record by creating a new record
                        $userupdatereply=DB::table('radreply')->insert([
                            ['username'=>$username,'attribute'=>'Max-All-MB','op'=>':=','value'=>$totalbundle],
                            ['username'=>$username,'attribute'=>'Session-Timeout','op'=>':=','value'=>3600],
                            ['username'=>$username,'attribute'=>'Acct-Interim-Interval','op'=>':=','value'=>60]
                        ]);
                        $userupdatecheck=DB::table('radcheck')->updateOrInsert(
                            ['username'=>$username,'attribute'=>'Max-All-MB'],
                            ['op'=>':=','value'=>$totalbundle]
                        );
                    
                }else if($plan=='2gb'){
                    $initialbundle=0;                   
                    $bundlebought=(2048*1024*1024);
                    $totalbundle=$bundlebought;
                    $remainder=0;

                    if (count($userhasboughtmbsbefore)>0) {
                        //if yes, query the max-all-mb value in radreply and radcheck,session-timeout in radreply andacct-interim interval in radreply and add the newly purchased bundle
                        foreach ($userhasboughtmbsbefore as $key => $mb) {
                            $initialbundle=$mb->value;
                        }
                        $deleteuser=DB::table('radreply')->where('username','=',$username)->delete();

                        //reduce the accounting data by whats bought
                        $userdownloads=DB::table('radacct')->where('username','=',$username)->sum('AcctInputOctets');
                        $useruploads=DB::table('radacct')->where('username','=',$username)->sum('AcctOutputOctets');
                        $totalAccounted=$userdownloads+$userdownloads;
                        $newAccounted=$totalAccounted-$bundlebought;
                        if ($totalAccounted>=$initialbundle) {
                            $deleteuseraccounts=DB::table('radacct')->where('username','=',$username)->delete();
                            $totalbundle=$bundlebought;
                        }else{
                            $deleteuseraccounts=DB::table('radacct')->where('username','=',$username)->delete();
                            $remainder=$initialbundle-$totalAccounted;
                            $totalbundle=$bundlebought+$remainder;
                        }
                        
                        
                    }
                    //update the record by creating a new record
                        $userupdatereply=DB::table('radreply')->insert([
                            ['username'=>$username,'attribute'=>'Max-All-MB','op'=>':=','value'=>$totalbundle],
                            ['username'=>$username,'attribute'=>'Session-Timeout','op'=>':=','value'=>3600],
                            ['username'=>$username,'attribute'=>'Acct-Interim-Interval','op'=>':=','value'=>60]
                        ]);
                        $userupdatecheck=DB::table('radcheck')->updateOrInsert(
                            ['username'=>$username,'attribute'=>'Max-All-MB'],
                            ['op'=>':=','value'=>$totalbundle]
                        );
                    
                }else if($plan=='5gb'){
                    $initialbundle=0;                   
                    $bundlebought=(5120*1024*1024);
                    $totalbundle=$bundlebought;
                    $remainder=0;

                    if (count($userhasboughtmbsbefore)>0) {
                        //if yes, query the max-all-mb value in radreply and radcheck,session-timeout in radreply andacct-interim interval in radreply and add the newly purchased bundle
                        foreach ($userhasboughtmbsbefore as $key => $mb) {
                            $initialbundle=$mb->value;
                        }
                        $deleteuser=DB::table('radreply')->where('username','=',$username)->delete();

                        //reduce the accounting data by whats bought
                        $userdownloads=DB::table('radacct')->where('username','=',$username)->sum('AcctInputOctets');
                        $useruploads=DB::table('radacct')->where('username','=',$username)->sum('AcctOutputOctets');
                        $totalAccounted=$userdownloads+$userdownloads;
                        $newAccounted=$totalAccounted-$bundlebought;
                        if ($totalAccounted>=$initialbundle) {
                            $deleteuseraccounts=DB::table('radacct')->where('username','=',$username)->delete();
                            $totalbundle=$bundlebought;
                        }else{
                            $deleteuseraccounts=DB::table('radacct')->where('username','=',$username)->delete();
                            $remainder=$initialbundle-$totalAccounted;
                            $totalbundle=$bundlebought+$remainder;
                        }
                        
                        
                    }
                    //update the record by creating a new record
                        $userupdatereply=DB::table('radreply')->insert([
                            ['username'=>$username,'attribute'=>'Max-All-MB','op'=>':=','value'=>$totalbundle],
                            ['username'=>$username,'attribute'=>'Session-Timeout','op'=>':=','value'=>7200],
                            ['username'=>$username,'attribute'=>'Acct-Interim-Interval','op'=>':=','value'=>60]
                        ]);
                        $userupdatecheck=DB::table('radcheck')->updateOrInsert(
                            ['username'=>$username,'attribute'=>'Max-All-MB'],
                            ['op'=>':=','value'=>$totalbundle]
                        );
                    
                }
                else if($plan=='monthlyplan'){
                    $year=date("Y");
                    $month=date("n");
                    $day=date("j");
                    $hour=date("H");
                    $min=date("i");
                    $sec=date("s");

                    $dateTo=mktime($hour,$min,$sec,$month,($day+30),$year);
                    $dateToDisconnect=date("Y-m-dTH:i:s",$dateTo);
                    $dateToDisconnect=str_replace('CET', 'T', $dateToDisconnect);
                    $dateToDisconnect=str_replace('am', '', $dateToDisconnect);
                    $dateToDisconnect=str_replace('UTC', 'T', $dateToDisconnect);
                    $dateToDisconnect=str_replace('CES', 'T', $dateToDisconnect);
                    $dateToDisconnect=str_replace('pm', '', $dateToDisconnect);
                    $usergroup=DB::table('radusergroup')->updateOrInsert(
                        ['username'=>$username],
                        ['groupname'=>$plan,'priority'=>0]
                    );
                    $user=DB::table('radreply')->updateOrInsert(
                        ['username'=>$username,'attribute'=>'WISPr-Session-Terminate-Time'],
                        ['value'=>$dateToDisconnect,'op'=>':=']
                    );
                    
                }else if($plan=='dailyplan'){
                    $year=date("Y");
                    $month=date("n");
                    $day=date("j");
                    $hour=date("H");
                    $min=date("i");
                    $sec=date("s");

                    $dateTo=mktime(($hour+1),$min,$sec,$month,($day+1),$year);
                    $dateToDisconnect=date("Y-m-dTH:i:s",$dateTo);
                    $dateToDisconnect=str_replace('CET', 'T', $dateToDisconnect);
                    $dateToDisconnect=str_replace('am', '', $dateToDisconnect);
                    $dateToDisconnect=str_replace('UTC', 'T', $dateToDisconnect);
                    $dateToDisconnect=str_replace('CES', 'T', $dateToDisconnect);
                    $dateToDisconnect=str_replace('pm', '', $dateToDisconnect);
                    $usergroup=DB::table('radusergroup')->updateOrInsert(
                        ['username'=>$username],
                        ['groupname'=>$plan,'priority'=>0]
                    );
                    $user=DB::table('radreply')->updateOrInsert(
                        ['username'=>$username,'attribute'=>'WISPr-Session-Terminate-Time'],
                        ['value'=>$dateToDisconnect,'op'=>':=']
                    );
                }
                else if($plan=='weeklyplan'){
                    $year=date("Y");
                    $month=date("n");
                    $day=date("j");
                    $hour=date("H");
                    $min=date("i");
                    $sec=date("s");

                    $dateTo=mktime($hour,$min,$sec,$month,($day+7),$year);
                    $dateToDisconnect=date("Y-m-dTH:i:s",$dateTo);
                    $dateToDisconnect=str_replace('CET', 'T', $dateToDisconnect);
                    $dateToDisconnect=str_replace('am', '', $dateToDisconnect);
                    $dateToDisconnect=str_replace('UTC', 'T', $dateToDisconnect);
                    $dateToDisconnect=str_replace('CES', 'T', $dateToDisconnect);
                    $dateToDisconnect=str_replace('pm', '', $dateToDisconnect);
                    $usergroup=DB::table('radusergroup')->updateOrInsert(
                        ['username'=>$username],
                        ['groupname'=>$plan,'priority'=>0]
                    );
                    $user=DB::table('radreply')->updateOrInsert(
                        ['username'=>$username,'attribute'=>'WISPr-Session-Terminate-Time'],
                        ['value'=>$dateToDisconnect,'op'=>':=']
                    );
                }
        return true;
        }catch(Exception $e){
            return $e;
        }
    }
    public function getAllVouchers(){
        $availablev=DB::table('vouchers')->where('status','=','notsold')->paginate(6);
        return view('pages.allvouchers',compact('usedv','availablev'));
    }
    public function getSellVoucher(Request $request,$id){
        $voucher=DB::table('vouchers')->where([['id','=',$id],['status','=','notsold']])->get();
        return view('pages.sellvoucher',compact('voucher'));
    }
    public function markVoucherPaid(Request $request){
        $id=$request->get('id');
        $plan=$request->get('plan');
        $cost=$request->get('cost');
        $username=$request->get('username');
        $serialnumber=$request->get('serialnumber');
        $date=date("YmdHis");
        $detail=DB::table('vouchers')
              ->where('id', $id)
              ->update(['status' => 'sold']);
              if($detail){
                $transaction=DB::table('transactions')->insert(['username'=>$username,'payment_method'=>'Voucher sold','amount'=>$cost,'plan'=>$plan,'transaction_id'=>$serialnumber,'transaction_date'=>$date,'phone_number'=>0]);
                echo "success";
              }else{
                echo "There was an error marking voucher as sold";
              }
    }
    public function bundlebalance(Request $request){
        return view('pages.bundlebalance');
    }
    public function fetchBalance(Request $request){
        $username=$request->get('username');

        $user=DB::table('radcheck')->where('username','=',$username)->get();
        $mbsused=0;
        $totalbytesrecord=0;
        $remainder=0;
        if(count($user)>0){
            $userdata=DB::table('radcheck')->where([['username','=',$username],['attribute','=','Max-All-MB']])->get();
            foreach ($userdata as $key => $data) {
                $totalbytesrecord=$data->value;
            }
            $totaldownbs=DB::table('radacct')->where('username','=',$username)->sum('AcctInputOctets');
            $totalupbs=DB::table('radacct')->where('username','=',$username)->sum('AcctOutputOctets');
            $mbsused=($totaldownbs+$totalupbs)/(1024*1024);

            $totalbytesrecord=($totalbytesrecord/(1024*1024));
            $remainder=$totalbytesrecord-$mbsused;

             echo '<tr><td>'.round($totalbytesrecord,2).' MBs</td><td>'.round($mbsused,2).' MBs</td><td>'.round($remainder,2).' MBs</td></tr>';
        }else{
            echo "error";
        }
        
    }
    public function getEditgroup(Request $request,$groupname){
        $groupname=$groupname;
        $checklimits=DB::table('radgroupcheck')->where('groupname','=',$groupname)->get();
        $replylimits=DB::table('radgroupreply')->where('groupname','=',$groupname)->get();
        $limitattributes=DB::table('limitattributes')->get();
        return view('pages.editgroup',compact('groupname','checklimits','replylimits','limitattributes'));
    }
    public function getDeletegroup($groupname){
        $delcheck=DB::table('radgroupcheck')->where('groupname','=',$groupname)->delete();
        $delreply=DB::table('radgroupreply')->where('groupname','=',$groupname)->delete();
        $delusergroup=DB::table('radusergroup')->where('groupname','=',$groupname)->delete();
        $delgrp=DB::table('user_groups')->where('groupname','=',$groupname)->delete();
        return redirect()->route('userlimitgroups')->with('success','group with associated users removed successfully');
    }
    public function postEditedGroup(Request $request){
        $attribute=$request->get('attribute');
        $attributevalue=$request->get('value');
        $op=$request->get('op');
        $type=$request->get('type');
        $groupname=$request->get('groupname');
        if(isset($attribute)){
            for ($i=0; $i < count($attribute); $i++) { 
                    if($type[$i]=='reply'){
                        DB::table('radgroupreply')->updateOrInsert(
                            ['groupname'=>$groupname,'attribute'=>$attribute[$i]],
                            ['op'=>$op[$i],'value'=>$attributevalue[$i]]
                        );  
                    }else{
                        DB::table('radgroupcheck')->updateOrInsert(
                            ['groupname'=>$groupname,'attribute'=>$attribute[$i]],
                            ['op'=>$op[$i],'value'=>$attributevalue[$i]]
                        );
                    }
                
            }
        }
        return redirect()->back()->with("success","group limits updated successfully");
    }
    public function postDeleteCheckLimit(Request $request,$id){
        $removelim=DB::table('radgroupcheck')->where('id','=',$id)->delete();
        return redirect()->back()->with("success","Limit removed successfully from the group");
    }
    public function postDeleteReplyLimit(Request $request,$id){
        $removelim=DB::table('radgroupreply')->where('id','=',$id)->delete();
        return redirect()->back()->with("success","Limit removed successfully from the group");
    }
     public function postDeleteCheckUserLimit(Request $request,$id){
        $removelim=DB::table('radcheck')->where('id','=',$id)->delete();
        return redirect()->back()->with("success","user limits updated successfully");
    }
    public function postDeleteReplyUserLimit(Request $request,$id){
        $removelim=DB::table('radreply')->where('id','=',$id)->delete();
        return redirect()->back()->with("success","user limits updated successfully");
    }
    public function searchUser(Request $request){
        $skey=$request->get('skey');
        $usernames=DB::table('radcheck')->where('username','LIKE','%'.$skey.'%')->pluck('username');
        $output="";
        foreach($usernames as $u){
            $output.= "<p>".$u."</p>";
        }
        $output.="";
        echo $output;
    }
    public function disconnectUser(){
        $nas=DB::table('nas')->get();
        return view('pages.disconnectcustomer',compact('nas'));
    }
    public function restartFreeradius(Request $request){
        shell_exec("systemctl restart freeradius.service");
        return redirect()->back()->with("message","Freeradius server restarted successfully");
    }
    public function restartApache(Request $request){
        die(shell_exec("systemctl restart apache2.service"));
        //return redirect()->back()->with("message","web server restarted successfully");
    }
    public function restartMysql(Request $request){
        shell_exec("systemctl restart mysql.service");
        return redirect()->back()->with("message","Mysql server restarted successfully");
    }
}
