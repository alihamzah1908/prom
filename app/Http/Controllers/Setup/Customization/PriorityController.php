<?php

namespace App\Http\Controllers\Setup\Customization;

use App\Http\Controllers\Controller;
use App\Model\Priority;
use Illuminate\Http\Request;
use \Auth;

class PriorityController extends Controller
{
    public function index($id_type)
    {
        $type = \App\Model\TaskType::where('id_type', $id_type)->first();
        if(!$type){
            \Session::flash('message', 'Oppss! Something went wrong please reload and try again!');
            \Session::flash('alert-class', 'alert-danger');
            return \Redirect::to('/setup/Customization');
        }
        $priority = Priority::where('id_task_type', $id_type)->get();
        return view('setup.customization.priority', compact('id_type', 'priority'));
    }
    public function getData(Request $r, $id_type)
    {
        $columns = $r->columns;
        $order = $r->order;
        if($order[0]){
            $column = $order[0]['column']; 
            $orderBy = $columns[$column]['data'];
            $order_dir = $order['dir'];
        }else{
            $orderBy = 'id_priority';
            $order_dir = 'ASC';
        }
        $data = Priority::orderBy($orderBy, $order_dir)->where('id_task_type', $id_type);
        
        $result = getDataCustom($data, $r, 'id_priority', 'priority_name')->original;
        return response()->json($result);
    }
    public function newData(Request $r, $id_type){
        $user = Auth::user();
        if(!$user){
            \Session::flash('message', "CSRF FAILED PLEASE RE-LOGIN!");
            \Session::flash('alert-class', 'alert-danger');
            return \Redirect::back();
        }
        $cek = Priority::where('priority_name', $r->priority_name)->where('id_task_type', $id_type)->first();
        if($cek){
            \Session::flash('message', "Priority with the same name already on list!");
            \Session::flash('alert-class', 'alert-info');
            return \Redirect::back();
        }
        
        $d = new Priority;
        $d->id_task_type = $id_type;
        $d->priority_name = $r->priority_name;
        $d->priority_desc = $r->priority_desc;
        $d->color = $r->color;
        $d->created_by = $user->id;
        $d->updated_by = $user->id;
        $d->save();
        
        \Session::flash('message', "Added Successfully");
        \Session::flash('alert-class', 'alert-success');
        return \Redirect::back();
    }    
    
     public function remove_priority(Request $r, $type, $id_priority){
        $result = [];
        $result["status"] = false;
        $result["message"] = "";
        $result["newtoken"] = csrf_token();
       
        $d = Priority::where('id_priority', $id_priority)->first();
        $result["id"] = $id_priority;
        $result["d"] = $d;
        if(!$d){
            $result["message"] = "priority not found!";
            return response($result);
        }
        $d->delete();
        
        $result["status"] = true;
        $result["message"] = "Deleted successfully!";
        return response()->json($result);
    }
    
    public function updateData($id_type,Request $r){
        $id = $r->id;
        $user = Auth::user();
        if(!$user){
            \Session::flash('message', "CSRF FAILED PLEASE RE-LOGIN!");
            \Session::flash('alert-class', 'alert-danger');
            return \Redirect::back();
        }
        $d = Priority::where('id_priority', $id)->first();
        if(!$d){
            \Session::flash('message', "Priority does not exist!");
            \Session::flash('alert-class', 'alert-danger');
            return \Redirect::back();
        }
        $cek = Priority::where('priority_name', $r->priority)->where('id_task_type', $id_type)->where('id_priority', $id)->first();
        if($cek){
            \Session::flash('message', "Priority with the same name already on list!");
            \Session::flash('alert-class', 'alert-info');
            return \Redirect::back();
        }
        
        $d->id_task_type = $id_type;
        $d->priority_name = $r->priority_name;
        $d->priority_desc = $r->priority_desc;
        $d->color = $r->color;
        $d->created_by = $user->id;
        $d->updated_by = $user->id;
        $d->save();
        
        \Session::flash('message', "Updated Successfully");
        \Session::flash('alert-class', 'alert-success');
        return \Redirect::back();
    }    
}
