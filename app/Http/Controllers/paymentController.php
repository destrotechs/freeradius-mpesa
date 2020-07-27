<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use App\Mpesa;
use DB;
use Auth;
use Validator;
class paymentController extends Controller
{
    public function postPayToGetCredentials(Request $request){
    	$validator=Validator::make($request->all(),[
    		'phone'=>['required','min:10','max:10'],
    		'plan'=>['required'],
    		'amount'=>['required'],
    	]);

    	if ($validator->fails()) {
    		if($request->ajax()){
    			echo "error";
	    	}else{
	    		return redirect()->back()->with('error',$validator->messages()->all()[0]);
	    	}
    		
    	}else{
    	$phone=$request->get('phone');
    	$amount=$request->get('amount');
    	$plan=$request->get('plan');
    	//dd($phone.$amount.$plan);
    	$username='';
    	$password='';
    	$permitted_chars_username = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
    	$permitted_chars_password = '23456789abcdefghjklmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ';
    	$token=Mpesa::generateToken();
    	$requestCheckoutId=Mpesa::processRequest($token,$phone,$amount);

    	if($requestCheckoutId!="" && $requestCheckoutId!='error'){
    		sleep(35);
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
	    		//save transaction details
	    		$callbackinfo=json_decode(trim(file_get_contents("https://hewanet.co.ke/churchcallback/callback.txt")),true);
	    		$resData=$callbackinfo['Body']['stkCallback']['CallbackMetadata']['Item'];
	    		if($resData!=NULL 	&& $resData!=""){
    				foreach ($resData as $key => $metadata) {
    					if($metadata['Name']=="Amount"){
    						$payed_amount=$metadata['Value'];
    					}else if($metadata['Name']=="MpesaReceiptNumber"){
    						$payment_id=$metadata['Value'];
    					}else if($metadata['Name']=="TransactionDate"){
    						$payment_date=$metadata['Value'];
    					}else if($metadata['Name']=="PhoneNumber"){
    						$payment_phone=$metadata['Value'];
    					}
    				}//end foreach
    			}
    			$transaction=DB::table('transactions')->insert([
    				['username'=>$username,'payment_method'=>'Mpesa','amount'=>$payed_amount,'plan'=>$plan,'transaction_id'=>$payment_id,'transaction_date'=>$payment_date,'phone_number'=>$payment_phone]
    			]);

	    		//save the username and password on db

	    		
	    		//check if username already exist in radcheck
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
<<<<<<< HEAD
	    			$initialbundle=0;
		    		$totalbundle=(50*1024*1024);
=======
	    			$initialbundle=0;		    		
		    		$bundlebought=(50*1024*1024);
		    		$totalbundle=$bundlebought;
		    		$remainder=0;
>>>>>>> 31c19eb... updating files, all

		    		if (count($userhasboughtmbsbefore)>0) {
		    			//if yes, query the max-all-mb value in radreply and radcheck,session-timeout in radreply andacct-interim interval in radreply and add the newly purchased bundle
		    			foreach ($userhasboughtmbsbefore as $key => $mb) {
		    				$initialbundle=$mb->value;
<<<<<<< HEAD
		    				$totalbundle+=$initialbundle;
		    			}
		    			$deleteuser=DB::table('radreply')->where('username','=',$username)->delete();
=======
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
		    			
>>>>>>> 31c19eb... updating files, all
		    			
		    		}
		    		//update the record by creating a new record
		    			$userupdatereply=DB::table('radreply')->insert([
		    				['username'=>$username,'attribute'=>'Max-All-MB','op'=>':=','value'=>$totalbundle],
		    				['username'=>$username,'attribute'=>'Session-Timeout','op'=>':=','value'=>600],
		    				['username'=>$username,'attribute'=>'Acct-Interim-Interval','op'=>':=','value'=>60]
		    			]);
		    			$userupdatecheck=DB::table('radcheck')->updateOrInsert(
		    				['username'=>$username,'attribute'=>'Max-All-MB'],
		    				['op'=>':=','value'=>$totalbundle]
		    			);
		    			
	    		}
	    		else if($plan=='100mbs'){
<<<<<<< HEAD
	    			$initialbundle=0;
		    		$totalbundle=(100*1024*1024);
=======
	    			$initialbundle=0;		    		
		    		$bundlebought=(100*1024*1024);
		    		$totalbundle=$bundlebought;
		    		$remainder=0;
>>>>>>> 31c19eb... updating files, all

		    		if (count($userhasboughtmbsbefore)>0) {
		    			//if yes, query the max-all-mb value in radreply and radcheck,session-timeout in radreply andacct-interim interval in radreply and add the newly purchased bundle
		    			foreach ($userhasboughtmbsbefore as $key => $mb) {
		    				$initialbundle=$mb->value;
<<<<<<< HEAD
		    				$totalbundle+=$initialbundle;
		    			}
		    			$deleteuser=DB::table('radreply')->where('username','=',$username)->delete();
=======
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
		    			
>>>>>>> 31c19eb... updating files, all
		    			
		    		}
		    		//update the record by creating a new record
		    			$userupdatereply=DB::table('radreply')->insert([
		    				['username'=>$username,'attribute'=>'Max-All-MB','op'=>':=','value'=>$totalbundle],
		    				['username'=>$username,'attribute'=>'Session-Timeout','op'=>':=','value'=>1200],
		    				['username'=>$username,'attribute'=>'Acct-Interim-Interval','op'=>':=','value'=>60]
		    			]);
		    			$userupdatecheck=DB::table('radcheck')->updateOrInsert(
		    				['username'=>$username,'attribute'=>'Max-All-MB'],
		    				['op'=>':=','value'=>$totalbundle]
		    			);
	    			
	    		}
	    		else if($plan=='250mbs'){
<<<<<<< HEAD
	    			$initialbundle=0;
		    		$totalbundle=(250*1024*1024);
=======
	    			$initialbundle=0;		    		
		    		$bundlebought=(250*1024*1024);
		    		$totalbundle=$bundlebought;
		    		$remainder=0;
>>>>>>> 31c19eb... updating files, all

		    		if (count($userhasboughtmbsbefore)>0) {
		    			//if yes, query the max-all-mb value in radreply and radcheck,session-timeout in radreply andacct-interim interval in radreply and add the newly purchased bundle
		    			foreach ($userhasboughtmbsbefore as $key => $mb) {
		    				$initialbundle=$mb->value;
<<<<<<< HEAD
		    				$totalbundle+=$initialbundle;
		    			}
		    			$deleteuser=DB::table('radreply')->where('username','=',$username)->delete();
=======
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
		    			
>>>>>>> 31c19eb... updating files, all
		    			
		    		}
		    		//update the record by creating a new record
		    			$userupdatereply=DB::table('radreply')->insert([
		    				['username'=>$username,'attribute'=>'Max-All-MB','op'=>':=','value'=>$totalbundle],
		    				['username'=>$username,'attribute'=>'Session-Timeout','op'=>':=','value'=>1800],
		    				['username'=>$username,'attribute'=>'Acct-Interim-Interval','op'=>':=','value'=>60]
		    			]);
		    			$userupdatecheck=DB::table('radcheck')->updateOrInsert(
		    				['username'=>$username,'attribute'=>'Max-All-MB'],
		    				['op'=>':=','value'=>$totalbundle]
		    			);
	    			
	    		}
	    		else if($plan=='500mbs'){
<<<<<<< HEAD
	    			$initialbundle=0;
		    		$totalbundle=(500*1024*1024);
=======
	    			$initialbundle=0;		    		
		    		$bundlebought=(500*1024*1024);
		    		$totalbundle=$bundlebought;
		    		$remainder=0;
>>>>>>> 31c19eb... updating files, all

		    		if (count($userhasboughtmbsbefore)>0) {
		    			//if yes, query the max-all-mb value in radreply and radcheck,session-timeout in radreply andacct-interim interval in radreply and add the newly purchased bundle
		    			foreach ($userhasboughtmbsbefore as $key => $mb) {
		    				$initialbundle=$mb->value;
<<<<<<< HEAD
		    				$totalbundle+=$initialbundle;
		    			}
		    			$deleteuser=DB::table('radreply')->where('username','=',$username)->delete();
=======
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
		    			
>>>>>>> 31c19eb... updating files, all
		    			
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
<<<<<<< HEAD
	    			$initialbundle=0;
		    		$totalbundle=(1024*1024*1024);
=======
	    			$initialbundle=0;		    		
		    		$bundlebought=(1024*1024*1024);
		    		$totalbundle=$bundlebought;
		    		$remainder=0;
>>>>>>> 31c19eb... updating files, all

		    		if (count($userhasboughtmbsbefore)>0) {
		    			//if yes, query the max-all-mb value in radreply and radcheck,session-timeout in radreply andacct-interim interval in radreply and add the newly purchased bundle
		    			foreach ($userhasboughtmbsbefore as $key => $mb) {
		    				$initialbundle=$mb->value;
<<<<<<< HEAD
		    				$totalbundle+=$initialbundle;
		    			}
		    			$deleteuser=DB::table('radreply')->where('username','=',$username)->delete();
=======
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
		    			
>>>>>>> 31c19eb... updating files, all
		    			
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
<<<<<<< HEAD
	    			$initialbundle=0;
		    		$totalbundle=(2048*1024*1024);
=======
	    			$initialbundle=0;		    		
		    		$bundlebought=(2048*1024*1024);
		    		$totalbundle=$bundlebought;
		    		$remainder=0;
>>>>>>> 31c19eb... updating files, all

		    		if (count($userhasboughtmbsbefore)>0) {
		    			//if yes, query the max-all-mb value in radreply and radcheck,session-timeout in radreply andacct-interim interval in radreply and add the newly purchased bundle
		    			foreach ($userhasboughtmbsbefore as $key => $mb) {
		    				$initialbundle=$mb->value;
<<<<<<< HEAD
		    				$totalbundle+=$initialbundle;
		    			}
		    			$deleteuser=DB::table('radreply')->where('username','=',$username)->delete();
=======
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
		    			
>>>>>>> 31c19eb... updating files, all
		    			
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
<<<<<<< HEAD
	    			$initialbundle=0;
		    		$totalbundle=(5120*1024*1024);
=======
	    			$initialbundle=0;		    		
		    		$bundlebought=(5120*1024*1024);
		    		$totalbundle=$bundlebought;
		    		$remainder=0;
>>>>>>> 31c19eb... updating files, all

		    		if (count($userhasboughtmbsbefore)>0) {
		    			//if yes, query the max-all-mb value in radreply and radcheck,session-timeout in radreply andacct-interim interval in radreply and add the newly purchased bundle
		    			foreach ($userhasboughtmbsbefore as $key => $mb) {
		    				$initialbundle=$mb->value;
<<<<<<< HEAD
		    				$totalbundle+=$initialbundle;
		    			}
		    			$deleteuser=DB::table('radreply')->where('username','=',$username)->delete();
=======
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
		    			
>>>>>>> 31c19eb... updating files, all
		    			
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
	    			
<<<<<<< HEAD
=======
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
>>>>>>> 31c19eb... updating files, all
	    		}
	    		
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
<<<<<<< HEAD
	                'message'=>'Your HEWANET internet access codes are: Username : '.$username.", Password :".$password,
=======
	                'message'=>'Your HEWANET internet access codes are: Username : '.$username.', Password : '.$password,
>>>>>>> 31c19eb... updating files, all
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
	            	if($request->ajax()){
	            		echo "Your internet access credentials are username :".$username." Password :".$password." Text Message has been sent successfully, if you don't receive the sms within 5 minutes, please contact admin";
	            	}else{
	            		return redirect()->back()->with("message","Your internet access credentials are username :".$username." Password :".$password." Text Message has been sent successfully, if you don't receive the sms within 5 minutes, please contact admin");
	            	}
	                
	            }else{
	            	if($request->ajax()){
	                echo "Your credentials are, username :".$username." Password :".$password." Message could not be sent";
	            	}else{
	            		return redirect()->back()->with("success_message","Your credentials are, username :".$username." Password :".$password." Message could not be sent");
	            	}
	            }
	    		//alert the user the status of transaction
	    		//echo "username :".$username." Password :".$password;
	    	}else if ($transactionResult=='error') {
	    		if($request->ajax()){
	    		echo"error";
	    		}else{
	    			return redirect()->back()->with("error","Your transaction has failed");
	    		}
	    	}
    	}else {
	    		if($request->ajax()){
	    		echo"error";
	    		}else{
	    			return redirect()->back()->with("error","Your transaction has failed");
	    		}
	    }
	}
    	
    }
}
