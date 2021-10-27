<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SendMessage extends Model
{
	public static function sendMessage($phone,$message){
				$smsgatewaUrl='https://sms.movesms.co.ke/api/compose?';
	            $curl=curl_init();
	            curl_setopt($curl, CURLOPT_URL, $smsgatewaUrl);
	            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
	            $data_string = array(
	                'username'=>'',
	                'api_key'=>'',
	                'sender'=>'',
	                'to'=>$phone,
	                'message'=>$message,
	                'msgtype'=>'5',
	                'dlr'=>'1',
	            );
	            $data=json_encode($data_string);
	            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	            curl_setopt($curl, CURLOPT_POST, true);
	            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
	            curl_setopt($curl, CURLOPT_HEADER, false);
	            $curl_response=curl_exec($curl);	            
	            if($curl_response=='Message Sent:1701'){
	            	return true;
	            }else{
	            	return false;
	            }
	}
}
