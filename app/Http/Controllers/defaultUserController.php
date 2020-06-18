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
    
    public function index(){
    	return view('users.index');
    }
    public function credentials(){
    	return view('users.credentials');
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
        $plan=$request->get('plan');
        $bundle=DB::table('radusergroup')->where([['username','=',$username],['groupname','=',$plan]])->get();
        if(count($bundle)==0){
            echo "error";
        }else{
            if($plan=='50mb'){
                $totalbytesbgt=(50*1024*1024);
                $totalbytesused=DB::table('radacct')->sum('AcctInpuOctets')->where('username','=',$username);
                $totalmbsbalance=(($totalbytesbgt-$totalbytesused)/(1024*1024));
                echo '<tr><td>'.$totalbytesbgt/(1024*1024).'</td><td>'.$totalbytesused/(1024*1024).'</td><td>'.$totalmbsbalance.'</td></tr>';
            }else if($plan=='100mb'){
                $totalbytesbgt=(100*1024*1024);
                $totalbytesused=DB::table('radacct')->sum('AcctInpuOctets')->where('username','=',$username);
                $totalmbsbalance=(($totalbytesbgt-$totalbytesused)/(1024*1024));
                echo '<tr><td>'.$totalbytesbgt/(1024*1024).'</td><td>'.$totalbytesused/(1024*1024).'</td><td>'.$totalmbsbalance.'</td></tr>';
            }else if($plan=='500mb'){
                $totalbytesbgt=(500*1024*1024);
                $totalbytesused=DB::table('radacct')->sum('AcctInputOctets')->where('username','=',$username);
                $totalmbsbalance=(($totalbytesbgt-$totalbytesused)/(1024*1024));
                echo '<tr><td>'.$totalbytesbgt/(1024*1024).'</td><td>'.$totalbytesused/(1024*1024).'</td><td>'.$totalmbsbalance.'</td></tr>';
            }
        }
    }
}
