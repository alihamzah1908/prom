<?php

namespace App\Http\Controllers\Setup\UserPermission;

use App\Http\Controllers\Controller;
use App\Model\Approver;
use App\Model\ApproverDetail;
use App\Model\Region;
use App\Model\TaskType;
use Illuminate\Http\Request;
use \Auth;

class ApproverController extends Controller
{
    public function index(Request $request)
    {
        $regions = Region::all();
        return view('setup.userpermission.approver', compact('regions'));
    }
    
    public function new_approver(Request $r)
    {
        $user = Auth::user();
        if(!$user){
            \Session::flash('message', "CSRF FAILED PLEASE RE-LOGIN!");
            \Session::flash('alert-class', 'alert-danger');
            return redirect()->back()->withInput($r->all());
        }
        
        $cek = Approver::where('id_region', $r->id_region)->where('id_task_type', $r->id_task_type)->first();
        if($cek){
            \Session::flash('message', "Approvers with the same Region and Task Type already on list!");
            \Session::flash('alert-class', 'alert-info');
            return redirect()->back();
        }
        
        $approver = new Approver;
        $approver->id_region = $r->id_region;
        $approver->id_task_type = $r->id_task_type;
        $approver->count_layer = count($r->id_approver);
        $approver->save();
        
        $layer = 1;
        foreach($r->id_approver as $key => $val){
            $detail = new ApproverDetail;
            $detail->id_approver = $approver->id_approver;
            $detail->user_id = $val;
            $detail->layer = $layer++;
            $detail->save();
        }
        
        \Session::flash('message', "Approver Created Successfully!");
        \Session::flash('alert-class', 'alert-success');
        return redirect()->back();
    }
    
    public function edit_approver(Request $r)
    {
        
        $user = Auth::user();
        if(!$user){
            \Session::flash('message', "CSRF FAILED PLEASE RE-LOGIN!");
            \Session::flash('alert-class', 'alert-danger');
            return redirect()->back()->withInput($r->all());
        }
        
        
        $approver = Approver::where('id_approver', $r->id)->first();
        if(!$approver){
            \Session::flash('message', "Opps something went wrong please try again!");
            \Session::flash('alert-class', 'alert-info');
            return redirect()->back();
        }
        
        $cek = Approver::where('id_region', $r->id_region)->where('id_task_type', $r->id_task_type)->where('id_approver', '!=', $r->id)->first();
        if($cek){
            \Session::flash('message', "Approvers with the same Region and Task Type already on list!");
            \Session::flash('alert-class', 'alert-info');
            return redirect()->back();
        }
        $approver->id_region = $r->id_region;
        $approver->id_task_type = $r->id_task_type;
        $approver->count_layer = count($r->id_approver);
        $approver->save();
        
        foreach($approver->detail as $d){
            $d->delete();
        }
        $layer = 1;
        foreach($r->id_approver as $key => $val){
            $detail = new ApproverDetail;
            $detail->id_approver = $approver->id_approver;
            $detail->user_id = $val;
            $detail->layer = $layer++;
            $detail->save();
        }
        
        \Session::flash('message', "Approver Updated Successfully!");
        \Session::flash('alert-class', 'alert-success');
        return redirect()->back();
    }
    
    public function getApprover(Request $r)
    {
        $columns = $r->columns;
        $order = $r->order;
        if($order[0]){
            $column = $order[0]['column']; 
            $orderBy = $columns[$column]['data'];
            $order_dir = $order['dir'];
        }else{
            $orderBy = 'id_approver';
            $order_dir = 'ASC';
        }
        $data = Approver::orderBy($orderBy, $order_dir);
        if($r->id_approver) $data = $data->where('id_approver', $r->id_approver);
        if($r->id) $data = $data->where('id_approver', $r->id);
        $result = getDataCustom($data, $r, 'id_approver', 'id_approver')->original;
        
        foreach($result['data'] as $d){
            $d->region;
            $d->task_type;
            $d->detail;
        }
        return response()->json($result);
    }
}







