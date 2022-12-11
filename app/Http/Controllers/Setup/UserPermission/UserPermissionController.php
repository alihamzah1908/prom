<?php

namespace App\Http\Controllers\Setup\UserPermission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \App\Model\Routes;
use \App\Model\Roles;
use \App\Model\GroupCustomer;
use \App\Model\GroupInternal;
use \App\Model\GroupUser;
use \App\Model\Technician;
use \App\Model\Customer;
use App\Model\Region;
use App\Model\Site;
use App\Model\AktivasiApprover;
use App\Model\AktivasiApproverDetail;
use App\Model\Departement;
use \App\User;
use \Auth;

class UserPermissionController extends Controller
{
    public function index(Request $r){
        $view = $r->view;
        $regions = new Region;
        $sites = new Site;
        $users = new \App\User;
        switch($view){
            case 'admin':
                $view = 'admin';
                break;
            case 'technicians':
                $view = 'technician';
                break;
            case 'validator':
                $view = 'validator';
                $regions = Region::all();
                $users = \App\User::get();
                break;
            case 'visitor':
                $view = 'visitor';
                break;
            case 'group_internal':
                $view = 'group_internal';
                break;
            case 'group_external':
                $view = 'group_external';
                break;
            case 'routes':
                $view = 'routes';
                break;
            case 'approver':
                $regions = Region::all();
                $users = \App\User::get();
                $view = 'approver';
                break;
            case 'site_entry_approver':
                $sites = Site::all();
                $users = \App\User::get();
                $view = 'site_entry_approver';
                break;
            case 'aktivasi_approver':
                $regions = Region::all();
                $users = \App\User::get();
                $view = 'aktivasi_approver';
                break;
            case 'customer':
                $view = 'customer';
                break;
            case 'departemen':
                $view = 'departemen';
                break;
            default:
                $view = 'role';
        }
        $include = "setup.userpermission.".$view;
        if($view == "routes"){
            return view('setup.userpermission.routes', compact('include','view'));
        }
        return view('setup.userpermission.index', compact('include','view', 'regions', 'users', 'sites'));
    }
    public function getRoute(Request $r){
        $columns = $r->columns;
        $order = $r->order;
        if($order[0]){
            $order = $order[0];
            $column = $order['column']; 
            $column = $columns[$column];
            $orderBy = $column['data'];
            $order_dir = $order['dir'];
    
            $data = Routes::orderBy($orderBy, $order_dir);
        }else{
            $orderBy = false;
            $data = Routes::orderBy('id_route','ASC');
        }
        
        $name = $r->name;
        $id = $r->id;
        if($id){
            $data = $data->where('id_route', $id);
        }
        
        $id_parent = $r->id_parent;
        if($id_parent){
            $data = $data->where('id_parent', $id_parent);
        }
        $type = $r->type;
        if($type == "PARENT"){
            $data = $data->where('id_parent', null);
        }
        
        if(!$name){
            $name = $r->search['value'];
        }
        
        if($name){
            $data = $data->where(function ($data) use($name) {
                            $data->where('name', 'like', '%' . $name . '%');
                            $data->where('route', 'like', '%' . $name . '%');
                          });
            
        }
        
        $draw = $r->get('draw');
        $limit = $r->get('length', 10);
        $offset = $r->get('start', 0);
        $timeout = $r->get('timeout', 0);
        
        $count = $data->count();
        // $data = $data->offset($offset)->limit($limit);
        $data = $data->get();
        
        foreach($data as $d){
            
        }
        
        $count_searched = count($data);
        $result = [];
        $result["data"] = $data;
        $result["draw"] = $draw;
        $result["recordsTotal"] = $count_searched;
        $result["recordsFiltered"] = $count;
        $result["limit"] = $limit;
        $result["offset"] = $offset;
        if($orderBy){
            $result['orderBy'] = $orderBy;
            $result['order_dir'] = $order_dir;   
        }
        return response()->json($result);
    }
    public function new_route(Request $r){
        $user = Auth::user();
        if(!$user){
            \Session::flash('message', "CSRF FAILED PLEASE RE-LOGIN!");
            \Session::flash('alert-class', 'alert-danger');
            return \Redirect::back();
        }
        $cek = Routes::where('route', $r->route)->first();
        if($cek){
            // \Session::flash('message', "Route already on list!");
            // \Session::flash('alert-class', 'alert-info');
            // return \Redirect::back();
        }
        
        $d = new Routes;
        $d->name = $r->name;
        $d->route = $r->route;
        if($r->id_parent){
            $d->id_parent = $r->id_parent;
        }
        $d->save();
        
        \Session::flash('message', "Added Successfully");
        \Session::flash('alert-class', 'alert-success');
        return \Redirect::back();
    }
    public function new_role(Request $r){
        $user = Auth::user();
        if(!$user){
            \Session::flash('message', "CSRF FAILED PLEASE RE-LOGIN!");
            \Session::flash('alert-class', 'alert-danger');
            return \Redirect::back();
        }
        $cek = Roles::where('role_name', $r->role_name)->first();
        if($cek){
            \Session::flash('message', "Role already on list!");
            \Session::flash('alert-class', 'alert-info');
            return \Redirect::back();
        }
        
        $d = new Roles;
        $d->role_name = $r->role_name;
        $d->web_access = "[]";
        $d->save();
        
        \Session::flash('message', "Added Successfully");
        \Session::flash('alert-class', 'alert-success');
        return \Redirect::back();
    }
    public function detailRole(Request $r, $id_role){
        $role = Roles::where('id_role', $id_role)->first();
        if(!$role){
            $role = new Roles;
            $code = random_code(20);
            $role->id_role = "NEW_ROLE_$code";
            $role->web_access = "[]";
            // \Session::flash('message', "Role not found!");
            // \Session::flash('alert-class', 'alert-info');
            // return \Redirect::to('/setup/userpermission?view=role');
        }
        
        return view('setup.userpermission.detail_role', compact('role'));
    }
    
    public function update_access(Request $r, $id_role){
        
        $role = Roles::where('id_role', $id_role)->first();
        if(!$role){
            $role = new Roles;
            $role->role_name = $r->role_name;
            $role->web_access = "[]";
            $role->save();
        }
        if(!$role){
            \Session::flash('message', "Role not found!");
            \Session::flash('alert-class', 'alert-info');
            return \Redirect::to('/setup/userpermission?view=role');
        }
        $role_access = [];
        $web_access = $r->web_access;
        if($web_access){
            foreach($web_access as $key => $val){
                $route = Routes::where('id_route', $web_access[$key])->first();
                if($route){
                    $role_access[] = $route->route;
                }
            }
        }
        $is_admin = "NO"; 
        if(is_admin(Auth::user())){
            if($r->is_admin == "on") $is_admin = "YES";
        }
        // $role_access = json_encode($role_access);
        $role_access = implode('","',$role_access);
        $role_access = '["'.$role_access.'"]';
        $role->web_access = $role_access;
        $role->is_admin = $is_admin;
        $role->role_name = $r->role_name;
        $role->save();
        \Session::flash('message', "Role Access updated successfully!");
        \Session::flash('alert-class', 'alert-success');
        return \Redirect::to('/setup/userpermission?view=role');
    }
    public function delete_role(Request $r){
        
        $role = Roles::where('id_role', $r->id_role)->first();
        if(!$role){
            \Session::flash('message', "Role not found!");
            \Session::flash('alert-class', 'alert-info');
            return \Redirect::to('/setup/userpermission?view=role');
        }
        $role->delete();
        \Session::flash('message', "Role Access Deleted successfully!");
        \Session::flash('alert-class', 'alert-success');
        return \Redirect::to('/setup/userpermission?view=role');
    }
    
    public function getGroupCustomer(Request $r){
        $columns = $r->columns;
        $order = $r->order;
        if($order[0]){
            $column = $order[0]['column']; 
            $orderBy = $columns[$column]['data'];
            $order_dir = $order['dir'];
        }else{
            $orderBy = 'id_group';
            $order_dir = 'ASC';
        }
        $data = GroupCustomer::orderBy($orderBy, $order_dir);
        
        $result = getDataCustom($data, $r, 'id_group', 'group_name')->original;
        
        foreach($result['data'] as $d){
            
        }
        return response()->json($result);
    }
    public function getGroupInternal(Request $r){
        $columns = $r->columns;
        $order = $r->order;
        if($order[0]){
            $column = $order[0]['column']; 
            $orderBy = $columns[$column]['data'];
            $order_dir = $order['dir'];
        }else{
            $orderBy = 'id_group';
            $order_dir = 'ASC';
        }
        $data = GroupInternal::orderBy($orderBy, $order_dir);
        
        $result = getDataCustom($data, $r, 'id_group', 'name_group')->original;
        
        foreach($result['data'] as $d){
            
        }
        return response()->json($result);
    }
    public function getGroupUser(Request $r){
        $columns = $r->columns;
        $order = $r->order;
        if($order[0]){
            $column = $order[0]['column']; 
            $orderBy = $columns[$column]['data'];
            $order_dir = $order['dir'];
        }else{
            $orderBy = 'id_group_user';
            $order_dir = 'ASC';
        }
        $data = GroupUser::orderBy($orderBy, $order_dir);
        $group_type = $r->group_type;
        if(!$group_type){
            $group_type = "CUSTOMER";
        }
        $data->where('id_group', $r->id_group)->where('group_type', $group_type);
        $result = getDataCustom($data, $r, 'id_group_user', 'name')->original;
        
        foreach($result['data'] as $d){
            
        }
        return response()->json($result);
    }
    
    public function delete_technician(Request $r,$id_technician){
        
       
        $d = Technician::where('id_technician', $id_technician)->first();
        if(!$d){
            \Session::flash('message', "Technician not found!");
            \Session::flash('alert-class', 'alert-info');
            return \Redirect::to('/setup/userpermission?view=technicians');
        }
        $d->delete();
        
        \Session::flash('message', "Technisian Deleted successfully!");
        \Session::flash('alert-class', 'alert-success');
        return \Redirect::to('/setup/userpermission?view=technicians');
    }
    public function getTechnicians(Request $r){
        $columns = $r->columns;
        $order = $r->order;
        if($order[0]){
            $column = $order[0]['column']; 
            $orderBy = $columns[$column]['data'];
            $order_dir = $order['dir'];
        }else{
            $orderBy = 'id_technician';
            $order_dir = 'ASC';
        }
        $data = Technician::orderBy($orderBy, $order_dir);
        if($r->id_user) $data->where('user_id', $r->id_user);
        $result = getDataCustom($data, $r, 'id_technician', 'name_technician')->original;
        
        foreach($result['data'] as $d){
            isset($d->user)?$d->user->getDepartement:'-';
        }
        return response()->json($result);
    }
    public function update_technician(Request $r){
        $user = Auth::user();
        if(!$user){
            \Session::flash('message', "CSRF FAILED PLEASE RE-LOGIN!");
            \Session::flash('alert-class', 'alert-danger');
            return \Redirect::back();
        }
       
        
        $d = Technician::where('user_id', $r->id_technician)->first();
        if(!$d){
            \Session::flash('message', "Customer not found!");
            \Session::flash('alert-class', 'alert-info');
            return \Redirect::to('/setup/userpermission?view=technisians');
        }
        $d->name_technician = $r->name_technician;
        $d->region_id = $r->region_id;
        $d->user_id = $r->user_id;
        $d->save();
        
        \Session::flash('message', "update Successfully");
        \Session::flash('alert-class', 'alert-success');
        return \Redirect::back();
    }
    public function new_technician(Request $r){
        $user = Auth::user();
        if(!$user){
            \Session::flash('message', "CSRF FAILED PLEASE RE-LOGIN!");
            \Session::flash('alert-class', 'alert-danger');
            return \Redirect::back();
        }
        $cek = Technician::where('user_id', $r->user_id)->first();
        if($cek){
            \Session::flash('message', "User already on list!");
            \Session::flash('alert-class', 'alert-info');
            return \Redirect::back();
        }
        
        $d = new Technician;
        $d->name_technician = $r->name_technician;
        $d->region_id = $r->region_id;
        $d->user_id = $r->user_id;
        $d->save();
        
        \Session::flash('message', "Added Successfully");
        \Session::flash('alert-class', 'alert-success');
        return \Redirect::back();
    }
    
    public function new_group_user(Request $r, $type){
        $user = Auth::user();
        if(!$user){
            \Session::flash('message', "CSRF FAILED PLEASE RE-LOGIN!");
            \Session::flash('alert-class', 'alert-danger');
            return \Redirect::back();
        }
        $group_type = $type;
        
        if($type == "CUSTOMER"){
            $user_group = Customer::where('id_customer', $r->id_user)->first(); 
            $name = $user_group->name_customer;
            $email = $user_group->email;
        }elseif($type == "INTERNAL"){
            $user_group = User::where('id', $r->id_user)->first(); 
            $name = $user_group->name;
            $email = $user_group->email;
        }else{
            \Session::flash('message', "Opps! Something went wrong! please try again!");
            \Session::flash('alert-class', 'alert-danger');
            return \Redirect::back();
        }
        if(!$user_group){
            \Session::flash('message', "User Not found!");
            \Session::flash('alert-class', 'alert-danger');
            return \Redirect::back();
        }
        if(!$email){
            \Session::flash('message', "$name Email is empty!");
            \Session::flash('alert-class', 'alert-danger');
            return \Redirect::back();
        }
        $cek = GroupUser::where('email', $email)->where('id_group', $r->id_group)->where('group_type', $group_type)->first();
        if($cek){
            \Session::flash('message', "User already on list!");
            \Session::flash('alert-class', 'alert-info');
            return \Redirect::back();
        }
        
        $d = new GroupUser;
        $d->name = $name;
        $d->email = $email;
        $d->group_type = $group_type;
        $d->id_group = $r->id_group;
        $d->save();
        
        \Session::flash('message', "Added Successfully");
        \Session::flash('alert-class', 'alert-success');
        return \Redirect::back();
    }
    
      public function delete_group_internal(Request $r,$id_group_internal){
        
       
        $d = GroupInternal::where('id_group', $id_group_internal)->first();
        if(!$d){
            \Session::flash('message', "Group internal not found!");
            \Session::flash('alert-class', 'alert-info');
            return \Redirect::to('/setup/userpermission?view=group_internal');
        }
        $d->delete();
        
        \Session::flash('message', "Group internal Deleted successfully!");
        \Session::flash('alert-class', 'alert-success');
        return \Redirect::to('/setup/userpermission?view=group_internal');
    }
     public function delete_group_external(Request $r,$id_group_external){
        
       
        $d = GroupCustomer::where('id_group', $id_group_external)->first();
        if(!$d){
            \Session::flash('message', "Group external not found!");
            \Session::flash('alert-class', 'alert-info');
            return \Redirect::to('/setup/userpermission?view=group_external');
        }
       
        $d->delete();
        
        \Session::flash('message', "Group external Deleted successfully!");
        \Session::flash('alert-class', 'alert-success');
        return \Redirect::to('/setup/userpermission?view=group_external');
    }
    public function new_group_customer(Request $r){
        $user = Auth::user();
        if(!$user){
            \Session::flash('message', "CSRF FAILED PLEASE RE-LOGIN!");
            \Session::flash('alert-class', 'alert-danger');
            return \Redirect::back();
        }
        
        $cek = GroupCustomer::where('group_name', $r->group_name)->first();
        if($cek){
            \Session::flash('message', "Group already on list!");
            \Session::flash('alert-class', 'alert-info');
            return \Redirect::back();
        }
        
        $d = new GroupCustomer;
        $d->group_name = $r->group_name;
        $d->group_desc = $r->group_desc;
        $d->save();
        
        \Session::flash('message', "Added Successfully");
        \Session::flash('alert-class', 'alert-success');
        return \Redirect::back();
    }
    public function new_group_internal(Request $r){
        // return $r->all();
        $user = Auth::user();
        if(!$user){
            \Session::flash('message', "CSRF FAILED PLEASE RE-LOGIN!");
            \Session::flash('alert-class', 'alert-danger');
            return \Redirect::back();
        }
        
        $cek = GroupInternal::where('name_group', $r->name_group)->first();
        if($cek){
            \Session::flash('message', "Group already on list!");
            \Session::flash('alert-class', 'alert-info');
            return \Redirect::back();
        }
        
        $d = new GroupInternal;
        $d->name_group = $r->group_name;
        $d->desc_group = $r->group_desc;
        $d->user_id = 0;
        $d->save();
        
        \Session::flash('message', "Added Successfully");
        \Session::flash('alert-class', 'alert-success');
        return \Redirect::back();
    }
    
    public function new_validator(Request $r){
        $user = Auth::user();
        if(!$user){
            \Session::flash('message', "CSRF FAILED PLEASE RE-LOGIN!");
            \Session::flash('alert-class', 'alert-danger');
            return \Redirect::back();
        }
        
        $cek = AktivasiApprover::where('id_region', $r->id_region)->where('id_type', $r->id_type)->first();
        if($cek){
            \Session::flash('message', "Validator already on list!");
            \Session::flash('alert-class', 'alert-info');
            return \Redirect::back();
        }
        
        $d = new AktivasiApprover;
        $d->id_region = $r->id_region;
        $d->id_type = $r->id_type;
        $d->count_layer = count($r->id_approver);
        
        // return $r->all();
        $type = \App\Model\AktivasiType::where('id_service', $r->id_type)->first();
        if(!$type){
            \Session::flash('message', "Opps! Something went wrong please try again!");
            \Session::flash('alert-class', 'alert-danger');
            return \Redirect::back();
        }
        if($d->count_layer != $type->approval_layer){
            \Session::flash('message', "$type->service_name must have $type->approval_layer of layer");
            \Session::flash('alert-class', 'alert-danger');
            return \Redirect::back();
        }
        
        $d->save();
        
        foreach($r->id_approver as $key => $val){
            $detail = new AktivasiApproverDetail;
            $detail->id_approver = $d->id_approver;
            $detail->user_id = $val;
            $detail->layer = $key + 1;
            $detail->save();
            
        }
        
        \Session::flash('message', "Added Successfully");
        \Session::flash('alert-class', 'alert-success');
        return \Redirect::back();
    }
    
    public function getCustomer(Request $r){
        $columns = $r->columns;
        $order = $r->order;
        if($order[0]){
            $column = $order[0]['column']; 
            $orderBy = $columns[$column]['data'];
            $order_dir = $order['dir'];
        }else{
            $orderBy = 'id_customer';
            $order_dir = 'ASC';
        }
        $data = Customer::orderBy($orderBy, $order_dir);
        if($r->id_customer) $data->where('id_customer', $r->id_customer);
        $result = getDataCustom($data, $r, 'id_customer', 'name_customer')->original;
        
        foreach($result['data'] as $d){
            
        }
        return response()->json($result);
    }
    public function new_customer(Request $r){
        // return $r->all();
        $user = Auth::user();
        if(!$user){
            \Session::flash('message', "CSRF FAILED PLEASE RE-LOGIN!");
            \Session::flash('alert-class', 'alert-danger');
            return \Redirect::back();
        }
        
        $cek = Customer::where('name_customer', $r->name_customer)->first();
        if($cek){
            \Session::flash('message', "Customer already on list!");
            \Session::flash('alert-class', 'alert-info');
            return \Redirect::back();
        }
        
        $d = new Customer;
        $d->name_customer = $r->name_customer;
        $d->email = $r->email;
        $d->save();
        
        \Session::flash('message', "Added Successfully");
        \Session::flash('alert-class', 'alert-success');
        return \Redirect::back();
    }
    public function edit_customer(Request $r){
        // return $r->all();
        $user = Auth::user();
        if(!$user){
            \Session::flash('message', "CSRF FAILED PLEASE RE-LOGIN!");
            \Session::flash('alert-class', 'alert-danger');
            return \Redirect::back();
        }
        $d = Customer::where('id_customer', $r->id_customer)->first();
        if(!$d){
            \Session::flash('message', "Customer not found!");
            \Session::flash('alert-class', 'alert-info');
            return \Redirect::back();
        }
        $cek = Customer::where('id_customer', '!=', $r->id_customer)->where('name_customer', $r->name_customer)->first();
        if($cek){
            \Session::flash('message', "Customer already on list!");
            \Session::flash('alert-class', 'alert-info');
            return \Redirect::back();
        }
        
        $d->name_customer = $r->name_customer;
        $d->email = $r->email;
        $d->save();
        
        \Session::flash('message', "Added Successfully");
        \Session::flash('alert-class', 'alert-success');
        return \Redirect::back();
    }
    public function delete_customer(Request $r){
        
        $d = \App\Model\Customer::where('id_customer', $r->id_customer)->first();
        if(!$d){
            \Session::flash('message', "Customer not found!");
            \Session::flash('alert-class', 'alert-info');
            return \Redirect::to('/setup/userpermission?view=customer');
        }
        $d->delete();
        
        \Session::flash('message', "Customer Deleted successfully!");
        \Session::flash('alert-class', 'alert-success');
        return \Redirect::to('/setup/userpermission?view=customer');
    }
    
    
    public function getDepartement(Request $r){
        $columns = $r->columns;
        $order = $r->order;
        if($order[0]){
            $column = $order[0]['column']; 
            $orderBy = $columns[$column]['data'];
            $order_dir = $order['dir'];
        }else{
            $orderBy = 'id_departement';
            $order_dir = 'ASC';
        }
        $data = Departement::orderBy($orderBy, $order_dir);
        if($r->id_departement) $data->where('id_departement', $r->id_departement);
        $result = getDataCustom($data, $r, 'id_departement', 'name_departement')->original;
        
        foreach($result['data'] as $d){
            
        }
        return response()->json($result);
    }
    public function new_departement(Request $r){
        //return $r->all();
        $user = Auth::user();
        if(!$user){
            \Session::flash('message', "CSRF FAILED PLEASE RE-LOGIN!");
            \Session::flash('alert-class', 'alert-danger');
            return \Redirect::back();
        }
        
        $cek = Departement::where('name_departement', $r->name_departement)->first();
        if($cek){
            \Session::flash('message', "Departement already on list!");
            \Session::flash('alert-class', 'alert-info');
            return \Redirect::back();
        }
        
        $d = new Departement;
        $d->name_departement = $r->name_departement;
        $d->desc_departement = $r->desc_departement;
        $d->save();
        //return $d;
        \Session::flash('message', "Added Successfully");
        \Session::flash('alert-class', 'alert-success');
        return \Redirect::back();
    }
    public function edit_departement(Request $r){
        // return $r->all();
        $user = Auth::user();
        if(!$user){
            \Session::flash('message', "CSRF FAILED PLEASE RE-LOGIN!");
            \Session::flash('alert-class', 'alert-danger');
            return \Redirect::back();
        }
        $d = Departement::where('id_departement', $r->id_departement)->first();
        if(!$d){
            \Session::flash('message', "Departement not found!");
            \Session::flash('alert-class', 'alert-info');
            return \Redirect::back();
        }
        $cek = Departement::where('id_departement', '!=', $r->id_departement)->where('name_departement', $r->name_departement)->first();
        if($cek){
            \Session::flash('message', "Departement already on list!");
            \Session::flash('alert-class', 'alert-info');
            return \Redirect::back();
        }
        
        $d->name_departement = $r->name_departement;
        $d->desc_departement = $r->desc_departement;
        $d->save();
        
        \Session::flash('message', "Added Successfully");
        \Session::flash('alert-class', 'alert-success');
        return \Redirect::back();
    }
    public function delete_departement(Request $r){
        
        $d = \App\Model\Departement::where('id_departement', $r->id_departement)->first();
        if(!$d){
            \Session::flash('message', "Departement not found!");
            \Session::flash('alert-class', 'alert-info');
            return \Redirect::to('/setup/userpermission?view=departemen');
        }
        $d->delete();
        
        \Session::flash('message', "Departement Deleted successfully!");
        \Session::flash('alert-class', 'alert-success');
        return \Redirect::to('/setup/userpermission?view=departemen');
    }
    
    
    
    public function delete_task_approver(Request $r){
        
        $d = \App\Model\Approver::where('id_approver', $r->id_approver)->first();
        if(!$d){
            \Session::flash('message', "Validator not found!");
            \Session::flash('alert-class', 'alert-info');
            return \Redirect::to('/setup/userpermission?view=approver');
        }
        
        foreach($d->detail as $de){
            $de->delete();
        }
        $d->delete();
        
        \Session::flash('message', "Validator Deleted successfully!");
        \Session::flash('alert-class', 'alert-success');
        return \Redirect::to('/setup/userpermission?view=approver');
    }
    
    public function delete_site_entry_approver(Request $r){
        
        $d = \App\Model\SiteEntryApprover::where('id_approver', $r->id_approver)->first();
        if(!$d){
            \Session::flash('message', "Validator not found!");
            \Session::flash('alert-class', 'alert-info');
            return \Redirect::to('/setup/userpermission?view=site_entry_approver');
        }
        $d->delete();
        
        \Session::flash('message', "Validator Deleted successfully!");
        \Session::flash('alert-class', 'alert-success');
        return \Redirect::to('/setup/userpermission?view=site_entry_approver');
    }
    
    public function delete_aktivasi_approver (Request $r){
        
        $d = \App\Model\AktivasiApprover::where('id_approver', $r->id_approver)->first();
        if(!$d){
            \Session::flash('message', "Validator not found!");
            \Session::flash('alert-class', 'alert-info');
            return \Redirect::to('/setup/userpermission?view=site_entry_approver');
        }
        $d->delete();
        
        \Session::flash('message', "Validator Deleted successfully!");
        \Session::flash('alert-class', 'alert-success');
        return \Redirect::to('/setup/userpermission?view=site_entry_approver');
    }
    
}





