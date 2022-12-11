<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Redirect;
use Validator;
use Auth;
use Session;
use Illuminate\Support\Facades\Hash;
use \App\PaketSubscription;
use DB;
use Illuminate\Support\Str;
use \App\User;
use Carbon\Carbon;

class UserController extends Controller
{
    public function api_login(Request $r)
    {
        $r->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $credentials = request(['email', 'password']);
        $user = User::where('email', $r->email)->first();
        if($user->is_verified != "true"){
            return response()->json([
                'status' => false,
                'message' => 'Please verify your email first!'
            ], 401);
        }
        if(!Auth::attempt($credentials))
            return response()->json([
                'status' => false,
                'message' => 'Incorrect Email or Password'
            ], 401);
        $user = $r->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        $technician = \App\Model\Technician::where('user_id', $user->id)->first();
        $user->id_technician = isset($technician->id_technician)?$technician->id_technician:'';
        $user->role_name = isset($user->role)?$user->role->role_name:'';
        $role = $user->role;
        if($role){
            $role->web_access = "HIDDEN";
        }
        return response()->json([
            'status' => true,
            'message' => "Login success",
            'user' => $user,
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ]);
    }
    public function api_logout(Request $r)
    {
        Auth::logout();
        
        return response()->json([
            'status' => true,
            'message' => "Logout success",
        ]);
    }
    
    public function index()
    {
        $data['title'] = 'Users';

      


        return view('user.index', $data);
    }
    
    public function userDetail()
    {
        return view('user.detailuser');
    }
    
    public function create()
    {
        return view('user.create');
    }
    public function profile()
    {
        $user = Auth::user();
        // $is_admin = is_admin($user);
        if(is_admin($user)){
            $id = request()->id;
            if($id) $user = User::where('id', $id)->first();
            // return $user;
        }
        if(!$user) return redirect()->to('/');
        return view('user.profile', compact('user'));
    }
    

    
    public function getData(Request $r)
    {
        $columns = $r->columns;
        $order = $r->order;
        if($order[0]){
            $order = $order[0];
            $column = $order['column']; 
            $column = $columns[$column];
            $orderBy = $column['data'];
            $order_dir = $order['dir'];
    
            $data = User::orderBy($orderBy, $order_dir);
        }else{
            $orderBy = false;
            $data = User::orderBy('id','ASC');
        }
        
       // $data = $data->where('is_deleted',0);
        $name = $r->name;
        $id = $r->id;
        if($id){
            $data = $data->where('id', $id);
        }
        
        $id_role = $r->id_role;
        if($id_role) $data = $data->where('role_id', $id_role);
        
        if(!$name){
            $name = $r->search['value'];
        }
        
        if($name){
            $data = $data->where(function ($data) use($name) {
                            $data->where('name', 'like', '%' . $name . '%');
                            $data->where('is_deleted',false);
                            $data->orWhere('email', 'like', '%' . $name . '%');
                            $data->orWhere('telpone', 'like', '%' . $name . '%');
                            $data->orWhere('mobile', 'like', '%' . $name . '%');
                          });
            
        }
        
        $draw = $r->get('draw');
        $limit = $r->get('length', 10);
        $offset = $r->get('start', 0);
        $timeout = $r->get('timeout', 0);
        
        $count = $data->count();
        if($count){
            // $data = $data->offset($offset)->limit($limit);
        }
        $data = $data->get();
        
        foreach($data as $d){
            $d->state;
            $d->role_name = isset($d->getRole)?$d->getRole->role_name:'';
            $d->departement_name = isset($d->getDepartement)?$d->getDepartement->name_departement:'';
            $d->created_date = date('Y-M-d', strtotime($d->created_at));
        }
        
        $count_searched = count($data);
        $result = [];
        $result["data"] = $data;
        $result["draw"] = $draw;
        $result["recordsTotal"] = $count_searched;
        $result["recordsFiltered"] = $count;
        $result["limit"] = $limit;
        $result["offset"] = $offset;
        $result["r"] = $r->all();
        if($orderBy){
            $result['orderBy'] = $orderBy;
            $result['order_dir'] = $order_dir;   
        }
        return response()->json($result);
    }
    
    public function newData(Request $r){
        
        $user = Auth::user();
        if(!$user){
            \Session::flash('message', "CSRF FAILED PLEASE RE-LOGIN!");
            \Session::flash('alert-class', 'alert-danger');
            return \Redirect::back();
        }
        $cek = User::where('email', $r->email)->where('is_deleted',false)->first();
        if($cek){
            \Session::flash('message', "Email already taken!");
            \Session::flash('alert-class', 'alert-info');
            return \Redirect::back();
        }
        
        if($r->password != $r->password_confirm){
            \Session::flash('message', "Password confirmation does not match!");
            \Session::flash('alert-class', 'alert-danger');
            return \Redirect::back();
        }
        $d = new User;
        $d->name = $r->name;
        $d->email = $r->email;
        $d->employe_id = random_code(11);
        $d->departement_id = $r->departement_id;
        $d->role_id = $r->role_id;
        $d->password = Hash::make($r->password);
        $d->telpone = $r->telpone;
        $d->mobile = $r->mobile;
        $d->save();
        
        $from = "ihsan@udacoding.com";
        $user_name = $d->name;
        $user_email = isset($d->email)?$d->email:'mail@mail.com';
        $msg = "Please verify your email to complete registration.";
        $subject = "Email Verificaition";
        
        $data = array('data' => $d,
                  'msg' => $msg,
                  'name' => $user_name,
                  'verify_url' => main_url()."/verify_email?id=$d->id"
                  );
        $mail = \Mail::send('email.user_verify', $data, function($message) use ($user_name, $user_email, $from, $subject) {
                    $message->to($user_email, $user_email)->subject($subject);
                    $message->from($from,"PROM");
                });
        \Session::flash('message', "User Added Successfully! Please verify your email to complete registration!");
        \Session::flash('alert-class', 'alert-success');
        return \Redirect::back();
    }    
    
    public function verify_email(Request $r, $id){
        return $id;
    }
    public function update_profile(Request $r, $id){
        
        $user = Auth::user();
        if(!$user){
            \Session::flash('message', "CSRF FAILED PLEASE RE-LOGIN!");
            \Session::flash('alert-class', 'alert-danger');
            return \Redirect::back();
        }
        $is_admin = is_admin($user);
        
        $d = User::where('id', $id)->first();
        if($d->id != $user->id){
            if(!$is_admin){
                \Session::flash('message', "Insufficient Role!");
                \Session::flash('alert-class', 'alert-danger');
                return \Redirect::back();
            }
        }
        
        $cek = User::where('id', $id)->where('email', $r->email)->first();
        if($cek){
            \Session::flash('message', "Email already taken!");
            \Session::flash('alert-class', 'alert-info');
            return \Redirect::back();
        }
        
        if($r->password){
            if($r->password != $r->password_confirm){
                \Session::flash('message', "Password confirmation does not match!");
                \Session::flash('alert-class', 'alert-danger');
                return \Redirect::back();
            }
            $d->password = Hash::make($r->password);
        }
        
        $d->name = $r->name;
        if($r->email){
            $d->email = $r->email;
        }
        $d->departement_id = $r->departement_id;
        if($is_admin){
            if($r->role_id) $d->role_id = $r->role_id;
        }
        $d->telpone = $r->telpone;
        if($r->mobile) $d->mobile = $r->mobile;
        $d->save();
        
        \Session::flash('message', "Updated Successfully");
        \Session::flash('alert-class', 'alert-success');
        if($is_admin){
            return \Redirect::to('/user');
        }else{
            return \Redirect::back();   
        }
    }    
    public function remove_user(Request $r, $id){
        
        $user = Auth::user();
        if(!$user){
            \Session::flash('message', "CSRF FAILED PLEASE RE-LOGIN!");
            \Session::flash('alert-class', 'alert-danger');
            return \Redirect::back();
        }
        $is_admin = is_admin($user);
        
        if(!$is_admin){
            \Session::flash('message', "Insufficient Role!");
            \Session::flash('alert-class', 'alert-danger');
            return \Redirect::back();
        }
        
        $d = User::where('id', $id)->first();
        $d->is_deleted = true;
        
        $d->save();
        
        \Session::flash('message', "Deleted Successfully");
        \Session::flash('alert-class', 'alert-success');
        return \Redirect::to('/user');
    }    
    
    public function getProfile(Request $r){
        $result = [];
        $result["status"] = false;
        $result["message"] = "";
        $result["newtoken"] = csrf_token();
        
        $user = Auth::user();
        $role = $user->getRole;
        if($role){
            $role->web_access = "HIDDEN";
        }
        $user->getDepartement;
        $user->getTechnician = \App\Model\Technician::where('user_id', $user->id)->first();
        
        $result["status"] = true;
        $result["message"] = "Get Data success";
        $result["data"] = $user;
        
        return response($result);
    }    
    
    public function submitData(Request $r){
        $result = [];
        $result["status"] = false;
        $result["message"] = "";
        $result["newtoken"] = csrf_token();
        
        $cek = User::where('email', $r->email)->first();
        if($cek){
            $message = "$r->email already on list!";
            $result["message"] = $message;
            return response($result);
        }else{
            $message = "$r->email Created Successfully!";
        }
        $c->name = $r->name;
        /*
        ...
        ...
        ...
        $c->save();
        */
        $result["status"] = true;
        $result["message"] = $message;
        $result["data"] = $c;
        
        return response($result);
    }    
    
    public function updatePhotoProfile(Request $r)
    {
        $result = [];
        $result["status"] = false;
        $result["message"] = "";
       
        $user = User::where('id',$r->id_user)->first();
       
        $photoProfile = $r->file('profile');
       
          
        if($photoProfile){
            $file = $photoProfile;
            $image_profile = "" . md5(time()) . '.' .$file->getClientOriginalExtension();
            $file->move(public_path().'/PROFILE', $image_profile);
                  
            $user->img_profile = $image_profile ;
                 
            $status = $user->update();
                 
            if($status){
                $result["status"] = true;
                $result["message"] = "success update profile";
                $result['user'] = $user ;
            }else{
                $result["status"] = false;
                $result["message"] = "error update profile";
            }
        }else{
            $result["status"] = false;
            $result["message"] = "photo profile masih kosong";
        }
            
        return response()->json($result);
    }
    
    public function updateProfile(Request $r){
        $result = [];
        $result["status"] = false;
        $result["message"] = "";
       
        
        $c = User::where('id', $id)->first();
        if(!$c){
            $result["message"] = "User not found!";
            return response($result);
        }
        
       
        
        $c->username = $r->username;
        $c->nama_lengkap = $r->nama_lengkap ;
        $c->phone = $r->phone ;
        $c->email = $r->email ;
        $c->save();
      
        
        $result["status"] = true;
        $result["message"] = "$r->email Updated Successfully";
        $result["data"] = $c;
        
        return response($result);
    }    
    
    public function set_firebase_token($id, Request $r){
        $result = [];
        $result["status"] = false;
        $result["message"] = "";
        $result["newtoken"] = csrf_token();
        
        $c = User::where('id', $id)->first();
        if(!$c){
            $result["message"] = "User not found!";
            return response($result);
        }
        
        if(!$r->firebase_token){
            $result["message"] = "Token can not be NULL!";
            return response($result);
        }
        $c->firebase_token = $r->firebase_token;
        $c->save();
        $result["status"] = true;
        $result["message"] = "Token Updated Successfully";
        $result["data"] = $c;
        
        return response($result);
    }    
    public function set_firebase_token_web(Request $r){
        $result = [];
        $result["status"] = false;
        $result["message"] = "";
        $result["newtoken"] = csrf_token();
        
        $id = Auth::user()->id;
        
        $c = User::where('id', $id)->first();
        if(!$c){
            $result["message"] = "User not found!";
            return response($result);
        }
        
        if(!$r->firebase_token_web){
            $result["message"] = "Token can not be NULL!";
            return response($result);
        }
        $c->firebase_token_web = $r->firebase_token_web;
        $c->save();
        $result["status"] = true;
        $result["message"] = "Token Updated Successfully";
        $result["data"] = $c;
        
        return response($result);
    }    
}




















