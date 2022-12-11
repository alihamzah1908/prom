<?php
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;

Route::group(['prefix' => 'firebase'], function () {
    Route::get('/', function () {
        return view('firebase.index');
    });
    Route::get('/test_notif', function () {
        $server_key = firebaseInfo('server_key');
        $user = \Auth::user();
        $data = \App\Model\Task::first();
        
        $task = new \App\Model\Task;
        $task->id_task = $data->id_task;
        $task->task_uid = $data->task_uid;
        $task->subject = $data->subject;
        $task->description = $data->description;
        $task->task_status = isset($data->getStatus)?$data->getStatus->status_name:'';
        $task->task_color = isset($data->getStatus)?$data->getStatus->color:'';
        // return request()->header();
        $token = [$user->firebase_token, $user->firebase_token_web];
        return response(sendFirebaseNotif($task, $token, "TITLE", "BODY"))->withHeaders(['Content-Type' => 'application/json','Authorization' => $server_key]);
    });
});

function addAdminTokens($tokens){
    $admin = \App\User::get();
    foreach($admin as $a){
        if(is_admin($a)){
            if(!in_array($a->firebase_token, $tokens)) $tokens[] = $a->firebase_token;
            if(!in_array($a->firebase_token_web, $tokens)) $tokens[] = $a->firebase_token_web;
        }
    }
    
    return $tokens;
}

function removeSender($tokens){
    $user = \Auth::user();
    $new_tokens = [];
    foreach($tokens as $k => $v){
        if(!in_array($user->firebase_token, $tokens)) $new_tokens[] = $v;
        if(!in_array($user->firebase_token_web, $tokens)) $new_tokens[] = $v;
    }
    
    return $new_tokens;
}

function sendTaskNotif($data, $tokens, $title, $body){
    $server_key = firebaseInfo('server_key');
    $task = new \App\Model\Task;
    $task->id_task = $data->id_task;
    $task->task_uid = $data->task_uid;
    $task->subject = $data->subject;
    $task->description = $data->description;
    $task->task_status = isset($data->getStatus)?$data->getStatus->status_name:'';
    $task->task_color = isset($data->getStatus)?$data->getStatus->color:'';
    $task->created_at = $data->updated_at;
    
    $tokens = addAdminTokens($tokens);
    // $tokens = removeSender($tokens);
    save_notif($task, $tokens, $title, $body, 'TASK');
    return response(sendFirebaseNotif($task, $tokens, $title, $body, "TASK"))->withHeaders(['Content-Type' => 'application/json','Authorization' => $server_key,]);
}
function sendPermitLetter($data, $tokens, $title, $body){
    $server_key = firebaseInfo('server_key');
    
    // $tokens = removeSender($tokens);
    
    save_notif($data, $tokens, $title, $body, 'PERMIT_LETTER');
    return response(sendFirebaseNotif($data, $tokens, $title, $body, "PERMIT_LETTER"))->withHeaders(['Content-Type' => 'application/json','Authorization' => $server_key,]);
}
function sendSiteEntry($data, $tokens, $title, $body){
    $server_key = firebaseInfo('server_key');
    
    // $tokens = removeSender($tokens);
    
    save_notif($data, $tokens, $title, $body, 'SITE_ENTRY');
    return response(sendFirebaseNotif($data, $tokens, $title, $body, "PERMIT_LETTER"))->withHeaders(['Content-Type' => 'application/json','Authorization' => $server_key,]);
}

function sendChatNotif($data, $tokens, $title, $body){
    $server_key = firebaseInfo('server_key');
    
    // $tokens = removeSender($tokens);
    
    save_notif($data, $tokens, $title, $body, 'CHAT');
    return response(sendFirebaseNotif($data, $tokens, $title, $body, "CHAT"))->withHeaders(['Content-Type' => 'application/json','Authorization' => $server_key,]);
}

function sendFirebaseNotif($datas, $tokens, $title, $body, $type = "TASK"){
    $result = [];
    
    $r = request();
    // if(!$tokens) $tokens = ['EMPTY_TOKEN'];
    $send_data = [
                    'data' => $datas,
                    'receivers' => $tokens,
                ];
    
    if(true){
        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60*20);
        $notificationBuilder = new PayloadNotificationBuilder($title);
        $notificationBuilder->setBody($body)->setIcon('/images/prom.png')->setSound('default');
        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData($send_data);
        
        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();
        $downstreamResponse = FCM::sendTo($tokens, $option, $notification, $data);
        $downstreamResponse->numberSuccess();
        $downstreamResponse->numberFailure();
        $downstreamResponse->numberModification();
        $downstreamResponse->tokensToDelete();
        $downstreamResponse->tokensToModify();
        $downstreamResponse->tokensToRetry();
        $downstreamResponse->tokensWithError();
    }
    
    $click_action = "FLUTTER_NOTIFICATION_CLICK";
    if(!isMobileDevice()){
        if($type == "TASK") $click_action = "https://prom.indonesiafintechforum.org/task/detail/$datas->id_task";
    }
    
    $notif = [];
    $notif['body'] = $body;
    $notif['title'] = $title;
    $notif['icon'] = main_url()."/images/prom.png";
    $notif['click_action'] = $click_action;
    
    $datas['notification_type'] = $type;
    
    $result['notification'] = $notif;
    $result['data'] = $datas;
    $result['receivers'] = $tokens;
    return $result;
}


function isMobileDevice(){
    $aMobileUA = array(
        '/iphone/i' => 'iPhone', 
        '/ipod/i' => 'iPod', 
        '/ipad/i' => 'iPad', 
        '/android/i' => 'Android', 
        '/blackberry/i' => 'BlackBerry', 
        '/webos/i' => 'Mobile'
    );

    //Return true if Mobile User Agent is detected
    foreach($aMobileUA as $sMobileKey => $sMobileOS){
        if(preg_match($sMobileKey, $_SERVER['HTTP_USER_AGENT'])){
            return true;
        }
    }
    //Otherwise return false..  
    return false;
}