<?php

namespace App\Http\Controllers\Setup\UserPermission;

use App\Http\Controllers\Controller;
use App\Model\SiteEntryApprover;
use App\Model\Region;
use App\Model\Site;
use Illuminate\Http\Request;
use \Auth;

class SiteEntryApproverController extends Controller
{
    public function index(Request $request)
    {
        $sites = Site::all();
        $users = \App\User::get();
        return view('setup.userpermission.site_entry_approver', compact('sites','users'));
    }
    
    public function new_approver(Request $r)
    {
        $user = Auth::user();
        if(!$user){
            \Session::flash('message', "CSRF FAILED PLEASE RE-LOGIN!");
            \Session::flash('alert-class', 'alert-danger');
            return redirect()->back()->withInput($r->all());
        }
        $cek = SiteEntryApprover::where('id_site', $r->id_site)->first();
        if($cek){
            $site_name = isset($cek->site)?$cek->site->name_site:'this Site';
            \Session::flash('message', "Approver for $site_name already assigned!");
            \Session::flash('alert-class', 'alert-info');
            return redirect()->back();  
        }
        $approver = new SiteEntryApprover;
        $approver->id_site = $r->id_site;
        $approver->approver_1 = $r->approver_1;
        $approver->approver_2 = $r->approver_2;
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
        
        $cek = SiteEntryApprover::where('id_site', $r->id_site)->where('id_approver', '!=', $r->id)->first();
        if($cek){
            $site_name = isset($cek->site)?$cek->site->name_site:'this Site';
            \Session::flash('message', "Approver for $site_name already assigned!");
            \Session::flash('alert-class', 'alert-info');
            return redirect()->back();  
        }
        $approver = SiteEntryApprover::where('id_approver', $r->id)->first();
        if(!$approver){
            \Session::flash('message', "Opps something went wrong please try again!");
            \Session::flash('alert-class', 'alert-info');
            return redirect()->back();  
        }
        $approver->id_site = $r->id_site;
        $approver->approver_1 = $r->approver_1;
        $approver->approver_2 = $r->approver_2;
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
        $data = SiteEntryApprover::orderBy($orderBy, $order_dir);
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







