<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Redirect;
use Validator;
use Auth;
use Session;
use Illuminate\Support\Facades\Hash;
use \App\User;
use DB;
use Mail;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\AuthenticatesUsers;


class LoginController extends Controller
{
    protected $username;
    
    public function __construct()
    {
        //$this->middleware('guest')->except('logout');
 
        $this->username = $this->findUsername();
    }
    
    public function login(Request $request)
    {
        $result = [];
        $result["status"] = false;
        $result["message"] = "";
        $result["newtoken"] = csrf_token();
        
        if(Auth::user()){
            Auth::logout();
        }
        
        $user = DB::table('users')->where('email', $request->email)->where('is_deleted',false)->first();
        
        if(!$user){
            $result['message'] = 'Login Failed! Incorrect Email';
            return response($result);
        }
        if($user->is_verified != "true"){
            $result['message'] = 'Please verify your email first!';
            return response($result);
        }
        if (Auth::attempt(['email' => $request->email,'password' => $request->password])){
            $result['status'] = true;
            $result['message'] = 'Login Success! Redirecting...';
            return response($result);
        }
        
        $result['message'] = 'Login Failed! Incorrect Password';
        return response($result);
    }
    
    public function new_password(Request $r){
        
        $result = [];
        $result["status"] = false;
        $result["message"] = "";
        $result["newtoken"] = csrf_token();
      
        
        $user = \App\User::where('email', $r->email)->first();
        
        if(!$user){
            $result['message'] = 'Incorrect Email';
            return response($result);
        }
        
          if($user){
            
            $user->password = Hash::make($r->new_password);
            $user->save();
            $result['status'] = true;
            $result['message'] = 'Success change Password';
            return response($result);
        
        
    }
    }
    
    public function validate_otp(Request $r){
        
         $result = [];
        $result["status"] = false;
        $result["message"] = "";
        $result["newtoken"] = csrf_token();
        
        $user = \App\User::where('otp_forgot', $r->otp)->first();
        
        if($user)
        {
            $result['status'] = true;
            $result['message'] = 'success validate OTP';
            return response($result);
            
        }
        else{
            $result['message'] = 'Something error validate OTP';
            return response($result);
        }
           
          
        
    }
    public function reset_password(Request $request)
    {
        $result = [];
        $result["status"] = false;
        $result["message"] = "";
      //  $result["newtoken"] = csrf_token();
        
      
        // if(Auth::user()){
        //     Auth::logout();
        // }
        
        $user = \App\User::where('email', $request->email)->first();
        
        if(!$user){
            $result['message'] = 'Incorrect Email';
            return response($result);
        }
        if($user){
            $otp = rand(0, 9999);
           
            $user->otp_forgot = $otp;
            $user->save();
            
            $from = "ihsan@udacoding.com";
            $user_name = $user->name;
            $user_email = isset($user->email)?$user->email:'mail@mail.com';
            $msg = "Here is your verification code <br> <p style='width:100%; text-align:center;'><b>$otp</b></p>";
            $subject = "Otp Forgot Password";
            
            $data = array('data' => $user,
                      'msg' => $msg,
                      'name' => $user_name,
                      'login_url' => main_url()."/login"
                      );
            $mail = \Mail::send('email.reset_password', $data, function($message) use ($user_name, $user_email, $from, $subject) {
                        $message->to($user_email, $user_email)->subject($subject);
                        $message->from($from,"PROM");
                    });
            $result['status'] = true;
            $result['message'] = 'Otp validate has been sended to your Email';
            return response($result);
        }
        
        $result['message'] = 'Something went wrong please try again!';
        return response($result);
    }
    
    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function findUsername()
    {
        $login = request()->input('login');
 
        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
 
        request()->merge([$fieldType => $login]);
 
        return $fieldType;
    }
 
    /**
     * Get username property.
     *
     * @return string
     */
    public function username()
    {
        return $this->username;
    }
}








