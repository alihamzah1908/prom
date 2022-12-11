<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \App\Model\Task;
use \App\Model\TaskDetail;
use \App\Model\TaskLog;
use \App\Model\TaskApproval;
use \App\Model\TaskLink;
use \App\Model\TaskImages;
use \App\Model\Status;
use \App\Model\Approver;
use \App\Model\ApproverDetail;
use \App\Model\Technician;
use \App\Model\Region;
use \App\Model\Site;
use \App\Model\GroupCustomer;
use \App\Model\Aktivasi;
use \App\Model\AktivasiApproval;
use \App\Model\SiteEntry;
use \App\Model\PermitLetter;
use \Auth;
use \Mail;
use \App\Templates;
use \App\TemplatesDefaultValue;
use DateTime;

class ReportController extends Controller
{
    
    public function task(){
        $data['title'] = 'Task';
        $types = \App\Model\TaskType::get();
        $report_columns = \App\Model\ReportColumn::where('id', request()->id)->where('type', 'TASK')->first();
        
        $encode_columns = "[]";
        $columns = [];
        if($report_columns){
            $encode_columns = $report_columns->columns;
            $columns = json_decode($report_columns->columns);
            if(!is_array($columns)) $columns = [$columns];
        }
        
        $table_columns = [];
        foreach($columns as $k => $v){
            $table_columns[] = ["data"=>$v];
        }
        $table_columns = json_encode($table_columns);
        
        return view('report.task', compact('types','columns', 'encode_columns', 'table_columns', 'report_columns'));
    }
    public function task_edit($id){
        $report_columns = \App\Model\ReportColumn::where('id', $id)->where('type', 'TASK')->first();
        
        $encode_columns = "[]";
        $columns = [];
        if($report_columns){
            $encode_columns = $report_columns->columns;
            $columns = json_decode($report_columns->columns);
            if(!is_array($columns)) $columns = [$columns];
        }
        
        $table_columns = [];
        foreach($columns as $k => $v){
            $table_columns[] = ["data"=>$v];
        }
        $table_columns = json_encode($table_columns);
        
        return view('report.task_edit', compact('columns', 'encode_columns', 'table_columns', 'report_columns'));
    }
    public function task_delete($id){
        $user = Auth::user();
        if(!$user){
            \Session::flash('message', "CSRF FAILED PLEASE RE-LOGIN!");
            \Session::flash('alert-class', 'alert-danger');
            return redirect()->back();
        }
        
        $report_columns = \App\Model\ReportColumn::where('id', $id)->where('type', 'TASK')->first();
        if(!$report_columns){
            \Session::flash('message', "Oops! Something went wrong please try again");
            \Session::flash('alert-class', 'alert-danger');
            return redirect()->back();
        }
        
        $report_columns->delete();
        \Session::flash('message', "Deleted Successfully!");
        \Session::flash('alert-class', 'alert-success');
        return redirect()->to('/report/task');
    }
    public function task_columns(Request $r){
        $result = [];
        $result["status"] = false;
        $result["message"] = "";
        $result["newtoken"] = csrf_token();
        
        $user = Auth::user();
        if(!$user){
            $result["message"] = "CSRF FAILED PLEASE RE-LOGIN!";
            return response($result);
        }
        
        $d = \App\Model\ReportColumn::where('id', $r->id)->where('type', 'TASK')->first();
        if(!$d){
            $d = new \App\Model\ReportColumn;
            $d->type = "TASK";
        }
        $d->name = $r->name;
        $d->description = $r->description;
        $d->columns = json_encode($r->fields);
        $d->save();
        
        $result["status"] = true;
        $result["message"] = "Updated Successfully";
        $result["data"] = $d;
        return response($result);
    }
    public function task_pdf(Request $r){
        $report_columns = \App\Model\ReportColumn::where('id', request()->id)->where('type', 'TASK')->first();
    
        $columns = [];
        if($report_columns){
            $columns = json_decode($report_columns->columns);
            if(!is_array($columns)) $columns = [$columns];
        }
        
        if(count($columns) > 8){
            $pdf = \PDF::loadView('report.pdf_task')->setPaper('LEGAL', 'landscape');;
        }else{
            $pdf = \PDF::loadView('report.pdf_task');
        }
        return $pdf->stream();
    }
    public function getReport(Request $r, $type = "TASK"){
        $columns = $r->columns;
        $order = $r->order;
        if($order[0]){ 
            $column = $order[0]['column']; 
            $orderBy = $columns[$column]['data'];
            $order_dir = $order['dir'];
        }else{
            $orderBy = 'id';
            $order_dir = 'ASC';
        }
        
        $data = \App\Model\ReportColumn::where('type', $type)->orderBy($orderBy, $order_dir);
        $created_at_from = $r->created_at_from; $created_at_to = $r->created_at_to; $select_date_range = $r->select_date_range;
        
        if($select_date_range){
            $select_date_range = explode(' - ', $select_date_range);
            $created_at_from = date('Y-m-d', strtotime($select_date_range[0]));
            $created_at_to = date('Y-m-d', strtotime($select_date_range[1]));
        }
        
        if($created_at_from && $created_at_to) $data = $data->whereBetween('created_at', ["$created_at_from 00:00:00", "$created_at_to 23:59:59"]);
        
        $result = getDataCustom($data, $r, 'id', 'name')->original;
        foreach($result['data'] as $d){
        }
        
        $result['select_date_range'] = $select_date_range;
        
        return response()->json($result);
    }
    
    public function aktivasi(){
        $types = \App\Model\AktivasiType::get();
        $report_columns = \App\Model\ReportColumn::where('id', request()->id)->where('type', 'AKTIVASI')->first();
        
        $encode_columns = "[]";
        $columns = [];
        if($report_columns){
            $encode_columns = $report_columns->columns;
            $columns = json_decode($report_columns->columns);
            if(!is_array($columns)) $columns = [$columns];
        }
        
        $table_columns = [];
        foreach($columns as $k => $v){
            $table_columns[] = ["data"=>$v];
        }
        $table_columns = json_encode($table_columns);
        
        return view('report.aktivasi', compact('types','columns', 'encode_columns', 'table_columns', 'report_columns'));
    }
    public function aktivasi_edit($id){
        $report_columns = \App\Model\ReportColumn::where('id', $id)->where('type', 'AKTIVASI')->first();
        
        $encode_columns = "[]";
        $columns = [];
        if($report_columns){
            $encode_columns = $report_columns->columns;
            $columns = json_decode($report_columns->columns);
            if(!is_array($columns)) $columns = [$columns];
        }
        
        $table_columns = [];
        foreach($columns as $k => $v){
            $table_columns[] = ["data"=>$v];
        }
        $table_columns = json_encode($table_columns);
        
        return view('report.aktivasi_edit', compact('columns', 'encode_columns', 'table_columns', 'report_columns'));
    }
    public function aktivasi_delete($id){
        $user = Auth::user();
        if(!$user){
            \Session::flash('message', "CSRF FAILED PLEASE RE-LOGIN!");
            \Session::flash('alert-class', 'alert-danger');
            return redirect()->back();
        }
        
        $report_columns = \App\Model\ReportColumn::where('id', $id)->where('type', 'AKTIVASI')->first();
        if(!$report_columns){
            \Session::flash('message', "Oops! Something went wrong please try again");
            \Session::flash('alert-class', 'alert-danger');
            return redirect()->back();
        }
        
        $report_columns->delete();
        \Session::flash('message', "Deleted Successfully!");
        \Session::flash('alert-class', 'alert-success');
        return redirect()->to('/report/aktivasi');
    }
    public function aktivasi_columns(Request $r){
        $result = [];
        $result["status"] = false;
        $result["message"] = "";
        $result["newtoken"] = csrf_token();
        
        $user = Auth::user();
        if(!$user){
            $result["message"] = "CSRF FAILED PLEASE RE-LOGIN!";
            return response($result);
        }
        
        $d = \App\Model\ReportColumn::where('id', $r->id)->where('type', 'AKTIVASI')->first();
        if(!$d){
            $d = new \App\Model\ReportColumn;
            $d->type = "AKTIVASI";
        }
        $d->name = $r->name;
        $d->description = $r->description;
        $d->columns = json_encode($r->fields);
        $d->save();
        
        $result["status"] = true;
        $result["message"] = "Updated Successfully";
        $result["data"] = $d;
        return response($result);
    }
    public function aktivasi_pdf(Request $r){
        $report_columns = \App\Model\ReportColumn::where('id', request()->id)->where('type', 'AKTIVASI')->first();
    
        $columns = [];
        if($report_columns){
            $columns = json_decode($report_columns->columns);
            if(!is_array($columns)) $columns = [$columns];
        }
        
        if(count($columns) > 8){
            $pdf = \PDF::loadView('report.pdf_aktivasi')->setPaper('LEGAL', 'landscape');;
        }else{
            $pdf = \PDF::loadView('report.pdf_aktivasi');
        }
        return $pdf->stream();
    }
    public function get_aktivasi_layanan(Request $r){
        $user = Auth::user();
        
        $columns = $r->columns;
        $order = $r->order;
        $orderBy = 'id';
        $order_dir = "DESC";
        if($order[0]){
            $order = $order[0];
            $column = $order['column']; 
            $column = $columns[$column];
            $orderBy = $column['data'];
            $order_dir = $order['dir'];
        }
        
        $data = Aktivasi::orderBy($orderBy, $order_dir);
        
        if($r->aktivasi_type) $data = $data->where('id_type_service', $r->aktivasi_type);
        // if($r->id)  $data = $data->where('id', $r->id);
        if($r->id_customer)  $data = $data->where('id_customer', $r->id_customer);
        if($r->region)  $data = $data->where('id_region', $r->region);
        if($r->id_location) $data = $data->where('id_segment', $r->id_location);
        if($r->id_site) $data = $data->where('id_site', $r->id_site);
        if($r->id_status) $data = $data->where('id_status', $r->id_status);
        if($r->capasity_type) $data = $data->where('capasity_type', $r->capasity_type);
        if($r->capasity) $data = $data->where('capasity', $r->capasity);
        if($r->id_cord) $data = $data->where('id_cord', $r->id_cord);
        
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
                            $data->where('approver_1', 'like', '%' . $user_id . '%');
                            $data->orWhere('approver_2', 'like', '%' . $user_id . '%');
                            $data->orWhere('approver_3', 'like', '%' . $user_id . '%');
                          });
        }
        
        $created_at_from = $r->created_at_from; $created_at_to = $r->created_at_to;
        if($created_at_from && $created_at_to) $data = $data->whereBetween('created_at', ["$created_at_from 00:00:00", "$created_at_to 23:59:59"]);
        
        $draw = $r->get('draw');
        $limit = $r->get('length');
        $offset = $r->get('start');
        $timeout = $r->get('timeout', 0);
        
        $count = $data->count();
        if($limit && $offset) $data = $data->offset($offset)->limit($limit);
        
        $data = $data->get();
        
        $datas = [];
        foreach($data as $d){
            $data = [];
            $data['type_service'] = isset($d->type)?$d->type->service_name:'';
            $data['active_uid'] = isset($d->active_uid)?$d->active_uid:'';
            $data['customer_name'] = isset($d->customer)?$d->customer->name_customer:'';
            $data['region_name'] = isset($d->region)?$d->region->region_name:'';
            $data['location_name'] = isset($d->location)?$d->location->segment_name:'';
            
            // site bisa bnyak ganti ntar
            $sites = "";
            $id_site = json_decode($d->id_site);
            if(!is_array($id_site)) $id_site = [$id_site];
            foreach($id_site as $k=>$v){
                $s = Site::where('site_id', $v)->first();
                $sites .= "$s->name_site, ";
            }
            $data['site_name'] = $sites;
            if($d->id_type_service == 3){
                $status = $d->status_collocation;
            }else{
                $status = $d->status;
            }
            if(!$status){
                $status = new \stdClass();
                $status->name = "<b class='text-danger'>DELETED STATUS</b>";
            }
            $data['status'] = $status->name;
            
            $data['capasity_type'] = $d->capasity_type;
            
            if($d->capasity_type == "Sewa Dark Fiber"){
                $capasity_cord = isset($d->cord)?$d->cord->name_cord:'';
            }else{
                $capasity_cord = $d->capasity;
            }
            $data['capasity_cord'] = $capasity_cord;
            $data['active_desc'] = $d->active_desc;
            $data['memo_file_link'] = main_url().'/aktivasi/memo/'.$d->memo_file;
            $data['bakti_file_link'] = main_url().'/aktivasi/bakti/'.$d->bakti_file;
            
            $approval = AktivasiApproval::where('id_aktivasi', $d->id)->first();
            $data['approver_1_name'] = isset($approval->approver1)?$approval->approver1->name:'';
            $data['approver_1_status'] = isset($approval)?$approval->approver_1_status:'';
            $data['approver_1_remark'] = isset($approval)?$approval->approver_1_remark:'';
            
            $data['approver_2_name'] = isset($approval->approver2)?$approval->approver2->name:'';
            $data['approver_2_status'] = isset($approval)?$approval->approver_2_status:'';
            $data['approver_2_remark'] = isset($approval)?$approval->approver_2_remark:'';
            $data['approver_2_cid_name'] = isset($approval->cid)?$approval->cid->cid_name:'';
            
            $approver_2_ne = json_decode($approval->approver_2_ne);
            if(!is_array($approver_2_ne)) $approver_2_ne = [$approver_2_ne];
            
            $approver_2_ne_list = "<ul>";
            foreach($approver_2_ne as $k => $v){
                $ne_name_1 = isset($v->ne_name_1)?$v->ne_name_1:'';
                $id_shelf_1 = isset($v->id_shelf_1)?$v->id_shelf_1:'';
                $id_slot_1 = isset($v->id_slot_1)?$v->id_slot_1:'';
                $id_port_1 = isset($v->id_port_1)?$v->id_port_1:'';
                $ne_name_2 = isset($v->ne_name_2)?$v->ne_name_2:'';
                $id_shelf_2 = isset($v->id_shelf_2)?$v->id_shelf_2:'';
                $id_slot_2 = isset($v->id_slot_2)?$v->id_slot_2:'';
                $id_port_2 = isset($v->id_port_2)?$v->id_port_2:'';
                
                
                $approver_2_ne_list .= "<li>";
                $approver_2_ne_list .= "<ul>";
                $approver_2_ne_list .= "<li>";
                $approver_2_ne_list .= "NE Name : $ne_name_1";
                $approver_2_ne_list .= "Shelf : $id_shelf_1";
                $approver_2_ne_list .= "Slot : $id_slot_1";
                $approver_2_ne_list .= "Port : $id_port_1";
                $approver_2_ne_list .= "</li>";
                $approver_2_ne_list .= "<li>";
                $approver_2_ne_list .= "NE Name : $ne_name_2";
                $approver_2_ne_list .= "Shelf : $id_shelf_2";
                $approver_2_ne_list .= "Slot : $id_slot_2";
                $approver_2_ne_list .= "Port : $id_port_2";
                $approver_2_ne_list .= "</li>";
                $approver_2_ne_list .= "</ul>";
                $approver_2_ne_list .= "</li>";
            }
            $approver_2_ne_list .= "</ul>";
            $data['approver_2_ne_list'] = $approver_2_ne_list;
            $data['approver_2_document'] = main_url().'/aktivasi/document/'.$approval->approver_2_document;
            
            $data['approver_3_name'] = isset($approval->approver3)?$approval->approver3->name:'';
            $data['approver_3_status'] = isset($approval)?$approval->approver_3_status:'';
            $data['approver_3_remark'] = isset($approval)?$approval->approver_3_remark:'';
            $data['approver_3_document'] = main_url().'/aktivasi/document/'.$approval->approver_3_document;
            $data['created_at'] = date('Y-m-d H:i:s', strtotime($d->created_at));
            
            $datas[] = $data;
        }
        
        $count_searched = count($datas);
        $result = [];
        $result["data"] = $datas;
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
    
    public function site_entry(){
        $types = \App\Model\AktivasiType::get();
        $report_columns = \App\Model\ReportColumn::where('id', request()->id)->where('type', 'SITE_ENTRY')->first();
        
        $encode_columns = "[]";
        $columns = [];
        if($report_columns){
            $encode_columns = $report_columns->columns;
            $columns = json_decode($report_columns->columns);
            if(!is_array($columns)) $columns = [$columns];
        }
        
        $table_columns = [];
        foreach($columns as $k => $v){
            $table_columns[] = ["data"=>$v];
        }
        $table_columns = json_encode($table_columns);
        
        return view('report.site_entry', compact('types','columns', 'encode_columns', 'table_columns', 'report_columns'));
    }
    public function site_entry_edit($id){
        $report_columns = \App\Model\ReportColumn::where('id', $id)->where('type', 'SITE_ENTRY')->first();
        
        $encode_columns = "[]";
        $columns = [];
        if($report_columns){
            $encode_columns = $report_columns->columns;
            $columns = json_decode($report_columns->columns);
            if(!is_array($columns)) $columns = [$columns];
        }
        
        $table_columns = [];
        foreach($columns as $k => $v){
            $table_columns[] = ["data"=>$v];
        }
        $table_columns = json_encode($table_columns);
        
        return view('report.site_entry_edit', compact('columns', 'encode_columns', 'table_columns', 'report_columns'));
    }
    public function site_entry_delete($id){
        $user = Auth::user();
        if(!$user){
            \Session::flash('message', "CSRF FAILED PLEASE RE-LOGIN!");
            \Session::flash('alert-class', 'alert-danger');
            return redirect()->back();
        }
        
        $report_columns = \App\Model\ReportColumn::where('id', $id)->where('type', 'SITE_ENTRY')->first();
        if(!$report_columns){
            \Session::flash('message', "Oops! Something went wrong please try again");
            \Session::flash('alert-class', 'alert-danger');
            return redirect()->back();
        }
        
        $report_columns->delete();
        \Session::flash('message', "Deleted Successfully!");
        \Session::flash('alert-class', 'alert-success');
        return redirect()->to('/report/site_entry');
    }
    public function site_entry_columns(Request $r){
        $result = [];
        $result["status"] = false;
        $result["message"] = "";
        $result["newtoken"] = csrf_token();
        
        $user = Auth::user();
        if(!$user){
            $result["message"] = "CSRF FAILED PLEASE RE-LOGIN!";
            return response($result);
        }
        
        $d = \App\Model\ReportColumn::where('id', $r->id)->where('type', 'SITE_ENTRY')->first();
        if(!$d){
            $d = new \App\Model\ReportColumn;
            $d->type = "SITE_ENTRY";
        }
        $d->name = $r->name;
        $d->description = $r->description;
        $d->columns = json_encode($r->fields);
        $d->save();
        
        $result["status"] = true;
        $result["message"] = "Updated Successfully";
        $result["data"] = $d;
        return response($result);
    }
    public function get_site_entry(Request $r){
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
        
        if($r->status) $data->where('status', $r->status);
        if($r->id_region) $data->where('id_region', $r->id_region);
        if($r->id_site) $data->where('id_site', $r->id_site);
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
        
        $created_at_from = $r->created_at_from; $created_at_to = $r->created_at_to;
        if($created_at_from && $created_at_to) $data = $data->whereBetween('created_at', ["$created_at_from 00:00:00", "$created_at_to 23:59:59"]);
        
        $result = getDataCustom($data, $r, 'id_site_entry', 'id_site_entry')->original;
        foreach($result['data'] as $d){
            $d->site_name = isset($d->site)?$d->site->name_site:'';
            $d->region_name = isset($d->region)?$d->region->region_name:'';
            $d->created_by_name = isset($d->createdBy)?$d->createdBy->name:'';
            
            $personil_list = "";
            $personil = json_decode($d->personil);
            if(!is_array($personil)) $personil = [$personil];
            foreach($personil as $k=>$v){
                $u = \App\User::where('id', $v)->first();
                if($u)$personil_list .= "$u->name, ";
            }
            $d->personil_list = $personil_list;
            $d->created_at = date('Y-m-d H:i:s', strtotime($d->created_at));
        }
        return response()->json($result);
    }
    public function site_entry_pdf(Request $r){
        $report_columns = \App\Model\ReportColumn::where('id', request()->col_id)->where('type', 'SITE_ENTRY')->first();
    
        $columns = [];
        if($report_columns){
            $columns = json_decode($report_columns->columns);
            if(!is_array($columns)) $columns = [$columns];
        }
        
        if(count($columns) > 8){
            $pdf = \PDF::loadView('report.pdf_site_entry')->setPaper('LEGAL', 'landscape');;
        }else{
            $pdf = \PDF::loadView('report.pdf_site_entry');
        }
        return $pdf->stream();
    }
    
    public function permit_letter(){
        $types = \App\Model\AktivasiType::get();
        $report_columns = \App\Model\ReportColumn::where('id', request()->id)->where('type', 'PERMIT_LETTER')->first();
        
        $encode_columns = "[]";
        $columns = [];
        if($report_columns){
            $encode_columns = $report_columns->columns;
            $columns = json_decode($report_columns->columns);
            if(!is_array($columns)) $columns = [$columns];
        }
        
        $table_columns = [];
        foreach($columns as $k => $v){
            $table_columns[] = ["data"=>$v];
        }
        $table_columns = json_encode($table_columns);
        
        return view('report.permit_letter', compact('types','columns', 'encode_columns', 'table_columns', 'report_columns'));
    }
    public function permit_letter_edit($id){
        $report_columns = \App\Model\ReportColumn::where('id', $id)->where('type', 'PERMIT_LETTER')->first();
        
        $encode_columns = "[]";
        $columns = [];
        if($report_columns){
            $encode_columns = $report_columns->columns;
            $columns = json_decode($report_columns->columns);
            if(!is_array($columns)) $columns = [$columns];
        }
        
        $table_columns = [];
        foreach($columns as $k => $v){
            $table_columns[] = ["data"=>$v];
        }
        $table_columns = json_encode($table_columns);
        
        return view('report.permit_letter_edit', compact('columns', 'encode_columns', 'table_columns', 'report_columns'));
    }
    public function permit_letter_delete($id){
        $user = Auth::user();
        if(!$user){
            \Session::flash('message', "CSRF FAILED PLEASE RE-LOGIN!");
            \Session::flash('alert-class', 'alert-danger');
            return redirect()->back();
        }
        
        $report_columns = \App\Model\ReportColumn::where('id', $id)->where('type', 'PERMIT_LETTER')->first();
        if(!$report_columns){
            \Session::flash('message', "Oops! Something went wrong please try again");
            \Session::flash('alert-class', 'alert-danger');
            return redirect()->back();
        }
        
        $report_columns->delete();
        \Session::flash('message', "Deleted Successfully!");
        \Session::flash('alert-class', 'alert-success');
        return redirect()->to('/report/permit_letter');
    }
    public function permit_letter_columns(Request $r){
        $result = [];
        $result["status"] = false;
        $result["message"] = "";
        $result["newtoken"] = csrf_token();
        
        $user = Auth::user();
        if(!$user){
            $result["message"] = "CSRF FAILED PLEASE RE-LOGIN!";
            return response($result);
        }
        
        $d = \App\Model\ReportColumn::where('id', $r->id)->where('type', 'PERMIT_LETTER')->first();
        if(!$d){
            $d = new \App\Model\ReportColumn;
            $d->type = "PERMIT_LETTER";
        }
        $d->name = $r->name;
        $d->description = $r->description;
        $d->columns = json_encode($r->fields);
        $d->save();
        
        $result["status"] = true;
        $result["message"] = "Updated Successfully";
        $result["data"] = $d;
        return response($result);
    }
    public function get_permit_letter(Request $r){
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
        if($r->created_by) $data->where('created_by', $r->created_by);
        
        $user = Auth::user();
        if(!is_admin($user)){
            $data = $data->where('created_by', $user->id);
        }else{
            if($r->created_by) $data->where('created_by', $r->created_by);
        }
        
        $created_at_from = $r->created_at_from; $created_at_to = $r->created_at_to;
        if($created_at_from && $created_at_to) $data = $data->whereBetween('created_at', ["$created_at_from 00:00:00", "$created_at_to 23:59:59"]);
        
        $result = getDataCustom($data, $r, 'id_permit_letter', 'id_permit_letter')->original;
        foreach($result['data'] as $d){
            $d->site_name = isset($d->site)?$d->site->name_site:'';
            $d->region_name = isset($d->region)?$d->region->region_name:'';
            $d->created_by_name = isset($d->createdBy)?$d->createdBy->name:'';
            $d->created_at = date('Y-m-d H:i:s', strtotime($d->created_at));
            $d->pdf = main_url().'/site-permit/permit-letter-pdf?id='.$d->id_permit_letter;
            
        }
        return response()->json($result);
    }
    public function permit_letter_pdf(Request $r){
        $report_columns = \App\Model\ReportColumn::where('id', request()->id)->where('type', 'PERMIT_LETTER')->first();
    
        $columns = [];
        if($report_columns){
            $columns = json_decode($report_columns->columns);
            if(!is_array($columns)) $columns = [$columns];
        }
        
        if(count($columns) > 8){
            $pdf = \PDF::loadView('report.pdf_permit_letter')->setPaper('LEGAL', 'landscape');;
        }else{
            $pdf = \PDF::loadView('report.pdf_permit_letter');
        }
        return $pdf->stream();
    }
    
    
}