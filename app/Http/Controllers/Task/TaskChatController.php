<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \App\Model\Task;
use \App\Model\Inbox;
use \App\Model\InboxChats;
use \Auth;
use \Mail;
use \App\Templates;
use \App\TemplatesDefaultValue;

class TaskChatController extends Controller
{
    public function index(Request $r){
        $user = Auth::user();
        $data = Inbox::orderBy('id', 'ASC')->get();
        $datas = [];
        foreach($data as $d){
            $participants = $d->participants;
            $participants = json_decode($participants);
            if(!is_array($participants)) $participants = [$participants];
            $task = $d->task;
            $user_participants = [];
            
            foreach($participants as $key => $val){
                $u = \App\User::where('id', $val)->first();
                $user_participants[] = ["id" => $u->id, "name" => $u->name, "email" => $u->email, "employe_id" => $u->employe_id, "telpone" => $u->telpone, "mobile" => $u->mobile, "role_id" => $u->role_id, "departement_id" => $u->departement_id];
            }
            
            if(in_array($user->id,$participants)){
                $datas[] = ['id' => $d->id, 'id_task' => $d->id_task,  'subject' => $task->subject, 'participants' => $participants, 'user_participants' => $user_participants];
            }
        }
        $inboxs = $datas;
        $chats = false;
        
        return view('chat.index', compact('inboxs', 'chats'));
    }
    
    public function chats(Request $r, $id_task){
        $result = [];
        $result["status"] = false;
        $result["message"] = "";
        $result["newtoken"] = csrf_token();
        
        $user = Auth::user();
        if(!$user){
            $result["message"] = "CSRF FAILED PLEASE RE-LOGIN!";
            return response($result);
        }
        
        if(!$r->chat){
            $result["message"] = "Cant send empty chat!";
            return response($result);
        }
        
        $task = Task::where('id_task', $id_task)->first();
        if(!$task){
            $result["message"] = "Oppss! Something went wrong please reload and try again4!";
            return response($result);
        }
        
        $inbox = Inbox::where('id_task', $task->id_task)->first();
        if(!$inbox){
            $technician =  $task->getTechnician;
            $technician_id = isset($technician->user)?$technician->user->id:'';
            $participants = [$user->id, $technician_id];

            $inbox = new Inbox;
            $inbox->id_task = $task->id_task;
            $inbox->participants = json_encode($participants);
            $inbox->save();
        }
        $participants = $inbox->participants;
        $participants = json_decode($participants);
        if(!is_array($participants)) $participants = [$participants];
        
        if(!in_array($user->id, $participants)){
            $result["message"] = "Anda belum ada di list, silahkan tambahkan nama anda di grup chat!";
            return response($result);
        }
        $chats = new InboxChats;
        $chats->id_inbox = $inbox->id;
        $chats->id_sender = $user->id;
        $chats->chat = $r->chat;
        $chats->type = "CHAT";
        
        $token_participants = [];
        foreach($participants as $key => $val){
            $u = \App\User::where('id', $val)->first();
            if($user->id != $u->id){
                $token_participants[] = $u->firebase_token;
                $token_participants[] = $u->firebase_token_web;
            }
        }
        
        $chats->save();
        $notif = sendChatNotif($chats, $token_participants, "New Message", "$r->chat");
        
        
        $result["status"] = true;
        $result["message"] = "Sended Successfully";
        $result["participants"] = $participants;
        $result["notif"] = $notif;
        $result["tokens"] = $token_participants;
        return response($result);
    }
    public function getData(Request $r, $id_task){
        $columns = $r->columns;
        $order = $r->order;
        if($order[0]){
            $order = $order[0];
            $column = $order['column']; 
            $column = $columns[$column];
            $orderBy = $column['data'];
            $order_dir = $order['dir'];
        }else{
            $orderBy = 'id';
            $order_dir = 'ASC';
        }
        
        $data = Inbox::orderBy($orderBy, $order_dir);
        
        $user = Auth::user();
        
        $data = $data->where('id_task', $id_task);
        // return $data->get();
        
        $draw = $r->get('draw', 1); $limit = $r->get('length', 10); $offset = $r->get('start', 0);  $timeout = $r->get('timeout', 0);   $count = $data->count();
        
        $data = $data->get();
        foreach($data as $d){
            foreach($d->chats as $chat){
                $type = "RECEIVE";
                $sender = $chat->sender;
                if($sender->id == $user->id){
                    $type = "SEND";
                }
                $chat->get_as = $type;
            }
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
    public function getChatByInbox(Request $r){
        $columns = $r->columns;
        $order = $r->order;
        if($order[0]){
            $order = $order[0];
            $column = $order['column']; 
            $column = $columns[$column];
            $orderBy = $column['data'];
            $order_dir = $order['dir'];
        }else{
            $orderBy = 'id';
            $order_dir = 'ASC';
        }
        
        $data = Inbox::orderBy($orderBy, $order_dir);
        
        $user = Auth::user();
        
        $data = $data->where('id', $r->id);
        
        $draw = $r->get('draw', 1); $limit = $r->get('length', 10); $offset = $r->get('start', 0);  $timeout = $r->get('timeout', 0);   $count = $data->count();
        
        $data = $data->get();
        foreach($data as $d){
            $d->task;
            foreach($d->chats as $chat){
                $type = "RECEIVE";
                $sender = $chat->sender;
                if($sender->id == $user->id){
                    $type = "SEND";
                }
                $chat->get_as = $type;
            }
            
            $participants = $d->participants;
            $participants = json_decode($participants);
            if(!is_array($participants)) $participants = [$participants];
            $task = $d->task;
            $user_participants = [];
            
            foreach($participants as $key => $val){
                $u = \App\User::where('id', $val)->first();
                $user_participants[] = ["id" => $u->id, "name" => $u->name];
            }
            $d['user_participants'] = $user_participants;
            
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
    public function getChatByTask(Request $r){
        $columns = $r->columns;
        $order = $r->order;
        if($order[0]){
            $order = $order[0];
            $column = $order['column']; 
            $column = $columns[$column];
            $orderBy = $column['data'];
            $order_dir = $order['dir'];
        }else{
            $orderBy = 'id';
            $order_dir = 'ASC';
        }
        
        $data = Inbox::orderBy($orderBy, $order_dir);
        
        $user = Auth::user();
        
        $data = $data->where('id_task', $r->id_task);
        
        $draw = $r->get('draw', 1); $limit = $r->get('length', 10); $offset = $r->get('start', 0);  $timeout = $r->get('timeout', 0);   $count = $data->count();
        
        $data = $data->get();
        foreach($data as $d){
            $d->task;
            foreach($d->chats as $chat){
                $type = "RECEIVE";
                $sender = $chat->sender;
                if($sender->id == $user->id){
                    $type = "SEND";
                }
                $chat->get_as = $type;
            }
            
            $participants = $d->participants;
            $participants = json_decode($participants);
            if(!is_array($participants)) $participants = [$participants];
            $task = $d->task;
            $user_participants = [];
            
            foreach($participants as $key => $val){
                $u = \App\User::where('id', $val)->first();
                $user_participants[] = ["id" => $u->id, "name" => $u->name];
            }
            $d['user_participants'] = $user_participants;
            
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
    public function getInboxs(Request $r){
        
        $user = Auth::user();
        
        $columns = $r->columns;
        $order = $r->order;
        $orderBy = 'id';
        $order_dir = 'ASC';
        if($order[0]){
            $order = $order[0];
            $column = $order['column']; 
            $column = $columns[$column];
            $orderBy = $column['data'];
            $order_dir = $order['dir'];
        }
        
        $data = Inbox::orderBy($orderBy, $order_dir);
        
        $user = Auth::user();
        
        $draw = $r->get('draw', 1); $limit = $r->get('length', 10); $offset = $r->get('start', 0);  $timeout = $r->get('timeout', 0);   $count = $data->count();
        
        $data = $data->get();
        
        $datas = [];
        foreach($data as $d){
            $participants = $d->participants;
            $participants = json_decode($participants);
            if(!is_array($participants)) $participants = [$participants];
            $task = $d->task;
            $user_participants = [];
            
            foreach($participants as $key => $val){
                $u = \App\User::where('id', $val)->first();
                $user_participants[] = ["id" => $u->id, "name" => $u->name, "email" => $u->email, "employe_id" => $u->employe_id, "telpone" => $u->telpone, "mobile" => $u->mobile, "role_id" => $u->role_id, "departement_id" => $u->departement_id];
            }
            
            if(in_array($user->id,$participants)){
                $datas[] = ['id' => $d->id, 'id_task' => $d->id_task, 'task_uid' => $task->task_uid, 'subject' => $task->subject, 'participants' => $participants, 'user_participants' => $user_participants];
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
        if($orderBy){
            $result['orderBy'] = $orderBy;
            $result['order_dir'] = $order_dir;   
        }
        return response()->json($result);
    }
    
    public function new_user_chat(Request $r, $id_task){
        $user = Auth::user();
        if(!$user){
            \Session::flash('message', "CSRF FAILED PLEASE RE-LOGIN!");
            \Session::flash('alert-class', 'alert-danger');
            return redirect()->back();
        }
        
        $task = Task::where('id_task', $id_task)->first();
        if(!$task){
            \Session::flash('message', "Oppss! Something went wrong please reload and try again1!");
            \Session::flash('alert-class', 'alert-danger');
            return redirect()->back();
        }
        $id_user = $r->id_user;
        $user_new = \App\User::where('id', $id_user)->first();
        if(!$user_new){
            \Session::flash('message', "Oppss! Something went wrong please reload and try again2!");
            \Session::flash('alert-class', 'alert-danger');
            return redirect()->back();
        }
        
        $technician =  $task->getTechnician;
        // $technician_id = isset($technician->user)?$technician->user->id:'';
        $technician_id = $r->id_user;
            
        $inbox = Inbox::where('id_task', $task->id_task)->first();
        if(!$inbox){
            $inbox = new Inbox;
            $inbox->id_task = $task->id_task;
            $participants = [$user->id, $technician_id];
        }else{
            $participants = json_decode($inbox->participants);
        }
        
        if(!is_array($participants)) $participants = [$participants];
        
        if(in_array($id_user, $participants)){
            \Session::flash('message', "User already on list!");
            \Session::flash('alert-class', 'alert-info');
            return redirect()->back();
        }
        array_push($participants, $id_user);
        $inbox->participants = $participants;   
        $inbox->save();
        
        $chats = new InboxChats;
        $chats->id_inbox = $inbox->id;
        $chats->id_sender = $user->id;
        $chats->type = "NOTIFICATION";
        $chats->chat = "<i>$user->name Added $user_new->name to chat</i>";
        $chats->save();
        
        \Session::flash('message', "Added successfully!");
        \Session::flash('alert-class', 'alert-success');
        return redirect()->back();
    }
    public function update_user_chat(Request $r, $id_task){
        $user = Auth::user();
        if(!$user){
            \Session::flash('message', "CSRF FAILED PLEASE RE-LOGIN!");
            \Session::flash('alert-class', 'alert-danger');
            return redirect()->back();
        }
        
        $task = Task::where('id_task', $id_task)->first();
        if(!$task){
            \Session::flash('message', "Oppss! Something went wrong please reload and try again3!");
            \Session::flash('alert-class', 'alert-danger');
            return redirect()->back();
        }
        
    
        $inbox = Inbox::where('id_task', $task->id_task)->first();
        if(!$inbox){
            $inbox = new Inbox;
            $inbox->id_task = $task->id_task;
        }
        
        $id_user = $r->id_user;
        
        $participants = [];
        if($id_user){
            if(!is_array($id_user)) $id_user = [$id_user];
            
            foreach($id_user as $key => $val){
                $participants[] = $key;
            }
        }
        $old_participants = json_decode($inbox->participants);
        $inbox->participants = json_encode($participants);   
        $inbox->save();
        
        $diff = array_diff($old_participants, $participants);
        foreach($diff as $key => $val){
            $user_new = \App\User::where('id', $val)->first();
            $chats = new InboxChats;
            $chats->id_inbox = $inbox->id;
            $chats->id_sender = $user->id;
            $chats->type = "NOTIFICATION";
            $chats->chat = "<i>$user->name Removed $user_new->name from chat</i>";
            $chats->save();
        }
        
        \Session::flash('message', "Updated successfully!");
        \Session::flash('alert-class', 'alert-success');
        return redirect()->back();
    }
}







