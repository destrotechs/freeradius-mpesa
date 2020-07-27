<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use DB;
use Illuminate\Support\Facades\Validator;
class adminController extends Controller
{
    public function getIndex(Request $request){
    	return view('admin.index');
    }
    public function getPlans(Request $request){
    	if($request->session()->has('success_message')){
            toast($request->session()->get('success_message'),'success','top-end');  
        }
        if($request->session()->has('error')){
            toast($request->session()->get('error'),'error','top-end');  
        }
    	$plans=DB::table('bundle_plans')->get();
    	return view('admin.plans',compact('plans'));
    }
    public function getCustomers(Request $request){
    	if($request->session()->has('success_message')){
            toast($request->session()->get('success_message'),'success','top-end');  
        }
        if($request->session()->has('error')){
            toast($request->session()->get('error'),'error','top-end');  
        }
    	$customers=DB::table('radcheck')->paginate(15);
    	return view('admin.customers',compact('customers'));
    }
    public function getPayments(Request $request){
    	$payments=DB::table('transactions')->paginate(15);
    	$totalsum=DB::table('transactions')->sum('amount');
    	return view('admin.payments',compact('payments','totalsum'));
    }
    public function postCustomer(Request $request){
    	$validator=Validator::make($request->all(),[
    		'username'=>['required','unique:radcheck','unique:customers'],
    		'value'=>['required']
    	]);
    	if ($validator->fails()) {
    		return redirect()->back()->with("error",$validator->messages()->all()[0]);
    	}
    	$c=DB::table('radcheck')->insert([
    		['username'=>$request->get('username'),'attribute'=>$request->get('attribute'),'op'=>$request->get('op'),'value'=>$request->get('value')]
    	]);
    	if ($c) {
    		return redirect()->back()->with("success_message","user created successfully");
    	}
    }

    public function postPlan(Request $request){
    	$validator=Validator::make($request->all(),[
    		'plantitle'=>['required','unique:bundle_plans'],
    		'planname'=>['required','unique:bundle_plans'],
    		'cost'=>['required'],
    		'desc'=>['required']
    	]);
    	if ($validator->fails()) {
    		return redirect()->back()->with("error",$validator->messages()->all()[0]);
    	}
    	$p=DB::table('bundle_plans')->insert([
    		['plantitle'=>$request->get('plantitle'),'planname'=>$request->get('planname'),'cost'=>$request->get('cost'),'desc'=>$request->get('desc')]
    	]);
    	if ($p) {
    		return redirect()->back()->with("success_message","plan created successfully");
    	}
    }
    public function getGroupsAndAttr(Request $request){
    	if($request->session()->has('success_message')){
            toast($request->session()->get('success_message'),'success','top-end');  
        }
        if($request->session()->has('error')){
            toast($request->session()->get('error'),'error','top-end');  
        }
    	$groups=DB::table('radgroupreply')->select('groupname')->distinct()->get();
    	return view('admin.groupsandattr',compact('groups'));
    }
    public function postSearchUser(Request $request){
    	$hint=$request->get('myhint');
    	$user=DB::table('radcheck')->where('username','LIKE','%'.$hint.'%')->get();
    	foreach ($user as $key => $u) {
    		echo '<option value="'.$u->username.'">'.$u->username.'</option>';
    	}
    }
    public function postGroupsAndAttr(Request $request){
    	//dd($request->all());
    	$attribute=$request->get('attribute');
    	$username=$request->get('username');
    	$attributevalue=$request->get('value');
    	$op=$request->get('op');
    	$type=$request->get('type');
    	$groupreply=$request->get('radgroupreply');

    	for ($i=0; $i < count($attribute); $i++) { 
    		
    		if($type[$i]=='check' && $groupreply!=""){
    			DB::table('radgroupcheck')->updateOrInsert(
    				['groupname'=>$groupreply,'attribute'=>$attribute[$i]],
    				['op'=>$op[$i],'value'=>$attributevalue[$i]]
    			);
    			DB::table('radusergroup')->updateOrInsert(
    				['username'=>$username],
    				['groupname'=>$groupreply,'priority'=>0]
    			);
    		}else if($type[$i]=='reply' && $groupreply!=""){
    			DB::table('radgroupreply')->updateOrInsert(
    				['groupname'=>$groupreply,'attribute'=>$attribute[$i]],
    				['op'=>$op[$i],'value'=>$attributevalue[$i]]
    			);
    			DB::table('radusergroup')->updateOrInsert(
    				['username'=>$username],
    				['groupname'=>$groupreply,'priority'=>0]
    			);
    		}else{
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

    	return redirect()->back()->with("success_message","attributes applied successfully to ".$username);
    }
}
