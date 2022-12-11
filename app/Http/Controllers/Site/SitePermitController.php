<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \App\Model\SiteEntry;
use \App\Model\SiteEntryLog;
use \App\Model\SiteEntryApprover;
use \App\Model\PermitLetter;
use \App\Model\PermitLetterDetail;
use \App\Model\Site;
use \App\Model\Region;
use \Auth;

class SitePermitController extends Controller
{
    public function index(){
        return view('site_permit.index');
    }
    public function siteEntry(){
        return view('site_permit.site_entry');
    }
    public function pdfPermitLetter(Request $r){
        $pdf = \PDF::loadView('site_permit.pdf_permit_letter');
        return $pdf->stream();
    }
    public function pdfSiteEntry(Request $r){
        $pdf = \PDF::loadView('site_permit.pdf_site_entry');
        return $pdf->stream();
    }
    public function detailSiteEntry($id){
        $data = SiteEntry::where('id_site_entry', $id)->first();
        $region = isset($data->region)?$data->region: new Region; 
        $site = isset($data->site)?$data->site: new Site; 
        return view('site_permit.detail_site_entry', compact('data', 'site', 'region'));
    }
    public function updateSiteEntry(Request $r, $id){
        $user = Auth::user();
        if(!$user){
            \Session::flash('message', "CSRF FAILED PLEASE RE-LOGIN!");
            \Session::flash('alert-class', 'alert-danger');
            return redirect()->back()->withInput($r->all());
        }
        $site = Site::where('site_id', $r->id_site)->first();
        if(!$site){
            \Session::flash('message', "Site does not exist!");
            \Session::flash('alert-class', 'alert-danger');
            return redirect()->back()->withInput($r->all());
        }
        
        $d = SiteEntry::where('id_site_entry', $id)->first();
        if(!$d){
            \Session::flash('message', "Oops! Something went wrong please try again");
            \Session::flash('alert-class', 'alert-danger');
            return redirect()->back()->withInput($r->all());
        }
        
         if($r->status == "CHECKOUT"){
           // $d->checkout_time = date('Y-m-d H:i:s');
             $d->status = "WAITING APPROVAL CHECKOUT";
        }
        else{
             $d->status = $r->status;
        }
       
        $d->id_site = $r->id_site;
        $d->id_region = $site->region_id;
        $d->entry_datetime = $r->entry_datetime;
        $d->jumlah_petugas = $r->jumlah_petugas;
        $d->latitude = $r->latitude;
        $d->longitude = $r->longitude;
        $d->personil = json_encode($r->personil);
        $d->description = $r->description;
        $d->save();
        
        $log = new SiteEntryLog;
        $log->id_site_entry = $d->id_site_entry;
        $log->action = "UPDATE";
        $log->status_to = isset($data->status)?$data->status->name:'CHECKIN';
        $log->changed_data_to = $this->siteEntryJsonData($d);
        $log->created_by = $user->id;
        $log->save();
        
        \Session::flash('message', "Updated Successfully!");
        \Session::flash('alert-class', 'alert-success');
        return redirect()->to('site-permit');
    }
    
     public function updateSiteEntryApi(Request $r, $id){
        // // $user = Auth::user();
        // // if(!$user){
        // //     \Session::flash('message', "CSRF FAILED PLEASE RE-LOGIN!");
        // //     \Session::flash('alert-class', 'alert-danger');
        // //     return redirect()->back()->withInput($r->all());
        // // }
        // $site = Site::where('site_id', $r->id_site)->first();
        // if(!$site){
        //     // \Session::flash('message', "Site does not exist!");
        //     // \Session::flash('alert-class', 'alert-danger');
        //     // return redirect()->back()->withInput($r->all());
        // }
        
        // $d = SiteEntry::where('id_site_entry', $id)->first();
        // if(!$d){
        //     \Session::flash('message', "Oops! Something went wrong please try again");
        //     \Session::flash('alert-class', 'alert-danger');
        //     return redirect()->back()->withInput($r->all());
        // }
        
         $result = [];
        $result["status"] = false;
        $result["message"] = "";
        $result["newtoken"] = csrf_token();
        
        $user = Auth::user();
        if(!$user){
            $result["message"] = "CSRF FAILED PLEASE RE-LOGIN!";
            return response($result);
        }
        $site = Site::where('site_id', $r->id_site)->first();
        if(!$site){
            $result["message"] = "Opps! Something went wrong please try again!";
            return response($result);
        }
        
         $d = SiteEntry::where('id_site_entry', $id)->first();
        if(!$d){
            $result["message"] = "Opps! Something went wrong please try again!";
            return response($result);
        }
        if($r->status == "CHECKOUT"){
            
            $d->status = "WAITING APPROVAL CHECKOUT";
        }
        else{
             $d->status = $r->status;
            
        }
        
        // $d->id_site = $r->id_site;
        // $d->id_region = $site->region_id;
        // $d->entry_datetime = $r->entry_datetime;
        // $d->jumlah_petugas = $r->jumlah_petugas;
        // $d->latitude = $r->latitude;
        // $d->longitude = $r->longitude;
        // $d->personil = json_encode($r->personil);
        // $d->description = $r->description;
        $d->save();
        
        
        
        $log = new SiteEntryLog;
        $log->id_site_entry = $d->id_site_entry;
        $log->action = "UPDATE";
        $log->status_to = isset($data->status)?$data->status->name:'CHECKOUT';
        $log->changed_data_to = $this->siteEntryJsonData($d);
        $log->created_by = $user->id;
        $log->save();
          $result["status"] = true;
        $result["data"] = $d;
        $result["message"] = "Update Site Entry Succesfully";
        return response($result);
        
        
        
        // \Session::flash('message', "Updated Successfully!");
        // \Session::flash('alert-class', 'alert-success');
        // return redirect()->to('site-permit');
    }
    
    public function delete_site_entry($id){
        
        $siteEntry = SiteEntry::where('id_site_entry',$id)->first();
        
        if($siteEntry){
             $siteEntry->is_deleted = true ;
            }
            
        $siteEntry->save();
        
        \Session::flash('message', "Deleted Successfully!");
        \Session::flash('alert-class', 'alert-success');
        return redirect()->to('site-permit');
        
        
    }
    public function newSiteEntry(Request $r){
        $user = Auth::user();
        if(!$user){
            \Session::flash('message', "CSRF FAILED PLEASE RE-LOGIN!");
            \Session::flash('alert-class', 'alert-danger');
            return redirect()->back()->withInput($r->all());
        }
        $site = Site::where('site_id', $r->id_site)->first();
        if(!$site){
            \Session::flash('message', "Site does not exist!");
            \Session::flash('alert-class', 'alert-danger');
            return redirect()->back()->withInput($r->all());
        }
        $sites = SiteEntry::where('created_by',$user->id)->whereNull('checkout_time')->first();
         if($sites){
            \Session::flash('message', "Sorry you must Checkout !");
            \Session::flash('alert-class', 'alert-danger');
            return redirect()->back()->withInput($r->all());
        }
        
        
        $d = new SiteEntry;
        
        $d->status = "WAITING APPROVAL CHECKIN";
        $d->id_site = $r->id_site;
        $d->id_region = $site->region_id;
        $d->entry_datetime = $r->entry_datetime;
        $d->jumlah_petugas = $r->jumlah_petugas;
        $d->latitude = $r->latitude;
        $d->longitude = $r->longitude;
        $d->personil = json_encode($r->personil);
        $d->description = $r->description;
        
        $approver = SiteEntryApprover::where('id_site', $r->id_site)->first();
        $site_name = isset($site)?$site->name_site:'this Site';
        if(!$approver){
            \Session::flash('message', "Approver for $site_name does not exist!");
            \Session::flash('alert-class', 'alert-danger');
            return redirect()->back()->withInput($r->all());
        }
        $approver_1 = \App\User::where('id', $approver->approver_1)->first();
        if(!$approver_1){
            \Session::flash('message', "Approver I for $site_name does not exist!");
            \Session::flash('alert-class', 'alert-danger');
            return redirect()->back()->withInput($r->all());
        }
        $d->id_approver = $approver->id_approver;
        $d->approver_1 = $approver->approver_1;
        $d->approver_2 = $approver->approver_2;
        $d->created_by = $user->id;
        $d->save();
        
        $status = isset($data->status)?$data->status->name:'CHECKIN';
        $log = new SiteEntryLog;
        $log->id_site_entry = $d->id_site_entry;
        $log->action = "CREATE";
        $log->status_to = $status;
        $log->changed_data_to = $this->siteEntryJsonData($d);
        $log->created_by = $user->id;
        $log->save();
        
        
        $tokens = [$approver_1->firebase_token, $approver_1->firebase_token_web];
        sendSiteEntry($d, $tokens, "Site Entry Has Been $status", "");
        
        \Session::flash('message', "Created Successfully!");
        \Session::flash('alert-class', 'alert-success');
        return redirect()->to('site-permit');
    }
    public function newSiteEntryAPI(Request $r){
        $result = [];
        $result["status"] = false;
        $result["message"] = "";
        $result["newtoken"] = csrf_token();
        
        $user = Auth::user();
        if(!$user){
            $result["message"] = "CSRF FAILED PLEASE RE-LOGIN!";
            return response($result);
        }
        $site = Site::where('site_id', $r->id_site)->first();
        if(!$site){
            $result["message"] = "Opps! Something went wrong please try again!";
            return response($result);
        }
        if(!($r->personil)){
            $result["message"] = "Opps! need input personil !";
             $result["status"] = false;
           return response($result);
       }
       
        $sites = SiteEntry::where('created_by',$user->id)->whereNull('checkout_time')->first();

        
        if($sites){
            $result["message"] = "Opps! You must Checkout  !";
             $result["status"] = false;
           return response($result);
       }
      
        

        
        $d = new SiteEntry;
        $d->status = "WAITING APPROVAL CHECKIN";
        $d->id_site = $r->id_site;
        $d->id_region = $site->region_id;
        $d->entry_datetime = $r->entry_datetime;
        $d->jumlah_petugas = $r->jumlah_petugas;
        $d->latitude = $r->latitude;
        $d->longitude = $r->longitude;
        $d->personil = json_encode($r->personil);
        $d->description = $r->description;
        
        $approver = SiteEntryApprover::where('id_site', $r->id_site)->first();
        $site_name = isset($site)?$site->name_site:'this Site';
        if(!$approver){
            $result["message"] = "Approver for $site_name does not exist!";
            return response($result);
        }
        $approver_1 = \App\User::where('id', $approver->approver_1)->first();
        if(!$approver_1){
            $result["message"] = "Approver I for $site_name does not exist!";
            return response($result);
        }
        $d->id_approver = $approver->id_approver;
        $d->approver_1 = $approver->approver_1;
        $d->approver_2 = $approver->approver_2;
        $d->created_by = $user->id;
        $d->save();
        
        $log = new SiteEntryLog;
        $log->id_site_entry = $d->id_site_entry;
        $log->action = "CREATE";
        $log->status_to = isset($data->status)?$data->status:'CHECKIN';
        $log->changed_data_to = $this->siteEntryJsonData($d);
        $log->created_by = $user->id;
        $log->save();
        
        $tokens = [$approver_1->firebase_token, $approver_1->firebase_token_web];
        sendSiteEntry($d, $tokens, "Site Entry Has Been created", "");
        
        $result["status"] = true;
        $result["data"] = $d;
        $result["message"] = "Created Succesfully";
        return response($result);
    }
    public function getSiteEntry(Request $r){
        
        $columns = $r->columns;
        $order = $r->order;
        if($order[0]){
            $column = $order[0]['column']; 
            $orderBy = $columns[$column]['data'];
            $order_dir = $order['dir'];
        }else{
            $orderBy = 'id_site_entry';
            $order_dir = 'ASC';
        }
        $data = SiteEntry::orderBy($orderBy, $order_dir);
      
        $data = $data->where('is_deleted',false);
        if($r->id_region) $data->where('id_region', $r->id_region);
        if($r->id_site) $data->where('id_site', $r->id_site);
        if($r->status) $data->where('status', $r->status);
        if($r->created_by) $data->where('created_by', $r->created_by);
        
        
        $user = Auth::user();
        if(!is_admin($user)){
            $user_id = $user->id;
            $data = $data->where(function ($data) use($user_id) {
                            $data->where('approver_1', 'like', '%' . $user_id . '%');
                            $data->orWhere('approver_2', 'like', '%' . $user_id . '%');
                            $data->orWhere('created_by', 'like', '%' . $user_id . '%');
                          });
        }
        
        $result = getDataCustom($data, $r, 'id_site_entry', 'id_site_entry')->original;
        foreach($result['data'] as $d){
            $d->site;
            $d->region;
            $d->pdf = main_url().'/site-permit/site-entry-pdf?id='.$d->id_site_entry;
            $personil_name = [];
            $personil = json_decode(isset($d->personil)?$d->personil:"");
           
            foreach($personil as $key => $val){
                $p = \App\User::where('id', $val)->first();
                if($p) $personil_name[] = $p->name;
            }
            $d->personil_name = $personil_name;
        }
        
        return response()->json($result);
    }
    public function siteEntryApproval(Request $r, $id_site_entry){
        $user = Auth::user();
        if(!$user){
            \Session::flash('message', "CSRF FAILED PLEASE RE-LOGIN!");
            \Session::flash('alert-class', 'alert-danger');
            return redirect()->back()->withInput($r->all());
        }
        
        $d = SiteEntry::where('id_site_entry', $id_site_entry)->first();
        if(!$d){
            \Session::flash('message', "Opps! something went wrong please try again!");
            \Session::flash('alert-class', 'alert-danger');
            return redirect()->back()->withInput($r->all());
        }
        
        $status = $r->approval_status;
        if($status != "APPROVED") $status = "REJECTED";
        $note = $r->note;
        
        if($d->approver_1 == $user->id){
            $d->approver_1_status = $status;
            $d->approver_1_note = $note;
            if($status == "REJECTED"){
                $d->approver_2_status = "REJECTED";
                $d->approver_2_note = "INHERITED THE REJECTION FROM APPROVER_1";
            }
            $next_id =  $d->approver_2;
        }elseif($d->approver_2 == $user->id){
            
            if(!$d->approver_1_status){
                $approver_1_name = isset($d->approver1)?$d->approver1->name:'DELETED APPROVER';
                \Session::flash('message', "Approver 1 ($approver_1_name) haven't approved this Site Entry yet!");
                \Session::flash('alert-class', 'alert-danger');
                return redirect()->back()->withInput($r->all());
            }
            if($d->approver_1_status == "REJECTED"){
                $approver_1_name = isset($d->approver1)?$d->approver1->name:'DELETED APPROVER';
                \Session::flash('message', "Approver 1 ($approver_1_name) has already REJECTED this Site Entry!");
                \Session::flash('alert-class', 'alert-danger');
                return redirect()->back()->withInput($r->all());
            }
            if($d->approver_1_status != "APPROVED"){
                $approver_1_name = isset($d->approver1)?$d->approver1->name:'DELETED APPROVER';
                \Session::flash('message', "Approver 1 ($approver_1_name) haven't approved this Site Entry yet!");
                \Session::flash('alert-class', 'alert-danger');
                return redirect()->back()->withInput($r->all());
            }
            $d->approver_2_status = $status;
            $d->approver_2_note = $note;
            $d->status = "CHECKIN";
             
            $d->checkin_time = date('Y-m-d H:i:s');
        
            $next_id =  $d->created_by;
        }else{
            \Session::flash('message', "Opps! something went wrong please try again!!");
            \Session::flash('alert-class', 'alert-danger');
            return redirect()->back()->withInput($r->all());
        }
            
        $d->save();
        
        $log = new SiteEntryLog;
        $log->id_site_entry = $d->id_site_entry;
        $log->action = "APPROVAL CHECKIN";
        $log->status_to = $status;
        $log->changed_data_to = $this->siteEntryJsonData($d);
        $log->created_by = $user->id;
        $log->save();
        
        $next = \App\User::where('id', $next_id)->first();
        $tokens = [$next->firebase_token, $next->firebase_token_web];
        sendSiteEntry($d, $tokens, "Site Entry Has Been $status", "Success Approved CheckIn");
        
        \Session::flash('message', "$status Successfully!");
        \Session::flash('alert-class', 'alert-success');
        return redirect()->to('waiting_approval/site-permit');
    }
     public function siteEntryApprovalCheckout(Request $r, $id_site_entry){
        $user = Auth::user();
        if(!$user){
            \Session::flash('message', "CSRF FAILED PLEASE RE-LOGIN!");
            \Session::flash('alert-class', 'alert-danger');
            return redirect()->back()->withInput($r->all());
        }
        
        $d = SiteEntry::where('id_site_entry', $id_site_entry)->first();
        if(!$d){
            \Session::flash('message', "Opps! something went wrong please try again!");
            \Session::flash('alert-class', 'alert-danger');
            return redirect()->back()->withInput($r->all());
        }
        
        $status = $r->approval_status_checkout;
        if($status != "APPROVED") $status = "REJECTED";
        $note = $r->note;
        
        if($d->approver_1 == $user->id){
            $d->approver_1_checkout = $status;
            $d->approver_1_notecheckout = $note;
            if($status == "REJECTED"){
                $d->approver_2_checkout = "REJECTED";
                $d->approver_2_notecheckout = "INHERITED THE REJECTION FROM APPROVER_1";
            }
            $next_id =  $d->approver_2;
        }elseif($d->approver_2 == $user->id){
            
            if(!$d->approver_1_checkout){
                $approver_1_name = isset($d->approver1)?$d->approver1->name:'DELETED APPROVER';
                \Session::flash('message', "Approver 1 ($approver_1_name) haven't approved this Site Entry yet!");
                \Session::flash('alert-class', 'alert-danger');
                return redirect()->back()->withInput($r->all());
            }
            if($d->approver_1_checkout == "REJECTED"){
                $approver_1_name = isset($d->approver1)?$d->approver1->name:'DELETED APPROVER';
                \Session::flash('message', "Approver 1 ($approver_1_name) has already REJECTED this Site Entry!");
                \Session::flash('alert-class', 'alert-danger');
                return redirect()->back()->withInput($r->all());
            }
            if($d->approver_1_status != "APPROVED"){
                $approver_1_name = isset($d->approver1)?$d->approver1->name:'DELETED APPROVER';
                \Session::flash('message', "Approver 1 ($approver_1_name) haven't approved this Site Entry yet!");
                \Session::flash('alert-class', 'alert-danger');
                return redirect()->back()->withInput($r->all());
            }
            $d->approver_2_checkout = $status;
            $d->approver_2_notecheckout = $note;
            $d->status = "CHECKOUT";
             
            $d->checkout_time = date('Y-m-d H:i:s');
        
            $next_id =  $d->created_by;
        }else{
            \Session::flash('message', "Opps! something went wrong please try again!!");
            \Session::flash('alert-class', 'alert-danger');
            return redirect()->back()->withInput($r->all());
        }
            
        $d->save();
        
        $log = new SiteEntryLog;
        $log->id_site_entry = $d->id_site_entry;
        $log->action = "APPROVAL CHECKOUT";
        $log->status_to = $status;
        $log->changed_data_to = $this->siteEntryJsonData($d);
        $log->created_by = $user->id;
        $log->save();
        
        $next = \App\User::where('id', $next_id)->first();
        $tokens = [$next->firebase_token, $next->firebase_token_web];
        sendSiteEntry($d, $tokens, "Site Entry Has Been $status", "Success Approved CheckIn");
        
        \Session::flash('message', "$status Successfully!");
        \Session::flash('alert-class', 'alert-success');
        return redirect()->to('waiting_approval/site-permit');
    }
    public function siteEntryApproval_api(Request $r, $id_site_entry){
        
        $result = [];
        $result["status"] = false;
        $result["message"] = "";
        $result["newtoken"] = csrf_token();
        
        $user = Auth::user();
        if(!$user){
            $result["message"] = "CSRF FAILED PLEASE RE-LOGIN!";
            return response($result);
        }
        
        $d = SiteEntry::where('id_site_entry', $id_site_entry)->first();
        if(!$d){
            $result["message"] = "Opps! Something went wrong please try again!";
            return response($result);
            return redirect()->back()->withInput($r->all());
        }
        
        $status = $r->approval_status;
        if($status != "APPROVED") $status = "REJECTED";
        $note = $r->note;
        
        if($d->approver_1 == $user->id){
            $d->approver_1_status = $status;
            $d->approver_1_note = $note;
            if($status == "REJECTED"){
                $d->approver_2_status = "REJECTED";
                $d->approver_2_note = "INHERITED THE REJECTION FROM APPROVER_1";
            }
            $next_id = $d->approver_2;
        }elseif($d->approver_2 == $user->id){
            
            if(!$d->approver_1_status){
                $approver_1_name = isset($d->approver1)?$d->approver1->name:'DELETED APPROVER';
                $result["message"] = "Approver 1 ($approver_1_name) haven't approved this Site Entry yet!";
                return response($result);
            }
            if($d->approver_1_status == "REJECTED"){
                $approver_1_name = isset($d->approver1)?$d->approver1->name:'DELETED APPROVER';
                $result["message"] = "Approver 1 ($approver_1_name) has already REJECTED this Site Entry!";
                return response($result);
            }
            if($d->approver_1_status != "APPROVED"){
                $approver_1_name = isset($d->approver1)?$d->approver1->name:'DELETED APPROVER';
                $result["message"] = "Approver 1 ($approver_1_name) haven't approved this Site Entry yet!";
                return response($result);
            }
            $d->approver_2_status = $status;
            $d->status = "CHECKIN";
            $d->approver_2_note = $note;
           
             
            $d->checkin_time = date('Y-m-d H:i:s');
            $next_id = $d->created_by;
        }else{
            $result["message"] = "Opps! Something went wrong please try again!";
            return response($result);
        }
        
        $d->save();
        
        $log = new SiteEntryLog;
        $log->id_site_entry = $d->id_site_entry;
        $log->action = "APPROVAL CHECKIN";
        $log->status_to = $status;
        $log->changed_data_to = $this->siteEntryJsonData($d);
        $log->created_by = $user->id;
        $log->save();
        
        $next = \App\User::where('id', $next_id)->first();
        $tokens = [$next->firebase_token, $next->firebase_token_web];
        sendSiteEntry($d, $tokens, "Site Entry Has Been $status", "success Approved CheckIn");
        
        $result["status"] = true;
        $result["message"] = "$status Successfully!";
        $result["data"] = $d;
        return response($result);
    }
     public function siteEntryApprovalCheckout_api(Request $r, $id_site_entry){
        
        $result = [];
        $result["status"] = false;
        $result["message"] = "";
        $result["newtoken"] = csrf_token();
        
        $user = Auth::user();
        if(!$user){
            $result["message"] = "CSRF FAILED PLEASE RE-LOGIN!";
            return response($result);
        }
        
        $d = SiteEntry::where('id_site_entry', $id_site_entry)->first();
        if(!$d){
            $result["message"] = "Opps! Something went wrong please try again!";
            return response($result);
            return redirect()->back()->withInput($r->all());
        }
        
        $status = $r->approval_status;
        if($status != "APPROVED") $status = "REJECTED";
        $note = $r->note;
        
        if($d->approver_1 == $user->id){
            $d->approver_1_checkout = $status;
            $d->approver_1_notecheckout = $note;
            if($status == "REJECTED"){
                $d->approver_2_checkout = "REJECTED";
                $d->approver_2_notecheckout = "INHERITED THE REJECTION FROM APPROVER_1";
            }
            $next_id = $d->approver_2;
        }elseif($d->approver_2 == $user->id){
            
            if(!$d->approver_1_checkout){
                $approver_1_name = isset($d->approver1)?$d->approver1->name:'DELETED APPROVER';
                $result["message"] = "Approver 1 ($approver_1_name) haven't approved this Site Entry yet!";
                return response($result);
            }
            if($d->approver_1_checkout == "REJECTED"){
                $approver_1_name = isset($d->approver1)?$d->approver1->name:'DELETED APPROVER';
                $result["message"] = "Approver 1 ($approver_1_name) has already REJECTED this Site Entry!";
                return response($result);
            }
            if($d->approver_1_checkout != "APPROVED"){
                $approver_1_name = isset($d->approver1)?$d->approver1->name:'DELETED APPROVER';
                $result["message"] = "Approver 1 ($approver_1_name) haven't approved this Site Entry yet!";
                return response($result);
            }
            $d->approver_2_checkout = $status;
            $d->approver_2_notecheckout = $note;
            $d->status = "CHECKOUT";
            $d->checkout_time = date('Y-m-d H:i:s');
            $next_id = $d->created_by;
        }else{
            $result["message"] = "Opps! Something went wrong please try again!";
            return response($result);
        }
        
        $d->save();
        
        $log = new SiteEntryLog;
        $log->id_site_entry = $d->id_site_entry;
        $log->action = "APPROVAL CHECKOUT";
        $log->status_to = $status;
        $log->changed_data_to = $this->siteEntryJsonData($d);
        $log->created_by = $user->id;
        $log->save();
        
        $next = \App\User::where('id', $next_id)->first();
        $tokens = [$next->firebase_token, $next->firebase_token_web];
        sendSiteEntry($d, $tokens, "Site Entry Has Been $status", "success Approved Checkout");
        
        $result["status"] = true;
        $result["message"] = "$status Successfully!";
        $result["data"] = $d;
        return response($result);
    }
    
    public function permitLetter(){
        return view('site_permit.permit_letter');
    }
    public function detailPermitLetter($id){
        $data = PermitLetter::where('id_permit_letter', $id)->first();
        $site = isset($data->site)?$data->site: new Site; 
        $pengunjung = isset($data->pengunjung)?$data->pengunjung: new PermitLetterDetail; 
        return view('site_permit.detail_permit_letter', compact('data', 'site', 'pengunjung'));
    }
    public function updatePermitLetter(Request $r, $id){
        return $r->all();
    }
    public function newPermitLetter(Request $r){
        $user = Auth::user();
        if(!$user){
            \Session::flash('message', "CSRF FAILED PLEASE RE-LOGIN!");
            \Session::flash('alert-class', 'alert-danger');
            return redirect()->back()->withInput($r->all());
        }
        $site = Site::where('site_id', $r->id_site)->first();
        if(!$site){
            \Session::flash('message', "Site does not exist!");
            \Session::flash('alert-class', 'alert-danger');
            return redirect()->back()->withInput($r->all());
        }
        
        $last_id = PermitLetter::orderBy('id_permit_letter','DESC')->first();
        if($last_id){
            $last_id = $last_id->id_permit_letter + 1;
        }else{
            $last_id = 1;
        }
        switch($last_id){
            case $last_id < 10 :
                $uid = "0000$last_id";
                break;
            case $last_id < 100 :
                $uid = "000$last_id";
                break;
            case $last_id < 1000 :
                $uid = "00$last_id";
                break;
            case $last_id < 10000 :
                $uid = "0$last_id";
                break;
            case $last_id < 100000 :
                $uid = "$last_id";
                break;
            default:
                $uid = "$last_id";
                
        }
        
        $d = new PermitLetter;
        $d->activity_no = date('ymd').$uid;;
        $d->id_site = $r->id_site;
        $d->id_region = $site->region_id;
        $d->pemohon = $r->pemohon;
        $d->instansi = $r->instansi;
        $d->departemen = $r->departemen;
        $d->atasan = $r->atasan;
        $d->nomor_telepon = $r->nomor_telepon;
        $d->tanggal_pengajuan = $r->tanggal_pengajuan;
        $d->tanggal_berlaku = $r->tanggal_berlaku;
        $d->tanggal_berlaku_sd = $r->tanggal_berlaku_sd;
        $d->jumlah_pengunjung = $r->jumlah_pengunjung;
        $d->status = "PENDING";
        $d->created_by = $user->id;
        $d->save();
        
        $nama_pengunjung = $r->nama_pengunjung;
        $id_pengunjungs = $r->file('id_pengunjung');
        foreach($id_pengunjungs as $key => $id_pengunjung){
            $detail = new PermitLetterDetail;
            $detail->id_permit_letter = $d->id_permit_letter;
            $detail->nama_pengunjung = $nama_pengunjung[$key];
            
            $image = "NO_IMAGE";
            if($id_pengunjung){
                $file = $id_pengunjung;
                $image = "PERMIT_LETTER:$key-$d->id_permit_letter" . md5(time()) . '.' .$file->getClientOriginalExtension();
                $file->move(public_path().'/permit_letter', $image);
            }
            $detail->id_pengunjung = $image;
            $detail->save();
            
        }
        
        $tokens = [$user->firebase_token, $user->firebase_token_web];
        sendPermitLetter($d, $tokens, "Permit Letter Has Been created", "");
        
        \Session::flash('message', "Created Successfully!");
        \Session::flash('alert-class', 'alert-success');
        return redirect()->to('site-permit');
    }
    public function newPermitLetterAPI(Request $r){
        $result = [];
        $result["status"] = false;
        $result["message"] = "";
        $result["newtoken"] = csrf_token();
        
        $user = Auth::user();
        if(!$user){
            $result["message"] = "CSRF FAILED PLEASE RE-LOGIN!";
            return response($result);
        }
        $site = Site::where('site_id', $r->id_site)->first();
        if(!$site){
            $result["message"] = "Site does not exist!";
            return response($result);
        }
        
        $last_id = PermitLetter::orderBy('id_permit_letter','DESC')->first();
        if($last_id){
            $last_id = $last_id->id_permit_letter + 1;
        }else{
            $last_id = 1;
        }
        switch($last_id){
            case $last_id < 10 :
                $uid = "0000$last_id";
                break;
            case $last_id < 100 :
                $uid = "000$last_id";
                break;
            case $last_id < 1000 :
                $uid = "00$last_id";
                break;
            case $last_id < 10000 :
                $uid = "0$last_id";
                break;
            case $last_id < 100000 :
                $uid = "$last_id";
                break;
            default:
                $uid = "$last_id";
                
        }
        
        $d = new PermitLetter;
        $d->activity_no = date('ymd').$uid;;
        $d->id_site = $r->id_site;
        $d->id_region = $site->region_id;
        $d->pemohon = $r->pemohon;
        $d->instansi = $r->instansi;
        $d->departemen = $r->departemen;
        $d->atasan = $r->atasan;
        $d->nomor_telepon = $r->nomor_telepon;
        $d->tanggal_pengajuan = $r->tanggal_pengajuan;
        $d->tanggal_berlaku = $r->tanggal_berlaku;
        $d->tanggal_berlaku_sd = $r->tanggal_berlaku_sd;
        $d->jumlah_pengunjung = $r->jumlah_pengunjung;
        $d->status = "PENDING";
        $d->created_by = $user->id;
        $d->save();
        
        $nama_pengunjung = $r->nama_pengunjung;
        $id_pengunjungs = $r->file('id_pengunjung');
        foreach($id_pengunjungs as $key => $id_pengunjung){
            $detail = new PermitLetterDetail;
            $detail->id_permit_letter = $d->id_permit_letter;
            $detail->nama_pengunjung = $nama_pengunjung[$key];
            
            $image = "NO_IMAGE";
            if($id_pengunjung){
                $file = $id_pengunjung;
                $image = "PERMIT_LETTER:$key-$d->id_permit_letter" . md5(time()) . '.' .$file->getClientOriginalExtension();
                $file->move(public_path().'/permit_letter', $image);
            }
            $detail->id_pengunjung = $image;
            $detail->save();
            
        }
        
        $tokens = [$user->firebase_token, $user->firebase_token_web];
        sendPermitLetter($d, $tokens, "New Permit Letter Has Been created", "");
        
        $result["status"] = true;
        $result["data"] = $d;
        $result["message"] = "Created Successfully!";
        return response($result);
    }
    public function getPermitLetter(Request $r){
        $columns = $r->columns;
        $order = $r->order;
        if($order[0]){
            $column = $order[0]['column']; 
            $orderBy = $columns[$column]['data'];
            $order_dir = $order['dir'];
        }else{
            $orderBy = 'id_permit_letter';
            $order_dir = 'ASC';
        }
        $data = PermitLetter::orderBy($orderBy, $order_dir);
        if($r->id_region) $data->where('id_region', $r->id_region);
        if($r->id_site) $data->where('id_site', $r->id_site);
        if($r->status) $data->where('status', $r->status);
        if($r->created_by) $data->where('created_by', $r->created_by);
        
        $user = Auth::user();
        if(!is_admin($user)){
            $data = $data->where('created_by', $user->id);
        }else{
            if($r->created_by) $data->where('created_by', $r->created_by);
        }
        
        $result = getDataCustom($data, $r, 'id_permit_letter', 'id_permit_letter')->original;
        foreach($result['data'] as $d){
            $d->pengunjung;
            $d->site;
            $d->pdf = main_url().'/site-permit/permit-letter-pdf?id='.$d->id_permit_letter;
        }
        return response()->json($result);
    }
    public function permitLetterApproval(Request $r, $id_permit_letter){
        $user = Auth::user();
        if(!$user){
            \Session::flash('message', "CSRF FAILED PLEASE RE-LOGIN!");
            \Session::flash('alert-class', 'alert-danger');
            return redirect()->back()->withInput($r->all());
        }
        
        $d = PermitLetter::where('id_permit_letter', $id_permit_letter)->first();
        if(!$d){
            \Session::flash('message', "Opps! something went wrong please try again!");
            \Session::flash('alert-class', 'alert-danger');
            return redirect()->back()->withInput($r->all());
        }
        
        $status = $r->approval_status;
        if($status != "APPROVED") $status = "REJECTED";
        $note = $r->note;
        
        $d->status = $status;
        $d->save();
        
        $created_by = \App\User::where('id', $d->created_by)->first();
        $tokens = [$created_by->firebase_token, $created_by->firebase_token_web];
        sendPermitLetter($d, $tokens, "Permit Letter Has Been $status", "");
        
        \Session::flash('message', "$status Successfully!");
        \Session::flash('alert-class', 'alert-success');
        return redirect()->to('site-permit');
    }
    
    public function siteEntryJsonData($data){
        $d = new SiteEntry;
        $d->ID = $data->id_site_entry;
        $d->Status = isset($data->status)?$data->status:'-';
        $d->Region = isset($data->region)?$data->region->region_name:'-';
        $d->Site = isset($data->site)?$data->site->name_site:'-';
        $d->JumlahPetugas = isset($data->jumlah_petugas)?$data->jumlah_petugas:'-';
        $d->Latitude = isset($data->latitude)?$data->latitude:'-';
        $d->Longitude = isset($data->longitude)?$data->longitude:'-';
        $d->Personil = isset($data->personil)?$data->personil:'-';
        $d->Description = isset($data->description)?$data->description:'-';
        return $d;
    }
}
