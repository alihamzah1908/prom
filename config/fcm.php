<?php

return [
    'driver' => env('FCM_PROTOCOL', 'http'),
    'log_enabled' => false,

    'http' => [
        'server_key' => env('FCM_SERVER_KEY', 'AAAAyeP9B2s:APA91bHK_G5pZWApR10l2zs33IFiRu38aTc3BCPPqKgKNuWNxOEJzT9_7EW4szI0J2nwFjugffacgt8Yum9uewvE6fIkVpnghU48D_UWOejYjA6c6Rvynhh6fkPTQB5HUUKvar33kG0V'),
        'sender_id' => env('FCM_SENDER_ID', '867113437035'),
        'server_send_url' => 'https://fcm.googleapis.com/fcm/send',
        'server_group_url' => 'https://android.googleapis.com/gcm/notification',
        'timeout' => 30.0, // in second
    ],
];
