<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \App\Model\Task;
use \App\Model\TaskDetail;
use \App\Model\TaskLog;
use \App\Model\TaskApproval;
use \App\Model\Status;
use \App\Model\Approver;
use \App\Model\ApproverDetail;
use \App\Model\Aktivasi;
use \App\Model\AktivasiApproval;
use \App\Model\SiteEntry;
use \App\Model\SiteEntryLog;
use \App\Model\SiteEntryApprover;
use \App\Model\PermitLetter;
use \App\Model\PermitLetterDetail;
use \Auth;
use \Mail;
use \App\Templates;
use \App\TemplatesDefaultValue;

class WaitingApprovalController extends Controller
{
    public function index()
    {
        $data['title'] = 'Task';
        $types = \App\Model\TaskType::get();
        return view('waiting.index', compact('types'));
    }
    public function getData(Request $r)
    {
       $columns = $r->columns;
        // $order = $r->order;
        //dd($order);
        $order = $r?$r->order:'';
        //dd($order);
        if ($order) {
            $order = $order[0];
            $column = $order['column'];
            $column = $columns[$column];
            $orderBy = $column['data'];
            $order_dir = $order['dir'];

            $data = Task::orderBy($orderBy, $order_dir);
        } else {
            $orderBy = false;
            $data = Task::orderBy('tb_task.id_task', 'ASC');
        }


        $id_type = $r->id_type;
        if ($id_type) {
            $data = $data->where('tb_task.id_task_type', $id_type);
        }

        $id = $r->id_task;
        if ($id) {
            $data = $data->where('tb_task.id_task', $id);
        }
        $id_technician = $r->id_technician;
        if ($id_technician) {
            $data = $data->where('tb_task.id_technician', $id_technician);
        }

        $id_region = $r->id_region;
        if ($id_region) {
            $data = $data->where('tb_task.id_region', $id_region);
        }

        $user = Auth::user();

        //   if($id_type = 1){
        $data = $data->whereIn('tb_task.id_status', array(3, 18, 17, 29, 30))->where('is_deleted', 0);
        // }
        // else if ($id_type == 2){
        //      $data = $data->where('id_status', 17);
        // }
        // else if($id_type == 4){
        //     $data = $data->where('id_status', 29);
        // }



        $created_at_from = $r->created_at_from;
        $created_at_to = $r->created_at_to;
        if ($created_at_from && $created_at_to) {
            $data = $data->whereBetween('tb_task.created_at', [$created_at_from, $created_at_to]);
        }

        $completion_from = $r->completion_from;
        $completion_to = $r->completion_to;
        if ($completion_from && $completion_to) {
            $data = $data->whereBetween('tb_task.time_complete', [$completion_from, $completion_to]);
        }

        $name = $r->name;
        // dd ($name);
        // dd();
        if (!$name) {
            $name = $r->search ? $r->search['value'] : '';
        }else{
            $name = false;
        }

        if ($name) {
            $data = $data->where(function ($data) use ($name) {
                $data->where('tb_task.subject', 'like', '%' . $name . '%');
            });
        }
        $data = $data->join('tb_task_approval', 'tb_task_approval.id_task', 'tb_task.id_task')
            ->where('tb_task_approval.user_id', $user->id)
            ->where('tb_task_approval.status', 'RESOLVED')
            // ->join('tb_task_approval as prev_approval', 'prev_approval.id_task', 'tb_task.id_task')
            // ->where('prev_approval.user_id', $user->id)
            // ->where('prev_approval.status', '!=', 'RESOLVED')
            // ->where('prev_approval.id_task_approval', '<', 'tb_task_approval.id_task_approval')
            ->select(
                'tb_task.*',
                'tb_task.id_task as id_task',
                'tb_task_approval.id_task_approval',
                'tb_task_approval.status as status_task_approval',
                // 'prev_approval.status as prev_approval'
            );
        $draw = $r->get('draw', 1);
        $limit = $r->get('length', 10);
        $offset = $r->get('start', 0);
        $timeout = $r->get('timeout', 0);

        $count = $data->count();
        // $data = $data->offset($offset)->limit($limit);
        $data = $data->get();



        $datas = [];
        foreach ($data as $d) {
            // $approval = TaskApproval::where('id_task', $d->id_task)->where('user_id', $user->id)->first();
            if ($d->id_task_approval) {
                $prev = TaskApproval::where('id_task', $d->id_task)
                    ->where('id_task_approval', '<', $d->id_task_approval)
                    ->orderby('id_task_approval', 'desc')
                    ->first();
                if ($prev) {
                    if ($prev->status == "RESOLVED") $d = null;
                }
            } else {
                $d = null;
            }
            if ($d) {
                $d->task_status = isset($d->getStatus) ? $d->getStatus->status_name : '';
                $d->task_color = isset($d->getStatus) ? $d->getStatus->color : '';
                $d->site_name = isset($d->getSite) ? $d->getSite->name_site : '';
                $d->task_technisian = isset($d->getTechnician->name_technician)?$d->getTechnician->name_technician : "";
                if ($id) {
                    $detail = $d->getDetail;
                    $d->getType;
                    $d->getCategory;
                    $d->getSubCategory;
                    $d->getTechnician;
                    $d->getItem;
                    $d->getRegion;
                    $d->getLocationA;
                    $detail->getPriority;
                    $detail->getImpact;
                }
                $d->created_by_name = isset($d->creator) ? $d->creator->name : '';
                $d->updated_by_name = isset($d->updater) ? $d->updater->name : '';
                $datas[] = $d;
            }
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
        if ($orderBy) {
            $result['orderBy'] = $orderBy;
            $result['order_dir'] = $order_dir;
        }
        return response()->json($result);
    }
    public function detail($id_task)
    {
        $task = Task::where('id_task', $id_task)->first();
        if (!$task) {
            \Session::flash('message', 'Oppss! Something went wrong please reload and try again!');
            \Session::flash('alert-class', 'alert-danger');
            return \Redirect::to('waiting_approval');
        }
        $task->sub_category_name = $task->getSubCategory ? $task->getSubCategory->sub_category_name : '-';
        $task->item_name = $task->getItem ? $task->getItem->item_name : '-';
        $task_detail = $task->getDetail;

        $id_template = $task->id_task_type;
        switch ($id_template) {
            case 2:
                $id_template = 2;
                $task_type = 'waiting.pmTask';
                break;
            case 3:
                $id_template = 3;
                $task_type = 'waiting.crTask';
                break;
            case 4:
                $id_tempate = 4;
                $task_type = 'waiting.plmTask';
                break;
            default:
                $id_template = 1;
                $task_type = 'waiting.cmTask';
        }

        return view('waiting.detail', compact('task', 'task_detail', 'task_type', 'id_template'));
    }
    public function approval(Request $r, $id_task)
    {
        $user = Auth::user();
        if (!$user) {
            \Session::flash('message', "CSRF FAILED PLEASE RE-LOGIN!");
            \Session::flash('alert-class', 'alert-danger');
            return redirect()->back()->withInput($r->all());
        }
        $task = Task::where('id_task', $id_task)->first();
        if (!$task) {
            \Session::flash('message', 'Oppss! Something went wrong please reload and try again!');
            \Session::flash('alert-class', 'alert-danger');
            return \Redirect::back();
        }
        if ($task->id_status != 3 && $task->id_task_type == 1) {
            \Session::flash('message', "Task($task->task_uid) has not been RESOLVED yet!");
            \Session::flash('alert-class', 'alert-danger');
            return \Redirect::back();
        }
        // if ($task->id_status != 17 && $task->id_task_type == 2) {
        //     \Session::flash('message', "Task($task->task_uid) has not been Waiting Approval yet!");
        //     \Session::flash('alert-class', 'alert-danger');
        //     return \Redirect::back();
        // }

        // if ($task->id_status != 29 && $task->id_task_type == 4) {
        //     \Session::flash('message', "Task($task->task_uid) has not been Waiting Approval yet!");
        //     \Session::flash('alert-class', 'alert-danger');
        //     return \Redirect::back();
        // }
        $status = $r->approval_status;
        if ($status != "APPROVED") $status = "REJECTED";

        $approval = TaskApproval::where('user_id', $user->id)->where('id_task', $task->id_task)->first();
        if ($approval) {
            $approval->status = $status;
            $approval->note = $r->note;
            $approval->save();

            $log = new TaskLog;
            $log->id_task = $task->id_task;
            $log->action = $status;
            $log->note = $r->note;
            $log->status_to = $task->task_status;
            $log->changed_data_to = $this->taskRelations($task);
            $log->created_by = Auth::user()->id;
            $log->save();
            if ($status == "APPROVED") {
                // $next_approver = TaskApproval::where('user_id', '!=', $user->id)->where('status', 'RECEIVED')->first();
                $next_approver = TaskApproval::where('id_task_approval', '>', $approval->id_task_approval)
                    ->where('id_task', $task->id_task)
                    ->orderby('id_task_approval', 'desc')->first();
                if ($next_approver) {
                    $user =  $next_approver->user;
                    // tambah approved
                    if ($task->id_task_type == 2 && $task->id_status == 17) {
                        $task->id_status = 18;
                        //     $task->time_complete = date('Y-m-d H:i:s');
                        $task->save();
                    } else if ($task->id_task_type == 4 && $task->id_status == 29) {
                        $task->id_status = 30;
                        //     $task->time_complete = date('Y-m-d H:i:s');
                        $task->save();
                    }
                    if ($task) {
                        $detail = $task->getDetail;
                        $from = "ihsan@udacoding.com";
                        $msg = "TASK APPROVAL - New RESOLVED Task require your Approval";
                        $subject = "Task Approval";

                        $user_name = $user->name;
                        $user_email = $user->email;
                        $data = array(
                            'task' => $task,
                            'msg' => $msg,
                            'name' => $user_name
                        );
                        // $mail = Mail::send('email.task', $data, function ($message) use ($user_name, $user_email, $from, $subject) {
                        //     $message->to($user_email, $user_email)->subject($subject);
                        //     $message->from($from, "PROM");
                        // });
                    }
                    if ($user) {
                        $tokens = isset($next_approver->firebase_token) ? $next_approver->firebase_token : 'TOKEN';
                        $notif_task = new \App\Model\Task;
                        $detail = $task->getDetail;
                        $notif_task->id_task = $task->id_task;
                        $notif_task->task_uid = $task->task_uid;
                        $notif_task->subject = $task->subject;
                        $notif_task->description = $task->description;
                        $notif_task->task_status = isset($task->getStatus) ? $task->getStatus->status_name : '';
                        $notif_task->task_color = isset($task->getStatus) ? $task->getStatus->color : '';
                        $notif_task->priority_name = isset($detail->getPriority) ? $detail->getPriority->priority_name : '';
                        $notif_task->region_name = isset($task->getRegion) ? $task->getRegion->region_name : '';
                        $notif_task->impact_name = isset($detail->getImpact) ? $detail->getImpact->impact_name : '';
                        $notif_task->impact_detail = isset($detail->impact_detail) ? $detail->impact_detail : '';
                        $notif_task->category_name = isset($task->getCategory) ? $task->getCategory->category_name : '';
                        $notif_task->created_date = $task->created_at;
                        $notif_notif = sendFirebaseNotif($notif_task, $tokens, 'New RESOLVED Task', "Task under your name has been Updated");
                    }
                } else {

                    if ($task->id_task_type == 1) {
                        $task->id_status = 8;
                    } else if ($task->id_task_type == 2) {
                        $task->id_status = 22;
                        // $task->time_complete = date('Y-m-d H:i:s');
                        // $task->save();
                    } else if ($task->id_task_type == 4) {
                        $task->id_status = 34;
                        // $task->time_complete = date('Y-m-d H:i:s');
                        // $task->save();
                    }
                    $task->time_complete = date('Y-m-d H:i:s');
                    $task->save();

                    $log = new TaskLog;
                    $log->id_task = $task->id_task;
                    $log->action = "APPROVAL";
                    if ($task->id_task_type == 1) {
                        $log->status_to = "CLOSED";
                    } else if ($task->id_task_type == 2) {
                        $log->status_to = "APPROVED";
                    } else if ($task->id_task_type == 4) {

                        $log->status_to = "APPROVED";
                    }

                    $log->changed_data_to = $this->taskRelations($task);
                    $log->created_by = $user->id;
                    $log->save();
                }
            } else {
                if ($task->id_task_type == 1) {
                    $task->id_status = 2;
                } else if ($task->id_task_type == 2) {
                    $task->id_status = 19;
                } else if ($task->id_task_type == 4) {
                    $task->id_status = 31;
                }
                $task->save();
            }
        } else {
            \Session::flash('message', "Your name isn`t assigned as Task($task->task_uid) Approver");
            \Session::flash('alert-class', 'alert-info');
            return \Redirect::to('waiting_approval');
        }

        // fcm web to mobile
        if ($task->id_status == 19 || $task->id_status == 31 || $task->id_task == 38) {
            $technician = $task->technician;
            if ($technician) {
                $user = $technician->user;
                if ($user) {
                    $tokens = [];
                    if ($user->firebase_token) $tokens[] = $user->firebase_token;
                    if ($user->firebase_token_web) $tokens[] = $user->firebase_token_web;
                    if (count($tokens)) {
                        sendTaskNotif($task, $tokens, "Task Telah di UPDATED", "Task#$task->task_uid telah di Rejected. Mohon dicek kembali Task#$task->task_uid");
                        save_notif($task, $tokens, "Update Task", "task has been updated", "UPDATE_TASK");
                    }
                }
            }
        }

        \Session::flash('message', "Task $status Successfully");
        \Session::flash('alert-class', 'alert-success');
        return \Redirect::to('waiting_approval');
    }
    public function approval_api(Request $r, $id_task)
    {
        $result = [];
        $result["status"] = false;
        $result["message"] = "";
        $result["newtoken"] = csrf_token();

        $user = Auth::user();
        if (!$user) {
            $result["message"] = "CSRF FAILED PLEASE RE-LOGIN!";
            return response($result);
        }
        $task = Task::where('id_task', $id_task)->first();
        if (!$task) {
            $result["message"] = "Oppss! Something went wrong please reload and try again!";
            return response($result);
        }
        if ($task->id_status != 3 && $task->id_task_type == 1) {
            $result["message"] = "Task($task->task_uid) has not been RESOLVED yet!";
            return response($result);
        }
        //  if($task->id_status != 17 && $task->id_task_type == 2){
        //     $result["message"] = "Task($task->task_uid) has not been RESOLVED yet!";
        //     return response($result);
        // }
        // if($task->id_status != 18 && $task->id_task_type == 2){
        //     $result["message"] = "Task($task->task_uid) has not been RESOLVED yet!";
        //     return response($result);
        // }
        // if ($task->id_status != 29 && $task->id_task_type == 4) {
        //     $result["message"] = "Task($task->task_uid) has not been RESOLVED yet!";
        //     return response($result);
        // }
        $status = $r->approval_status;
        if ($status != "APPROVED") $status = "REJECTED";

        $approval = TaskApproval::where('user_id', $user->id)->where('id_task', $task->id_task)->first();
        if ($approval) {
            $approval->status = $status;
            $approval->note = $r->note;
            $approval->save();

            $log = new TaskLog;
            $log->id_task = $task->id_task;
            $log->action = $status;
            $log->note = $r->note;
            $log->status_to = $task->task_status;
            $log->changed_data_to = $this->taskRelations($task);
            $log->created_by = Auth::user()->id;
            $log->save();
            if ($status == "APPROVED") {
                // $next_approver = TaskApproval::where('user_id', '!=', $user->id)->where('status', 'RECEIVED')->first();
                $next_approver = TaskApproval::where('id_task_approval', '>', $approval->id_task_approval)
                    ->where('id_task', $task->id_task)
                    ->orderby('id_task_approval', 'desc')->first();





                if ($next_approver) {
                    $user =  $next_approver->user;
                    // tambah approved
                    if ($task->id_task_type == 2 && $task->id_status == 17) {
                        $task->id_status = 18;
                        //     $task->time_complete = date('Y-m-d H:i:s');
                        $task->save();
                    } else if ($task->id_task_type == 4 && $task->id_status == 29) {
                        $task->id_status = 30;
                        //     $task->time_complete = date('Y-m-d H:i:s');
                        $task->save();
                    }



                    if ($task) {
                        $detail = $task->getDetail;
                        $from = "ihsan@udacoding.com";
                        $msg = "TASK APPROVAL - New RESOLVED Task require your Approval";
                        $subject = "Task Approval";

                        $user_name = $user->name;
                        $user_email = $user->email;
                        $data = array(
                            'task' => $task,
                            'msg' => $msg,
                            'name' => $user_name
                        );
                        // $mail = Mail::send('email.task', $data, function ($message) use ($user_name, $user_email, $from, $subject) {
                        //     $message->to($user_email, $user_email)->subject($subject);
                        //     $message->from($from, "PROM");
                        // });
                    }
                    if ($user) {
                        $tokens = isset($next_approver->firebase_token) ? $next_approver->firebase_token : 'TOKEN';
                        $notif_task = new \App\Model\Task;
                        $detail = $task->getDetail;
                        $notif_task->id_task = $task->id_task;
                        $notif_task->task_uid = $task->task_uid;
                        $notif_task->subject = $task->subject;
                        $notif_task->description = $task->description;
                        $notif_task->task_status = isset($task->getStatus) ? $task->getStatus->status_name : '';
                        $notif_task->task_color = isset($task->getStatus) ? $task->getStatus->color : '';
                        $notif_task->priority_name = isset($detail->getPriority) ? $detail->getPriority->priority_name : '';
                        $notif_task->region_name = isset($task->getRegion) ? $task->getRegion->region_name : '';
                        $notif_task->impact_name = isset($detail->getImpact) ? $detail->getImpact->impact_name : '';
                        $notif_task->impact_detail = isset($detail->impact_detail) ? $detail->impact_detail : '';
                        $notif_task->category_name = isset($task->getCategory) ? $task->getCategory->category_name : '';
                        $notif_task->created_date = $task->created_at;
                        $notif_notif = sendFirebaseNotif($notif_task, $tokens, 'New RESOLVED Task', "Task under your name has been Updated");
                    }
                } else {
                    if ($task->id_task_type == 1) {
                        $task->id_status = 8;
                    } else if ($task->id_task_type == 2) {
                        $task->id_status = 22;
                        $task->time_complete = date('Y-m-d H:i:s');
                        $task->save();
                    } else if ($task->id_task_type == 4) {
                        $task->id_status = 34;
                        $task->time_complete = date('Y-m-d H:i:s');
                        $task->save();
                    }


                    $log = new TaskLog;
                    $log->id_task = $task->id_task;
                    $log->action = "APPROVAL";
                    if ($task->id_task_type == 1) {
                        $log->status_to = "CLOSED";
                    } else if ($task->id_task_type == 2) {
                        $log->status_to = "APPROVED";
                    } else if ($task->id_task_type == 4) {

                        $log->status_to = "APPROVED";
                    }

                    $log->changed_data_to = $this->taskRelations($task);
                    $log->created_by = $user->id;
                    $log->save();
                }

                // tambah



            } else {

                if ($task->id_task_type == 1) {
                    $task->id_status = 2;
                } else if ($task->id_task_type == 2) {
                    $task->id_status = 19;
                } else if ($task->id_task_type == 4) {
                    $task->id_status = 31;
                }
                $task->save();
            }
        }
        //     else{
        //         $result["message"] = "Your name isn`t assigned as Task($task->task_uid) Approver";
        //         return response($result);

        // }
        $result["status"] = true;
        $result["message"] = "Task $status Successfully";
        $result["data"] = $task;
        return response($result);
    }
    public function taskRelations($task)
    {
        $t = new Task;
        $t->Task_UID = $task->task_uid;
        $t->Task_Type = isset($task->getType) ? $task->getType->type_name : '-';
        $t->Status = isset($task->getStatus) ? $task->getStatus->status_name : '-';
        $t->Subject = $task->subject;
        $t->Description = $task->description;
        $t->Category = isset($task->getCategory) ? $task->getCategory->category_name : '-';
        $t->Sub_Category = isset($task->getSubCategory) ? $task->getSubCategory->sub_category_name : '-';
        $t->Item = isset($task->getItem) ? $task->getItem->item_name : '-';
        $t->Time_Receive = $task->time_receive;
        $t->Time_Depart = $task->time_depart;
        $t->Time_Arrived = $task->time_arrived;
        $t->Time_Complete = $task->time_complete;
        $t->Region = isset($task->getRegion) ? $task->getRegion->region_name : '-';
        $t->Location_A = isset($task->getLocationA) ? $task->getLocationA->segment_name : '-';
        $t->Site = isset($task->getSite) ? $task->getSite->name_site : '-';
        $t->Attachment = $task->attachment;
        $t->Created_By = isset($task->creator) ? $task->creator->name : '-';

        $task_detail = $task->getDetail;
        $t->Priority = isset($task_detail->getPriority) ? $task_detail->getPriority->priority_name : '-';
        $t->Impact = isset($task_detail->getImpact) ? $task_detail->getImpact->impact_name : '-';
        $t->Impact_detail = isset($task_detail->impact_detail) ? $task_detail->impact_detail : '-';
        return $t;
    }

    // aktivasi
    public function aktivasi()
    {
        return view('waiting.Activasi.index');
    }
    public function aktivasi_detail($id)
    {
        $data = Aktivasi::where('id', $id)->first();
        $approval = AktivasiApproval::where('id_aktivasi', $data->id)->first();
        $user = Auth::user();
        $user_id = $user->id;
        $approver_1 = isset($approval->approver_1) ? $approval->approver_1 : new AktivasiApproval;
        $approver_2 = isset($approval->approver_2) ? $approval->approver_2 : new AktivasiApproval;
        $approver_3 = isset($approval->approver_3) ? $approval->approver_3 : new AktivasiApproval;
        if (!$approval) {
            \Session::flash('message_2', "APPROVAL DATA DOES NOT EXIST OR HAS BEEN DELETED! SIMPLY UPDATE DATA TO ASSIGN NEW APPROVERS");
            \Session::flash('alert-class-2', 'alert-info');
        }

        $is_approver = false;
        if ($approval) {
            if (!$approval->approver_1_status) {
                if ($user_id == $approver_1) $is_approver = 1;
            } else {
                if (!$approval->approver_2_status) {
                    if ($user_id == $approver_2) $is_approver = 2;
                } else {
                    if (!$approval->approver_3_status) {
                        if ($user_id == $approver_3) $is_approver = 3;
                    } else {
                        $is_approver = false;
                    }
                    if ($approval->approver_2_status == "REJECTED") $is_approver = false;
                }
                if ($approval->approver_1_status == "REJECTED") $is_approver = false;
            }
        }

        if ($approval->approver_1_status == "REJECTED") {
            $approval->approver_2_status = "INHERIT REJECTION BY APPROVER 1";
            $approval->approver_2_remark = "INHERIT REJECTION BY APPROVER 1";
            $approval->approver_3_status = "INHERIT REJECTION BY APPROVER 1";
            $approval->approver_3_remark = "INHERIT REJECTION BY APPROVER 1";
        }
        if ($approval->approver_2_status == "REJECTED") {
            $approval->approver_3_status = "INHERIT REJECTION BY APPROVER 2";
            $approval->approver_3_remark = "INHERIT REJECTION BY APPROVER 2";
        }

        $ports = \App\Model\Port::get();
        $slots = \App\Model\Slot::get();
        $shelfs = \App\Model\Shelf::get();
        return view('waiting.Activasi.detail', compact('data', 'approval', 'user', 'is_approver', 'shelfs', 'slots', 'ports'));
    }
    public function getAktivasiData(Request $r)
    {
        $user = Auth::user();

        $columns = $r->columns;
        $order = $r->order;
        if ($order[0]) {
            $order = $order[0];
            $column = $order['column'];
            $column = $columns[$column];
            $orderBy = $column['data'];
            $order_dir = $order['dir'];

            $data = Aktivasi::orderBy($orderBy, $order_dir);
        } else {
            $orderBy = false;
            $data = Aktivasi::orderBy('id', 'DESC');
        }

        if ($r->id_type_service) $data = $data->where('id_type_service', $r->id_type_service);
        if ($r->id)  $data = $data->where('id', $r->id);
        if ($r->id_customer)  $data = $data->where('id_customer', $r->id_customer);
        if ($r->id_region)  $data = $data->where('id_region', $r->id_region);
        if ($r->id_site) $data = $data->where('id_site', $r->id_site);
        if ($r->id_segment) $data = $data->where('id_segment', $r->id_segment);
        if ($r->id_status) $data = $data->where('id_status', $r->id_status);

        $name = $r->name;
        if (!$name)  $name = $r->search['value'];

        if ($name) {
            $data = $data->where(function ($data) use ($name) {
                $data->where('subject', 'like', '%' . $name . '%');
            });
        }

        $user = Auth::user();
        $user_id = $user->id;
        $data = $data->join('tb_aktivasi_approval', 'tb_aktivasi_approval.id_aktivasi', 'tb_active_service.id');

        $data = $data->where(function ($data) use ($user_id) {
            $data->where('approver_1', $user_id);
            $data->orWhere('approver_2', $user_id);
            $data->orWhere('approver_3', $user_id);
        });

        $draw = $r->get('draw');
        $limit = $r->get('length');
        $offset = $r->get('start');
        $timeout = $r->get('timeout', 0);

        $count = $data->count();
        if ($limit && $offset) {
            $data = $data->offset($offset)->limit($limit);
        }
        $data = $data->get();

        $new_data = [];

        foreach ($data as $d) {
            $d->type;
            $d->customer;
            $d->site;
            $d->region;
            $d->location;
            if ($d->id_type_service == 3) {
                $status = $d->status_collocation;
            } else {
                $status = $d->status;
            }
            if (!$status) {
                $status = new \stdClass();
                $status->name = "<b class='text-danger'>DELETED STATUS</b>";
            }
            $d->status = isset($status) ? $status : new Status;

            if ($user_id == $d->approver_1) {
                if ($d->id_type_service == 3) {
                    if ($d->approver_1_status != "BEING REVIEWED") $new_data[] = $d;
                } else {
                    if ($d->approver_1_status != "CONFIRMED") $new_data[] = $d;
                }
            } elseif ($user_id == $d->approver_2) {
                if ($d->id_type_service == 3) {
                    if ($d->approver_1_status == "BEING REVIEWED") {
                        if (!$d->approver_2_status) $new_data[] = $d;
                    }
                } else {
                    if ($d->approver_1_status == "CONFIRMED") {
                        if (!$d->approver_2_status) $new_data[] = $d;
                    }
                }
            } elseif ($user_id == $d->approver_3) {
                if ($d->id_type_service == 3) {
                    if ($d->approver_2_status == "COMPLETE") {
                        if (!$d->approver_3_status) $new_data[] = $d;
                    }
                } else {
                    if ($d->approver_2_status == "PROPOSED") {
                        if (!$d->approver_3_status) $new_data[] = $d;
                    }
                }
            } else {
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
        if ($orderBy) {
            $result['orderBy'] = $orderBy;
            $result['order_dir'] = $order_dir;
        }
        return response()->json($result);
    }

    // site permit
    public function site_permit()
    {
        return view('waiting.site_permit.index');
    }
    public function pdfPermitLetter(Request $r)
    {
        $pdf = \PDF::loadView('site_permit.pdf_permit_letter');
        return $pdf->stream();
    }
    public function pdfSiteEntry(Request $r)
    {
        $pdf = \PDF::loadView('site_permit.pdf_site_entry');
        return $pdf->stream();
    }

    public function getSiteEntry(Request $r)
    {

        $columns = $r->columns;
        $order = $r->order;
        if ($order[0]) {
            $column = $order[0]['column'];
            $orderBy = $columns[$column]['data'];
            $order_dir = $order['dir'];
        } else {
            $orderBy = 'id_site_entry';
            $order_dir = 'ASC';
        }
        $data = SiteEntry::orderBy($orderBy, $order_dir);

        if ($r->id_region) $data->where('id_region', $r->id_region);
        if ($r->id_site) $data->where('id_site', $r->id_site);
        // if($r->created_by) $data->where('created_by', $r->created_by);


        $user = Auth::user();
        $user_id = $user->id;




        // $data = $data->where(function ($data) use($user_id) {
        //                 $data->where('approver_1_status', null);
        //                 $data->orWhere('approver_2_status', null);
        //                  $data->orWhere('approver_1_checkout', null);
        //                 $data->orWhere('approver_2_checkout', null);

        //               });

        //   $data = $data->where(function ($data) use($user_id) {

        //               });




        $result = getDataCustom($data, $r, 'id_site_entry', 'id_site_entry')->original;
        $new_data = [];
        foreach ($result['data'] as $d) {
            $d->site;
            $d->region;

            if ($user_id == $d->approver_1) {
                if (!$d->approver_1_status) $new_data[] = $d;
                if (!$d->approver_1_checkout && $d->approver_2_status) $new_data[] = $d;
            } elseif ($user_id == $d->approver_2) {
                if ($d->approver_1_status == "APPROVED") {
                    if (!$d->approver_2_status) $new_data[] = $d;
                }
                if ($d->approver_1_checkout == "APPROVED") {
                    if (!$d->approver_2_checkout) $new_data[] = $d;
                }
            } else {
            }
        }
        $result['user'] = $user_id;
        $result['data'] = $new_data;
        return response()->json($result);
    }
    public function detailSiteEntry($id)
    {
        $data = SiteEntry::where('id_site_entry', $id)->first();
        $region = isset($data->region) ? $data->region : new Region;
        $site = isset($data->site) ? $data->site : new Site;
        return view('waiting.site_permit.detail_site_entry', compact('data', 'site', 'region'));
    }

    public function getPermitLetter(Request $r)
    {
        $columns = $r->columns;
        $order = $r->order;
        if ($order[0]) {
            $column = $order[0]['column'];
            $orderBy = $columns[$column]['data'];
            $order_dir = $order['dir'];
        } else {
            $orderBy = 'id_permit_letter';
            $order_dir = 'ASC';
        }
        $data = PermitLetter::orderBy($orderBy, $order_dir);
        if ($r->id_region) $data->where('id_region', $r->id_region);
        if ($r->id_site) $data->where('id_site', $r->id_site);
        // if($r->created_by) $data->where('created_by', $r->created_by);

        $user = Auth::user();
        if (!is_admin($user)) {
            // $data = $data->where('created_by', $user->id);
        } else {
            if ($r->created_by) {
                // $data = $data->where('created_by', $r->created_by);  
            } else {
                // $data = $data->where('created_by', $user->id);
            }
        }

        $result = getDataCustom($data, $r, 'id_permit_letter', 'id_permit_letter')->original;
        foreach ($result['data'] as $d) {
            $d->pengunjung;
            $d->site;
            $d->pdf = main_url() . '/site-permit/permit-letter-pdf?id=' . $d->id_permit_letter;
        }
        return response()->json($result);
    }
    public function detailPermitLetter($id)
    {
        $data = PermitLetter::where('id_permit_letter', $id)->first();
        $site = isset($data->site) ? $data->site : new Site;
        $pengunjung = isset($data->pengunjung) ? $data->pengunjung : new PermitLetterDetail;
        return view('waiting.site_permit.detail_permit_letter', compact('data', 'site', 'pengunjung'));
    }
}
