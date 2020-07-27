<?php

namespace App\Http\Controllers;
use App\Mpesa;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use DB;
use Auth;
use App\Customer;

class defaultUserController extends Controller
{
    
    public function index(Request $request){
        if($request->session()->has('success_message')){
            Alert::success("success",$request->session()->get('success_message'));  
        }
        if($request->session()->has('error')){
            Alert::error($request->session()->get('error'));  
        }
        $plans=DB::table('bundle_plans')->limit(3)->get();
        
    	return view('users.index',compact('plans'));
    }
    public function credentials(){
        $plans=DB::table('bundle_plans')->get();
    	return view('users.credentials',compact('plans'));
    }
    public function signup(Request $request){
        if($request->session()->has('success_message')){
            Alert::success("success",$request->session()->get('success_message'));  
        }
        if($request->session()->has('error')){
            Alert::error($request->session()->get('error'));  
        }
    	return view('users.signup');
    }
    public function signin(Request $request){
        if($request->session()->has('success_message')){
            Alert::success("success",$request->session()->get('success_message'));  
        }
        if($request->session()->has('error')){
            Alert::error($request->session()->get('error'));  
        }
    	return view('users.signin');
    }
    public function postSignup(Request $request){
    	$request->validate([
    		'name'=>'required|max:25',
    		'phone'=>'required|min:10|max:10|unique:tempaccount',
    		'username'=>'required|unique:customers|min:6|unique:radcheck',
    		'password'=>'required|min:4',
    	]);
    	$p=Hash::make($request->get('password'));
    	$password=$request->get('password');
    	$name=$request->get('name');
    	$phone=$request->get('phone');
    	$username=$request->get('username');
    	$email=$request->get('email');

        $customer= new Customer;
        $customer->name=$name;
        $customer->email=$email;
        $customer->phone=$phone;
        $customer->username=$username;
        $customer->password=$p;
        $customer->cleartextpassword=$password;
        $customer->save();
    	//$user=DB::table('customers')->insert(['name'=>$name,'email'=>$email,'phone'=>$phone,'username'=>$username,'password'=>$p,'cleartextpassword'=>$password]);
    	if ($customer==true) {
    		 
            Auth::login($customer);
            return redirect()->route('home')->with('success_message','Your account has been created successfully!');
    	}
    }
    public function postSignin(Request $request){
    	  $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            // Authentication passed...
            return redirect()->intended(route('home'));
        }else{
        	return redirect()->back()->with("error","wrong username or password!");
        }
    	
    }
    public function bundlebalance(Request $request){
        return view('users.checkbalance');
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
            $mbsused=($totaldownbs+$totalupbs);

            $totalbytesrecord=($totalbytesrecord/(1024*1024));
            $mbsused=2;
            $remainder=$totalbytesrecord-$mbsused;

             echo '<tr><td>'.round($totalbytesrecord,2).' MBs</td><td>'.round($mbsused,2).' MBs</td><td>'.round($remainder,2).' MBs</td></tr>';
        }else{
            echo "error";
        }
        
    }
    public function getAllPlans(Request $request){
         if($request->session()->has('success_message')){
            Alert::success("success",$request->session()->get('success_message'));  
        }
        if($request->session()->has('error')){
            Alert::error($request->session()->get('error'));  
        }
        $plans=DB::table('bundle_plans')->get();
        return view('users.bundleplans',compact('plans'));
    }
    public function buyBundlePlan(Request $request,$id){
        $plan=DB::table('bundle_plans')->where('id','=',$id)->get();
        return view('users.buybundle',compact('plan'));
    }
    public function Error(){
        return view('users.ment');
    }
}
