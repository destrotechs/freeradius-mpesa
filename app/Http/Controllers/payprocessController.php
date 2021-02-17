<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;

class payprocessController extends Controller
{
    public static function createNewTempCustomer($username,$password){
    	$user=DB::table('radcheck')->insert(['username'=>$username,'attribute'=>'Cleartext-Password','op'=>':=','value'=>$password]);
    	if ($user==true) {
    		return "success";
    	}else{
    		return "error";
    	}
    }
    public static function saveTransaction($phone,$receiptno,$plan,$amount,$paydate,$paymentmethod,$username){
    	$transaction=DB::table('transactions')->insert([
    				['username'=>$username,'payment_method'=>'Mpesa','amount'=>$payed_amount,'plan'=>$plan,'transaction_id'=>$payment_id,'transaction_date'=>$payment_date,'phone_number'=>$payment_phone]
    			]);
    	if ($transaction==true) {
    		return "success";
    	}else{
    		return "error";
    	}
    }
    public static function createBillPlan($username,$password,$plan){
    	switch ($plan) {
    		case '50mbs':
    			
    			break;
    		
    		default:
    			# code...
    			break;
    	}
    }
}
