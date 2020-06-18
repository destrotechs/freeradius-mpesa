<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use App\Mpesa;
use DB;
use Auth;
class paymentController extends Controller
{
    public function postPayToGetCredentials(Request $request){
    	$phone=$request->get('phone');
    	$amount=$request->get('amount');
    	$plan=$request->get('plan');
    	$username='';
    	$password='';
    	$permitted_chars_username = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    	$permitted_chars_password = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    	$token=Mpesa::generateToken();
    	$requestCheckoutId=Mpesa::processRequest($token,$phone,$amount);

    	if($requestCheckoutId!=""){
    		sleep(30);
	    	$transactionResult=Mpesa::querySTKPush($token,$requestCheckoutId);
	    	if ($transactionResult=='success') {
	    		//save the transaction details from callback
	    		//generate username and password
	    		if (isset(Auth::user()->username)) {
	    			$username=Auth::user()->username;
	    			$password= Auth::user()->cleartextpassword;
	    		}else{
		    		$username=substr(str_shuffle($permitted_chars_username), 0, 6);
		    		$password= substr(str_shuffle($permitted_chars_password), 0, 5);
	    		}
	    		//save the username and password on db
	    		$user=DB::table('radcheck')->insert(['username'=>$username,'attribute'=>'Cleartext-Password','op'=>':=','value'=>$password]);
	    		//add user to the group of these purchased mbs
	    		if($plan=='50mbs'){
	    			$usergroup=DB::table('radusergroup')->updateOrInsert(['username'=>$username],['groupname'=>'50mbs','priority'=>0]);
	    		}
	    		else if($plan=='100mbs'){
	    			$usergroup=DB::table('radusergroup')->updateOrInsert(['username'=>$username],['groupname'=>'100mbs','priority'=>0]);
	    		}
	    		else if($plan=='500mbs'){
	    			$usergroup=DB::table('radusergroup')->updateOrInsert(
	    				['username'=>$username],
	    				['groupname'=>'500mbs','priority'=>0]
	    			);
	    		}
	    		//clean the radacct details for new records
	    		$delUserAcctDetail=DB::table('radacct')->where('username','=',$username)->delete();
	    		//send username and password to the user phone number
	    		$p='254'.substr($phone, 1);
	            $smsgatewaUrl='https://sms.movesms.co.ke/api/compose?';
	            $curl=curl_init();
	            curl_setopt($curl, CURLOPT_URL, $smsgatewaUrl);
	            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
	            $data_string = array(
	                'username'=>'HewaNet',
	                'api_key'=>'c04EhaD3ipcTGztn5albuExDHTdLCRPzP0BYUNYYF32UxShhDc',
	                'sender'=>'SMARTLINK',
	                'to'=>$p,
	                'message'=>'Your HEWANET internet access codes are: Username : '.$username.", Password :".$password,
	                'msgtype'=>'5',
	                'dlr'=>'1',
	            );
	            $data=json_encode($data_string);
	            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	            curl_setopt($curl, CURLOPT_POST, true);
	            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
	            curl_setopt($curl, CURLOPT_HEADER, false);
	            $curl_response=curl_exec($curl);
	            $resultcode=$curl_response;
	            if($resultcode=='Message Sent:1701'){
	                echo "Your internet access credentials are username :".$username." Password :".$password." Text Message has been sent successfully, if you don't receive the sms within 5 minutes, please contact admin";
	            }else{
	                echo "Your credentials are, username :".$username." Password :".$password." Message could not be sent";
	            }
	    		//alert the user the status of transaction
	    		//echo "username :".$username." Password :".$password;
	    	}else if ($transactionResult=='error') {
	    		echo"error";
	    	}
    	}else {
	    		echo"error";
	    }
    	
    }
}
