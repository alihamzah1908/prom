<?php

namespace App\Http\Controllers\Setup\Customization;

use App\Http\Controllers\Controller;
use App\Model\Mode;
use Illuminate\Http\Request;
use \Auth;

class ModeController extends Controller
{
    public function index($id_type)
    {
        $type = \App\Model\TaskType::where('id_type', $id_type)->first();
        if(!$type){
            \Session::flash('message', 'Oppss! Something went wrong please reload and try again!');
            \Session::flash('alert-class', 'alert-danger');
            return \Redirect::to('/setup/Customization');
        }
        $mode = Mode::where('id_task_type', $id_type)->get();
        return view('setup.customization.mode', compact('id_type', 'mode'));
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
            $orderBy = 'id_mode';
            $order_dir = 'ASC';
        }
        $data = Mode::orderBy($orderBy, $order_dir)->where('id_task_type', $id_type);
        
        $result = getDataCustom($data, $r, 'id_mode', 'mode_name')->original;
        return response()->json($result);
    }

    public function newData(Request $r, $id_type){
        $user = Auth::user();
        if(!$user){
            \Session::flash('message', "CSRF FAILED PLEASE RE-LOGIN!");
            \Session::flash('alert-class', 'alert-danger');
            return \Redirect::back();
        }
        $cek = Mode::where('mode_name', $r->mode_name)->where('id_task_type', $id_type)->first();
        if($cek){
            \Session::flash('message', "Mode with the same name already on list!");
            \Session::flash('alert-class', 'alert-info');
            return \Redirect::back();
        }
        
        $d = new Mode;
        $d->id_task_type = $id_type;
        $d->mode_name = $r->mode_name;
        $d->mode_desc = $r->mode_desc;
        $d->created_by = $user->id;
        $d->updated_by = $user->id;
        $d->save();
        
        \Session::flash('message', "Added Successfully");
        \Session::flash('alert-class', 'alert-success');
        return \Redirect::back();
    }    
    
    public function updateData($id_type, $id, Request $r){
        $user = Auth::user();
        if(!$user){
            \Session::flash('message', "CSRF FAILED PLEASE RE-LOGIN!");
            \Session::flash('alert-class', 'alert-danger');
            return \Redirect::back();
        }
        $d = Mode::where('id_mode', $id)->first();
        if(!$d){
            \Session::flash('message', "Mode does not exist!");
            \Session::flash('alert-class', 'alert-danger');
            return \Redirect::back();
        }
        $cek = Mode::where('mode_name', $r->mode_name)->where('id_task_type', $id_type)->where('id_mode', $id)->first();
        if($cek){
            \Session::flash('message', "Mode with the same name already on list!");
            \Session::flash('alert-class', 'alert-info');
            return \Redirect::back();
        }
        
        $d->id_task_type = $id_type;
        $d->mode_name = $r->mode_name;
        $d->mode_desc = $r->mode_desc;
        $d->created_by = $user->id;
        $d->updated_by = $user->id;
        $d->save();
        
        \Session::flash('message', "Updated Successfully");
        \Session::flash('alert-class', 'alert-success');
        return \Redirect::back();
    }    
}
