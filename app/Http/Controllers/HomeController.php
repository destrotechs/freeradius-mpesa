<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Auth;
use Validator;
use DB;
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
    public function getIndex(Request $request)
    {
        if($request->session()->has('success_message')){
            Alert::success("success",$request->session()->get('success_message'));  
        }
        if($request->session()->has('error')){
            Alert::error($request->session()->get('error'));  
        }
        return view('users.dashboard');
    }
    public function getLogout(){
        Auth::logout();
        return redirect()->route('login');
    }
    public function getChangePhone(Request $request){
        if($request->session()->has('success_message')){
            Alert::success("success",$request->session()->get('success_message'));  
        }
        if($request->session()->has('error')){
            Alert::error($request->session()->get('error'));  
        }
        return view('users.changephone');
    }
    public function postChangePhone(Request $request){
        $validator=Validator::make($request->all(),[
            'phone'=>['required','min:10','max:10','unique:customers'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error',$validator->messages()->all()[0]);
        }
        $username=Auth::user()->username;
        $phone=Auth::user()->phone;
        $phoneupdate=$request->get('phone');
        $user= DB::table('customers')->where('phone','=',$phone)->get();
        if (count($user)>0) {
            $userupdate=DB::table('customers')->where('username','=',$username)->update(['phone'=>$phoneupdate]);
            return redirect()->back()->with("success_message","Phone number was updated successfully");
        }else{
            return redirect()->back()->with('error','No user was found with the current phone number');
        }
    }
    public function getTransactions(Request $request){
        $username=Auth::user()->username;
        $transactions=DB::table('transactions')->where('username','=',$username)->get();
        return view('users.transactions',compact('transactions'));
    }
}
