<?php

namespace App\Http\Controllers;
use Validator;
use Auth;
use DB;
use App\Message;
use App\SendMessage;
use Illuminate\Http\Request;

class messagesController extends Controller
{	
	public function __construct()
    {
        $this->middleware('auth');
    }
    public function getInbox(){
    	return view('pages.inbox');
    }
    public function getSent(){
    	$messages=DB::table('messages')->orderBy('id','desc')->paginate(20);
    	return view('pages.sent',compact('messages'));
    }
    public function getNewMessage(){
    	return view('pages.newmessage');
    }
    public function sendMessage(Request $request){
    	$validator=Validator::make($request->all(),[
    		'message'=>['required','max:254'],
    	]);

    	if ($validator->fails()) {
    		if($request->ajax()){
    			echo "error";
	    	}else{
	    		return redirect()->back()->with('error',$validator->messages()->all()[0]);
	    	}
    		
    	}else{
            $sender='Admin';
            $about='marketing';
            $recipient=$request->get('recipient');
    		$message=$request->get('message');
    		if($request->get('allcustomers')!="" && $request->get('allcustomers')!=NULL){
    			$cellnumbers=DB::table('customers')->pluck('phone');
                $i=0;
                
                    foreach ($cellnumbers as $key => $num) {
                        $phone='254'.substr($num, 1);
                        SendMessage::sendMessage($phone,$message);
                        $newmessage=new Message;
                        $newmessage->recipient=$num;
                        $newmessage->sender=$sender;
                        $newmessage->message=$message;
                        $newmessage->save();
                    }
            
                return redirect()->back()->with("success",$i." messages sent successfully");
    			
    		}else{
    			
    			$phone='254'.substr($recipient, 1);
    			if ($recipient!="" && $recipient!=NULL) {
    				 $reply=SendMessage::sendMessage($phone,$message);
    				if ($reply==true) {
    					//save message to messages box
    					$newmessage=new Message;
    					$newmessage->recipient=$recipient;
    					$newmessage->sender=$sender;
    					$newmessage->message=$message;
    					$newmessage->save();
    					return redirect()->back()->with("success","Message sent successfully");
    				}else{
    					return redirect()->back()->with("error","Failed");
    				}
    			}
    		}
    	}
    }
    public function deleteMessage(Request $request,$id){
    	$mes=DB::table('messages')->where('id','=',$id)->delete();
    	if ($mes) {
    		return redirect()->back()->with("success","Message has been deleted successfully");
    	}else{
    		return redirect()->back()->with("error","There was an error deleting the message, try again");
    	}
    }
}
