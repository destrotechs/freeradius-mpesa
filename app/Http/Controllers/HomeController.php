<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Auth;
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
}
