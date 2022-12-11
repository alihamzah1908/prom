<?php

namespace App\Http\Controllers\Setup\UserPermission;

use App\Http\Controllers\Controller;
use App\Model\AktivasiApprover;
use App\Model\AktivasiApproverDetail;
use App\Model\Region;
use App\Model\Site;
use App\Model\TaskType;
use Illuminate\Http\Request;
use \Auth;

class AktivasiApproverController extends Controller
{
    public function index(Request $request)
    {
        $regions = Region::all();
        $sites = Site::all();
        $users = \App\User::get();
        return view('setup.userpermission.aktivasi_approver', compact('regions', 'users', 'sites'));
    }
    
    public function new_approver(Request $r)
    {
        $user = Auth::user();
        if(!$user){
            \Session::flash('message', "CSRF FAILED PLEASE RE-LOGIN!");
            \Session::flash('alert-class', 'alert-danger');
            return redirect()->back()->withInput($r->all());
        }
        
        $cek = AktivasiApprover::where('id_region', $r->id_region)->where('id_type', $r->id_type)->first();
        if($cek){
            \Session::flash('message', "Approvers with the same Region and Type already on list!");
            \Session::flash('alert-class', 'alert-info');
            return redirect()->back();
        }
        $approver = new AktivasiApprover;
        $approver->id_region = $r->id_region;
        $approver->id_site = $r->id_site;
        $approver->id_type = $r->id_type;
        $approver->approver_1 = $r->approver_1;
        $approver->approver_2 = $r->approver_2;
        $approver->approver_3 = $r->approver_3;
        $approver->save();
        
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
        
        
        $approver = AktivasiApprover::where('id_approver', $r->id)->first();
        if(!$approver){
            \Session::flash('message', "Opps something went wrong please try again!");
            \Session::flash('alert-class', 'alert-info');
            return redirect()->back();
        }
        
        $cek = AktivasiApprover::where('id_region', $r->id_region)->where('id_type', $r->id_type)->where('id_approver', '!=', $r->id)->first();
        if($cek){
            \Session::flash('message', "Approvers with the same Region and Type already on list!");
            \Session::flash('alert-class', 'alert-info');
            return redirect()->back();
        }
        $approver->id_region = $r->id_region;
        $approver->id_site = $r->id_site;
        $approver->id_type = $r->id_type;
        $approver->approver_1 = $r->approver_1;
        $approver->approver_2 = $r->approver_2;
        $approver->approver_3 = $r->approver_3;
        $approver->save();
        
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
        $data = AktivasiApprover::orderBy($orderBy, $order_dir);
        if($r->id_approver) $data = $data->where('id_approver', $r->id_approver);
        if($r->id) $data = $data->where('id_approver', $r->id);
        $result = getDataCustom($data, $r, 'id_approver', 'id_approver')->original;
        
        foreach($result['data'] as $d){
            $d->region;
            $d->site;
        }
        return response()->json($result);
    }
}







