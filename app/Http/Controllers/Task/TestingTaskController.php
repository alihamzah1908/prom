<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \App\Model\Task;
use \App\Model\TaskType;
use \App\Model\TaskSchedule;
use \App\Model\TaskDetail;
use \App\Model\TaskLog;
use \App\Model\TaskApproval;
use \App\Model\TaskLink;
use \App\Model\TaskImages;
use \App\Model\Status;
use \App\Model\Priority;
use \App\Model\Approver; 
use \App\Model\ApproverDetail;
use \App\Model\Technician;
use \App\Model\Region;
use \App\Model\Site;
use \App\Model\RootCaused;
use \App\Model\GroupCustomer;
use \App\Model\Checklist;
use \App\Model\ChecklistAnswer;
use \Auth;
use \Mail;
use \App\Templates;
use \App\TemplatesDefaultValue;
use DateTime;
use \App\TaskAddOns;
use \App\TaskAddOnsSection;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use \App\Model\Filter;
// use Maatwebsite\Excel\Excel;
// use App\Exports\UserMultiSheetExport;
use Maatwebsite\Excel\Excel;
use App\Exports\TasksExport;

class TestingTaskController extends Controller
{
    private $excel;

    public function __construct(Excel $excel){
        $this->excel = $excel;
    }

    public function index(){
        $id_user = Auth::id();
        $data['title'] = 'Task';
        $types = \App\Model\TaskType::get();
        $regions = \App\Model\Region::get();
        $statuses = \App\Model\Status::get();
        $priorities = \App\Model\Priority::get();
        $roots = \App\Model\RootCaused::get();
        $tasks = \App\Model\Task::get();
        $filter_fiture = \App\Model\Filter::where('id_user', $id_user)->first();
        $select_creation_from = '22-07-2021';
        return view('task.index', compact('types','filter_fiture','select_creation_from','regions','statuses','priorities','roots','tasks'));
    }

    public function index_testing(){
        
        $tasks = Task::when(request()->id_type, function($tasks){
                            $tasks = $tasks->where('id_task_type', request()->id_type);
                    })->when(request()->id_region, function($tasks){
                            $tasks = $tasks->where('id_region', request()->id_region);
                    })->when(request()->id_status, function($tasks){
                            $tasks = $tasks->where('id_status', request()->id_status);
                    })->when(request()->created_at_when, function($tasks){
                            $tasks = $tasks->where('created_at','>=', date('Y-m-d 00:00:00', strtotime(request()->created_at_when)));
                    })->when(request()->created_at_until, function($tasks){
                            $tasks = $tasks->where('created_at','<=', date('Y-m-d 23:59:59', strtotime(request()->created_at_until)));
                    })->when(request()->id_task, function($tasks){
                            $tasks = $tasks->where('task_uid', 'like', '%'.request()->id_task.'%');
                    })->when(request()->subject, function($tasks){
                            $tasks = $tasks->where('subject', 'like', '%'.request()->subject.'%');
                    })->when(request()->id_priority, function($tasks){
                        $tasks = $tasks->whereHas('taskDetail', function ($tasks) {
                            return $tasks->where('id_priority', request()->id_priority);
                        });
                    })->when(request()->id_root, function($tasks){
                        $tasks = $tasks->whereHas('taskDetail', function($tasks){
                            return $tasks->where('id_root_caused', request()->id_root);
                        });
                    })->when(request()->completed_at_when, function($tasks){
                        $tasks = $tasks->whereHas('taskDetail', function($tasks){
                            return $tasks->where('request_complete_time', '>=', date('Y-m-d 00:00:00', strtotime(request()->completed_at_when)));
                        });
                    })->when(request()->completed_at_until, function($tasks){
                        $tasks = $tasks->whereHas('taskDetail', function($tasks){
                            return $tasks->where('request_complete_time', '<=', date('Y-m-d 23:59:59', strtotime(request()->completed_at_until)));
                        });
                    })->when(request()->technician, function($tasks){
                        $tasks = $tasks->whereHas('technician', function($tasks){
                            return $tasks->where('name_technician', 'like', '%'.request()->technician.'%');
                        });
                    })->when(request()->name_site_a, function($tasks){
                        $tasks = $tasks->whereHas('siteA', function($tasks){
                            return $tasks->where('name_site', 'like', '%'.request()->name_site_a.'%');
                        })
                    })->where('is_deleted', '=', '0')->latest()->paginate(10);
        $tasks_count = Task::when(request()->id_type, function($tasks_count){
                            $tasks_count = $tasks_count->where('id_task_type', request()->id_type);
                    })->when(request()->id_region, function($tasks_count){
                            $tasks_count = $tasks_count->where('id_region', request()->id_region);
                    })->when(request()->id_status, function($tasks_count){
                            $tasks_count = $tasks_count->where('id_status', request()->id_status);
                    })->when(request()->created_at_when, function($tasks_count){
                            $tasks_count = $tasks_count->where('created_at','>=', date('Y-m-d 00:00:00', strtotime(request()->created_at_when)));
                    })->when(request()->created_at_until, function($tasks_count){
                            $tasks_count = $tasks_count->where('created_at','<=', date('Y-m-d 23:59:59', strtotime(request()->created_at_until)));
                    })->when(request()->id_task, function($tasks_count){
                            $tasks_count = $tasks_count->where('task_uid', 'like', '%'.request()->id_task.'%');
                    })->when(request()->subject, function($tasks_count){
                            $tasks_count = $tasks_count->where('subject', 'like', '%'.request()->subject.'%');
                    })->when(request()->id_priority, function($tasks_count){
                        $tasks_count = $tasks_count->whereHas('taskDetail', function ($tasks_count) {
                            return $tasks_count->where('id_priority', request()->id_priority);
                        });
                    })->when(request()->id_root, function($tasks_count){
                        $tasks_count = $tasks_count->whereHas('taskDetail', function($tasks_count){
                            return $tasks_count->where('id_root_caused', request()->id_root);
                        });
                    })->when(request()->completed_at_when, function($tasks_count){
                        $tasks_count = $tasks_count->whereHas('taskDetail', function($tasks_count){
                            return $tasks_count->where('request_complete_time', '>=', date('Y-m-d 00:00:00', strtotime(request()->completed_at_when)));
                        });
                    })->when(request()->completed_at_until, function($tasks_count){
                        $tasks_count = $tasks_count->whereHas('taskDetail', function($tasks_count){
                            return $tasks_count->where('request_complete_time', '<=', date('Y-m-d 23:59:59', strtotime(request()->completed_at_until)));
                        });
                    })->when(request()->technician, function($tasks_count){
                        $tasks_count = $tasks_count->whereHas('technician', function($tasks_count){
                            return $tasks_count->where('name_technician', 'like', '%'.request()->technician.'%');
                        });
                    })->where('is_deleted', 0)->latest()->count();
                    // dd($tasks);
        $types  = TaskType::all();
        $regions  = Region::all();
        $statuses = Status::all();
        $priorities = Priority::all();
        $roots = RootCaused::all();
        return view('task.index_testing', compact('tasks', 'types', 'regions', 'statuses', 'priorities', 'roots', 'tasks_count'));
    }

    public function download_list_excel_test(){
       
        return $this->excel->download(new TasksExport(request()->query()), 'List-Task.xlsx');
    }
    public function download_list_pdf_test(){
       
        return $this->excel->download(new TasksExport(request()->query()), 'List-Task.pdf');
    }
    public function index_schedule(){
        $data['title'] = 'Task';
        $types = \App\Model\TaskType::get();
        return view('task_schedule.index', compact('types'));
    }
    
    // private $excel;

    // public function __construct(Excel $excel){
    //     $this->excel = $excel;
    // }

    // public function export7days(){
    //     return $this->excel->download(new UserMultiSheetExport(2021), 'Task 7 Days.xlsx');
    // }

    public function update_filter(Request $request){
        $id_user = Auth::id();

        $id = $request->id;
        
        $check_id = Filter::where('id_user',$id_user)->first('id_user');
        $find_id_filter = Filter::where('id_user',$id_user)->first();

      
        
        if($check_id != null){
            $id_filter = $find_id_filter->id_filter;
            $filter = Filter::find($id_filter);
            $filter->id_type = $request->id_task_type;
            $filter->id_region = $request->id_region;
            $filter->id_status = $request->id_status;
            $filter->id_priority = $request->id_priority;
            $filter->id_caused = $request->id_caused;
            $filter->id_subject = $request->subject;
            $filter->created_at_from = $request->created_at_from;
            $filter->created_at_to = $request->created_at_to;
            $filter->completion_from = $request->completion_from;
            $filter->completion_to = $request->completion_to;
            $filter->save();
        }else{
            $filter = new Filter();
            $filter->id_user = $id_user;
            $filter->id_type = $request->id_task_type;
            $filter->id_region = $request->id_region;
            $filter->id_status = $request->id_status;
            $filter->id_priority = $request->id_priority;
            $filter->id_caused = $request->id_caused;
            $filter->id_subject = $request->subject;
            $filter->created_at_from = $request->created_at_from;
            $filter->created_at_to = $request->created_at_to;
            $filter->completion_from = $request->completion_from;
            $filter->completion_to = $request->completion_to;
            $filter->save();
        }
        
        
        
        // return view('task.index');
        return redirect()->to('/task');
    }
    public function report(){
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
        
        return view('task.report', compact('types','columns', 'encode_columns', 'table_columns', 'report_columns'));
    }
    public function report_edit($id){
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
        
        return view('task.report_edit', compact('columns', 'encode_columns', 'table_columns', 'report_columns'));
    }
    public function report_delete($id){
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
        return redirect()->to('/task/report');
    }
    
    public function report_columns(Request $r){
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
    
    public function download(Request $r){
        $download = $r->download_type;
        if($download == "EXCEL"){
            $name = "$download TASK";
            $file = \Excel::download(new \App\Excels\Task, "$name.xlsx");
            return $file;
        }else{
            $pdf = \PDF::loadView('task.pdf');//->setPaper('LEGAL', 'landscape');
            return $pdf->stream();
        }
    }
    
    
    public function checklist_answers_pdf(Request $r){
        $pdf = \PDF::loadView('task.pdf_checklist_answers');//->setPaper('LEGAL', 'landscape');
        return $pdf->stream();
    }
    
     public function pdf_task_plm(Request $r){
        
        $pdf = \PDF::loadView('task.plm_task_pdf');//->setPaper('LEGAL', 'landscape');
        return $pdf->stream();
    }
    
    public function checklist_answers_excel(Request $r){
        $task = Task::find(2260);
        $taskku = $task->task_uid;
        $download2 = $r->download_type;
        $name = "$download2 Answer Checklist $taskku";
            $file = \Excel::download(new \App\Excels\Detail_Task, "$name.xlsx");
            return $file;
    }
     public function task_plm_excel(Request $r){
       $task = Task::find($r->id_task);
        $taskku = $task->task_uid;
        
        $name = "Task $taskku";
       
            $file = \Excel::download(new \App\Excels\plm_task, "$name.xlsx");
            return $file;
    }
    
    
    // public function download2(Request $r){
    //     $download = $r->download_type2;
    //     if($download == "EXCEL"){
    //         $name = "$download TASK";
    //         $file = \Excel::download(new \App\Excels\Detail_Task, "$name.xlsx");
    //         return $file;
    //     }else{
    //         $pdf = \PDF::loadView('task.pdf');//->setPaper('LEGAL', 'landscape');
    //         return $pdf->stream();
    //     }
    // }
    
    public function getStatus(Request $r){
        
        $status = Status::where('task_type_id',$r->id_task_type)->orderBy('id_status','ASC')->get();
        
        if($status->isNotEmpty()){
            $result['data'] = $status; 
            $result['status'] = true ;
             
        }
        else{
            $result['data'] = null; 
            $result['status'] = false;
        }
        
       return response()->json($result);
        
    }
    
    public function delete_task(Request $r,$id_task){
         $user = Auth::user();
         $task = Task::where('id_task',$id_task)->first();
         
         $task->is_deleted = true ;
         
         $task->save();
         
         \Session::flash('message', "Task Deleted Successfully!");
        \Session::flash('alert-class', 'alert-success');
        \Session::flash('data', $task);
        return redirect()->to('task');
         
         
        
    }

    public function delete_task_schedule(Request $r,$id_task){
        $user = Auth::user();
        $task = TaskSchedule::where('id_task',$id_task)->first();
        
        $task->is_deleted = true ;
        
        $task->save();
        
        \Session::flash('message', "Task Deleted Successfully!");
       \Session::flash('alert-class', 'alert-success');
       \Session::flash('data', $task);
       return redirect()->to('task/task_schedule');
        
        
       
   }
    
    public function getDataReport(Request $r){
        $user = Auth::user();
        $technician = Technician::where('user_id', $user->id)->first();
        
        $columns = $r->columns;
        $order = $r->order;
        $orderBy = 'id_task';
        $order_dir = "DESC";
        if($order[0]){
            $order = $order[0];
            $column = $order['column']; 
            $column = $columns[$column];
            $orderBy = $column['data'];
            $order_dir = $order['dir'];
        }
        
        if($orderBy == 'id_task') $orderBy = 'tb_task.id_task';
        $data = Task::orderBy($orderBy, $order_dir)
                      ->leftjoin('tb_detail_task', 'tb_detail_task.id_task', 'tb_task.id_task')
                      ->select('tb_task.*');
        
        if($r->is_link_task == false){
        if($technician){
            $data = $data->where('id_technician', $technician->id_technician);
        }else{
            if($r->id_technician) $data = $data->where('id_technician', $r->id_technician);
        }
        }
        
        
       // if($r->is_link_task) $data = $data->whereIn('id_status', [1,2,3,4,5]); 
        
        $data = $data->where('is_deleted',0);
        
        if($r->id_type) $data = $data->where('tb_task.id_task_type', $r->id_type);
        if($r->id_category) $data = $data->where('id_category', $r->id_category);
        if($r->id_region) $data = $data->where('id_region', $r->id_region);
        if($r->id_priority) $data = $data->where('id_priority', $r->id_priority);
        if($r->id_status) $data = $data->where('id_status', $r->id_status);
        if($r->id_impact) $data = $data->where('id_impact', $r->id_impact);
        if($r->id_group_internal) $data = $data->where('id_group_internal', $r->id_group_internal);
        if($r->id_technician) $data = $data->where('id_technician', $r->id_technician);
        if($r->id_subject) $data = $data->where('subject', $r->id_subject);
        if($r->id_site_a) $data = $data->where('id_site_a', $r->id_site_a);
        if($r->id_location_b) $data = $data->where('id_location_b', $r->id_location_b);
        if($r->id_site_b) $data = $data->where('id_site_b', $r->id_site_b);
        if($r->id_root_caused) $data = $data->where('id_root_caused', $r->id_root_caused);
        if($r->id_caused) $data = $data->where('id_root_caused', $r->id_caused);
          if($r->subject) $data = $data->where('subject', $r->subject);
        
        $id_site_frequency = $r->id_site_frequency;
        if($id_site_frequency){
            $data = $data->where(function ($data) use($id_site_frequency) {
                            $data->where('id_site_a', $id_site_frequency);
                            $data->orWhere('id_site_b', $id_site_frequency);
                          });
        }
        
        if($r->id_task) $data = $data->where('tb_task.id_task', $r->id_task);
        
      
        if($r->created_by) $data = $data->where('created_by', $r->created_by);
        
        $created_at_from = $r->created_at_from; $created_at_to = $r->created_at_to;
        if($created_at_from && $created_at_to) $data = $data->whereBetween('tb_task.created_at', ["$created_at_from 00:00:00", "$created_at_to 23:59:59"]);
        
        $completion_from = $r->completion_from;
        $completion_to = $r->completion_to;
        if($completion_from && $completion_to) $data = $data->whereBetween('time_complete', ["$completion_from 00:00:00", "$completion_to 23:59:59"]);
        
        $name = $r->name;
        if(!$name) $name = $r->search['value'];
        
        if($name){
            $data = $data->where(function ($data) use($name) {
                            $data->where('subject', 'like', '%' . $name . '%');
                          });
            
        }
        
        $draw = $r->get('draw');
        $limit = $r->get('length');
        $offset = $r->get('start');
        $timeout = $r->get('timeout', 0);
        
        $count = $data->count();
        if($limit && $offset) $data = $data->offset($offset)->limit($limit);
        
        $data = $data->get();
        
        foreach($data as $d){
            $d->getApproval;
            $d->task_status = isset($d->getStatus)?$d->getStatus->status_name:'';
            $d->task_color = isset($d->getStatus)?$d->getStatus->color:'';
            $d->site_name = isset($d->getSite)?$d->getSite->name_site:'';
            $detail = $d->getDetail;
            
            $d->task_type_name = isset($d->getType)?$d->getType->type_name:'';
            $d->name_technician = isset($d->getTechnician)?$d->getTechnician->name_technician:'';
            $d->category_name = isset($d->getCategory)?$d->getCategory->category_name:'';
            $d->sub_category_name = isset($d->getSubCategory)?$d->getSubCategory->category_name:'';
            $d->item_name = isset($d->getItem)?$d->getItem->item_name:'';
            $d->region_name = isset($d->getRegion)?$d->getRegion->region_name:'';
            $d->location_a_name = isset($d->getLocationA)?$d->getLocationA->segment_name:'';
            $d->site_a_name = isset($d->getSite)?$d->getSite->name_site:'';
            $d->attachment_link = main_url().'/task_attachment/'.$d->attachment;
            
            $periodeName = isset($detail->checklist_periode)?$detail->checklist_periode:'' ;
            $b = \App\Model\ChecklistPeriode::where('id_periode', $periodeName)->first();
            $d->periode_name = isset($b->periode_name)?$b->periode_name:'';
            
            //$d->checklist_periode_name = isset($detail->getChecklistPeriode)?$detail->getChecklistPeriode->periode_name:'';
            $checklist_category_list = "";
            $checklist_category = $detail->id_checklist_category;
            $checklist_category = json_decode($checklist_category);
            if(!is_array($checklist_category)) $checklist_category = [$checklist_category];
            foreach($checklist_category as $key=>$val){
                $c = \App\Model\ChecklistCategory::where('id_category', $val)->first();
                if($c) $checklist_category_list .= "$c->category_name, ";
            }
            $d->checklist_category = $checklist_category_list;
            
            $d->mode_name = isset($detail->getMode)?$detail->getMode->mode_name:'';
            $d->impact_name = isset($detail->getImpact)?$detail->getImpact->impact_name:'';
            $d->priority_name = isset($detail->getPriority)?$detail->getPriority->priority_name:'';
            $d->root_caused_name = isset($detail->getRootCaused)?$detail->getRootCaused->name_caused:'';
            $d->asset_name = isset($detail->getAsset)?$detail->getAsset->name:'';
            $d->group_internal_name = isset($detail->getGroupInternal)?$detail->getGroupInternal->name_group:'';
            
            $group_customer_list = "";
            $group_customer = $detail->id_group_customer;
            $group_customer = json_decode($group_customer);
            if(!is_array($group_customer)) $group_customer = [$group_customer];
            foreach($group_customer as $key=>$val){
                $c = \App\Model\GroupCustomer::where('id_group', $val)->first();
                if($c) $group_customer_list .= "$c->group_name, ";
            }
            $d->group_customer = $group_customer_list;
            
            $d->location_b_name = isset($detail->getLocationB2)?$detail->getLocationB2->segment_name:'';
            $d->site_b_name = isset($detail->getSiteB)?$detail->getSiteB->name_site:'';
            $d->request_start_time = isset($detail)?$detail->request_start_time:'';
            $d->request_complete_time = isset($detail)?$detail->request_complete_time:'';
            $d->impact_detail = isset($detail)?$detail->impact_detail:'';
            $d->total_hari_kerja = isset($detail)?$detail->total_hari_kerja:'';
            $d->total_waktu_kerja = isset($detail)?$detail->total_waktu_kerja:'';
            $d->down_start = isset($detail)?$detail->down_start:'';
            $d->down_end = isset($detail)?$detail->down_end:'';
            
            $d->created_by_name = isset($d->creator)?$d->creator->name:'';
            $d->updated_by_name = isset($d->updater)?$d->updater->name:'';
            
            $new_r = new Request();
            $new_r->id_task = $d->id_task;
            $d->task_link = $this->getLinked($new_r)->original['data'];
          
            
            
        }
        
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
    
    public function getData(Request $r){
        $user = Auth::user();
        $technician = Technician::where('user_id', $user->id)->first();
        
        $columns = $r->columns;
        $order = $r->order;
        $orderBy = 'id_task';
        $order_dir = "DESC";
        if($order[0]){
            $order = $order[0];
            $column = $order['column']; 
            $column = $columns[$column];
            $orderBy = $column['data'];
            $order_dir = $order['dir'];
        }
        
        if($orderBy == 'id_task') $orderBy = 'tb_task.id_task';
        $data = Task::orderBy($orderBy, $order_dir)
                      ->leftjoin('tb_detail_task', 'tb_detail_task.id_task', 'tb_task.id_task')
                      ->select('tb_task.*');
        
        if($r->is_link_task == false){
        if($technician){
            $data = $data->where('id_technician', $technician->id_technician);
        }else{
            if($r->id_technician) $data = $data->where('id_technician', $r->id_technician);
        }
        }
        
        
       // if($r->is_link_task) $data = $data->whereIn('id_status', [1,2,3,4,5]); 
        
        $data = $data->where('is_deleted',0);
        
        if($r->id_type) $data = $data->where('tb_task.id_task_type', $r->id_type);
        if($r->id_category) $data = $data->where('id_category', $r->id_category);
        if($r->id_region) $data = $data->where('id_region', $r->id_region);
        if($r->id_priority) $data = $data->where('id_priority', $r->id_priority);
        if($r->id_status) $data = $data->where('id_status', $r->id_status);
        if($r->id_impact) $data = $data->where('id_impact', $r->id_impact);
        if($r->id_group_internal) $data = $data->where('id_group_internal', $r->id_group_internal);
        if($r->id_technician) $data = $data->where('id_technician', $r->id_technician);
        if($r->id_subject) $data = $data->where('subject', $r->id_subject);
        if($r->id_site_a) $data = $data->where('id_site_a', $r->id_site_a);
        if($r->id_location_b) $data = $data->where('id_location_b', $r->id_location_b);
        if($r->id_site_b) $data = $data->where('id_site_b', $r->id_site_b);
        if($r->id_root_caused) $data = $data->where('id_root_caused', $r->id_root_caused);
        if($r->id_caused) $data = $data->where('id_root_caused', $r->id_caused);
          if($r->subject) $data = $data->where('subject', $r->subject);
        
        $id_site_frequency = $r->id_site_frequency;
        if($id_site_frequency){
            $data = $data->where(function ($data) use($id_site_frequency) {
                            $data->where('id_site_a', $id_site_frequency);
                            $data->orWhere('id_site_b', $id_site_frequency);
                          });
        }
        
        if($r->id_task) $data = $data->where('tb_task.id_task', $r->id_task);
        
      
        if($r->created_by) $data = $data->where('created_by', $r->created_by);
        
        $created_at_from = $r->created_at_from; $created_at_to = $r->created_at_to;
        if($created_at_from && $created_at_to) $data = $data->whereBetween('tb_task.created_at', ["$created_at_from 00:00:00", "$created_at_to 23:59:59"]);
        
        $completion_from = $r->completion_from;
        $completion_to = $r->completion_to;
        if($completion_from && $completion_to) $data = $data->whereBetween('time_complete', ["$completion_from 00:00:00", "$completion_to 23:59:59"]);
        
        $name = $r->name;
        if(!$name) $name = $r->search['value'];
        
        if($name){
            $data = $data->where(function ($data) use($name) {
                            $data->where('subject', 'like', '%' . $name . '%');
                          });
            
        }
        
        $draw = $r->get('draw');
        $limit = $r->get('length');
        $offset = $r->get('start');
        $timeout = $r->get('timeout', 0);
        
        $count = $data->count();
        if($limit && $offset) $data = $data->offset($offset)->limit($limit);
        
        $data = $data->get();
        
        foreach($data as $d){
            $d->getApproval;
            $d->task_status = isset($d->getStatus)?$d->getStatus->status_name:'';
            $d->task_color = isset($d->getStatus)?$d->getStatus->color:'';
            $d->site_name = isset($d->getSite)?$d->getSite->name_site:'';
            $detail = $d->getDetail;
            
            $d->task_type_name = isset($d->getType)?$d->getType->type_name:'';
            $d->name_technician = isset($d->getTechnician)?$d->getTechnician->name_technician:'';
            $d->category_name = isset($d->getCategory)?$d->getCategory->category_name:'';
            $d->sub_category_name = isset($d->getSubCategory)?$d->getSubCategory->category_name:'';
            $d->item_name = isset($d->getItem)?$d->getItem->item_name:'';
            $d->region_name = isset($d->getRegion)?$d->getRegion->region_name:'';
            $d->location_a_name = isset($d->getLocationA)?$d->getLocationA->segment_name:'';
            $d->site_a_name = isset($d->getSite)?$d->getSite->name_site:'';
            $d->attachment_link = main_url().'/task_attachment/'.$d->attachment;
            
            $periodeName = isset($detail->checklist_periode)?$detail->checklist_periode:'' ;
            $b = \App\Model\ChecklistPeriode::where('id_periode', $periodeName)->first();
            $d->periode_name = isset($b->periode_name)?$b->periode_name:'';
            
            //$d->checklist_periode_name = isset($detail->getChecklistPeriode)?$detail->getChecklistPeriode->periode_name:'';
            $checklist_category_list = "";
            $checklist_category = $detail->id_checklist_category;
            $checklist_category = json_decode($checklist_category);
            if(!is_array($checklist_category)) $checklist_category = [$checklist_category];
            foreach($checklist_category as $key=>$val){
                $c = \App\Model\ChecklistCategory::where('id_category', $val)->first();
                if($c) $checklist_category_list .= "$c->category_name, ";
            }
            $d->checklist_category = $checklist_category_list;
            
            $d->mode_name = isset($detail->getMode)?$detail->getMode->mode_name:'';
            $d->impact_name = isset($detail->getImpact)?$detail->getImpact->impact_name:'';
            $d->priority_name = isset($detail->getPriority)?$detail->getPriority->priority_name:'';
            $d->root_caused_name = isset($detail->getRootCaused)?$detail->getRootCaused->name_caused:'';
            $d->asset_name = isset($detail->getAsset)?$detail->getAsset->name:'';
            $d->group_internal_name = isset($detail->getGroupInternal)?$detail->getGroupInternal->name_group:'';
            
            $group_customer_list = "";
            $group_customer = $detail->id_group_customer;
            $group_customer = json_decode($group_customer);
            if(!is_array($group_customer)) $group_customer = [$group_customer];
            foreach($group_customer as $key=>$val){
                $c = \App\Model\GroupCustomer::where('id_group', $val)->first();
                if($c) $group_customer_list .= "$c->group_name, ";
            }
            $d->group_customer = $group_customer_list;
            
            $d->location_b_name = isset($detail->getLocationB2)?$detail->getLocationB2->segment_name:'';
            $d->site_b_name = isset($detail->getSiteB)?$detail->getSiteB->name_site:'';
            $d->request_start_time = isset($detail)?$detail->request_start_time:'';
            $d->request_complete_time = isset($detail)?$detail->request_complete_time:'';
            $d->impact_detail = isset($detail)?$detail->impact_detail:'';
            $d->total_hari_kerja = isset($detail)?$detail->total_hari_kerja:'';
            $d->total_waktu_kerja = isset($detail)?$detail->total_waktu_kerja:'';
            $d->down_start = isset($detail)?$detail->down_start:'';
            $d->down_end = isset($detail)?$detail->down_end:'';
            
            $d->created_by_name = isset($d->creator)?$d->creator->name:'';
            $d->updated_by_name = isset($d->updater)?$d->updater->name:'';
            
            $new_r = new Request();
            $new_r->id_task = $d->id_task;
            $d->task_link = $this->getLinked($new_r)->original['data'];
          
            
            
        }
        
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
    
    public function getDataSchedule(Request $r){
        $user = Auth::user();
        $technician = Technician::where('user_id', $user->id)->first();
        
        $columns = $r->columns;
        $order = $r->order;
        $orderBy = 'id_task';
        $order_dir = "DESC";
        if($order[0]){
            $order = $order[0];
            $column = $order['column']; 
            $column = $columns[$column];
            $orderBy = $column['data'];
            $order_dir = $order['dir'];
        }
        
        if($orderBy == 'id_task') $orderBy = 'tb_task_schedule.id_task';
        $data = TaskSchedule::orderBy($orderBy, $order_dir)
                      ->select('tb_task_schedule.*');
        
        if($r->is_link_task == false){
        if($technician){
            $data = $data->where('id_technician', $technician->id_technician);
        }else{
            if($r->id_technician) $data = $data->where('id_technician', $r->id_technician);
        }
        }
        
        
       // if($r->is_link_task) $data = $data->whereIn('id_status', [1,2,3,4,5]); 
        
        $data = $data->where('is_deleted',0);
        
        if($r->id_type) $data = $data->where('tb_task.id_task_type', $r->id_type);
        if($r->id_category) $data = $data->where('id_category', $r->id_category);
        if($r->id_region) $data = $data->where('id_region', $r->id_region);
        if($r->id_priority) $data = $data->where('id_priority', $r->id_priority);
        if($r->id_status) $data = $data->where('id_status', $r->id_status);
        if($r->id_impact) $data = $data->where('id_impact', $r->id_impact);
        if($r->id_group_internal) $data = $data->where('id_group_internal', $r->id_group_internal);
        if($r->id_technician) $data = $data->where('id_technician', $r->id_technician);
        if($r->id_subject) $data = $data->where('subject', $r->id_subject);
        if($r->id_site_a) $data = $data->where('id_site_a', $r->id_site_a);
        if($r->id_location_b) $data = $data->where('id_location_b', $r->id_location_b);
        if($r->id_site_b) $data = $data->where('id_site_b', $r->id_site_b);
        if($r->id_root_caused) $data = $data->where('id_root_caused', $r->id_root_caused);
        if($r->id_caused) $data = $data->where('id_root_caused', $r->id_caused);
          if($r->subject) $data = $data->where('subject', $r->subject);
        
        $id_site_frequency = $r->id_site_frequency;
        if($id_site_frequency){
            $data = $data->where(function ($data) use($id_site_frequency) {
                            $data->where('id_site_a', $id_site_frequency);
                            $data->orWhere('id_site_b', $id_site_frequency);
                          });
        }
        
        if($r->id_task) $data = $data->where('tb_task.id_task', $r->id_task);
        
      
        if($r->created_by) $data = $data->where('created_by', $r->created_by);
        
        $created_at_from = $r->created_at_from; $created_at_to = $r->created_at_to;
        if($created_at_from && $created_at_to) $data = $data->whereBetween('tb_task.created_at', ["$created_at_from 00:00:00", "$created_at_to 23:59:59"]);
        
        $completion_from = $r->completion_from;
        $completion_to = $r->completion_to;
        if($completion_from && $completion_to) $data = $data->whereBetween('time_complete', ["$completion_from 00:00:00", "$completion_to 23:59:59"]);
        
        $name = $r->name;
        if(!$name) $name = $r->search['value'];
        
        if($name){
            $data = $data->where(function ($data) use($name) {
                            $data->where('subject', 'like', '%' . $name . '%');
                          });
            
        }
        
        $draw = $r->get('draw');
        $limit = $r->get('length');
        $offset = $r->get('start');
        $timeout = $r->get('timeout', 0);
        
        $count = $data->count();
        if($limit && $offset) $data = $data->offset($offset)->limit($limit);
        
        $data = $data->get();
        
        foreach($data as $d){
            $d->getApproval;
            $d->task_status = isset($d->getStatus)?$d->getStatus->status_name:'';
            $d->task_color = isset($d->getStatus)?$d->getStatus->color:'';
            $d->site_name = isset($d->getSite)?$d->getSite->name_site:'';
            $detail = $d->getDetail;
            
            $d->task_type_name = isset($d->getType)?$d->getType->type_name:'';
            $d->name_technician = isset($d->getTechnician)?$d->getTechnician->name_technician:'';
            $d->category_name = isset($d->getCategory)?$d->getCategory->category_name:'';
            $d->sub_category_name = isset($d->getSubCategory)?$d->getSubCategory->category_name:'';
            $d->item_name = isset($d->getItem)?$d->getItem->item_name:'';
            $d->region_name = isset($d->getRegion)?$d->getRegion->region_name:'';
            $d->location_a_name = isset($d->getLocationA)?$d->getLocationA->segment_name:'';
            $d->site_a_name = isset($d->getSite)?$d->getSite->name_site:'';
            $d->attachment_link = main_url().'/task_attachment/'.$d->attachment;
            
            $periodeName = isset($detail->checklist_periode)?$detail->checklist_periode:'' ;
            $b = \App\Model\ChecklistPeriode::where('id_periode', $periodeName)->first();
            $d->periode_name = isset($b->periode_name)?$b->periode_name:'';
            
            //$d->checklist_periode_name = isset($detail->getChecklistPeriode)?$detail->getChecklistPeriode->periode_name:'';
            $checklist_category_list = "";
            $checklist_category = $detail->id_checklist_category;
            $checklist_category = json_decode($checklist_category);
            if(!is_array($checklist_category)) $checklist_category = [$checklist_category];
            foreach($checklist_category as $key=>$val){
                $c = \App\Model\ChecklistCategory::where('id_category', $val)->first();
                if($c) $checklist_category_list .= "$c->category_name, ";
            }
            $d->checklist_category = $checklist_category_list;
            
            $d->mode_name = isset($detail->getMode)?$detail->getMode->mode_name:'';
            $d->impact_name = isset($detail->getImpact)?$detail->getImpact->impact_name:'';
            $d->priority_name = isset($detail->getPriority)?$detail->getPriority->priority_name:'';
            $d->root_caused_name = isset($detail->getRootCaused)?$detail->getRootCaused->name_caused:'';
            $d->asset_name = isset($detail->getAsset)?$detail->getAsset->name:'';
            $d->group_internal_name = isset($detail->getGroupInternal)?$detail->getGroupInternal->name_group:'';
            
            $group_customer_list = "";
            $group_customer = $detail->id_group_customer;
            $group_customer = json_decode($group_customer);
            if(!is_array($group_customer)) $group_customer = [$group_customer];
            foreach($group_customer as $key=>$val){
                $c = \App\Model\GroupCustomer::where('id_group', $val)->first();
                if($c) $group_customer_list .= "$c->group_name, ";
            }
            $d->group_customer = $group_customer_list;
            
            $d->location_b_name = isset($detail->getLocationB2)?$detail->getLocationB2->segment_name:'';
            $d->site_b_name = isset($detail->getSiteB)?$detail->getSiteB->name_site:'';
            $d->request_start_time = isset($detail)?$detail->request_start_time:'';
            $d->request_complete_time = isset($detail)?$detail->request_complete_time:'';
            $d->impact_detail = isset($detail)?$detail->impact_detail:'';
            $d->total_hari_kerja = isset($detail)?$detail->total_hari_kerja:'';
            $d->total_waktu_kerja = isset($detail)?$detail->total_waktu_kerja:'';
            $d->down_start = isset($detail)?$detail->down_start:'';
            $d->down_end = isset($detail)?$detail->down_end:'';
            
            $d->created_by_name = isset($d->creator)?$d->creator->name:'';
            $d->updated_by_name = isset($d->updater)?$d->updater->name:'';
            
            $new_r = new Request();
            $new_r->id_task = $d->id_task;
            $d->task_link = $this->getLinked($new_r)->original['data'];
          
            
            
        }
        
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

    public function getLinked(Request $r){
        $columns = $r->columns;
        $order = $r->order;
        if($order[0]){
            $order = $order[0];
            $column = $order['column']; 
            $column = $columns[$column];
            $orderBy = $column['data'];
            $order_dir = $order['dir'];
    
            $data = TaskLink::orderBy($orderBy, $order_dir);
        }else{
            
            $orderBy = false;
            $data = TaskLink::orderBy('id_link','DESC');
        }
        
        $id_technician = $r->id_technician;
        $id_task = $r->id_task;
        
        if($id_technician){
            $data = $data->where(function ($data) use($id_technician) {
                                $data->where('id_technician_1', $id_technician);
                                $data->orWhere('id_technician_2', $id_technician);
                              });
                               
        }else{
            $data = $data->where(function ($data) use($id_task) {
                                $data->where('id_task_1', $id_task);
                                $data->orWhere('id_task_2', $id_task);
                              });
        }
        
        
        $draw = $r->get('draw', 1);
        $limit = $r->get('length', 10);
        $offset = $r->get('start', 0);
        $timeout = $r->get('timeout', 0);
        
        $count = $data->count();
        // $data = Task::orderBy('id_task','DESC');
        $data = $data->get();
        $datas = [];
        foreach($data as $d){
            if($id_technician){
                if($id_technician == $d->id_technician_1){
                    $parent = $d->task_1;
                    $d = $d->task_2;
                    $d->link_type = "FROM";
                }else{
                    $parent = $d->task_2;
                    $d = $d->task_1;
                    $d->link_type = "TO";
                }
            }else{
                if($id_task == $d->id_task_1){
                    $parent = $d->task_1;
                    $d = $d->task_2;
                    $d->link_type = "FROM";
                }else{
                    $parent = $d->task_2;
                    $d = $d->task_1;
                    $d->link_type = "TO";
                }
            }
            if($d){
                $d->task_uid_parent = $parent->task_uid;
                $d->task_id_parent = $parent->id_task;
                $d->task_status = isset($d->getStatus)?$d->getStatus->status_name:'';
                $d->task_color = isset($d->getStatus)?$d->getStatus->color:'';
                $d->site_name = isset($d->getSite)?$d->getSite->name_site:'';
            }
            $datas[] = $d;
        }
        $data = $datas;
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
    public function getBeforeAfter(Request $r, $id_task){
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
        $data = TaskImages::orderBy($orderBy, $order_dir)->where('id_task', $id_task);
        if($r->type) $data = $data->where('type', $r->type);
        $result = getDataCustom($data, $r, 'id', 'id')->original;
        
        foreach($result['data'] as $d){
            $d->image = \URL::to('/')."/task_report/$d->image";
        }
        
        return response()->json($result);
    }
    
    public function create(Request $r){
        $id_template = $r->id_template;
        $template_name = "";
        switch($id_template){
            case 2:
                $id_template = 2;
                $task_type = 'task.pmTask';
                $template_name = "PM Task";
                break;
            case 3:
                $id_template = 3;
                $task_type = 'task.crTask';
                $template_name = "CR Task";
                break;
            case 4 : 
                $id_tempate = 4 ;
                $task_type = 'task.plmTask';
                $template_name = "PLM Task";
                break;
            default:
                $id_template = 1;
                $task_type = 'task.cmTask';
                $template_name = "CM Task";
        }
        $template_default_value = $r->template_default_value;
        $task = new Task;
        $task_detail = new TaskDetail;
        
        $add_ons = false;
        if($r->template_default_value){
            $temp = Templates::where('id', $r->template_default_value)->first();
            $deff = TemplatesDefaultValue::where('id_template', $temp->id)->first();
            if($deff){
                $task = $deff; $task_detail = $deff;
                $task->sub_category_name = $task->getSubCategory?$task->getSubCategory->sub_category_name:'-';
                $task->item_name = $task->getItem?$task->getItem->item_name:'-';
                $id_template = $task->id_task_type;
                $task->id_template = $task->id_task_type;
            }
            if($temp){
                $add_ons = \App\TemplatesAddOnsSection::where('id_template', $temp->id)->get();
            }
        }
        
        return view('task.create', compact('task', 'task_detail', 'id_template', 'task_type', 'template_default_value', 'add_ons', 'template_name'));
    }

    public function create_schedule(Request $r){
        $id_template = $r->id_template;
        $template_name = "";
        switch($id_template){
            case 2:
                $id_template = 2;
                $task_type = 'task_schedule.pmTask';
                $template_name = "PM Task";
                break;
            case 3:
                $id_template = 3;
                $task_type = 'task_schedule.pmTask';
                $template_name = "CR Task";
                break;
            case 4 : 
                $id_tempate = 4 ;
                $task_type = 'task_schedule.pmTask';
                $template_name = "PLM Task";
                break;
            default:
                $id_template = 1;
                $task_type = 'task_schedule.pmTask';
                $template_name = "CM Task";
        }
        $template_default_value = $r->template_default_value;
        $task = new Task;
        $task_detail = new TaskDetail;
        
        $add_ons = false;
        if($r->template_default_value){
            $temp = Templates::where('id', $r->template_default_value)->first();
            $deff = TemplatesDefaultValue::where('id_template', $temp->id)->first();
            if($deff){
                $task = $deff; $task_detail = $deff;
                $task->sub_category_name = $task->getSubCategory?$task->getSubCategory->sub_category_name:'-';
                $task->item_name = $task->getItem?$task->getItem->item_name:'-';
                $id_template = $task->id_task_type;
                $task->id_template = $task->id_task_type;
            }
            if($temp){
                $add_ons = \App\TemplatesAddOnsSection::where('id_template', $temp->id)->get();
            }
        }
        
        return view('task_schedule.create_schedule', compact('task', 'task_detail', 'id_template', 'task_type', 'template_default_value', 'add_ons', 'template_name'));
    }
    
    public function new_task(Request $r){
        $user = Auth::user();
        if(!$user){
            \Session::flash('message', "CSRF FAILED PLEASE RE-LOGIN!");
            \Session::flash('alert-class', 'alert-danger');
            return redirect()->back()->withInput($r->all());
        }
        
        if($r->pilih_waktu == "sekarang"){
            $id_region = $r->id_region;
            if(!$r->id_region){
                $site = Site::where('site_id', $r->id_site_a)->first();
                $id_region = $site->region_id;
            }
            
            $approver = Approver::where('id_task_type', $r->id_template)->where('id_region', $id_region)->first();
            // if(!$approver && $r->id_template != 3){
            //     $site_name = isset($site)?$site->name_site:'this Site';
            //     \Session::flash('message', "Approver for $site_name does not exist!");
            //     \Session::flash('alert-class', 'alert-danger');
            //     return redirect()->back()->withInput($r->all());
            // }
            
            $last_id = Task::orderBy('id_task','DESC')->first();
            if($last_id){
                $last_id = $last_id->id_task + 1;
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
            
            if($r->id_template == 1){
                $uid = "CM-".date('ymd').$uid;
            }elseif($r->id_template == 2){
                $uid = "PM-".date('ymd').$uid;
            //  $uid = "CR-".date('ymd').$uid;
            }elseif($r->id_template == 4){
                $uid = "PLM-".date('ymd').$uid;
            }else{
                $uid = "CR-".date('ymd').$uid;
            }
            
            if(true){
                $task = new Task;
                $task->task_uid = $uid;
                $task->id_technician = $r->id_technician;
                $task->id_task_type = $r->id_template;
                
                if ($r->id_template == 1){
                $task->id_status = 1;  
                }
                else if ($r->id_template == 2 ){
                $task->id_status = 12;   
                }
                else if ($r->id_template == 4 ){
                    $task->id_status = 24; 
                }
                else{
                    $task->id_status = 35; 
                    
                }
                
                $task->id_category = $r->id_category;
                $task->id_sub_category = $r->id_sub_category;
                $task->id_item = $r->id_item;
                $task->description = $r->description;
                $task->subject = $r->subject;
                $task->id_region = $id_region;
                $task->id_location_a = $r->id_location_a;
                $task->id_site_a = $r->id_site_a;
                $task->created_by = $user->id;
                
                $attachment = 'default.png';
                if($r->file('attachment')){
                    $file = $r->file('attachment');
                    $file->move(public_path().'/task_attachment', $file->getClientOriginalName());
                    $attachment = $file->getClientOriginalName();
                }
                $task->attachment = $attachment;
                $task->save();
                
                $task_detail = new TaskDetail;
                $task_detail->id_task_type = $task->id_task_type;
                $task_detail->id_task = $task->id_task;
                $task_detail->checklist_periode = $r->checklist_periode;
                $task_detail->id_checklist_category = json_encode($r->id_checklist_category);
                $task_detail->request_start_time = $r->request_start_time;
                $task_detail->request_complete_time = $r->request_complete_time;
                $task_detail->id_mode = $r->id_mode;
                $task_detail->id_impact = $r->id_impact;
                $task_detail->impact_detail = $r->impact_detail;
                $task_detail->id_priority = $r->id_priority;
                $task_detail->id_root_caused = $r->id_root_caused;
                $task_detail->id_asset = $r->id_asset;
                $task_detail->id_group_internal = $r->id_group_internal;
                // $task_detail->id_group_customer = $r->id_group_customer;
                $task_detail->id_group_customer = json_encode($r->id_group_customer);
                $task_detail->id_location_b = $r->id_location_b;
                $task_detail->id_site_b = $r->id_site_b; 
                $task_detail->total_hari_kerja = $r->total_hari_kerja;
                $task_detail->total_waktu_kerja = $r->total_waktu_kerja;
                $task_detail->down_start = $r->down_start;
                $task_detail->down_end = $r->down_end;
                $task_detail->save();
                
                
                $log = new TaskLog;
                $log->id_task = $task->id_task;
                $log->action = "CREATE";
                $log->status_to = isset($task->getStatus)?$task->getStatus->status_name:'OPEN';
                $log->changed_data_to = $this->taskRelations($task);
                $log->created_by = $user->id;
                $log->save();
            }
            // send mail
            if($task->id_task_type == 1){
                $task = Task::where('id_task', $task->id_task)->first();
                $detail = $task->getDetail;
            //   return $id_group_customer ; 
                foreach($r->id_group_customer as $key => $val){
                    $from = "ihsan@udacoding.com";
                    $group_name = 'UNDEFINED';
                    $group_customer = false;
                    $msg = "TASK - has been CREATED by $user->name";
                    $subject = "New Task";
                    if($detail){
                        $group = GroupCustomer::where('id_group', $val)->first();;
                        $group_name = isset($group)?$group->group_name:'-';
                        $group_customer = $group;
                    }
                    if($group_customer){
                        foreach($group_customer->getUsers as $user){
                            $user_name = $user->name;
                            $user_email = isset($user->email)?$user->email:'mail@mail.com';
                            $data = array('task' => $task,
                                    'msg' => $msg,
                                    'name' => $user_name
                                    );
                            $mail = Mail::send('email.task', $data, function($message) use ($user_name, $user_email, $from, $subject) {
                                        $message->to($user_email, $user_email)->subject($subject);
                                        $message->from($from,"PROM");
                                    });
                        }
                    }
                }
            }
            // firebase notif
            if($task->id_task_type != 3){
                $technician =  $task->getTechnician;
                $user = null;
                $tokens = null;
                $name = null ;
                if($technician) $user = $technician->user;
                if($technician) $name = $technician->name_technician ;
                if($user) $tokens = [$user->firebase_token_web, $user->firebase_token];
                
                
                sendTaskNotif($task, $tokens, 'New Task Has Been Created', "New task has been created Assign To $name with title $task->subject");
            }
            // return $tokens;
            
            $field_parent = $r->field_parent;
            $section_name = $r->section_name;
            $arr_field = $r->arr_field;
            $fields = $r->fields;
            $section_id = $r->section_id;
            if($field_parent && $section_name && $arr_field){
                foreach(TaskAddOnsSection::where('id_task', $task->id_task)->get() as $se){
                    foreach(TaskAddOns::where('id_section', $se->id)->get() as $fi){
                        $fi->delete();
                    }
                    $se->delete();
                }
                
                foreach($section_name as $k => $v){
                    $section = new TaskAddOnsSection;
                    $section->name = $v;
                    $section->section_id = $field_parent[$k];
                    $section->id_task = $task->id_task;
                    $section->save();
                    
                    foreach($arr_field as $k_f => $v_f){
                        $arr_field = json_decode($v_f);
                        $parent = $arr_field->parent;
                        
                        if($parent == $field_parent[$k_f]){
                            $field = new TaskAddOns;
                            $field->id_section = $section->id;
                            $field->type = $arr_field->type;
                            $field->field_id = $arr_field->id;
                            $field->name = $arr_field->name;
                            $name = str_replace(' ', '_', $arr_field->name);
                            $field->value = $r->$name;
                            $field->save();
                        }
                    }
                    
                }
            }
        }
        if($r->pilih_waktu == "dengan_jadwal"){
            $id_region = $r->id_region;
            if(!$r->id_region){
                $site = Site::where('site_id', $r->id_site_a)->first();
                $id_region = $site->region_id;
            }
            $approver = Approver::where('id_task_type', $r->id_template)->where('id_region', $id_region)->first();
            if(!$approver && $r->id_template != 3){
                $site_name = isset($site)?$site->name_site:'this Site';
                \Session::flash('message', "Approver for $site_name does not exist!");
                \Session::flash('alert-class', 'alert-danger');
                return redirect()->back()->withInput($r->all());
            }
            
            $last_id = Task::orderBy('id_task','DESC')->first();
            if($last_id){
                $last_id = $last_id->id_task + 1;
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
            
            if($r->id_template == 1){
                $uid = "CM-".date('ymd').$uid;
            }elseif($r->id_template == 2){
                $uid = "PM-".date('ymd').$uid;
            //  $uid = "CR-".date('ymd').$uid;
            }elseif($r->id_template == 4){
                $uid = "PLM-".date('ymd').$uid;
            }else{
                $uid = "CR-".date('ymd').$uid;
            }
            
            if(true){
                $task_sche = new TaskSchedule;
                $task_sche->task_uid = $uid;
                $task_sche->id_technician = $r->id_technician;
                $task_sche->id_task_type = $r->id_template;
                
                if ($r->id_template == 1){
                $task_sche->id_status = 1;  
                }
                else if ($r->id_template == 2 ){
                $task_sche->id_status = 12;   
                }
                else if ($r->id_template == 4 ){
                    $task_sche->id_status = 24; 
                }
                else{
                    $task_sche->id_status = 35; 
                    
                }
                //for frequency dozoftware
                // $frequencySelect = '08:00';
                // if($r->selectFrequency == "optionDaily"){
                //     $frequencySelect = "dailyAt('".$r->jam.':'.$r->menit."')";
                // }else if($r->selectFrequency == "optionWeekly"){
                //     $frequencySelect = "weeklyOn(".$r->hari.", '".$r->jam.":".$r->menit."')";
                // }else if($r->selectFrequency == "optionMonthly"){
                //     $frequencySelect = "monthlyOn(".$r->tanggal.", '".$r->jam.":".$r->menit."')";
                // }
                //end for frequency
                
                
                $task_sche->id_category = $r->id_category;
                $task_sche->id_sub_category = $r->id_sub_category;
                $task_sche->id_item = $r->id_item;
                $task_sche->description = $r->description;
                $task_sche->subject = $r->subject;
                $task_sche->id_region = $id_region;
                $task_sche->id_location_a = $r->id_location_a;
                $task_sche->id_site_a = $r->id_site_a;
                $task_sche->created_by = $user->id;
                // $task->frequency = $frequencySelect;
                $clocks = $r->jam.':'.$r->menit;

                $task_sche->frequency = $r->selectFrequency;
                $task_sche->jam = $r->jam;
                $task_sche->menit = $r->menit;
                $task_sche->clock = $clocks;
                // $task->menit = $r->menit;
                $task_sche->hari = $r->hari;
                $task_sche->tanggal = $r->tanggal;
                
                $attachment = 'default.png';
                if($r->file('attachment')){
                    $file = $r->file('attachment');
                    $file->move(public_path().'/task_attachment', $file->getClientOriginalName());
                    $attachment = $file->getClientOriginalName();
                }
                $task_sche->attachment = $attachment;
                //for detail
                $task_sche->checklist_periode = $r->checklist_periode;
                $task_sche->id_checklist_category = json_encode($r->id_checklist_category);
                $task_sche->request_start_time = $r->request_start_time;
                $task_sche->request_complete_time = $r->request_complete_time;
                $task_sche->id_mode = $r->id_mode;
                $task_sche->id_impact = $r->id_impact;
                $task_sche->impact_detail = $r->impact_detail;
                $task_sche->id_priority = $r->id_priority;
                $task_sche->id_root_caused = $r->id_root_caused;
                $task_sche->id_asset = $r->id_asset;
                $task_sche->id_group_internal = $r->id_group_internal;
                $task_sche->id_group_customer = json_encode($r->id_group_customer);
                $task_sche->id_location_b = $r->id_location_b;
                $task_sche->id_site_b = $r->id_site_b; 
                $task_sche->total_hari_kerja = $r->total_hari_kerja;
                $task_sche->total_waktu_kerja = $r->total_waktu_kerja;
                $task_sche->down_start = $r->down_start;
                $task_sche->down_end = $r->down_end;
                //end detail
                $task_sche->save();
                
            }
        } 
      
        \Session::flash('message', "Task Created Successfully!");
        \Session::flash('alert-class', 'alert-success');
        // dd($task);
        \Session::flash('data', $task);
        // return \Session::get('data');
        return redirect()->to('task')->with('message', "Task Created Successfully!")->with('alert-class', 'alert-success')->with('data', $task);
    }
    public function new_task_schedule(Request $r){
        $user = Auth::user();
        if(!$user){
            \Session::flash('message', "CSRF FAILED PLEASE RE-LOGIN!");
            \Session::flash('alert-class', 'alert-danger');
            return redirect()->back()->withInput($r->all());
        }
        
        $id_region = $r->id_region;
        if(!$r->id_region){
            $site = Site::where('site_id', $r->id_site_a)->first();
            $id_region = $site->region_id;
        }
        
        $approver = Approver::where('id_task_type', $r->id_template)->where('id_region', $id_region)->first();
        if(!$approver && $r->id_template != 3){
            $site_name = isset($site)?$site->name_site:'this Site';
            \Session::flash('message', "Approver for $site_name does not exist!");
            \Session::flash('alert-class', 'alert-danger');
            return redirect()->back()->withInput($r->all());
        }
        
        $last_id = Task::orderBy('id_task','DESC')->first();
        if($last_id){
            $last_id = $last_id->id_task + 1;
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
        
        if($r->id_template == 1){
            $uid = "CM-".date('ymd').$uid;
        }elseif($r->id_template == 2){
            $uid = "PM-".date('ymd').$uid;
          //  $uid = "CR-".date('ymd').$uid;
        }elseif($r->id_template == 4){
            $uid = "PLM-".date('ymd').$uid;
        }else{
            $uid = "CR-".date('ymd').$uid;
        }
        
        if(true){
            $task = new TaskSchedule;
            $task->task_uid = $uid;
            $task->id_technician = $r->id_technician;
            $task->id_task_type = $r->id_template;
            
            if ($r->id_template == 1){
              $task->id_status = 1;  
            }
            else if ($r->id_template == 2 ){
               $task->id_status = 12;   
            }
            else if ($r->id_template == 4 ){
                 $task->id_status = 24; 
            }
            else{
                $task->id_status = 35; 
                
            }
            //for frequency dozoftware
            // $frequencySelect = '08:00';
            // if($r->selectFrequency == "optionDaily"){
            //     $frequencySelect = "dailyAt('".$r->jam.':'.$r->menit."')";
            // }else if($r->selectFrequency == "optionWeekly"){
            //     $frequencySelect = "weeklyOn(".$r->hari.", '".$r->jam.":".$r->menit."')";
            // }else if($r->selectFrequency == "optionMonthly"){
            //     $frequencySelect = "monthlyOn(".$r->tanggal.", '".$r->jam.":".$r->menit."')";
            // }
            //end for frequency
            
            
            $task->id_category = $r->id_category;
            $task->id_sub_category = $r->id_sub_category;
            $task->id_item = $r->id_item;
            $task->description = $r->description;
            $task->subject = $r->subject;
            $task->id_region = $id_region;
            $task->id_location_a = $r->id_location_a;
            $task->id_site_a = $r->id_site_a;
            $task->created_by = $user->id;
            // $task->frequency = $frequencySelect;
            $clocks = $r->jam.':'.$r->menit;

            $task->frequency = $r->selectFrequency;
            $task->jam = $r->jam;
            $task->menit = $r->menit;
            $task->clock = $clocks;
            // $task->menit = $r->menit;
            $task->waktus = $r->jadwalku;
            $task->hari = $r->hari;
            $task->tanggal = $r->tanggal;
            
            $attachment = 'default.png';
            if($r->file('attachment')){
                $file = $r->file('attachment');
                $file->move(public_path().'/task_attachment', $file->getClientOriginalName());
                $attachment = $file->getClientOriginalName();
            }
            $task->attachment = $attachment;
            //for detail
            $task->checklist_periode = $r->checklist_periode;
            $task->id_checklist_category = json_encode($r->id_checklist_category);
            $task->request_start_time = $r->request_start_time;
            $task->request_complete_time = $r->request_complete_time;
            $task->id_mode = $r->id_mode;
            $task->id_impact = $r->id_impact;
            $task->impact_detail = $r->impact_detail;
            $task->id_priority = $r->id_priority;
            $task->id_root_caused = $r->id_root_caused;
            $task->id_asset = $r->id_asset;
            $task->id_group_internal = $r->id_group_internal;
            $task->id_group_customer = json_encode($r->id_group_customer);
            $task->id_location_b = $r->id_location_b;
            $task->id_site_b = $r->id_site_b; 
            $task->total_hari_kerja = $r->total_hari_kerja;
            $task->total_waktu_kerja = $r->total_waktu_kerja;
            $task->down_start = $r->down_start;
            $task->down_end = $r->down_end;
            //end detail
            $task->save();
            
            // $task_detail = new TaskDetail;
            // $task_detail->id_task_type = $task->id_task_type;
            // $task_detail->id_task = $task->id_task;
            // $task_detail->checklist_periode = $r->checklist_periode;
            // $task_detail->id_checklist_category = json_encode($r->id_checklist_category);
            // $task_detail->request_start_time = $r->request_start_time;
            // $task_detail->request_complete_time = $r->request_complete_time;
            // $task_detail->id_mode = $r->id_mode;
            // $task_detail->id_impact = $r->id_impact;
            // $task_detail->impact_detail = $r->impact_detail;
            // $task_detail->id_priority = $r->id_priority;
            // $task_detail->id_root_caused = $r->id_root_caused;
            // $task_detail->id_asset = $r->id_asset;
            // $task_detail->id_group_internal = $r->id_group_internal;
            // // $task_detail->id_group_customer = $r->id_group_customer;
            // $task_detail->id_group_customer = json_encode($r->id_group_customer);
            // $task_detail->id_location_b = $r->id_location_b;
            // $task_detail->id_site_b = $r->id_site_b; 
            // $task_detail->total_hari_kerja = $r->total_hari_kerja;
            // $task_detail->total_waktu_kerja = $r->total_waktu_kerja;
            // $task_detail->down_start = $r->down_start;
            // $task_detail->down_end = $r->down_end;
            // $task_detail->save();
            
            
            // $log = new TaskLog;
            // $log->id_task = $task->id_task;
            // $log->action = "CREATE";
            // $log->status_to = isset($task->getStatus)?$task->getStatus->status_name:'OPEN';
            // $log->changed_data_to = $this->taskRelations($task);
            // $log->created_by = $user->id;
            // $log->save();
        }
        // send mail
        // if($task->id_task_type == 1){
        //     $task = Task::where('id_task', $task->id_task)->first();
        //     $detail = $task->getDetail;
        //  //   return $id_group_customer ; 
        //     foreach($r->id_group_customer as $key => $val){
        //         $from = "ihsan@udacoding.com";
        //         $group_name = 'UNDEFINED';
        //         $group_customer = false;
        //         $msg = "TASK - has been CREATED by $user->name";
        //         $subject = "New Task";
        //         if($detail){
        //             $group = GroupCustomer::where('id_group', $val)->first();;
        //             $group_name = isset($group)?$group->group_name:'-';
        //             $group_customer = $group;
        //         }
        //         if($group_customer){
        //             foreach($group_customer->getUsers as $user){
        //                 $user_name = $user->name;
        //                 $user_email = isset($user->email)?$user->email:'mail@mail.com';
        //                 $data = array('task' => $task,
        //                           'msg' => $msg,
        //                           'name' => $user_name
        //                           );
        //                 $mail = Mail::send('email.task', $data, function($message) use ($user_name, $user_email, $from, $subject) {
        //                             $message->to($user_email, $user_email)->subject($subject);
        //                             $message->from($from,"PROM");
        //                         });
        //             }
        //         }
        //     }
        // }
        // firebase notif
        // if($task->id_task_type != 3){
        //     $technician =  $task->getTechnician;
        //     $user = null;
        //     $tokens = null;
        //     if($technician) $user = $technician->user;
        //     if($user) $tokens = [$user->firebase_token_web, $user->firebase_token];
            
            
        //     // $tokens = addAdminTokens($tokens);
        //     // $tokens = removeSender($tokens);
            
        //     sendTaskNotif($task, $tokens, 'New Task Has Been Created', "New task has been created");
        // }
        // return $tokens;
        
        // $field_parent = $r->field_parent;
        // $section_name = $r->section_name;
        // $arr_field = $r->arr_field;
        // $fields = $r->fields;
        // $section_id = $r->section_id;
        // if($field_parent && $section_name && $arr_field){
        //     foreach(TaskAddOnsSection::where('id_task', $task->id_task)->get() as $se){
        //         foreach(TaskAddOns::where('id_section', $se->id)->get() as $fi){
        //             $fi->delete();
        //         }
        //         $se->delete();
        //     }
            
        //     foreach($section_name as $k => $v){
        //         $section = new TaskAddOnsSection;
        //         $section->name = $v;
        //         $section->section_id = $field_parent[$k];
        //         $section->id_task = $task->id_task;
        //         $section->save();
                
        //         foreach($arr_field as $k_f => $v_f){
        //             $arr_field = json_decode($v_f);
        //             $parent = $arr_field->parent;
                    
        //             if($parent == $field_parent[$k_f]){
        //                 $field = new TaskAddOns;
        //                 $field->id_section = $section->id;
        //                 $field->type = $arr_field->type;
        //                 $field->field_id = $arr_field->id;
        //                 $field->name = $arr_field->name;
        //                 $name = str_replace(' ', '_', $arr_field->name);
        //                 $field->value = $r->$name;
        //                 $field->save();
        //             }
        //         }
                
        //     }
        // }
      
        \Session::flash('message', "Task Created Successfully!");
        \Session::flash('alert-class', 'alert-success');
        \Session::flash('data', $task);
        // return \Session::get('data');
        return redirect()->to('task/task_schedule')->with('message', "Task Created Successfully!")->with('alert-class', 'alert-success')->with('data', $task);
    }
    
    public function link_task(Request $r){
        $user = Auth::user();
        if(!$user){
            \Session::flash('message', "CSRF FAILED PLEASE RE-LOGIN!");
            \Session::flash('alert-class', 'alert-danger');
            return redirect()->back()->withInput($r->all());
        }
        
        $task_1 = Task::where('id_task', $r->id_task_1)->whereIn('id_status', [1,2,3,4,5])->first();
        if(!$task_1){
            \Session::flash('message', "Task I not found!");
            \Session::flash('alert-class', 'alert-info');
            return redirect()->back();
        }
        $task_2 = Task::where('id_task', $r->id_task_2)->whereIn('id_status', [1,2,3,4,5])->first();
        if(!$task_2){
            \Session::flash('message', "Task II not found!");
            \Session::flash('alert-class', 'alert-info');
            return redirect()->back();
        }
        
        $cek = TaskLink::where('id_task_1', $r->id_task_1)->where('id_task_2', $r->id_task_2)->first();
        if($cek){
            \Session::flash('message', "Task ( $task_1->task_uid & $task_2->task_uid) Has already been linked before!");
            \Session::flash('alert-class', 'alert-info');
            return redirect()->back();
        }
        
        $technician_1 = $task_1->getTechnician;
        if(!$technician_1){
            \Session::flash('message', "Technician from Task I not found!");
            \Session::flash('alert-class', 'alert-info');
            return redirect()->back();
        }
        $technician_2 = $task_2->getTechnician;
        if(!$technician_2){
            \Session::flash('message', "Technician from Task II not found!");
            \Session::flash('alert-class', 'alert-info');
            return redirect()->back();
        }
        
        $link = new TaskLink;
        $link->id_task_1 = $r->id_task_1;
        $link->id_task_2 = $r->id_task_2;
        $link->id_technician_1 = $technician_1->id_technician;
        $link->id_technician_2 = $technician_2->id_technician;
        $link->save();
        
        \Session::flash('message', "Task Linked Successfully!");
        \Session::flash('alert-class', 'alert-success');
        return redirect()->to('task');
    }
    
    public function update_teknisi_cir(Request $r, $id_task){
        
         $task = Task::where('id_task', $id_task)->first();
        if(!$task){ $result["message"] = "Task does not exist!";return response($result);   }
       // $id_status = $r->id_status;
        // if($id_status == "WAITING_APPROVAL"){    $result["message"] = "Waiting for admin approval!"; return response($result);   }
        // if(!$id_status){    $result["message"] = "Status is required!"; return response($result);   }
         $status = Status::where('id_status', $task->id_status)->first();
       if(!$status){   $result["message"] = "Status does not exist!";  return response($result);   }
        
       // return $result['id_status'] = $status->id_status ;
     
        $this->assignTaskApprovers($task, $status->id_status, "UPDATE_CIR", $status->status_name);
        
            
            $attachment = "default";
            if($r->file('doc_cir')){
                $file = $r->file('doc_cir');
                $file->move(public_path().'/task_attachment', $file->getClientOriginalName());
                $attachment = $file->getClientOriginalName();
                //return response($attachment);
                 $task->task_doc_cir = $attachment;
            $task->update();
            
               $result["status"] = true;
        $result["message"] = "Updated Successfully";
        $result["data"] = $task;
        return response($result);
            }
            else{
                   $result["status"] = false;
              $result["message"] = "file not found";
       
        return response($result);
                
            }
            
           
            
          
            
      
    }
    
    public function update_task(Request $r, $id_task){
        
        $user = Auth::user();
        if(!$user){
            \Session::flash('message', "CSRF FAILED PLEASE RE-LOGIN!");
            \Session::flash('alert-class', 'alert-danger');
            return redirect()->back()->withInput($r->all());
        }
        
        if(true){
            $task = Task::where('id_task', $id_task)->first();
            $task_detail = TaskDetail::where('id_task', $id_task)->first();
            if(!$task || !$task_detail){
                \Session::flash('message', "Opps! Something went wrong please try again!");
                \Session::flash('alert-class', 'alert-danger');
                return redirect()->back()->withInput($r->all());
            }
            
            $changed_data_from = $this->taskRelations($task);
            $status_from = isset($task->getStatus)?$task->getStatus->status_name:'OPEN';
            
            $task->task_uid = $task->task_uid;
            $task->id_technician = $r->id_technician;
            $task->id_task_type = $task->id_task_type;
            $task->id_status = $r->id_status;
            $task->id_category = $r->id_category;
            $task->id_sub_category = $r->id_sub_category;
            $task->id_item = $r->id_item;
            $task->status_read = 1 ; 
            $task->description = $r->description;
            $task->subject = $r->subject;
            $id_region = $r->id_region;
            if(!$r->id_region){
                $site = Site::where('site_id', $r->id_site_a)->first();
                $id_region = $site->region_id;
            }
            $task->id_region = $id_region;
            $task->id_location_a = $r->id_location_a;
            $task->id_site_a = $r->id_site_a;
            $task->created_by = $task->created_by;
            $task->updated_by = $user->id;
            
            $attachment = $task->attachment;
            if($r->file('attachment')){
                $file = $r->file('attachment');
                $file->move(public_path().'/task_attachment', $file->getClientOriginalName());
                $attachment = $file->getClientOriginalName();
            }
            $task->attachment = $attachment;
            $task->save();
            
            
            $task_detail->id_task_type = $task->id_task_type;
            $task_detail->id_task = $task->id_task;
            $task_detail->checklist_periode = $r->checklist_periode;
            $task_detail->id_checklist_category = json_encode($r->id_checklist_category);
            $task_detail->request_start_time = $r->request_start_time;
            $task_detail->request_complete_time = $r->request_complete_time;
            $task_detail->id_mode = $r->id_mode;
            $task_detail->id_impact = $r->id_impact;
            $task_detail->impact_detail = $r->impact_detail;
            $task_detail->id_priority = $r->id_priority;
            $task_detail->id_root_caused = $r->id_root_caused;
            $task_detail->id_asset = $r->id_asset;
            $task_detail->id_site_b = $r->id_site_b;
            $task_detail->id_group_internal = $r->id_group_internal;
            // $task_detail->id_group_customer = $r->id_group_customer;
            $task_detail->id_group_customer = json_encode($r->id_group_customer);
            $task_detail->id_location_b = $r->id_location_b;
            $task_detail->total_hari_kerja = $r->total_hari_kerja;
            $task_detail->total_waktu_kerja = $r->total_waktu_kerja;
            $task_detail->save();
            
            $status_to = \App\Model\Status::where('id_status', $r->id_status)->first();
            $status_to = $status_to->status_name;
            $log = new TaskLog;
            $log->id_task = $task->id_task;
            $log->action = "UPDATE";
            $log->status_from = $status_from;
            $log->status_to = isset($status_to)?$status_to:'OPEN';
            $log->changed_data_from = $changed_data_from;
            $log->changed_data_to = $this->taskRelations($task);
            $log->created_by = $user->id;
            $log->save();
        }
        if($task->id_task_type == 1){
            $task = Task::where('id_task', $task->id_task)->first();
            $detail = $task->getDetail;
            foreach($r->id_group_customer as $key => $val){
                $from = "ihsan@udacoding.com";
                $group_name = 'UNDEFINED';
                $group_customer = false;
                $msg = "TASK - has been UPDATED by $user->name";
                $subject = "Task Update";
                
                if($detail){
                    $group = GroupCustomer::where('id_group', $val)->first();;
                    $group_name = isset($group)?$group->group_name:'-';
                    $group_customer = $group;
                }
                if($group_customer){
                    foreach($group_customer->getUsers as $user){
                        $user_name = $user->name;
                        $user_email = isset($user->email)?$user->email:'mail@mail.com';
                        $data = array('task' => $task,
                                  'msg' => $msg,
                                  'name' => $user_name
                                  );
                        $mail = Mail::send('email.task', $data, function($message) use ($user_name, $user_email, $from, $subject) {
                                    $message->to($user_email, $user_email)->subject($subject);
                                    $message->from($from,"PROM");
                                });
                    }
                }
            }
        }
        $id_status = $task->id_status;
        $this->assignTaskApprovers($task, $id_status, "UPDATED");
        
        $field_parent = $r->field_parent;
        $section_name = $r->section_name;
        $arr_field = $r->arr_field;
        $fields = $r->fields;
        $section_id = $r->section_id;
        if($field_parent && $section_name && $arr_field){
            foreach(TaskAddOnsSection::where('id_task', $task->id_task)->get() as $se){
                foreach(TaskAddOns::where('id_section', $se->id)->get() as $fi){
                    $fi->delete();
                }
                $se->delete();
            }
            
            foreach($section_name as $k => $v){
                $section = new TaskAddOnsSection;
                $section->name = $v;
                $section->section_id = $field_parent[$k];
                $section->id_task = $task->id_task;
                $section->save();
                
                foreach($arr_field as $k_f => $v_f){
                    $arr_field = json_decode($v_f);
                    $parent = $arr_field->parent;
                    
                    if($parent == $field_parent[$k_f]){
                        $field = new TaskAddOns;
                        $field->id_section = $section->id;
                        $field->type = $arr_field->type;
                        $field->field_id = $arr_field->id;
                        $field->name = $arr_field->name;
                        $name = str_replace(' ', '_', $arr_field->name);
                        $field->value = $r->$name;
                        $field->save();
                    }
                }
                
            }
        }
        \Session::flash('message', "Task Updated Successfully!");
        \Session::flash('alert-class', 'alert-success');
        \Session::flash('data', $task);
        return redirect()->to('task');
    }
    public function update_task_schedule(Request $r, $id_task){
        
        $user = Auth::user();
        if(!$user){
            \Session::flash('message', "CSRF FAILED PLEASE RE-LOGIN!");
            \Session::flash('alert-class', 'alert-danger');
            return redirect()->back()->withInput($r->all());
        }
        
        if(true){
            $task = TaskSchedule::where('id_task', $id_task)->first();
            // $task_detail = TaskDetail::where('id_task', $id_task)->first();
            // if(!$task || !$task_detail){
            //     \Session::flash('message', "Opps! Something went wrong please try again!");
            //     \Session::flash('alert-class', 'alert-danger');
            //     return redirect()->back()->withInput($r->all());
            // }
            
            $changed_data_from = $this->taskRelations($task);
            $status_from = isset($task->getStatus)?$task->getStatus->status_name:'OPEN';
            
            $task->task_uid = $task->task_uid;
            $task->id_technician = $r->id_technician;
            $task->id_task_type = $task->id_task_type;
            $task->id_status = $r->id_status;
            $task->id_category = $r->id_category;
            $task->id_sub_category = $r->id_sub_category;
            $task->id_item = $r->id_item;
            $task->status_read = 0 ; 
            $task->description = $r->description;
            $task->subject = $r->subject;
            $id_region = $r->id_region;
            if(!$r->id_region){
                $site = Site::where('site_id', $r->id_site_a)->first();
                $id_region = $site->region_id;
            }
            $task->id_region = $id_region;
            $task->id_location_a = $r->id_location_a;
            $task->id_site_a = $r->id_site_a;
            $task->created_by = $task->created_by;
            $task->updated_by = $user->id;

            $clocks = $r->jam.':'.$r->menit;
            
            $task->frequency = $r->selectFrequency;
            $task->jam = $r->jam;
            $task->menit = $r->menit;
            $task->clock = $clocks;
            $task->waktus = $r->jadwalku;
            // $task->menit = $r->menit;
            $task->hari = $r->hari;
            $task->tanggal = $r->tanggal;
            
            $attachment = $task->attachment;
            if($r->file('attachment')){
                $file = $r->file('attachment');
                $file->move(public_path().'/task_attachment', $file->getClientOriginalName());
                $attachment = $file->getClientOriginalName();
            }
            $task->attachment = $attachment;
            $task->checklist_periode = $r->checklist_periode;
            $task->id_checklist_category = json_encode($r->id_checklist_category);
            $task->save();
            
            
            // $task_detail->id_task_type = $task->id_task_type;
            // $task_detail->id_task = $task->id_task;
            // $task_detail->checklist_periode = $r->checklist_periode;
            // $task_detail->id_checklist_category = json_encode($r->id_checklist_category);
            // $task_detail->request_start_time = $r->request_start_time;
            // $task_detail->request_complete_time = $r->request_complete_time;
            // $task_detail->id_mode = $r->id_mode;
            // $task_detail->id_impact = $r->id_impact;
            // $task_detail->impact_detail = $r->impact_detail;
            // $task_detail->id_priority = $r->id_priority;
            // $task_detail->id_root_caused = $r->id_root_caused;
            // $task_detail->id_asset = $r->id_asset;
            // $task_detail->id_site_b = $r->id_site_b;
            // $task_detail->id_group_internal = $r->id_group_internal;
            // // $task_detail->id_group_customer = $r->id_group_customer;
            // $task_detail->id_group_customer = json_encode($r->id_group_customer);
            // $task_detail->id_location_b = $r->id_location_b;
            // $task_detail->total_hari_kerja = $r->total_hari_kerja;
            // $task_detail->total_waktu_kerja = $r->total_waktu_kerja;
            // $task_detail->save();
            
            // $status_to = \App\Model\Status::where('id_status', $r->id_status)->first();
            // $status_to = $status_to->status_name;
            // $log = new TaskLog;
            // $log->id_task = $task->id_task;
            // $log->action = "UPDATE";
            // $log->status_from = $status_from;
            // $log->status_to = isset($status_to)?$status_to:'OPEN';
            // $log->changed_data_from = $changed_data_from;
            // $log->changed_data_to = $this->taskRelations($task);
            // $log->created_by = $user->id;
            // $log->save();
        }
        // if($task->id_task_type == 1){
        //     $task = Task::where('id_task', $task->id_task)->first();
        //     $detail = $task->getDetail;
        //     foreach($r->id_group_customer as $key => $val){
        //         $from = "ihsan@udacoding.com";
        //         $group_name = 'UNDEFINED';
        //         $group_customer = false;
        //         $msg = "TASK - has been UPDATED by $user->name";
        //         $subject = "Task Update";
                
        //         if($detail){
        //             $group = GroupCustomer::where('id_group', $val)->first();;
        //             $group_name = isset($group)?$group->group_name:'-';
        //             $group_customer = $group;
        //         }
        //         if($group_customer){
        //             foreach($group_customer->getUsers as $user){
        //                 $user_name = $user->name;
        //                 $user_email = isset($user->email)?$user->email:'mail@mail.com';
        //                 $data = array('task' => $task,
        //                           'msg' => $msg,
        //                           'name' => $user_name
        //                           );
        //                 $mail = Mail::send('email.task', $data, function($message) use ($user_name, $user_email, $from, $subject) {
        //                             $message->to($user_email, $user_email)->subject($subject);
        //                             $message->from($from,"PROM");
        //                         });
        //             }
        //         }
        //     }
        // }
        // $id_status = $task->id_status;
        // $this->assignTaskApprovers($task, $id_status, "UPDATED");
        
        // $field_parent = $r->field_parent;
        // $section_name = $r->section_name;
        // $arr_field = $r->arr_field;
        // $fields = $r->fields;
        // $section_id = $r->section_id;
        // if($field_parent && $section_name && $arr_field){
        //     foreach(TaskAddOnsSection::where('id_task', $task->id_task)->get() as $se){
        //         foreach(TaskAddOns::where('id_section', $se->id)->get() as $fi){
        //             $fi->delete();
        //         }
        //         $se->delete();
        //     }
            
        //     foreach($section_name as $k => $v){
        //         $section = new TaskAddOnsSection;
        //         $section->name = $v;
        //         $section->section_id = $field_parent[$k];
        //         $section->id_task = $task->id_task;
        //         $section->save();
                
        //         foreach($arr_field as $k_f => $v_f){
        //             $arr_field = json_decode($v_f);
        //             $parent = $arr_field->parent;
                    
        //             if($parent == $field_parent[$k_f]){
        //                 $field = new TaskAddOns;
        //                 $field->id_section = $section->id;
        //                 $field->type = $arr_field->type;
        //                 $field->field_id = $arr_field->id;
        //                 $field->name = $arr_field->name;
        //                 $name = str_replace(' ', '_', $arr_field->name);
        //                 $field->value = $r->$name;
        //                 $field->save();
        //             }
        //         }
                
        //     }
        // }
        \Session::flash('message', "Task Updated Successfully!");
        \Session::flash('alert-class', 'alert-success');
        \Session::flash('data', $task);
        return redirect()->to('task/task_schedule');
    }
    
    public function update_task_api(Request $r, $id_task){
        $result = [];
        $result["status"] = false;
        $result["message"] = "";
        $result["newtoken"] = csrf_token();
        
        $user = Auth::user();
        if(!$user){
            $result["message"] = "CSRF FAILED PLEASE RE-LOGIN!";
            return response($result);
        }
        
        $task = Task::where('id_task', $id_task)->first();
        $task_detail = TaskDetail::where('id_task', $id_task)->first();
        if(!$task || !$task_detail){
            $result["message"] = "Opps! Something went wrong please try again!";
            return response($result);
        }
        
        $task->description = $r->get('description', $task->description);
        $task->save();
        
        // $image_before = $task->image_before;
        
        $r_image_befores = $r->image_before;
        foreach($r_image_befores as $b_key => $r_image_before){
           // if($r_image_before){
                $file = $r_image_before;
                $image_before = 'IMAGE_BEFORE'.md5(time()) . '.' .$file->getClientOriginalName();
                $file->move(public_path().'/task_report', $image_before);
                $this->newImages($task->id_task,$r->latitude,$r->longitude,$r->name_place, $image_before, "BEFORE");
           // }
        }
        
       // $image_after = $task->image_after;
        $r_image_afters = $r->image_after;
        foreach($r_image_afters as $a_key => $r_image_after){
          //  if($r_image_after){
                $fileAfter = $r_image_after;
                $image_after =  'IMAGE_AFTER'.md5(time()) . '.' .$fileAfter->getClientOriginalName();
                $fileAfter->move(public_path().'/task_report', $image_after);
                $this->newImages($task->id_task,$r->latitude,$r->longitude,$r->name_place, $image_after, "AFTER");
           // }
        }
        // $task_detail->save();
        
        $task->getDetail;
        $task->getImages;
        
        
        $result["status"] = true;
        $result["message"] = "Updated Successfully";
        $result["data"] = $task;
        return response($result);
    }
    //old
    // public function image_before_after(Request $r, $id_task){
    //     $user = Auth::user();
    //     if(!$user){
    //         \Session::flash('message', "CSRF FAILED PLEASE RE-LOGIN!");
    //         \Session::flash('alert-class', 'alert-danger');
    //         return redirect()->back();
    //     }
        
    //     $task = Task::where('id_task', $id_task)->first();
    //     $task_detail = TaskDetail::where('id_task', $id_task)->first();
    //     if(!$task || !$task_detail){
    //         \Session::flash('message', "Opps! Something went wrong please try again!");
    //         \Session::flash('alert-class', 'alert-info');
    //         return redirect()->back();
    //     }
        
    //     // $task->description = $r->get('description', $task->description);
    //     // $task->save();
    //     // return $r->all();
    //     $r_image_befores = $r->file('image_before');
    //     if(is_array($r_image_befores)){
    //         foreach($r_image_befores as $b_key => $r_image_before){
    //             if($r_image_before){
    //                 $file = $r_image_before;
    //                 $image_before = "IMAGE_BEFORE:$b_key-$task->task_uid" . md5(time()) . '.' .$file->getClientOriginalExtension();
    //                 $file->move(public_path().'/task_report', $image_before);
    //                 $this->newImages($task->id_task, $image_before, "BEFORE");
    //             }
    //         }
    //     }
        
    //     $r_image_afters = $r->file('image_after');
    //     if(is_array($r_image_afters)){
    //         foreach($r_image_afters as $a_key => $r_image_after){
    //             if($r_image_after){
    //                 $file = $r_image_after;
    //                 $image_after = "IMAGE_AFTER:$a_key-$task->task_uid" . md5(time()) . '.' .$file->getClientOriginalExtension();
    //                 $file->move(public_path().'/task_report', $image_after);
    //                 $this->newImages($task->id_task, $image_after, "AFTER");
    //             }
    //         }
    //     }
        
    //     \Session::flash('message', "Uploaded Successfully");
    //     \Session::flash('alert-class', 'alert-success');
    //     return redirect()->back();
    // }
    public function image_before_after(Request $r, $id_task){
        $user = Auth::user();
        if(!$user){
            \Session::flash('message', "CSRF FAILED PLEASE RE-LOGIN!");
            \Session::flash('alert-class', 'alert-danger');
            return redirect()->back();
        }
        
        $task = Task::where('id_task', $id_task)->first();
        $task_detail = TaskDetail::where('id_task', $id_task)->first();
        if(!$task || !$task_detail){
            \Session::flash('message', "Opps! Something went wrong please try again!");
            \Session::flash('alert-class', 'alert-info');
            return redirect()->back();
        }
        
        // $task->description = $r->get('description', $task->description);
        // $task->save();
        // return $r->all();
        $r_image_befores = $r->file('image_before');
        if(is_array($r_image_befores)){
            foreach($r_image_befores as $b_key => $r_image_before){
                if($r_image_before){
                    $file = $r_image_before;
                    $image_before = "IMAGE_BEFORE:$b_key-$task->task_uid" . md5(time()) . '.' .$file->getClientOriginalExtension();
                    $file->move(public_path().'/task_report', $image_before);
                    $this->newImages($task->id_task, $image_before, "BEFORE");
                }
            }
        }
        
        $r_image_afters = $r->file('image_after');
        if(is_array($r_image_afters)){
            foreach($r_image_afters as $a_key => $r_image_after){
                if($r_image_after){
                    $file = $r_image_after;
                    $image_after = "IMAGE_AFTER:$a_key-$task->task_uid" . md5(time()) . '.' .$file->getClientOriginalExtension();
                    $file->move(public_path().'/task_report', $image_after);
                    $this->newImages($task->id_task, $image_after, "AFTER");
                }
            }
        }
        
        \Session::flash('message', "Uploaded Successfully");
        \Session::flash('alert-class', 'alert-success');
        return redirect()->back();
    }
    
    public function remove_image(Request $r, $id_image){
        $user = Auth::user();
        if(!$user){
            \Session::flash('message', "CSRF FAILED PLEASE RE-LOGIN!");
            \Session::flash('alert-class', 'alert-danger');
            return redirect()->back();
        }
        
        $i = TaskImages::where('id', $id_image)->first();
        if(!$i){
            \Session::flash('message', "Opps! Something went wrong please try again!");
            \Session::flash('alert-class', 'alert-info');
            return redirect()->back();
        }
        $i->delete();
        
        \Session::flash('message', "Deleted Successfully");
        \Session::flash('alert-class', 'alert-success');
        return redirect()->back();
    }
    
    public function submit_task_checklist(Request $r, $id_task){
        // return $r->all();
        $task = Task::where('id_task', $id_task)->first();
        if(!$task){
            \Session::flash('message', "Opps! Something went wrong please try again!");
            \Session::flash('alert-class', 'alert-info');
            return redirect()->back();
        }
        if($task->id_task_type != 2){
            \Session::flash('message', "Required PM Type TASK to continue!");
            \Session::flash('alert-class', 'alert-info');
            return redirect()->back();
        }
        $user = Auth::user();  
        if(!$user){
            \Session::flash('message', "CSRF FAILED PLEASE RE-LOGIN!");
            \Session::flash('alert-class', 'alert-info');
            return redirect()->back();   
        }
        
        $r_checklist = $r->checklist;
        if(!$r_checklist){
            \Session::flash('message', "Cheklist Required!");
            \Session::flash('alert-class', 'alert-info');
            return redirect()->back();
        }
        $is_available = $r->is_available;
        if(!$is_available){
            \Session::flash('message', "Is Available Required!");
            \Session::flash('alert-class', 'alert-info');
            return redirect()->back();
        }
        $answers = $r->answers;
        if(!$answers){
            \Session::flash('message', "Answers Required!");
            \Session::flash('alert-class', 'alert-info');
            return redirect()->back();
        }
        
        if(!is_array($r_checklist)) $r_checklist = json_decode($r_checklist);
        if(!is_array($is_available)) $is_available = json_decode($is_available);
        if(!is_array($answers)) $answers = json_decode($answers);
        $checklist = [];
        
        foreach($r_checklist as $key => $val){
            // where('checklist_periode', $id_periode)
            //                   ->where('id_checklist_category', $id_checklist_category)
            //                   ->where('id_region', $id_region)
            
            $check = Checklist::where('id_checklist', $val)->first();
            if($check){
                $c = new Checklist;
                $c->id_checklist = $check->id_checklist;
                $c->checklist_name = $check->checklist_name;
                $c->periode = isset($check->periode)?$check->periode->periode_name:'';
                $c->category = isset($check->category)?$check->category->category_name:'';
                $c->region = isset($check->region)?$check->region->region_name:'';
                $c->is_avaiable = $is_available[$key];
                $c->answer = $answers[$key];
                
                $image = 'default.png';
                $images[] = $r->image;
                
                $file = getIndex($r->file('image'), $key, '');
                if($file){
                    $image = "CHECKLIST_IMAGE-" . md5(time()) . '.' .$file->getClientOriginalExtension();
                    $file->move(public_path().'/checklist_image', $image);
                }
                $c->image = $image;
                
                $checklist[] = $c;
            }
            
        }
        
        $answer = ChecklistAnswer::where('id_task', $task->id_task)->first();
        if(!$answer){
            $answer = new ChecklistAnswer;
        }
        $answer->id_task = $task->id_task;
        $answer->datas = json_encode($checklist);
        $answer->save();
        
        \Session::flash('message', "Submitted Succssfully!");
        \Session::flash('alert-class', 'alert-success');
        return redirect()->back();
    }
    
    function getChecklistAnswer(Request $r){
        
         $result = [];
        $result["status"] = false;
        $result["message"] = "";
        
        $answer = ChecklistAnswer::where('id_task', $r->id_task)->first();
        
        
        if(!empty($answer)){
         
        $result["status"] = true;
        $result["message"] = "data ada";
        $answer->datas = json_decode($answer->datas);
        $result["data"] = $answer;
        
        }
        else{
        $result["status"] = false;
        $result["message"] = "data tidak ada";
            
        }
        
        return response()->json($result);
        
        
        
        
        
        
        
    }

     function getImageBeforeAfter(Request $r){

        $id = $r->id_task ;

        if(!$id){

              $result["status"] = false;
              $result["message"] = "id task data tidak ada";

              return response()->json($result);

        }

        $taskImage = TaskImages::where('id_task',$id)->get();

        if($taskImage){
          
            $result["data"] = $taskImage ;
            $result["status"] = true;
            $result["message"] = "Successfully for data photo image before";

              return response()->json($result);

        }
        else{

              $result["status"] = false;
              $result["message"] = " data tidak ada";

              return response()->json($result);

        }


    }

    function deleteImageBeforeAfter(Request $r){

        $id = $r->id_image ;

        if(!$id){

              $result["status"] = false;
              $result["message"] = "id data tidak ada";

              return response()->json($result);

        }

        $taskImage = TaskImages::where('id',$id)->first();

        if($taskImage){
            $taskImage->delete();

            $result["status"] = true;
              $result["message"] = "Successfully for deleted";

              return response()->json($result);

        }
        else{

              $result["status"] = false;
              $result["message"] = " data tidak ada";

              return response()->json($result);

        }


    }
    
    function newImages($id_task,$latitude,$longitude,$place, $image_name, $type){
        $i = new TaskImages;
        $i->id_task = $id_task;
        $i->type = $type;
        $i->image = $image_name;
        $i->latitude = $latitude ;
        $i->longitude = $longitude ;
        $i->name_place = $place ;
        $i->save();
    }
     function newImagesBefore($id_task,$latitude,$longitude,$place, $image_name, $type){
        $i = new TaskImages;
        $i->id_task = $id_task;
        $i->type = $type;
        $i->image = $image_name;
        $i->latitude = $latitude ;
        $i->longitude = $longitude ;
        $i->name_place = $place ;
        $i->save();
    }
    
    public function taskRelations($task){
        $t = new Task;
        $t->Task_UID = $task->task_uid;
        $t->Task_Type = isset($task->getType)?$task->getType->type_name:'-';
        $t->Status = isset($task->getStatus)?$task->getStatus->status_name:'-';
        $t->Subject = $task->subject;
        $t->Description = $task->description;
        $t->Category = isset($task->getCategory)?$task->getCategory->category_name:'-';
        $t->Sub_Category = isset($task->getSubCategory)?$task->getSubCategory->sub_category_name:'-';
        $t->Item = isset($task->getItem)?$task->getItem->item_name:'-';
        $t->Time_Receive = $task->time_receive;
        $t->Time_Depart = $task->time_depart;
        $t->Time_Arrived = $task->time_arrived;
        $t->Time_Complete = $task->time_complete;
        $t->Region = isset($task->getRegion)?$task->getRegion->region_name:'-';
        $t->Location_A = isset($task->getLocationA)?$task->getLocationA->segment_name:'-';
        $t->Site = isset($task->getSite)?$task->getSite->name_site:'-';
        $t->Attachment = $task->attachment;
        $t->Created_By = isset($task->creator)?$task->creator->name:'-';
        
        $task_detail = $task->getDetail;
        $t->Priority = isset($task_detail->getPriority)?$task_detail->getPriority->priority_name:'-';
        $t->Impact = isset($task_detail->getImpact)?$task_detail->getImpact->impact_name:'-';
        $t->Impact_detail = isset($task_detail->impact_detail)?$task_detail->impact_detail:'-';
        return $t;
    }
    
    public function detail($id_task){
        $task_status_read = Task::where('id_task', $id_task)->first();
        $task_status_read->status_read  = 0;
        $task_status_read->save();
        $task = Task::where('id_task', $id_task)->first();
        if(!$task){
            \Session::flash('message', 'Oppss! Something went wrong please reload and try again!');
            \Session::flash('alert-class', 'alert-danger');
            return \Redirect::to('task');
        }
        $task->sub_category_name = $task->getSubCategory?$task->getSubCategory->sub_category_name:'-';
        $task->item_name = $task->getItem?$task->getItem->item_name:'-';
        $task_detail = $task->getDetail;
        
        $mtask = Task::where('id_task',$id_task)->first();
        $mtask->status_read = 0 ;
        $mtask->save();
        $after = TaskImages::where('id_task', $id_task)->where('type', '=', 'AFTER')->get();
        // dd($after);
        $before = TaskImages::where('id_task', $id_task)->where('type', '=', 'BEFORE')->get();
        
        $id_template = $task->id_task_type;
        switch($id_template){
            case 2:
                $id_template = 2;
                $task_type = 'task.pmTask';
                break;
            case 3:
                $id_template = 3;
                $task_type = 'task.crTask';
                break;
            case 4 : 
                $id_tempate = 4 ;
                $task_type = 'task.plmTask';
                break;
            default:
                $id_template = 1;
                $task_type = 'task.cmTask';
        }
        
        $user = Auth::user();
        $technician = Technician::where('user_id', $user->id)->first();
        
        $add_ons = \App\TaskAddOnsSection::where('id_task', $task->id_task)->get();
        
        $next_status = false;
        $next_status_name = '';
        $status = $task->id_status;
        switch($status){
            case '1':
                $next_status = '2';
                $next_status_name = 'ACCEPT';
                break;
            case '2':
                $next_status = '3';
                $next_status_name = 'DEPART';
                break;
            case '3':
                $next_status = '4';
                $next_status_name = 'ARRIVED';
                break;
            case '4':
                $next_status = '5';
                $next_status_name = 'IN PROGRESS';
                break;
            // case '5':
            //     $next_status = '6';
            //     $next_status_name = 'RESOLVED';
            //     break;
            default:
                $next_status = false;
        }
        
        return view('task.detail', compact('task','task_detail', 'task_type','id_template', 'technician', 'add_ons', 'next_status', 'next_status_name', 'after', 'before'));
    }

    public function detail_schedule($id_task){
        $task = TaskSchedule::where('id_task', $id_task)->first();
        // dd($task);
        if(!$task){
            \Session::flash('message', 'Oppss! Something went wrong please reload and try again!');
            \Session::flash('alert-class', 'alert-danger');
            return \Redirect::to('task');
        }
        $task->sub_category_name = $task->getSubCategory?$task->getSubCategory->sub_category_name:'-';
        $task->item_name = $task->getItem?$task->getItem->item_name:'-';
        $task_detail = $task->getDetail;
        
        // $mtask = Task::where('id_task',$id_task)->first();
        // $mtask->status_read = 0 ;
        // $mtask->save();
        
        $id_template = $task->id_task_type;
        switch($id_template){
            case 2:
                $id_template = 2;
                $task_type = 'task_schedule.pmTask';
                break;
            case 3:
                $id_template = 3;
                $task_type = 'task.crTask';
                break;
            case 4 : 
                $id_tempate = 4 ;
                $task_type = 'task.plmTask';
                break;
            default:
                $id_template = 1;
                $task_type = 'task.cmTask';
        }
        
        $user = Auth::user();
        $technician = Technician::where('user_id', $user->id)->first();
        
        $add_ons = \App\TaskAddOnsSection::where('id_task', $task->id_task)->get();
        
        $next_status = false;
        $next_status_name = '';
        $status = $task->id_status;
        switch($status){
            case '1':
                $next_status = '2';
                $next_status_name = 'ACCEPT';
                break;
            case '2':
                $next_status = '3';
                $next_status_name = 'DEPART';
                break;
            case '3':
                $next_status = '4';
                $next_status_name = 'ARRIVED';
                break;
            case '4':
                $next_status = '5';
                $next_status_name = 'IN PROGRESS';
                break;
            // case '5':
            //     $next_status = '6';
            //     $next_status_name = 'RESOLVED';
            //     break;
            default:
                $next_status = false;
        }
        
        return view('task_schedule.detail_sche', compact('task','task_detail', 'task_type','id_template', 'technician', 'add_ons', 'next_status', 'next_status_name'));
    }
    
    public function update_status(Request $r, $id_task){
        $result = [];
        $result["status"] = false;
        $result["message"] = "";
        $result["newtoken"] = csrf_token();
        
        $task = Task::where('id_task', $id_task)->first();
        
        $mtask = Task::where('id_task', $id_task)->first();
        
        $mtask->status_read = 1 ;
        $mtask->save();
        
        
        $id_status = $task->id_status;
        if(!$task){ $result["message"] = "Task does not exist!";return response($result);   }
        $id_status = $r->id_status;
        if($id_status == "WAITING_APPROVAL"){    $result["message"] = "Waiting for admin approval!"; return response($result);   }
        if(!$id_status){    $result["message"] = "Status is required!"; return response($result);   }
        $status = Status::where('id_status', $id_status)->first();
        if(!$status){   $result["message"] = "Status does not exist!";  return response($result);   }
        
     
        $this->assignTaskApprovers($task, $id_status, "UPDATE_STATUS", $status->status_name);
        if($id_status == 2 ){
            $now = date('Y-m-d H:i:s');
            $datetime1 = new DateTime($task->created_at);
            $datetime2 = new DateTime($now);
            $interval = $datetime1->diff($datetime2);


            $task->resolved_at = $now;
            $resolved_time = "";
            if($interval->format('%y')) $resolved_time = $resolved_time. $interval->format('%y')." Year(s) ";
            if($interval->format('%m')) $resolved_time = $resolved_time. $interval->format('%m')." Month(s) ";
            if($interval->format('%d')) $resolved_time = $resolved_time. $interval->format('%d')." Day(s) ";
            $resolved_time = $resolved_time. $interval->format('%h')." Hours ".$interval->format('%i')." Minutes";
            $task->resolved_time = $resolved_time;
        }
        else if($id_status == 14 || $id_status == 27){

             $now = date('Y-m-d H:i:s');
              $task->resolved_at = $now;



        }
        
        $task->id_Status = $id_status;
      
        $task->save();
        $status = \App\Model\Status::where('id_status', $id_status)->first();
        $task->task_status = $status->status_name;
        
        $d = Task::where('id_task', $task->id_task)->first();
        $d->task_status = isset($d->getStatus)?$d->getStatus->status_name:'';
        $d->task_color = isset($d->getStatus)?$d->getStatus->color:'';
        $d->site_name = isset($d->getSite)?$d->getSite->name_site:'';
        $d->getType;
        $d->getCategory;
        $d->getSubCategory;
        $d->getItem;
        $d->getRegion;
        $d->getLocationA;
        $detail = $d->getDetail;
        $detail->getPriority;
        $detail->getImpact;
        
        $log = new TaskLog;
        $log->id_task = $d->id_task;
        $log->action = $status->status_name;
        $log->status_to = $d->task_status;
        $log->changed_data_to = $this->taskRelations($d);
        $log->created_by = Auth::user()->id;
        $log->save();
        
        $result["status"] = true;
        $result["message"] = "Task Status Updated Successfully";
        $result["data"] = $d;
        return response($result);
    }
    
    public function assignTaskApprovers($task, $id_status, $type, $status_name = ''){
        $assign = false;
        
        
        
        
     //   return json_encode($id_status);
        if($type == "UPDATE_STATUS") $assign = true;
        if($type == "UPDATE_CIR") $assign = true ;
        if($task->id_task_type == 1 ){
        if($id_status == 3) {
        if($type == "UPDATE_CIR"){
            if($task->id_task_type != 3){
                $cekApproval = TaskApproval::where('id_task', $task->id_task)->first();
                if($cekApproval){
                    $approvers = TaskApproval::where('id_task', $task->id_task)->get();
                    foreach($approvers as $as){
                        $as->delete();
                    }
                }
                $approver = Approver::where('id_task_type', $task->id_task_type)->where('id_region', $task->id_region)->first();
                if($approver){
                    $task->id_approver = $approver->id_approver;
                    $approver_detail_all = ApproverDetail::where('id_approver', $approver->id_approver)->get();
                    foreach($approver_detail_all as $ad){
                        $task_approval = new TaskApproval;
                        $task_approval->id_task = $task->id_task;
                        $task_approval->user_id = $ad->user_id;
                        $task_approval->layer = $ad->layer;
                        $task_approval->status = "RESOLVED";
                        $task_approval->note = "";
                        $task_approval->save();
                    }
                    
                    $ad = $approver_detail_all->first();
                    $user =  $ad->user;
                    if($task){
                        $detail = $task->getDetail;
                        $from = "ihsan@udacoding.com";
                        $msg = "TASK APPROVAL - New RESOLVED Task require your Approval";
                        $subject = "Task Approval";
                        
                        $user_name = $user->name;
                        $user_email = isset($user->email)?$user->email:'mail@mail.com';
                        $data = array('task' => $task,
                                  'msg' => $msg,
                                  'name' => $user_name
                                  );
                        // $mail = Mail::send('email.task', $data, function($message) use ($user_name, $user_email, $from, $subject) {
                        //             $message->to($user_email, $user_email)->subject($subject);
                        //             $message->from($from,"PROM");
                        //         });
                    }
                    if($user){
                        $tokens = [$user->firebase_token, $user->firebase_token_web];
                        if($tokens){
                            if($type == "UPDATE_STATUS") $type = "UPDATED";
                            if($status_name){
                                $status_name = "updated to $status_name!";
                            }else{
                                $status_name = "updated!";
                            } 
                            sendTaskNotif($task, $tokens, "Update Task has been $type", "Task#$task->task_uid has been $status_name");
                        } 
                    }
                }
            }
        
        }
        else{
             // firebase notif
        if($task->id_task_type != 3){
            $technician =  $task->getTechnician;
            $user = null;
            $tokens = null;
            if($technician) $user = $technician->user;
            if($user) $tokens = [$user->firebase_token_web, $user->firebase_token];
            
            
            // $tokens = addAdminTokens($tokens);
            // $tokens = removeSender($tokens);
           //  return $tokens;
            sendTaskNotif($task, $tokens, 'Upload CIR', "Need file CIR forward for validator");
        }
            
            
        }
        }
    
       
    }
     else if ($task->id_task_type == 2){
             if($assign){
            if($task->id_task_type != 3){
                $cekApproval = TaskApproval::where('id_task', $task->id_task)->first();
                if($cekApproval){
                    $approvers = TaskApproval::where('id_task', $task->id_task)->get();
                    foreach($approvers as $as){
                        $as->delete();
                    }
                }
                $approver = Approver::where('id_task_type', $task->id_task_type)->where('id_region', $task->id_region)->first();
                if($approver){
                    $task->id_approver = $approver->id_approver;
                    $approver_detail_all = ApproverDetail::where('id_approver', $approver->id_approver)->get();
                    foreach($approver_detail_all as $ad){
                        $task_approval = new TaskApproval;
                        $task_approval->id_task = $task->id_task;
                        $task_approval->user_id = $ad->user_id;
                        $task_approval->layer = $ad->layer;
                        $task_approval->status = "RESOLVED";
                        $task_approval->note = "";
                        $task_approval->save();
                    }
                    
                    $ad = $approver_detail_all->first();
                    $user =  $ad->user;
                    if($task){
                        $detail = $task->getDetail;
                        $from = "ihsan@udacoding.com";
                        $msg = "TASK APPROVAL - New RESOLVED Task require your Approval";
                        $subject = "Task Approval";
                        
                        $user_name = $user->name;
                        $user_email = isset($user->email)?$user->email:'mail@mail.com';
                        $data = array('task' => $task,
                                  'msg' => $msg,
                                  'name' => $user_name
                                  );
                        $mail = Mail::send('email.task', $data, function($message) use ($user_name, $user_email, $from, $subject) {
                                    $message->to($user_email, $user_email)->subject($subject);
                                    $message->from($from,"PROM");
                                });
                    }
                    if($user){
                        $tokens = [$user->firebase_token, $user->firebase_token_web];
                        if($tokens){
                            if($type == "UPDATE_STATUS") $type = "UPDATED";
                            if($status_name){
                                $status_name = "updated to $status_name!";
                            }else{
                                $status_name = "updated!";
                            } 
                            sendTaskNotif($task, $tokens, "Update Task has been $type", "Task#$task->task_uid has been $status_name");
                        } 
                    }
                }
            }
        }
            
        }
       else  if ($task->id_task_type == 4){
             if($assign){
            if($task->id_task_type != 3){
                $cekApproval = TaskApproval::where('id_task', $task->id_task)->first();
                if($cekApproval){
                    $approvers = TaskApproval::where('id_task', $task->id_task)->get();
                    foreach($approvers as $as){
                        $as->delete();
                    }
                }
                $approver = Approver::where('id_task_type', $task->id_task_type)->where('id_region', $task->id_region)->first();
                if($approver){
                    $task->id_approver = $approver->id_approver;
                    $approver_detail_all = ApproverDetail::where('id_approver', $approver->id_approver)->get();
                    foreach($approver_detail_all as $ad){
                        $task_approval = new TaskApproval;
                        $task_approval->id_task = $task->id_task;
                        $task_approval->user_id = $ad->user_id;
                        $task_approval->layer = $ad->layer;
                        $task_approval->status = "RESOLVED";
                        $task_approval->note = "";
                        $task_approval->save();
                    }
                    
                    $ad = $approver_detail_all->first();
                    $user =  $ad->user;
                    if($task){
                        $detail = $task->getDetail;
                        $from = "ihsan@udacoding.com";
                        $msg = "TASK APPROVAL - New RESOLVED Task require your Approval";
                        $subject = "Task Approval";
                        
                        $user_name = $user->name;
                        $user_email = isset($user->email)?$user->email:'mail@mail.com';
                        $data = array('task' => $task,
                                  'msg' => $msg,
                                  'name' => $user_name
                                  );
                        $mail = Mail::send('email.task', $data, function($message) use ($user_name, $user_email, $from, $subject) {
                                    $message->to($user_email, $user_email)->subject($subject);
                                    $message->from($from,"PROM");
                                });
                    }
                    if($user){
                        $tokens = [$user->firebase_token, $user->firebase_token_web];
                        if($tokens){
                            if($type == "UPDATE_STATUS") $type = "UPDATED";
                            if($status_name){
                                $status_name = "updated to $status_name!";
                            }else{
                                $status_name = "updated!";
                            } 
                            sendTaskNotif($task, $tokens, "Update Task has been $type", "Task#$task->task_uid has been $status_name");
                        } 
                    }
                }
            }
        }
            
        }
}

}