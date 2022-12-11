<?php
function main_url()
{
    return 'http://103.101.194.69';
}
function getImageSizeMb($img)
{
    $size_in_bytes = (int) (strlen(rtrim($img, '=')) * 3 / 4);
    $size_in_kb    = $size_in_bytes / 1024;
    $size_in_mb    = $size_in_kb / 1024;
    $size_in_mb = round($size_in_mb, 3);

    return $size_in_mb;
}
function getImageSizeKb($img)
{
    $size_in_bytes = (int) (strlen(rtrim($img, '=')) * 3 / 4);
    $size_in_kb    = $size_in_bytes / 1024;
    $size_in_kb = round($size_in_kb, 3);

    return $size_in_kb;
}
function getDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000)
{
    /**
     * Calculates the great-circle distance between two points, with the Haversine formula.
     * @param float $latitudeFrom Latitude of start point in [deg decimal]
     * @param float $longitudeFrom Longitude of start point in [deg decimal]º
     * @param float $latitudeTo Latitude of target point in [deg decimal]
     * @param float $longitudeTo Longitude of target point in [deg decimal]
     * @param float $earthRadius Mean earth radius in [m]
     * @return float Distance between points in [m] (same as earthRadius)
     */
    $latFrom = deg2rad($latitudeFrom);
    $lonFrom = deg2rad($longitudeFrom);
    $latTo = deg2rad($latitudeTo);
    $lonTo = deg2rad($longitudeTo);

    $latDelta = $latTo - $latFrom;
    $lonDelta = $lonTo - $lonFrom;

    $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) + cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
    return $angle * $earthRadius;
}

function divider()
{
    $d = "<br><hr><br>";
    return $d;
}
function random_code($n = 10)
{
    if ($n < 6) {
        $n = 10;
    }
    $num = "";
    $str = "";
    for ($i = 1; $i <= $n / 2; ++$i) {
        $str .= chr(rand(65, 90));
        $num .= rand(1, 9);
    }
    $rand = "$str$num";
    return $rand;
    // return response()->json(compact('i','str','num','rand'));

    $random_number = intval("0" . rand(1, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9));
    $random_string = chr(rand(65, 90)) . chr(rand(65, 90)) . chr(rand(65, 90)) . chr(rand(65, 90)) . chr(rand(65, 90));
    $rand = "$random_string$random_number";
    return $rand;
}

function uploadFile($base64, $folderName, $fileName)
{
    $path  = public_path() . "/$folderName";
    if (!is_dir($path)) {
        dirCreate($path);
    }

    list($type, $base64) = explode(';', $base64);
    list(, $extension) = explode('/', $type);
    list(, $base64) = explode(',', $base64);

    $base64 = base64_decode($base64);
    $full_path = "$folderName/$fileName";

    file_put_contents($full_path, $base64);
    return $full_path;
}

function dirCreate($path, $mode = null, $recursive = true)
{
    if (file_exists($path)) return 1;

    $mode = $mode ? $mode : 0755;
    $ok1 = mkdir($path, $mode, $recursive);
    $ok2 = chmod($path, $mode);

    return $ok1 && $ok2;
}

function time_elapsed_string($datetime, $full = false)
{
    $now = new \DateTime;
    $ago = new \DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}

function createDateRangeArray($strDateFrom, $strDateTo)
{
    $aryRange = array();

    $iDateFrom = mktime(1, 0, 0, substr($strDateFrom, 5, 2),     substr($strDateFrom, 8, 2), substr($strDateFrom, 0, 4));
    $iDateTo = mktime(1, 0, 0, substr($strDateTo, 5, 2),     substr($strDateTo, 8, 2), substr($strDateTo, 0, 4));

    if ($iDateTo >= $iDateFrom) {
        array_push($aryRange, date('Y-m-d', $iDateFrom)); // first entry
        while ($iDateFrom < $iDateTo) {
            $iDateFrom += 86400; // add 24 hours
            array_push($aryRange, date('Y-m-d', $iDateFrom));
        }
    }
    return $aryRange;
}

function getIndex($array = [], $index = '', $default = '')
{
    return isset($array[$index]) ? $array[$index] : $default;
}

function getAccess($to)
{
    $user = Auth::user();
    if ($user) {
        return $user->getAccess($to);
    }
    return false;
}

function getTaskImages($id_task, $type)
{
    $images = \App\Model\TaskImages::where('id_task', $id_task)->where('type', $type)->get();
    return $images;
}

function is_admin($user)
{
    $admin_roles = ['ADMIN'];
    $role_name = isset($user->role) ? $user->role->role_name : '-';
    $is_admin = isset($user->role) ? $user->role->is_admin : '-';
    if ($is_admin == "YES") {
        return true;
    }
    if (in_array($role_name, $admin_roles)) {
        return true;
    }
    return false;
}

function getServiceDeskNav()
{
    $nav = [
        [
            'name' => 'Instance_Setting',
            'url' => '/',
        ],
        [
            'name' => 'Region',
            'url' => '/region',
        ],
        [
            'name' => 'Site',
            'url' => '/site',
        ],
        // [
        //     'name' => 'Task_Type',
        //     'url' => '/task_type',
        // ],
        // [
        //     'name' => 'Segment',
        //     'url' => '/segment',
        // ],
        [
            'name' => 'RootCaused',
            'url' => '/rootcaused',
        ],
        // [
        //     'name' => 'Cord',
        //     'url' => '/cord',
        // ],
        // [
        //     'name' => 'Status',
        //     'url' => '/status',
        // ],
    ];
    return $nav;
}

function getUserPermissionsNav()
{
    $nav = [
        [
            'name' => 'Role',
            'url' => '?view=role',
        ],
        [
            'name' => 'Technicians',
            'url' => '?view=technicians',
        ],
        // [
        //     'name' => 'Validator',
        //     'url' => '?view=validator',
        // ],
        [
            'name' => 'Group Internal',
            'url' => '?view=group_internal',
        ],
        [
            'name' => 'Group External',
            'url' => '?view=group_external',
        ],
        [
            'name' => 'Task Validator',
            'url' => '?view=approver',
        ],
        [
            'name' => 'Site Entry Validator',
            'url' => '?view=site_entry_approver',
        ],
        [
            'name' => 'Aktivasi Validator',
            'url' => '?view=aktivasi_approver',
        ],
        [
            'name' => 'Customer',
            'url' => '?view=customer',
        ],
        [
            'name' => 'Departemen',
            'url' => '?view=departemen',
        ],
    ];
    return $nav;
}

function getTaskColumns($field = "")
{
    $col = [
        'task_uid' => [
            'name' => 'Task UID',
            'field' => 'task_uid'
        ],
        'task_type_name' => [
            'name' => 'Task Type',
            'field' => 'task_type_name'
        ],
        'task_status' => [
            'name' => 'Status',
            'field' => 'task_status'
        ],
        'name_technician' => [
            'name' => 'Technician',
            'field' => 'name_technician'
        ],
        'subject' => [
            'name' => 'Subject',
            'field' => 'subject'
        ],
        'description' => [
            'name' => 'Description',
            'field' => 'description'
        ],
        'category_name' => [
            'name' => 'Category',
            'field' => 'category_name'
        ],
        'sub_category_name' => [
            'name' => 'Sub Category',
            'field' => 'sub_category_name'
        ],
        'item_name' => [
            'name' => 'Item',
            'field' => 'item_name'
        ],
        'time_receive' => [
            'name' => 'Time Receive',
            'field' => 'time_receive'
        ],
        'time_depart' => [
            'name' => 'Time Depart',
            'field' => 'time_depart'
        ],
        'time_arrived' => [
            'name' => 'Time Arrived',
            'field' => 'time_arrived'
        ],
        'time_complete' => [
            'name' => 'Time Complete',
            'field' => 'time_complete'
        ],
        'region_name' => [
            'name' => 'Region',
            'field' => 'region_name'
        ],
        'location_a_name' => [
            'name' => 'Location A',
            'field' => 'location_a_name'
        ],
        'site_a_name' => [
            'name' => 'Site A',
            'field' => 'site_a_name'
        ],
        'attachment_link' => [
            'name' => 'Attachment',
            'field' => 'attachment_link'
        ],
        'resolved_at' => [
            'name' => 'Resolved At',
            'field' => 'resolved_at'
        ],
        'resolved_time' => [
            'name' => 'Resolved Time',
            'field' => 'resolved_time'
        ],
        'created_by_name' => [
            'name' => 'Created By',
            'field' => 'created_by_name'
        ],
        'checklist_periode_name' => [
            'name' => 'Checklist Periode',
            'field' => 'checklist_periode_name'
        ],
        'checklist_category' => [
            'name' => 'Checklist Category',
            'field' => 'checklist_category'
        ],
        'request_start_time' => [
            'name' => 'Request Start Time',
            'field' => 'request_start_time'
        ],
        'created_at' => [
            'name' => 'Created Time',
            'field' => 'created_at'
        ],
        'request_complete_time' => [
            'name' => 'Request Complete Time',
            'field' => 'request_complete_time'
        ],
        'mode_name' => [
            'name' => 'Mode',
            'field' => 'mode_name'
        ],
        'impact_name' => [
            'name' => 'Impact',
            'field' => 'impact_name'
        ],
        'impact_detail' => [
            'name' => 'Impact Detail',
            'field' => 'impact_detail'
        ],
        'priority_name' => [
            'name' => 'Priority',
            'field' => 'priority_name'
        ],
        'root_caused_name' => [
            'name' => 'Root Caused',
            'field' => 'root_caused_name'
        ],
        'asset_name' => [
            'name' => 'Asset',
            'field' => 'asset_name'
        ],
        'group_internal_name' => [
            'name' => 'Group Internal',
            'field' => 'group_internal_name'
        ],
        'group_customer' => [
            'name' => 'Group Customer',
            'field' => 'group_customer'
        ],
        'location_b_name' => [
            'name' => 'Location B',
            'field' => 'location_b_name'
        ],
        'site_b_name' => [
            'name' => 'Site B',
            'field' => 'site_b_name'
        ],
        'total_hari_kerja' => [
            'name' => 'Total Hari Kerja',
            'field' => 'total_hari_kerja'
        ],
        'total_waktu_kerja' => [
            'name' => 'Total Waktu Kerja',
            'field' => 'total_waktu_kerja'
        ],
        'down_start' => [
            'name' => 'Down Start',
            'field' => 'down_start'
        ],
        'down_end' => [
            'name' => 'Down End',
            'field' => 'down_end'
        ]
    ];
    if ($field) {
        return $col[$field];
    }
    return $col;
}

function getAktivasiColumns($field = "")
{
    $col = [
        'type_service' => [
            'name' => 'Type Service',
            'field' => 'type_service'
        ],
        'active_uid' => [
            'name' => 'Service UID',
            'field' => 'active_uid'
        ],
        'customer_name' => [
            'name' => 'Customer Name',
            'field' => 'customer_name'
        ],
        'region_name' => [
            'name' => 'Region',
            'field' => 'region_name'
        ],
        'location_name' => [
            'name' => 'Location',
            'field' => 'location_name'
        ],
        'site_name' => [
            'name' => 'Site',
            'field' => 'site_name'
        ],
        'status_name' => [
            'name' => 'Status',
            'field' => 'status_name'
        ],
        'capasity_type' => [
            'name' => 'Capacity Type',
            'field' => 'capasity_type'
        ],
        'capasity_cord' => [
            'name' => 'Capacity / Cord',
            'field' => 'capasity_cord'
        ],
        'active_desc' => [
            'name' => 'Description',
            'field' => 'active_desc'
        ],
        'memo_file_link' => [
            'name' => 'Memo File',
            'field' => 'memo_file_link'
        ],
        'bakti_file_link' => [
            'name' => 'Bakti File',
            'field' => 'bakti_file_link'
        ],
        'created_at' => [
            'name' => 'Created At',
            'field' => 'created_at'
        ],
        // 'approver_1_name' => [
        //     'name' => 'Approver I',
        //     'field' => 'approver_1_name'
        // ],
        // 'approver_1_status' => [
        //     'name' => 'Approver I Status',
        //     'field' => 'approver_1_status'
        // ],
        // 'approver_1_remark' => [
        //     'name' => 'Approver I Remark',
        //     'field' => 'approver_1_remark'
        // ],
        // 'approver_2_name' => [
        //     'name' => 'Approver II',
        //     'field' => 'approver_2_name'
        // ],
        // 'approver_2_status' => [
        //     'name' => 'Approver II Status',
        //     'field' => 'approver_2_status'
        // ],
        // 'approver_2_remark' => [
        //     'name' => 'Approver II Remark',
        //     'field' => 'approver_2_remark'
        // ],
        // 'approver_2_cid_name' => [
        //     'name' => 'Approver II CID',
        //     'field' => 'approver_2_cid_name'
        // ],
        // 'approver_2_ne_list' => [
        //     'name' => 'Approver II NE',
        //     'field' => 'approver_2_ne_list'
        // ],
        // 'approver_2_document' => [
        //     'name' => 'Approver II Document',
        //     'field' => 'approver_2_document'
        // ],
        // 'approver_3_name' => [
        //     'name' => 'Approver III',
        //     'field' => 'approver_3_name'
        // ],
        // 'approver_3_status' => [
        //     'name' => 'Approver III Status',
        //     'field' => 'approver_3_status'
        // ],
        // 'approver_3_remark' => [
        //     'name' => 'Approver III Remark',
        //     'field' => 'approver_3_remark'
        // ],
        // 'approver_3_document' => [
        //     'name' => 'Approver III Document',
        //     'field' => 'approver_3_document'
        // ],
    ];
    if ($field) {
        return $col[$field];
    }
    return $col;
}
function getSiteEntryColumns($field = "")
{
    $col = [
        'status' => [
            'name' => 'status',
            'field' => 'status'
        ],
        'region_name' => [
            'name' => 'Region',
            'field' => 'region_name'
        ],
        'site_name' => [
            'name' => 'Site',
            'field' => 'site_name'
        ],
        'entry_datetime' => [
            'name' => 'Entry Datetime',
            'field' => 'entry_datetime'
        ],
        'entry_datetime' => [
            'name' => 'Entry Datetime',
            'field' => 'entry_datetime'
        ],
        'jumlah_petugas' => [
            'name' => 'Jumlah Petugas',
            'field' => 'jumlah_petugas'
        ],
        'latitude' => [
            'name' => 'Latitude',
            'field' => 'latitude'
        ],
        'longitude' => [
            'name' => 'Longitude',
            'field' => 'longitude'
        ],
        'personil_list' => [
            'name' => 'Personil',
            'field' => 'personil_list'
        ],
        'description' => [
            'name' => 'Description',
            'field' => 'description'
        ],
        'created_by_name' => [
            'name' => 'Created By',
            'field' => 'created_by_name'
        ],
        'created_at' => [
            'name' => 'Created At',
            'field' => 'created_at'
        ],
        // 'approver_1_name' => [
        //     'name' => 'Approver I',
        //     'field' => 'approver_1_name'
        // ],
        // 'approver_1_status' => [
        //     'name' => 'Approver I Status',
        //     'field' => 'approver_1_status'
        // ],
        // 'approver_1_note' => [
        //     'name' => 'Approver I Note',
        //     'field' => 'approver_1_note'
        // ],
        // 'approver_2_name' => [
        //     'name' => 'Approver II',
        //     'field' => 'approver_2_name'
        // ],
        // 'approver_2_status' => [
        //     'name' => 'Approver II Status',
        //     'field' => 'approver_2_status'
        // ],
        // 'approver_2_note' => [
        //     'name' => 'Approver II Note',
        //     'field' => 'approver_2_note'
        // ],
    ];
    if ($field) {
        return $col[$field];
    }
    return $col;
}
function getPermitLetterColumns($field = "")
{
    $col = [
        'activity_no' => [
            'name' => 'Activity No',
            'field' => 'activity_no'
        ],
        'region_name' => [
            'name' => 'Region',
            'field' => 'region_name'
        ],
        'site_name' => [
            'name' => 'Site',
            'field' => 'site_name'
        ],
        'pemohon' => [
            'name' => 'Pemohon',
            'field' => 'pemohon'
        ],
        'instansi' => [
            'name' => 'Instansi',
            'field' => 'instansi'
        ],
        'departemen' => [
            'name' => 'Departemen',
            'field' => 'departemen'
        ],
        'atasan' => [
            'name' => 'Atasan',
            'field' => 'atasan'
        ],
        'nomor_telepon' => [
            'name' => 'Nomor Telepon',
            'field' => 'nomor_telepon'
        ],
        'tanggal_pengajuan' => [
            'name' => 'Tanggal Pengajuan',
            'field' => 'tanggal_pengajuan'
        ],
        'tanggal_berlaku' => [
            'name' => 'Tanggal Berlaku',
            'field' => 'tanggal_berlaku'
        ],
        'tanggal_berlaku_sd' => [
            'name' => 'Tanggal Berlaku sd',
            'field' => 'tanggal_berlaku_sd'
        ],
        'jumlah_pengunjung' => [
            'name' => 'Jumlah Pengunjung',
            'field' => 'jumlah_pengunjung'
        ],
        'status' => [
            'name' => 'Status',
            'field' => 'status'
        ],
        // 'validity_status' => [
        //     'name' => 'Validity Status',
        //     'field' => 'validity_status'
        // ],
        'created_by_name' => [
            'name' => 'Created By',
            'field' => 'created_by_name'
        ],
        'created_at' => [
            'name' => 'Created At',
            'field' => 'created_at'
        ],

    ];
    if ($field) {
        return $col[$field];
    }
    return $col;
}

function getDataCustom($data, $r, $id_col, $name_col)
{
    $name = $r->name;
    $id = $r->id;
    if ($id) {
        $data = $data->where($id_col, $id);
    }

    if (!$name) {
        $name = $r->search ? $r->search['value'] : '';
    }

    if ($name) {
        $data = $data->where(function ($data) use ($name_col, $name) {
            $data->where($name_col, 'like', '%' . $name . '%');
        });
    }

    $draw = $r->get('draw');
    $limit = $r->get('length');
    $offset = $r->get('start');
    $timeout = $r->get('timeout', 0);

    $count = $data->count();
    if ($limit && $offset) {
        $data = $data->offset($offset)->limit($limit);
    }
    $data = $data->get();

    foreach ($data as $d) {
        $d->created_by_name = isset($d->creator) ? $d->creator->name : '';
        $d->updated_by_name = isset($d->updater) ? $d->updater->name : '';
    }

    $count_searched = count($data);
    $result = [];
    $result["data"] = $data;
    $result["draw"] = $draw;
    $result["recordsTotal"] = $count_searched;
    $result["recordsFiltered"] = $count;
    $result["limit"] = $limit;
    $result["offset"] = $offset;
    // if($orderBy){
    //     $result['orderBy'] = $orderBy;
    //     $result['order_dir'] = $order_dir;   
    // }
    return response()->json($result);
}

function firebaseInfo($key = false)
{
    $data = [];
    $data['server_key'] = "AAAAyeP9B2s:APA91bHK_G5pZWApR10l2zs33IFiRu38aTc3BCPPqKgKNuWNxOEJzT9_7EW4szI0J2nwFjugffacgt8Yum9uewvE6fIkVpnghU48D_UWOejYjA6c6Rvynhh6fkPTQB5HUUKvar33kG0V";
    $data['messagingSenderId'] = "867113437035";
    $data['apiKey'] = "AIzaSyDQYUrYhQyBZx_ZneLzTouz6v7H9mZVlmE";
    $data['authDomain'] = "fcm-demo-f5cc3.firebaseapp.com";
    $data['databaseURL'] = "https://fcm-demo-f5cc3.firebaseio.com";
    $data['projectId'] = "fcm-demo-f5cc3";
    $data['storageBucket'] = "fcm-demo-f5cc3.appspot.com";
    $data['appId'] = "1:867113437035:web:3e21039080ab6a961dee2e";
    if ($key) $data = getIndex($data, $key);
    return $data;
}
function formatBytes($size, $precision = 2)
{
    if ($size > 0) {
        $size = (int) $size;
        $base = log($size) / log(1024);
        $suffixes = array(' bytes', ' KB', ' MB', ' GB', ' TB');

        return round(pow(1024, $base - floor($base)), $precision) . $suffixes[floor($base)];
    } else {
        return $size;
    }
}

function save_notif($datas, $receivers, $title, $body, $type)
{
    $result = [];
    $result["status"] = false;
    $result["message"] = "";
    $result["newtoken"] = csrf_token();

    if (!is_array($receivers)) $receivers = [$receivers];

    $receivers_id = [];
    foreach ($receivers as $key => $val) {
        $user = \App\User::where(function ($data) use ($val) {
            $data->where('firebase_token', $val);
            $data->orWhere('firebase_token_web', $val);
        })->first();

        if ($user) {
            if (!in_array($user->id, $receivers_id)) $receivers_id[] = $user->id;
        }
    }

    $d = new \App\Model\Notification;
    $d->datas = json_encode($datas);
    $d->title = $title;
    $d->body = $body;
    $d->type = $type;
    $d->received_by = json_encode($receivers_id);
    $d->save();

    $result["status"] = true;
    $result["message"] = "Notif saved successfully";
    $result["data"] = $d;
    return response($result);
}

function getWaitingApprovalTaskCount($user)
{
   $counts = app('App\Http\Controllers\WaitingApprovalController')->getData(request())->original;
    return $counts['recordsFiltered'];
    $data = \App\Model\Task::orderBy('id_task', 'ASC')->whereIn('id_status', [3, 17, 18, 29, 30])->get();

    $datas = [];
    foreach ($data as $d) {
        $approval = \App\Model\TaskApproval::where('id_task', $d->id_task)->where('user_id', $user->id)->first();
        if ($approval) {
            $prev = \App\Model\TaskApproval::where('id_task', $d->id_task)->where('id_task_approval', '<', $approval->id_task_approval)->orderby('id_task_approval', 'desc')->first();
            if ($prev) if ($prev->status == "RESOLVED") $d = null;
            if ($approval->status != "RESOLVED") $d = null;
        } else {
            $d = null;
        }
        if ($d) {
            $datas[] = $d;
        }
    }

    $data = $datas;

    return count($data);
}

function getWaitingApprovalAktivasiCount($user)
{
    $data = \App\Model\Aktivasi::orderBy('id', 'DESC')->join('tb_aktivasi_approval', 'tb_aktivasi_approval.id_aktivasi', 'tb_active_service.id');

    $user_id = $user->id;
    $data = $data->where(function ($data) use ($user_id) {
        $data->where('approver_1', $user_id);
        $data->orWhere('approver_2', $user_id);
        $data->orWhere('approver_3', $user_id);
    });
    $data = $data->get();

    $new_data = [];
    foreach ($data as $d) {
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
    return count($data);
}

function getWaitingApprovalSiteCount($user)
{
    $data = \App\Model\SiteEntry::orderBy('id_site_entry', 'ASC');

    $user_id = $user->id;
    // $data = $data->where(function ($data) use($user_id) {
    //                 $data->where('approver_1', $user_id);
    //                 $data->orWhere('approver_2', $user_id);
    //               });
    // $data = $data->where(function ($data) use($user_id) {
    //                 $data->where('approver_1_status', null);
    //                 $data->orWhere('approver_2_status', null);
    //                 $data->orWhere('approver_1_checkout', null);
    //                 $data->orWhere('approver_2_checkout', null);
    //               });
    $r = new Illuminate\Http\Request;
    $result = getDataCustom($data, $r, 'id_site_entry', 'id_site_entry')->original;
    $new_data = [];
    foreach ($result['data'] as $d) {
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

    return count($new_data);
}
