<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Redirect;
use Validator;
use Auth;
use Session;
use Illuminate\Support\Facades\Hash;
use \App\User;
use \App\Model\Notification;

class NotifController extends Controller
{
    public function getData(Request $r){
        $columns = $r->columns;
        $order = $r->order;
        if($order[0]){
            $column = $order[0]['column']; 
            $orderBy = $columns[$column]['data'];
            $order_dir = $order['dir'];
        }else{
            $orderBy = 'id';
            $order_dir = 'DESC';
        }
        $data = Notification::orderBy($orderBy, $order_dir);
        if($r->id) $data->where('id', $r->id);
        
        $result = getDataCustom($data, $r, 'id', 'datas')->original;
        
        $user = Auth::user();
        $result_data = [];
        $my_notifs = [];
        foreach($result['data'] as $d){
            $receiver = json_decode($d->received_by);
            if(!is_array($receiver)) $receiver = [$receiver];
            
            $d->received_by = $receiver;
            
            $datas = json_decode($d->datas);
            if(!is_array($datas)) $datas = [$datas];
            $d->datas = $datas[0];
            
            $is_me = false;
            if(in_array($user->id, $receiver)) $is_me = true;
            
            
            if($is_me){
                $datas = $datas[0];
                $my_notifs[] = $d->id;
                
                $title = $d->title;
                if($d->type == "CHAT"){
                    $sender = $datas->id_sender;
                    $sender = User::where('id', $sender)->first();
                    $title = $sender->name;
                    $content = $datas->chat;
                    $inbox = \App\Model\Inbox::where('id', $datas->id_inbox)->first();
                    $click_action = "/task/task_chats?id=$datas->id_inbox&id_task=$inbox->id_task";
                }elseif($d->type == 'TASK'){
                    $content = $d->body;
                    $click_action = "/task/detail/$datas->id_task";
                }elseif($d->type == "PERMIT_LETTER"){
                    $content = $d->body;
                    $click_action = "/site-permit/permit-letter-detail/$datas->id_permit_letter";
                }else{
                     $content = $d->type;
                     $click_action = "#";
                }
                $datas->created_at = isset($datas->created_at)?$datas->created_at:'';
                $notif = [];
                $notif['id'] = $d->id;
                $notif['sender'] = $title;
                $notif['type'] = $d->type;
                $notif['content'] = $content;
                $notif['click_action'] = $click_action;
                $notif['created_at'] = $datas->created_at;
                $notif['received_by'] = $d->received_by;
                $notif['readed_by'] = $d->readed_by;
                $notif['time_stamp_ago'] = time_elapsed_string($datas->created_at);
                
                $result_data[] = $notif;
            }
        }
        
        Session::put('my_notifs', $my_notifs);
        $result = [];
        $result['data'] = $result_data;
        return response()->json($result);
    }
    public function deleteNotif(Request $r){
        $result = [];
        $result['status'] = false;
        $my_notifs = Session::get('my_notifs');
        
        if(is_array($my_notifs)){
            $notif = Notification::whereIn('id', $my_notifs)->get();
            foreach($notif as $n){
                $n->delete();
            }
            $result['status'] = true;
        }
        return response()->json($result);
    }
    
    public function save_notif(Request $r){
        
    }    
}




















