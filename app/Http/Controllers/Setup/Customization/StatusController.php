<?php

namespace App\Http\Controllers\Setup\Customization;

use App\Http\Controllers\Controller;
use App\Model\Status;
use Illuminate\Http\Request;
use \Auth;

class StatusController extends Controller
{
    public function index($id_type)
    {
         $type = \App\Model\TaskType::where('id_type', $id_type)->first();
        if(!$type){
            \Session::flash('message', 'Oppss! Something went wrong please reload and try again!');
            \Session::flash('alert-class', 'alert-danger');
            return \Redirect::to('/setup/Customization');
        }
        //where('id_task_type', $id_type)->get();
        $status = Status::where('task_type_id',$id_type)->get();
        return view('setup.customization.status', compact('id_type','status'));
    }
    
    public function getData(Request $r,$id_type)
    {
        $columns = $r->columns;
        $order = $r->order;
        if($order[0]){
            $column = $order[0]['column']; 
            $orderBy = $columns[$column]['data'];
            $order_dir = $order['dir'];
        }else{
            $orderBy = 'id_status';
            $order_dir = 'ASC';
        }
        //  return $id_type ;
        $data = Status::orderBy($orderBy, $order_dir)->where('task_type_id',$id_type);
       // $data = Status::where('task_type_id',$id_type);
        
        $result = getDataCustom($data, $r, 'id_status', 'status_name')->original;
        return response()->json($result);
    }
    
    public function newData(Request $r,$id_type){
        $user = Auth::user();
        if(!$user){
            \Session::flash('message', "CSRF FAILED PLEASE RE-LOGIN!");
            \Session::flash('alert-class', 'alert-danger');
            return \Redirect::back();
        }
        $cek = Status::where('status_name', $r->status_name)->where('task_type_id', $id_type)->first();
       
        if($cek){
            \Session::flash('message', "Status with the same name already on list!");
            \Session::flash('alert-class', 'alert-info');
            return \Redirect::back();
        }
        
        $d = new Status;
        $d->status_name = $r->status_name;
        $d->status_desc = $r->status_desc;
        $d->color = $r->color;
        $d->group_status = $r->input('statusProgress');
        
        if($r->input("onoffswitch") == "on"){
            $d->stop_timer = 1 ;
        }
        else{
               $d->stop_timer = 0 ;
            
        }
       
        $d->task_type_id = $id_type;
        $d->save();
        
        \Session::flash('message', "Added Successfully");
        \Session::flash('alert-class', 'alert-success');
        return \Redirect::back();
    }    
    
    public function updateData($id, Request $r){
        
        $user = Auth::user();
        if(!$user){
            \Session::flash('message', "CSRF FAILED PLEASE RE-LOGIN!");
            \Session::flash('alert-class', 'alert-danger');
            return \Redirect::back();
        }
        $d = Status::where('id_status', $id)->first();
        if(!$d){
            \Session::flash('message', "Status does not exist!");
            \Session::flash('alert-class', 'alert-danger');
            return \Redirect::back();
        }
        $cek = Status::where('status_name', $r->status_name)->where('id_status', $id)->first();
        if($cek){
            \Session::flash('message', "Status with the same name already on list!");
            \Session::flash('alert-class', 'alert-info');
            return \Redirect::back();
        }
        
        $d->status_name = $r->status_name;
        $d->status_desc = $r->status_desc;
        $d->color = $r->color;

        $d->group_status = $r->input('statusProgress');
        
        if($r->input("onoffswitch") == "on"){
            $d->stop_timer = 1 ;
        }
        else{
               $d->stop_timer = 0 ;
            
        }
       
        $d->task_type_id = $r->id_type;
        $d->update();
   
       
        
        \Session::flash('message', "Updated Successfully");
        \Session::flash('alert-class', 'alert-success');
        return \Redirect::back();
    }    
}
