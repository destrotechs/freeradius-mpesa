<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mpesa extends Model
{
    public static function generateToken(){
    	 $url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
  
		  $curl = curl_init();
		  curl_setopt($curl, CURLOPT_URL, $url);
		  $credentials = base64_encode('KOnqrBLeALMObbmwaVz7qGdOYHLAG1rr:AIePPGkOaGUQ0MGO');
		  curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Basic '.$credentials)); //setting a custom header
		  curl_setopt($curl, CURLOPT_HEADER, false);
		  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		  
		  $curl_response = curl_exec($curl);
        return json_decode($curl_response,true)['access_token'];
    }
    public static function processRequest($token,$p,$amnt){
    	$phone='254'.substr($p, 1);
    	$amount='1';
		$transactiontype='CustomerPayBillOnline';
		$partyA=$phone;
		$partyB='174379';
		$callbackurl="https://hewanet.co.ke/churchcallback/";
		$accountreference="Morris mbae";
		$transactiondesc="plan payment";
		$remark='pay subscription';
		$url='https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
		
		$timestamp='20'.date("ymdhis");
    	$password=base64_encode('174379'.'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919'.$timestamp);
		$ch=curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
  		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.$token));

		$postData=array(
			'BusinessShortCode'=>'174379',
			'Password'=>$password,
			'Timestamp'=>$timestamp,
			'TransactionType'=>$transactiontype,
			'Amount'=>$amount,
			'PartyA'=>$partyA,
			'PartyB'=>'174379',
			'PhoneNumber'=>$phone,
			'CallBackURL'=>$callbackurl,
			'AccountReference'=>$accountreference,
			'TransactionDesc'=>$transactiondesc
		);
		$data=json_encode($postData);
		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_HEADER, false);
		$curl_response=curl_exec($ch);
		//dd($curl_response);
		 
		$mycode=json_decode($curl_response,true)['ResponseCode'];
		if($mycode==0){
			return json_decode($curl_response,true)['CheckoutRequestID'];
		}
	}
	public static function querySTKPush($token,$checkoutid){ 
	    
	    $url = 'https://sandbox.safaricom.co.ke/mpesa/stkpushquery/v1/query';
	    $timestamp='20'.date("ymdhis");

	    $curl = curl_init();
	    curl_setopt($curl, CURLOPT_URL, $url);
	    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.$token));


	    $curl_post_data = array(
	        'BusinessShortCode' => '174379',
	        'Password' => base64_encode('174379'.'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919'.$timestamp),
	        'Timestamp' => $timestamp,
	        'CheckoutRequestID' => $checkoutid,
	    );

	    $data_string = json_encode($curl_post_data);

	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($curl, CURLOPT_POST, true);
	    curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
	    curl_setopt($curl, CURLOPT_HEADER, false);

	    $curl_response = curl_exec($curl);
	    
	    $resultCode=json_decode($curl_response,true)['ResultCode'];
	    
	    //if transaction was successful
	    if($resultCode==0){
	    	 return "success"; 
	    	  	
	    }else{
	    	return "error";
	    	
	    }
	}
	public static function callback($amnt){
		$callbackData=json_decode(trim(file_get_contents("https://hewanet.co.ke/churchcallback/callback.txt")),true);		
		 
        if($callbackData!=NULL && $callbackData!=""){
           return $callbackData;
	    }else{
	        return "error";
	    }
		        

		 
	}
	public static function registerURLs($t){
		 $url = 'https://sandbox.safaricom.co.ke/mpesa/c2b/v1/registerurl';
	  
	  $curl = curl_init();
	  curl_setopt($curl, CURLOPT_URL, $url);
	  curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.$t)); //setting custom header
	  
	  
	  $curl_post_data = array(
	    //Fill in the request parameters with valid values
	    'ShortCode' => '600460',
	    'ResponseType' => 'Completed',
	    'ConfirmationURL' => 'https://hewanet.co.ke/churchconfirmation/index.php',
	    'ValidationURL' => 'https://hewanet.co.ke/churchvalidation/index.php'
	  );
	  
	  $data_string = json_encode($curl_post_data);
	  
	  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	  curl_setopt($curl, CURLOPT_POST, true);
	  curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
	  
	  $curl_response = curl_exec($curl);
	  // print_r($curl_response);
	  
	  dd($curl_response);
	}
	public static function simulate($token){
		 $url = 'https://sandbox.safaricom.co.ke/mpesa/c2b/v1/simulate';
	  
	    $curl = curl_init();
	    curl_setopt($curl, CURLOPT_URL, $url);
	    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.$token)); //setting custom header
	  
	  
	    $curl_post_data = array(
	            //Fill in the request parameters with valid values
	           'ShortCode' => '600460',
	           'CommandID' => 'CustomerPayBillOnline',
	           'Amount' => '5000',
	           'Msisdn' => '254708374149',
	           'BillRefNumber' => 'morrismbae'
	    );
	  
	    $data_string = json_encode($curl_post_data);
	  
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($curl, CURLOPT_POST, true);
	    curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
	  
	    $curl_response = curl_exec($curl);
	    // print_r($curl_response);
	  
	    dd($curl_response);
	}

}
