<?php

namespace App\Http\Controllers\Setup\Customization;

use App\Http\Controllers\Controller;
use App\Model\Impact;
use Illuminate\Http\Request;
use \Auth;

class ImpactController extends Controller
{
    public function index($id_type)
    {
        $type = \App\Model\TaskType::where('id_type', $id_type)->first();
        if(!$type){
            \Session::flash('message', 'Oppss! Something went wrong please reload and try again!');
            \Session::flash('alert-class', 'alert-danger');
            return \Redirect::to('/setup/Customization');
        }
        $impact = Impact::where('id_task_type', $id_type)->get();
        return view('setup.customization.impact', compact('id_type', 'impact'));
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
            $orderBy = 'id_impact';
            $order_dir = 'ASC';
        }
        $data = Impact::orderBy($orderBy, $order_dir)->where('id_task_type', $id_type);
        
        $result = getDataCustom($data, $r, 'id_impact', 'impact_name')->original;
        return response()->json($result);
    }
    public function newData(Request $r, $id_type){
        $user = Auth::user();
        if(!$user){
            \Session::flash('message', "CSRF FAILED PLEASE RE-LOGIN!");
            \Session::flash('alert-class', 'alert-danger');
            return \Redirect::back();
        }
        $cek = Impact::where('impact_name', $r->impact_name)->where('id_task_type', $id_type)->first();
        if($cek){
            \Session::flash('message', "Impact with the same name already on list!");
            \Session::flash('alert-class', 'alert-info');
            return \Redirect::back();
        }
        
        $d = new Impact;
        $d->id_task_type = $id_type;
        $d->impact_name = $r->impact_name;
        $d->impact_desc = $r->impact_desc;
        $d->created_by = $user->id;
        $d->updated_by = $user->id;
        $d->save();
        
        \Session::flash('message', "Added Successfully");
        \Session::flash('alert-class', 'alert-success');
        return \Redirect::back();
    }    
    public function remove_impact(Request $r, $type, $id_impact){
        $result = [];
        $result["status"] = false;
        $result["message"] = "";
        $result["newtoken"] = csrf_token();
       
        $d = Impact::where('id_impact', $id_impact)->first();
        $result["id"] = $id_impact;
        $result["d"] = $d;
        if(!$d){
            $result["message"] = "Impact not found!";
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
        $d = Impact::where('id_impact', $id)->first();
        if(!$d){
            \Session::flash('message', "Impact does not exist!");
            \Session::flash('alert-class', 'alert-danger');
            return \Redirect::back();
        }
        $cek = Impact::where('impact_name', $r->impact_name)->where('id_task_type', $id_type)->where('id_impact', $id)->first();
        if($cek){
            \Session::flash('message', "Impact with the same name already on list!");
            \Session::flash('alert-class', 'alert-info');
            return \Redirect::back();
        }
        
        $d->id_task_type = $id_type;
        $d->impact_name = $r->impact_name;
        $d->impact_desc = $r->impact_desc;
        $d->created_by = $user->id;
        $d->updated_by = $user->id;
        $d->save();
        
        \Session::flash('message', "Updated Successfully");
        \Session::flash('alert-class', 'alert-success');
        return \Redirect::back();
    }    
}
