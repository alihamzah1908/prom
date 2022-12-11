<?php

namespace App\Http\Controllers\Activasi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \App\Model\AktivasiType;
use \App\Model\Aktivasi;
use \App\Model\AktivasiLog;
use \App\Model\AktivasiApprover;
use \App\Model\AktivasiApproval;
use \App\Model\AktivasiStatus;
use \App\Model\Site;
use \App\Model\Region;
use \Auth;

class ActivasiController extends Controller
{
    public function index()
    {
        return view('Activasi.index');
    }
    public function detail($id)
    {
        $data = Aktivasi::where('id', $id)->first();
        $approval = AktivasiApproval::where('id_aktivasi', $data->id)->first();
        $user = Auth::user();
        $user_id = $user->id;
        $approver_1 = isset($approval->approver_1)?$approval->approver_1:'';
        $approver_2 = isset($approval->approver_2)?$approval->approver_2:'';
        $approver_3 = isset($approval->approver_3)?$approval->approver_3:'';
        // return $approval;
        if(!$approver_1 || !$approver_2 || !$approver_3){
            $approval->delete();
            $approval = false;
        }
        if(!$approval){
            \Session::flash('message_2', "APPROVAL DATA DOES NOT EXIST OR HAS BEEN DELETED! SIMPLY UPDATE DATA TO ASSIGN NEW APPROVERS");
            \Session::flash('alert-class-2', 'alert-info');
        }
        
        $is_approver = '';
        if($approval){
            if(!$approval->approver_1_status){
                if($user_id == $approver_1) $is_approver = 1;
            }else{
                if(!$approval->approver_2_status){
                    if($user_id == $approver_2) $is_approver = 2;
                }else{
                    if(!$approval->approver_3_status){
                        if($user_id == $approver_3) $is_approver = 3;
                    }else{
                        $is_approver = false;
                    }   
                    if($approval->approver_2_status == "REJECTED") $is_approver = false;
                }
                if($approval->approver_1_status == "REJECTED") $is_approver = false;
            }
            
            if($approval->approver_1_status == "REJECTED"){
                $approval->approver_2_status = "INHERIT REJECTION BY APPROVER 1";
                $approval->approver_2_remark = "INHERIT REJECTION BY APPROVER 1";
                $approval->approver_3_status = "INHERIT REJECTION BY APPROVER 1";
                $approval->approver_3_remark = "INHERIT REJECTION BY APPROVER 1";
            }
            if($approval->approver_2_status == "REJECTED"){
                $approval->approver_3_status = "INHERIT REJECTION BY APPROVER 2";
                $approval->approver_3_remark = "INHERIT REJECTION BY APPROVER 2";
            }
        }
        
        $ports = \App\Model\Port::get();
        $slots = \App\Model\Slot::get();
        $shelfs = \App\Model\Shelf::get();
        return view('Activasi.detail',compact('data', 'approval', 'user', 'is_approver', 'shelfs', 'slots', 'ports'));
    }
    
    public function create(Request $r)
    {
        $id_type_service = $r->id_type_service;
        $type = \App\Model\AktivasiType::where('id_service', $id_type_service)->first();
        if(!$type){
            $id_type_service = 1;
        }
        return view('Activasi.create', compact('id_type_service'));
    }
    
    public function new_aktivasi(Request $r){
        
        $user = Auth::user();
        if(!$user){
            \Session::flash('message', "CSRF FAILED PLEASE RE-LOGIN!");
            \Session::flash('alert-class', 'alert-danger');
            return redirect()->back()->withInput($r->all());
        }
        $last_id = Aktivasi::orderBy('id','DESC')->first();
        if($last_id){
            $last_id = $last_id->id + 1;
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
        
        $d = new Aktivasi;
        
        if ($r->id_type_service == 1){
        $d->active_uid = "ACT - ".date('ymd').$uid;
        }
        else if ($r->id_type_service == 2){
            
           $d->active_uid = "DEA - ".date('ymd').$uid;  
        }
        else if ($r->id_type_service == 3){
            $d->active_uid = "CLO - ".date('ymd').$uid;
        }
        else {
            $d->active_uid = "BL - ".date('ymd').$uid;
        }
        
        $d->id_customer = $r->id_customer;
        $d->id_status = '1';
        $d->id_region = $r->id_region;
        $d->id_segment = $r->id_segment;
        $d->id_site = json_encode($r->id_site);
        $d->id_site_b = json_encode($r->id_site_b);
        
        $memo = "default";
        if($r->file('memo')){
            $file = $r->file('memo');
            $memo = "MEMO-$d->active_uid" . md5(time()) . '.' .$file->getClientOriginalExtension();
            $file->move(public_path().'/aktivasi/memo', $memo);
        }
        $d->memo_file = $memo;
        
        $bakti = "default";
        if($r->file('bakti')){
            $file = $r->file('bakti');
            $bakti = "BAKTI-$d->active_uid" . md5(time()) . '.' .$file->getClientOriginalExtension();
            $file->move(public_path().'/aktivasi/bakti', $bakti);
        }
        $d->bakti_file = $bakti;
        
        $d->capasity_type = $r->capasity_type;
        $d->capasity = $r->capasity;
        $d->id_cord = $r->id_cord;
        $d->id_type_service = $r->id_type_service;
        $d->active_desc = $r->active_desc;
        
        $approver = AktivasiApprover::where('id_region', $r->id_region)->first();
        if(!$approver){
            $region = Region::where('region_id', $r->id_region)->first();
            $site_name = isset($region)?$region->region_name:'this Region';
            \Session::flash('message', "Approver for $site_name does not exist!");
            \Session::flash('alert-class', 'alert-danger');
            return redirect()->back()->withInput($r->all());
        }
        
        $d->save();
        
        $log = new AktivasiLog;
        $log->id_aktivasi = $d->id;
        $log->action = "CREATE";
        $log->status_to = isset($data->status)?$data->status->name:'OPEN';
        $log->changed_data_to = $this->toJsonData($d);
        $log->created_by = $user->id;
        $log->save();
        
        $approval = new AktivasiApproval;
        $approval->id_aktivasi = $d->id;
        $approval->approver_1 = $approver->approver_1;
        $approval->approver_2 = $approver->approver_2;
        $approval->approver_3 = $approver->approver_3;
        $approval->save();
        
       
       
        if ($r->id_type_service == 1){
        \Session::flash('message', "Created Aktivasi Layanan Successfully!");
        \Session::flash('alert-class', 'alert-success');
        return redirect()->to('aktivasi-layanan');
        }
        else if ($r->id_type_service == 2){
            
            \Session::flash('message', "Created Deaktive Layanan Successfully!");
        \Session::flash('alert-class', 'alert-success');
        return redirect()->to('aktivasi-layanan'); 
        }
        else if ($r->id_type_service == 3){
            
            \Session::flash('message', "Created Collocation Successfully!");
        \Session::flash('alert-class', 'alert-success');
        return redirect()->to('aktivasi-layanan'); 
        }
        else {
             
            \Session::flash('message', "Created Blokir Sementara Successfully!");
        \Session::flash('alert-class', 'alert-success');
        return redirect()->to('aktivasi-layanan'); 
        }
        
       
    }
    
    public function update_aktivasi(Request $r, $id){
        
        $user = Auth::user();
        if(!$user){
            \Session::flash('message', "CSRF FAILED PLEASE RE-LOGIN!");
            \Session::flash('alert-class', 'alert-danger');
            return redirect()->back()->withInput($r->all());
        }
        $d = Aktivasi::where('id', $id)->first();
        if(!$d){
            \Session::flash('message', "Opps! Something went wrong please try again!");
            \Session::flash('alert-class', 'alert-danger');
            return redirect()->back()->withInput($r->all());
        }
        $d->active_uid = $d->active_uid;
        $d->id_customer = $r->id_customer;
        
        if(is_admin($user)){
            if($r->id_status){
                $d->id_status = $r->id_status;
            }
        }else{
            $d->id_status = $d->id_status;
        }
        
        $id_region = $r->id_region;
        $site = Site::where('site_id', $r->id_site)->first();
        if(!$r->id_region){
            $id_region = $site->region_id;
        }
        $d->id_region = $id_region;
        $d->id_segment = $r->id_segment;
        $d->id_site = $r->id_site;
        $d->id_site_b = $r->id_site_b ;
        
        $memo = $d->memo_file;
        if($r->file('memo')){
            $file = $r->file('memo');
            $memo = "MEMO-EDITED$d->active_uid" . md5(time()) . '.' .$file->getClientOriginalExtension();
            $file->move(public_path().'/aktivasi/memo', $memo);
        }
        $d->memo_file = $memo;
        
        $bakti = $d->bakti_file;
        if($r->file('bakti')){
            $file = $r->file('bakti');
            $bakti = "BAKTI-EDITED$d->active_uid" . md5(time()) . '.' .$file->getClientOriginalExtension();
            $file->move(public_path().'/aktivasi/bakti', $bakti);
        }
        $d->bakti_file = $bakti;
        
        $d->capasity_type = $r->capasity_type;
        $d->capasity = $r->capasity;
        $d->id_cord = $r->id_cord;
        $d->id_type_service = $d->id_type_service;
        $d->active_desc = $r->active_desc;
        
        $approver = AktivasiApprover::where('id_region', $id_region)->first();
        if(!$approver){
            $site_name = isset($region)?$region->region_name:'this Region';
            \Session::flash('message', "Approver for $site_name does not exist!");
            \Session::flash('alert-class', 'alert-danger');
            return redirect()->back()->withInput($r->all());
        }
        $d->save();
        $approval = AktivasiApproval::where('id_aktivasi', $d->id)->first();
        if(!$approval){
            $approval = new AktivasiApproval;
            $approval->id_aktivasi = $d->id;
            $approval->approver_1 = $approver->approver_1;
            $approval->approver_2 = $approver->approver_2;
            $approval->approver_3 = $approver->approver_3;
            $approval->save();
        }
        
        $log = new AktivasiLog;
        $log->id_aktivasi = $d->id;
        $log->action = "UPDATE";
        $log->status_to = isset($data->status)?$data->status->name:'OPEN';
        $log->changed_data_to = $this->toJsonData($d);
        $log->created_by = $user->id;
        $log->save();
       if ($d->id_type_service == 1){
        \Session::flash('message', "Update Aktivasi Layanan Successfully!");
        \Session::flash('alert-class', 'alert-success');
        return redirect()->to('aktivasi-layanan');
        }
        else if ($d->id_type_service == 2){
            
            \Session::flash('message', "Update Deaktive Layanan Successfully!");
        \Session::flash('alert-class', 'alert-success');
        return redirect()->to('aktivasi-layanan'); 
        }
        else if ($d->id_type_service == 3){
            
            \Session::flash('message', "Update Collocation Successfully!");
        \Session::flash('alert-class', 'alert-success');
        return redirect()->to('aktivasi-layanan'); 
        }
        else {
             
            \Session::flash('message', "Update Blokir Sementara Successfully!");
        \Session::flash('alert-class', 'alert-success');
        return redirect()->to('aktivasi-layanan'); 
        }
    }
    
    public function getData(Request $r){
        $user = Auth::user();
        
        $columns = $r->columns;
        $order = $r->order;
        if($order[0]){
            $order = $order[0];
            $column = $order['column']; 
            $column = $columns[$column];
            $orderBy = $column['data'];
            $order_dir = $order['dir'];
    
            $data = Aktivasi::orderBy($orderBy, $order_dir);
        }else{
            $orderBy = false;
            $data = Aktivasi::orderBy('id','DESC');
        }
        
        if($r->id_type_service) $data = $data->where('id_type_service', $r->id_type_service);
        if($r->id)  $data = $data->where('id', $r->id);
      //  if($r->id_customer)  $data = $data->where('id_customer', $r->id_customer);
        if($r->id_region)  $data = $data->where('id_region', $r->id_region);
        if($r->id_site) $data = $data->where('id_site', $r->id_site);
        if($r->id_segment) $data = $data->where('id_segment', $r->id_segment);
        if($r->id_status) $data = $data->where('id_status', $r->id_status);
        if($r->capasity) $data = $data->where('capasity', $r->capasity);
        
        $name = $r->name;
        if(!$name)  $name = $r->search['value'];
        
        if($name){
            $data = $data->where(function ($data) use($name) {
                            $data->where('subject', 'like', '%' . $name . '%');
                          });
            
        }
        
        $user = Auth::user();
        if(!is_admin($user)){
            $user_id = $user->id;
            $data = $data->join('tb_aktivasi_approval', 'tb_aktivasi_approval.id_aktivasi', 'tb_active_service.id');
            
            $data = $data->where(function ($data) use($user_id) {
                            $data->where('approver_1', $user_id);
                            $data->orWhere('approver_2', $user_id);
                            $data->orWhere('approver_3', $user_id);
                          });
        }
        
        $draw = $r->get('draw');
        $limit = $r->get('length');
        $offset = $r->get('start');
        $timeout = $r->get('timeout', 0);
        
        $count = $data->count();
        if($limit && $offset){
            $data = $data->offset($offset)->limit($limit);
        }
        $data = $data->get();
        
        $new_data = [];
        
        foreach($data as $d){
            $d->type;
            $d->customer;
            $d->site;
            $d->region;
            $d->location;
            if($d->id_type_service == 3){
                $status = $d->status_collocation;
            }else{
                $status = $d->status;
            }
            if(!$status){
                $status = new \stdClass();
                $status->name = "<b class='text-danger'>DELETED STATUS</b>";
            }
            $d->status_name = $status->name;
            
            if(is_admin($user)){
                $new_data[] = $d;
            }else{
                if($user_id == $d->approver_1){
                    if($d->approver_1_status != "CONFIRMED") $new_data[] = $d;
                }elseif($user_id == $d->approver_2){
                    if($d->approver_1_status == "CONFIRMED"){
                        if(!$d->approver_2_status) $new_data[] = $d;
                    }
                }elseif($user_id == $d->approver_3){
                    if($d->approver_2_status == "PROPOSED"){
                        if(!$d->approver_3_status) $new_data[] = $d;
                    }
                }else{
                    
                }
                
            }
        }
        $data = $new_data;
        
        $count_searched = count($data);
        $result = [];
        $result["data"] = $data;
        $result["draw"] = $draw;
        $result["recordsTotal"] = $count;
        $result["recordsFiltered"] = $count_searched;
        $result["limit"] = $limit;
        $result["offset"] = $offset;
        if($orderBy){
            $result['orderBy'] = $orderBy;
            $result['order_dir'] = $order_dir;   
        }
        return response()->json($result);
    }
    
    public function getStatus(Request $r){
        $user = Auth::user();
        
        
        if($r->type == 3){
            $data = \App\Model\AktivasiStatusCollocation::orderBy('id','DESC');
        }else{
            $data = \App\Model\AktivasiStatus::orderBy('id','DESC');
        }
        
        
        $name = $r->name;
        if(!$name)  $name = $r->search['value'];
        
        if($name){
            $data = $data->where(function ($data) use($name) {
                            $data->where('name', 'like', '%' . $name . '%');
                          });
            
        }
        
        $draw = $r->get('draw');
        $limit = $r->get('length');
        $offset = $r->get('start');
        $timeout = $r->get('timeout', 0);
        
        $count = $data->count();
        if($limit && $offset){
            $data = $data->offset($offset)->limit($limit);
        }
        $data = $data->get();
        
        foreach($data as $d){
        }
        
        $count_searched = count($data);
        $result = [];
        $result["data"] = $data;
        $result["draw"] = $draw;
        $result["recordsTotal"] = $count;
        $result["recordsFiltered"] = $count_searched;
        $result["limit"] = $limit;
        $result["offset"] = $offset;
        return response()->json($result);
    }
    
    public function approval(Request $r, $id){
        $user = Auth::user();
        if(!$user){
            \Session::flash('message', "CSRF FAILED PLEASE RE-LOGIN!");
            \Session::flash('alert-class', 'alert-danger');
            return redirect()->back();
        }
        $d = Aktivasi::where('id', $id)->first();
        if(!$d){
            \Session::flash('message', "Opps! Something went wrong please try again!");
            \Session::flash('alert-class', 'alert-danger');
            return redirect()->back();
        }
        $approval = AktivasiApproval::where('id_aktivasi', $d->id)->first();
        if(!$approval){
            \Session::flash('message', "APPROVAL DATA DOES NOT EXIST OR HAS BEEN DELETED! SIMPLY UPDATE DATA TO ASSIGN NEW APPROVERS");
            \Session::flash('alert-class', 'alert-info');
            return redirect()->back();
        }
        $data = $approval->aktivasi;
        if(!$data){
            \Session::flash('message', "AKTIVASI DATA DOES NOT EXIST OR HAS BEEN DELETED!");
            \Session::flash('alert-class', 'alert-info');
            return redirect()->back();
        }
            
        $approver_1 = isset($approval->approver_1)?$approval->approver_1:new AktivasiApproval;
        $approver_2 = isset($approval->approver_2)?$approval->approver_2:new AktivasiApproval;
        $approver_3 = isset($approval->approver_3)?$approval->approver_3:new AktivasiApproval;
        $user_id = $user->id;
        $is_approver = false;
        if($approval){
            if(!$approval->approver_1_status){
                if($user_id == $approver_1) $is_approver = 1;
            }else{
                if(!$approval->approver_2_status){
                    if($user_id == $approver_2) $is_approver = 2;
                }else{
                    if(!$approval->approver_3_status){
                        if($user_id == $approver_3) $is_approver = 3;
                    }else{
                        $is_approver = false;
                    }   
                }
                
            }
        }
        
        if(!$is_approver){
            \Session::flash('message', "Only assigned approver can perform Aktivasi Approval!");
            \Session::flash('alert-class', 'alert-info');
            return redirect()->back();
        }
        
        $status = $r->approval_status;
        if($is_approver == 1){
            if($approval->approver_1_status){
                \Session::flash('message', "You've already post your remark on this Aktivasi!");
                \Session::flash('alert-class', 'alert-info');
                return redirect()->back();
            }
            if($data->id_type_service == 3){
                if($status == "APPROVED"){
                    $status = "BEING REVIEWED";
                }else{
                    $status = "REJECTED";
                }
            }else{
                if($status == "APPROVED"){
                    $status = "CONFIRMED";  
                }else{
                    $status = "REJECTED";
                }
            }
            $approval->approver_1_status = $status;
            $approval->approver_1_remark = $r->note;
            $approval->save();
        }elseif($is_approver == 2){
            if(!$approval->approver_1_status){
                \Session::flash('message', "Approver I haven`t post any remark on this Aktivasi yet!");
                \Session::flash('alert-class', 'alert-info');
                return redirect()->back();
            }
            if($approval->approver_1_status == "REJECTED"){
                \Session::flash('message', "Approver I has already REJECTED this Aktivasi!");
                \Session::flash('alert-class', 'alert-info');
                return redirect()->back();
            }
            if($approval->approver_2_status){
                \Session::flash('message', "You've already post your Approval on this Aktivasi!");
                \Session::flash('alert-class', 'alert-info');
                return redirect()->back();
            }
            
            if($data->id_type_service == 3){
                if($status == "APPROVED"){
                    $status = "COMPLETE";  
                }else{
                    $status = "REJECTED";
                }
                $document = 'default';
                if($r->file('document')){
                    $file = $r->file('document');
                    $document = "DOCUMENT-$data->active_uid" . md5(time()) . '.' .$file->getClientOriginalExtension();
                    $file->move(public_path().'/aktivasi/document', $document);
                }
                
                $approval->approver_2_status = $status;
                $approval->approver_2_remark = $r->note;
                $approval->approver_2_document = $document;
                $approval->save();
            }else{
                if($status == "APPROVED"){
                    $status = "PROPOSED";  
                }else{
                    $status = "REJECTED";
                }
                $document = 'default';
                if($r->file('document')){
                    $file = $r->file('document');
                    $document = "DOCUMENT-$data->active_uid" . md5(time()) . '.' .$file->getClientOriginalExtension();
                    $file->move(public_path().'/aktivasi/document', $document);
                }
                
                $approval->approver_2_status = $status;
                $approval->approver_2_cid = $r->id_cid;
                $approval->approver_2_ne = json_encode($r->segment);
                $approval->approver_2_document = $document;
                $approval->save();
                $data->id_cid = $r->id_cid;
                $data->save();
            }
        }elseif($is_approver == 3){
            if(!$approval->approver_1_status){
                \Session::flash('message', "Approver I haven`t post any remark on this Aktivasi yet!");
                \Session::flash('alert-class', 'alert-info');
                return redirect()->back();
            }
            if($approval->approver_1_status == "REJECTED"){
                \Session::flash('message', "Approver I has already REJECTED this Aktivasi!");
                \Session::flash('alert-class', 'alert-info');
                return redirect()->back();
            }
            if(!$approval->approver_2_status){
                \Session::flash('message', "Approver II haven`t post any remark on this Aktivasi yet!");
                \Session::flash('alert-class', 'alert-info');
                return redirect()->back();
            }
            if($approval->approver_2_status == "REJECTED"){
                \Session::flash('message', "Approver II has already REJECTED this Aktivasi!");
                \Session::flash('alert-class', 'alert-info');
                return redirect()->back();
            }
            if($approval->approver_3_status){
                \Session::flash('message', "You've already post your Approval on this Aktivasi!");
                \Session::flash('alert-class', 'alert-info');
                return redirect()->back();
            }
            if($data->id_type_service == 3){
                $document = 'default';
                if($r->file('approver_3_document')){
                    $file = $r->file('approver_3_document');
                    $document = "DOCUMENT-$data->active_uid" . md5(time()) . '.' .$file->getClientOriginalExtension();
                    $file->move(public_path().'/aktivasi/document', $document);
                }
                
                $approval->approver_3_status = $status;
                $approval->approver_3_document = $document;
                
                $approval->approver_3_remark = $r->note;
                $approval->save();
                $data->id_status = $r->id_status;
                $data->save();
            }else{
                $document = 'default';
                if($r->file('approver_3_document')){
                    $file = $r->file('approver_3_document');
                    $document = "DOCUMENT-$data->active_uid" . md5(time()) . '.' .$file->getClientOriginalExtension();
                    $file->move(public_path().'/aktivasi/document', $document);
                }
                
                $approval->approver_3_status = $status;
                $approval->approver_3_document = $document;
                $approval->save();
                $data->id_status = $r->id_status;
                $data->save();
            }
        }
        
        $log = new AktivasiLog;
        $log->id_aktivasi = $d->id;
        $log->action = "UPDATE";
        $log->status_to = $status;
        $log->changed_data_to = $this->toJsonData($d);
        $log->created_by = $user->id;
        $log->save();
        
        if ($d->id_type_service == 1){
        \Session::flash('message', "Approve Aktivasi Layanan Successfully!");
        \Session::flash('alert-class', 'alert-success');
        return redirect()->to('aktivasi-layanan');
        }
        else if ($d->id_type_service == 2){
            
            \Session::flash('message', "Approve Deaktive Layanan Successfully!");
        \Session::flash('alert-class', 'alert-success');
        return redirect()->to('aktivasi-layanan'); 
        }
        else if ($d->id_type_service == 3){
            
            \Session::flash('message', "Approve Collocation Successfully!");
        \Session::flash('alert-class', 'alert-success');
        return redirect()->to('aktivasi-layanan'); 
        }
        else {
             
            \Session::flash('message', "Approve Blokir Sementara Successfully!");
        \Session::flash('alert-class', 'alert-success');
        return redirect()->to('aktivasi-layanan'); 
        }
    }
    public function approval_api(Request $r, $id){
        $result = [];
        $result["status"] = false;
        $result["message"] = "";
        $result["newtoken"] = csrf_token();
        
        $user = Auth::user();
        if(!$user){
            $result["message"] = "CSRF FAILED PLEASE RE-LOGIN!";
            return response($result);
        }
        $d = Aktivasi::where('id', $id)->first();
        if(!$d){
            $result["message"] = "Opps! Something went wrong please try again!";
            return response($result);
        }
        $approval = AktivasiApproval::where('id_aktivasi', $d->id)->first();
        if(!$approval){
            $result["message"] = "APPROVAL DATA DOES NOT EXIST OR HAS BEEN DELETED!";
            return response($result);
        }
        $data = $approval->aktivasi;
        if(!$data){
            $result["message"] = "AKTIVASI DATA DOES NOT EXIST OR HAS BEEN DELETED!";
            return response($result);
        }
            
        $approver_1 = isset($approval->approver_1)?$approval->approver_1:new AktivasiApproval;
        $approver_2 = isset($approval->approver_2)?$approval->approver_2:new AktivasiApproval;
        $approver_3 = isset($approval->approver_3)?$approval->approver_3:new AktivasiApproval;
        $user_id = $user->id;
        
        $is_approver = false;
        if($approval){
            if(!$approval->approver_1_status){
                if($user_id == $approver_1) $is_approver = 1;
            }else{
                if(!$approval->approver_2_status){
                    if($user_id == $approver_2) $is_approver = 2;
                }else{
                    if(!$approval->approver_3_status){
                        if($user_id == $approver_3) $is_approver = 3;
                    }else{
                        $is_approver = false;
                    }   
                }
                
            }
        }
        
        if(!$is_approver){
            $result["message"] = "Only assigned approver can perform Aktivasi Approval!";
            return response($result);
        }
        
        if($r->file('document')){
            $kb = $r->file('document')->getSize() / 1024;
            $mb = $kb / 1024;
            $mb = round($mb);
            if($mb > 5){
                $result["message"] = "Can't upload image bigger than 5mb!";
                return response($result);
            }
        }
        $status = $r->approval_status;
        if($is_approver == 1){
            if($approval->approver_1_status){
                $result["message"] = "You've already post your remark on this Aktivasi!";
                return response($result);
            }
            if($data->id_type_service == 3){
                if($status == "APPROVED"){
                    $status = "BEING REVIEWED";
                }else{
                    $status = "REJECTED";
                }
            }else{
                if($status == "APPROVED"){
                    $status = "CONFIRMED";  
                }else{
                    $status = "REJECTED";
                }
            }
            $approval->approver_1_status = $status;
            $approval->approver_1_remark = $r->note;
            $approval->save();
        }elseif($is_approver == 2){
            if(!$approval->approver_1_status){
                $result["message"] = "Approver I haven`t post any remark on this Aktivasi yet!";
                return response($result);
            }
            if($approval->approver_1_status == "REJECTED"){
                $result["message"] = "Approver I has already REJECTED this Aktivasi!";
                return response($result);
            }
            if($approval->approver_2_status){
                $result["message"] = "You've already post your Approval on this Aktivasi!";
                return response($result);
            }
            
            if($data->id_type_service == 3){
                if($status == "APPROVED"){
                    $status = "COMPLETE";  
                }else{
                    $status = "REJECTED";
                }
                $document = 'default';
                if($r->file('document')){
                    $file = $r->file('document');
                    $document = "DOCUMENT-$data->active_uid" . md5(time()) . '.' .$file->getClientOriginalExtension();
                    $file->move(public_path().'/aktivasi/document', $document);
                }
                
                $approval->approver_2_status = $status;
                $approval->approver_2_remark = $r->note;
                $approval->approver_2_document = $document;
                $approval->save();
            }else{
                if($status == "APPROVED"){
                    $status = "PROPOSED";  
                }else{
                    $status = "REJECTED";
                }
                $document = 'default';
                if($r->file('document')){
                    $file = $r->file('document');
                    $document = "DOCUMENT-$data->active_uid" . md5(time()) . '.' .$file->getClientOriginalExtension();
                    $file->move(public_path().'/aktivasi/document', $document);
                }
                
                $approval->approver_2_status = $status;
                $approval->approver_2_cid = $r->id_cid;
                $approval->approver_2_ne = json_encode($r->segment);
                $approval->approver_2_document = $document;
                $approval->save();
                $data->id_cid = $r->id_cid;
                $data->save();
            }
        }elseif($is_approver == 3){
            if(!$approval->approver_1_status){
                $result["message"] = "Approver I haven`t post any remark on this Aktivasi yet!";
                return response($result);
            }
            if($approval->approver_1_status == "REJECTED"){
                $result["message"] = "Approver I has already REJECTED this Aktivasi!";
                return response($result);
            }
            if(!$approval->approver_2_status){
                $result["message"] = "Approver II haven`t post any remark on this Aktivasi yet!";
                return response($result);
            }
            if($approval->approver_2_status == "REJECTED"){
                $result["message"] = "Approver II has already REJECTED this Aktivasi!";
                return response($result);
            }
            if($approval->approver_3_status){
                $result["message"] = "You've already post your Approval on this Aktivasi!";
                return response($result);
            }
            if($data->id_type_service == 3){
                $document = 'default';
                if($r->file('approver_3_document')){
                    $file = $r->file('approver_3_document');
                    $document = "DOCUMENT-$data->active_uid" . md5(time()) . '.' .$file->getClientOriginalExtension();
                    $file->move(public_path().'/aktivasi/document', $document);
                }
                
                $approval->approver_3_status = $status;
                $approval->approver_3_document = $document;
                
                $approval->approver_3_remark = $r->note;
                $approval->save();
                $data->id_status = $r->id_status;
                $data->save();
            }else{
                $document = 'default';
                if($r->file('approver_3_document')){
                    
                    $file = $r->file('approver_3_document');
                    $document = "DOCUMENT-$data->active_uid" . md5(time()) . '.' .$file->getClientOriginalExtension();
                    $file->move(public_path().'/aktivasi/document', $document);
                }
                
                $approval->approver_3_status = $status;
                $approval->approver_3_document = $document;
                $approval->save();
                $data->id_status = $r->id_status;
                $data->save();
            }
        }
        
        $log = new AktivasiLog;
        $log->id_aktivasi = $d->id;
        $log->action = "UPDATE";
        $log->status_to = $status;
        $log->changed_data_to = $this->toJsonData($d);
        $log->created_by = $user->id;
        $log->save();
        
        $result["status"] = true;
        $result["message"] = "Aktivasi $status Successfully!";
        $result["data"] = $data;
        return response($result);
    }
    
    public function toJsonData($data){
        $d = new Aktivasi;
        $d->UID = $data->active_uid;
        $d->Type = isset($data->type)?$data->type->service_name:'-';
        $d->Customer = isset($data->customer)?$data->customer->name_customer:'-';
        $d->Region = isset($data->region)?$data->region->region_name:'-';
        $d->Segment = isset($data->segment)?$data->segment->segment_name:'-';
        $d->Site = isset($data->site)?$data->site->name_site:'-';
        $d->Status = isset($data->status)?$data->status->name:'-';
        $d->Capasity = isset($data->capasity)?$data->capasity:'-';
        $d->Active_Desc = isset($data->active_desc)?$data->active_desc:'-';
        $d->Memo = isset($data->memo_file)?$data->memo_file:'-';
        $d->Bakti = isset($data->bakti_file)?$data->bakti_file:'-';
        return $d;
    }
}
