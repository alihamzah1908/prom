<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use \App\Model\TaskSchedule;
use \App\Model\Task;
use \App\Model\TaskDetail;
use \App\Model\TaskLog;
use \App\Model\TangkapError ;


class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        // $schedule->command('sg:taskPm')->everyMinute();
        $schedule->command('task:expiry')->cron('*/1 * * * *');



     
        try {
        $tasks = TaskSchedule::all();
        foreach ($tasks as $taskku){
            $frequencies = $taskku->frequency;
             $tanggals = 1;
            $haris = $taskku->hari;
            $jams = $taskku->jam;
            $clocks = $taskku->clock;
            $menits = $taskku->menit;

            $a = json_decode('['.$taskku->waktus.']');
            foreach( $a as $file){
                if(date("Y",strtotime($file)) == date('Y') ){
                    if(date("m",strtotime($file)) != date('m') ){
                        $bulans = date("m",strtotime($file)); 
                        $tanggals = date("d",strtotime($file)); 
                    } 
                }    
            }
            foreach( $a as $file){
                if(date("Y",strtotime($file)) == date('Y') ){
                    if(date("m",strtotime($file)) == date('m') ){
                        $bulans = date('m'); 
                        if(date("d",strtotime($file)) != date('d') ){
                            $tanggals = date("d",strtotime($file)); 
                        }
                    } 
                }    
            }
            foreach( $a as $file){
                if(date("Y",strtotime($file)) == date('Y') ){
                    if(date("m",strtotime($file)) == date('m') ){
                        $bulans = date('m'); 
                        if(date("d",strtotime($file)) == date('d') ){
                            $tanggals = date('d'); 
                        }
                    }  
                }   
            }

            // $real = new Task;

            // $real->nama = $a->name;
            // $category->description = $a->description;

            // $category->save();
           
            // if(true){
                if($taskku->frequency =="dailyAt"){
                    $schedule->call(function() use($taskku) {
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
                        
                        if($taskku->id_task_type == 1){
                            $uid = "CM-".date('ymd').$uid;
                        }elseif($taskku->id_task_type == 2){
                            $uid = "PM-".date('ymd').$uid;
                          //  $uid = "CR-".date('ymd').$uid;
                        }elseif($taskku->id_task_type == 4){
                            $uid = "PLM-".date('ymd').$uid;
                        }else{
                            $uid = "CR-".date('ymd').$uid;
                        }

                        /*  Run your task here */
        
                        $task = new Task;
                        $task->task_uid = $uid;
                        $task->id_technician = $taskku->id_technician;
                        $task->id_task_type = $taskku->id_task_type;
                        
                        if ($taskku->id_task_type == 1){
                          $task->id_status = 1;  
                        }
                        else if ($taskku->id_task_type == 2 ){
                           $task->id_status = 12;   
                        }
                        else if ($taskku->id_task_type == 4 ){
                             $task->id_status = 24; 
                        }
                        else{
                            $task->id_status = 35; 
                            
                        }
                        
                        $task->id_category = $taskku->id_category;
                        $task->id_sub_category = $taskku->id_sub_category;
                        $task->id_item = $taskku->id_item;
                        $task->description = $taskku->description;
                        $task->subject = $taskku->subject;
                        $task->id_region = $taskku->id_region;
                        $task->id_location_a = $taskku->id_location_a;
                        $task->id_site_a = $taskku->id_site_a;
                        $task->created_by = $taskku->created_by;
                        // $task->frequency = $taskku->frequency;
                        
                        $attachment = 'default.png';
                        // if($taskku->file('attachment')){
                        //     $file = $taskku->file('attachment');
                        //     $file->move(public_path().'/task_attachment', $file->getClientOriginalName());
                        //     $attachment = $file->getClientOriginalName();
                        // }
                        $task->attachment = $attachment;
                        $task->save();
                        // ->monthlyOn(4, '15:00');
                        // $jamku = "'".$jams.":".$menits."'";
                        // $schedule->command('mycommand')->cron('0 17 3,5,7,22 * *');
                        // ->dailyAt('13:00');
                        $task_detail = new TaskDetail;
                        $task_detail->id_task_type = $taskku->id_task_type;
                        $task_detail->id_task = $task->id_task;
                        $task_detail->checklist_periode = $taskku->checklist_periode;
                        $task_detail->id_checklist_category = $taskku->id_checklist_category;
                        $task_detail->request_start_time = date('Y-m-d H:i:s');
                        $task_detail->request_complete_time = date('Y-m-d 23:59:59');
                        $task_detail->id_mode = $taskku->id_mode;
                        $task_detail->id_impact = $taskku->id_impact;
                        $task_detail->impact_detail = $taskku->impact_detail;
                        $task_detail->id_priority = $taskku->id_priority;
                        $task_detail->id_root_caused = $taskku->id_root_caused;
                        $task_detail->id_asset = $taskku->id_asset;
                        $task_detail->id_group_internal = $taskku->id_group_internal;
                        // $task_detail->id_group_customer = $r->id_group_customer;
                        $task_detail->id_group_customer = $taskku->id_group_customer;
                        $task_detail->id_location_b = $taskku->id_location_b;
                        $task_detail->id_site_b = $taskku->id_site_b; 
                        $task_detail->total_hari_kerja = $taskku->total_hari_kerja;
                        $task_detail->total_waktu_kerja = $taskku->total_waktu_kerja;
                        $task_detail->down_start = $taskku->down_start;
                        $task_detail->down_end = $taskku->down_end;
                        $task_detail->save();
                        
                        $log = new TaskLog;
                        $log->id_task = $task->id_task;
                        $log->action = "CREATE";
                        $log->status_to = 'OPEN';
                        $log->changed_data_to = $task;
                        $log->created_by = $task->created_by;
                        $log->save();


                    })->$frequencies($clocks);
                }
                if($taskku->frequency =="weeklyOn"){
                    $schedule->call(function() use($taskku) {
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
                        
                        if($taskku->id_task_type == 1){
                            $uid = "CM-".date('ymd').$uid;
                        }elseif($taskku->id_task_type == 2){
                            $uid = "PM-".date('ymd').$uid;
                          //  $uid = "CR-".date('ymd').$uid;
                        }elseif($taskku->id_task_type == 4){
                            $uid = "PLM-".date('ymd').$uid;
                        }else{
                            $uid = "CR-".date('ymd').$uid;
                        }
                        /*  Run your task here */
        
                        $task = new Task;
                        $task->task_uid = $uid;
                        $task->id_technician = $taskku->id_technician;
                        $task->id_task_type = $taskku->id_task_type;
                        
                        if ($taskku->id_task_type == 1){
                          $task->id_status = 1;  
                        }
                        else if ($taskku->id_task_type == 2 ){
                           $task->id_status = 12;   
                        }
                        else if ($taskku->id_task_type == 4 ){
                             $task->id_status = 24; 
                        }
                        else{
                            $task->id_status = 35; 
                            
                        }
                        
                        $task->id_category = $taskku->id_category;
                        $task->id_sub_category = $taskku->id_sub_category;
                        $task->id_item = $taskku->id_item;
                        $task->description = $taskku->description;
                        $task->subject = $taskku->subject;
                        $task->id_region = $taskku->id_region;
                        $task->id_location_a = $taskku->id_location_a;
                        $task->id_site_a = $taskku->id_site_a;
                        $task->created_by = $taskku->created_by;
                        // $task->frequency = $taskku->frequency;
                        
                        $attachment = 'default.png';
                        // if($taskku->file('attachment')){
                        //     $file = $taskku->file('attachment');
                        //     $file->move(public_path().'/task_attachment', $file->getClientOriginalName());
                        //     $attachment = $file->getClientOriginalName();
                        // }
                        $task->attachment = $attachment;
                        $task->save();
                        // ->monthlyOn(4, '15:00');
                        // $jamku = "'".$jams.":".$menits."'";
                        // $schedule->command('mycommand')->cron('0 17 3,5,7,22 * *');

                        $task_detail = new TaskDetail;
                        $task_detail->id_task_type = $taskku->id_task_type;
                        $task_detail->id_task = $task->id_task;
                        $task_detail->checklist_periode = $taskku->checklist_periode;
                        $task_detail->id_checklist_category = $taskku->id_checklist_category;
                        $task_detail->request_start_time = date('Y-m-d H:i:s');
                        $task_detail->request_complete_time = date('Y-m-d 23:59:59');
                        $task_detail->id_mode = $taskku->id_mode;
                        $task_detail->id_impact = $taskku->id_impact;
                        $task_detail->impact_detail = $taskku->impact_detail;
                        $task_detail->id_priority = $taskku->id_priority;
                        $task_detail->id_root_caused = $taskku->id_root_caused;
                        $task_detail->id_asset = $taskku->id_asset;
                        $task_detail->id_group_internal = $taskku->id_group_internal;
                        // $task_detail->id_group_customer = $r->id_group_customer;
                        $task_detail->id_group_customer = $taskku->id_group_customer;
                        $task_detail->id_location_b = $taskku->id_location_b;
                        $task_detail->id_site_b = $taskku->id_site_b; 
                        $task_detail->total_hari_kerja = $taskku->total_hari_kerja;
                        $task_detail->total_waktu_kerja = $taskku->total_waktu_kerja;
                        $task_detail->down_start = $taskku->down_start;
                        $task_detail->down_end = $taskku->down_end;
                        $task_detail->save();
                        
                        $log = new TaskLog;
                        $log->id_task = $task->id_task;
                        $log->action = "CREATE";
                        $log->status_to = 'OPEN';
                        $log->changed_data_to = $task;
                        $log->created_by = $task->created_by;
                        $log->save();

                    })->$frequencies($haris, $clocks);
                }
                // if($taskku->frequency =="monthlyOn"){
                //     $schedule->call(function() use($taskku) {
                //         $last_id = Task::orderBy('id_task','DESC')->first();
                //         if($last_id){
                //             $last_id = $last_id->id_task + 1;
                //         }else{
                //             $last_id = 1;
                //         }
                //         switch($last_id){
                //             case $last_id < 10 :
                //                 $uid = "0000$last_id";
                //                 break;
                //             case $last_id < 100 :
                //                 $uid = "000$last_id";
                //                 break;
                //             case $last_id < 1000 :
                //                 $uid = "00$last_id";
                //                 break;
                //             case $last_id < 10000 :
                //                 $uid = "0$last_id";
                //                 break;
                //             case $last_id < 100000 :
                //                 $uid = "$last_id";
                //                 break;
                //             default:
                //                 $uid = "$last_id";
                                
                //         }
                        
                //         if($taskku->id_task_type == 1){
                //             $uid = "CM-".date('ymd').$uid;
                //         }elseif($taskku->id_task_type == 2){
                //             $uid = "PM-".date('ymd').$uid;
                //           //  $uid = "CR-".date('ymd').$uid;
                //         }elseif($taskku->id_task_type == 4){
                //             $uid = "PLM-".date('ymd').$uid;
                //         }else{
                //             $uid = "CR-".date('ymd').$uid;
                //         }
                        

                //         /*  Run your task here */
        
                //         $task = new Task;
                //         $task->task_uid = $uid;
                //         $task->id_technician = $taskku->id_technician;
                //         $task->id_task_type = $taskku->id_task_type;
                        
                //         if ($taskku->id_task_type == 1){
                //           $task->id_status = 1;  
                //         }
                //         else if ($taskku->id_task_type == 2 ){
                //            $task->id_status = 12;   
                //         }
                //         else if ($taskku->id_task_type == 4 ){
                //              $task->id_status = 24; 
                //         }
                //         else{
                //             $task->id_status = 35; 
                            
                //         }
                        
                //         $task->id_category = $taskku->id_category;
                //         $task->id_sub_category = $taskku->id_sub_category;
                //         $task->id_item = $taskku->id_item;
                //         $task->description = $taskku->description;
                //         $task->subject = $taskku->subject;
                //         $task->id_region = $taskku->id_region;
                //         $task->id_location_a = $taskku->id_location_a;
                //         $task->id_site_a = $taskku->id_site_a;
                //         $task->created_by = $taskku->created_by;
                //         // $task->frequency = $taskku->frequency;
                        
                //         $attachment = 'default.png';
                //         // if($taskku->file('attachment')){
                //         //     $file = $taskku->file('attachment');
                //         //     $file->move(public_path().'/task_attachment', $file->getClientOriginalName());
                //         //     $attachment = $file->getClientOriginalName();
                //         // }
                //         $task->attachment = $attachment;
                //         $task->save();
                //         // ->monthlyOn(4, '15:00');
                //         // $jamku = "'".$jams.":".$menits."'";
                //         // $schedule->command('mycommand')->cron('0 17 3,5,7,22 * *');

                //         $task_detail = new TaskDetail;
                //         $task_detail->id_task_type = $taskku->id_task_type;
                //         $task_detail->id_task = $task->id_task;
                //         $task_detail->checklist_periode = $taskku->checklist_periode;
                //         $task_detail->id_checklist_category = $taskku->id_checklist_category;
                //         $task_detail->request_start_time = date('Y-m-d H:i:s');
                //         $task_detail->request_complete_time = date('Y-m-d 23:59:59');
                //         $task_detail->id_mode = $taskku->id_mode;
                //         $task_detail->id_impact = $taskku->id_impact;
                //         $task_detail->impact_detail = $taskku->impact_detail;
                //         $task_detail->id_priority = $taskku->id_priority;
                //         $task_detail->id_root_caused = $taskku->id_root_caused;
                //         $task_detail->id_asset = $taskku->id_asset;
                //         $task_detail->id_group_internal = $taskku->id_group_internal;
                //         // $task_detail->id_group_customer = $r->id_group_customer;
                //         $task_detail->id_group_customer = $taskku->id_group_customer;
                //         $task_detail->id_location_b = $taskku->id_location_b;
                //         $task_detail->id_site_b = $taskku->id_site_b; 
                //         $task_detail->total_hari_kerja = $taskku->total_hari_kerja;
                //         $task_detail->total_waktu_kerja = $taskku->total_waktu_kerja;
                //         $task_detail->down_start = $taskku->down_start;
                //         $task_detail->down_end = $taskku->down_end;
                //         $task_detail->save();
                        
                //         $log = new TaskLog;
                //         $log->id_task = $task->id_task;
                //         $log->action = "CREATE";
                //         $log->status_to = 'OPEN';
                //         $log->changed_data_to = $task;
                //         $log->created_by = $task->created_by;
                //         $log->save();

                //     })->$frequencies($tanggals, $clocks);
                // }
                if($taskku->frequency =="monthlyOn"){
                    $schedule->call(function() use($taskku) {


                        // ===
                        $a = json_decode('['.$taskku->waktus.']');
                        foreach( $a as $file)

                        {
                            if(date("m",strtotime($file)) == date('m') ){
                                $bulan = date('m');
                                $tanggal = date('d');
                                if(date("d",strtotime($file)) == date('d') ){
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
                                    
                                    if($taskku->id_task_type == 1){
                                        $uid = "CM-".date('ymd').$uid;
                                    }elseif($taskku->id_task_type == 2){
                                        $uid = "PM-".date('ymd').$uid;
                                    //  $uid = "CR-".date('ymd').$uid;
                                    }elseif($taskku->id_task_type == 4){
                                        $uid = "PLM-".date('ymd').$uid;
                                    }else{
                                        $uid = "CR-".date('ymd').$uid;
                                    }
                                    

                                    /*  Run your task here */
                    
                                    $task = new Task;
                                    $task->task_uid = $uid;
                                    $task->id_technician = $taskku->id_technician;
                                    $task->id_task_type = $taskku->id_task_type;
                                    
                                    if ($taskku->id_task_type == 1){
                                    $task->id_status = 1;  
                                    }
                                    else if ($taskku->id_task_type == 2 ){
                                    $task->id_status = 12;   
                                    }
                                    else if ($taskku->id_task_type == 4 ){
                                        $task->id_status = 24; 
                                    }
                                    else{
                                        $task->id_status = 35; 
                                        
                                    }
                                    
                                    $task->id_category = $taskku->id_category;
                                    $task->id_sub_category = $taskku->id_sub_category;
                                    $task->id_item = $taskku->id_item;
                                    $task->description = $taskku->description;
                                    $task->subject = $taskku->subject;
                                    $task->id_region = $taskku->id_region;
                                    $task->id_location_a = $taskku->id_location_a;
                                    $task->id_site_a = $taskku->id_site_a;
                                    $task->created_by = $taskku->created_by;
                                    // $task->frequency = $taskku->frequency;
                                    
                                    $attachment = 'default.png';
                                    // if($taskku->file('attachment')){
                                    //     $file = $taskku->file('attachment');
                                    //     $file->move(public_path().'/task_attachment', $file->getClientOriginalName());
                                    //     $attachment = $file->getClientOriginalName();
                                    // }
                                    $task->attachment = $attachment;
                                    $task->save();
                                    // ->monthlyOn(4, '15:00');
                                    // $jamku = "'".$jams.":".$menits."'";
                                    // $schedule->command('mycommand')->cron('0 17 3,5,7,22 * *');

                                    $task_detail = new TaskDetail;
                                    $task_detail->id_task_type = $taskku->id_task_type;
                                    $task_detail->id_task = $task->id_task;
                                    $task_detail->checklist_periode = $taskku->checklist_periode;
                                    $task_detail->id_checklist_category = $taskku->id_checklist_category;
                                    $task_detail->request_start_time = date('Y-m-d H:i:s');
                                    $task_detail->request_complete_time = date('Y-m-d 23:59:59');
                                    $task_detail->id_mode = $taskku->id_mode;
                                    $task_detail->id_impact = $taskku->id_impact;
                                    $task_detail->impact_detail = $taskku->impact_detail;
                                    $task_detail->id_priority = $taskku->id_priority;
                                    $task_detail->id_root_caused = $taskku->id_root_caused;
                                    $task_detail->id_asset = $taskku->id_asset;
                                    $task_detail->id_group_internal = $taskku->id_group_internal;
                                    // $task_detail->id_group_customer = $r->id_group_customer;
                                    $task_detail->id_group_customer = $taskku->id_group_customer;
                                    $task_detail->id_location_b = $taskku->id_location_b;
                                    $task_detail->id_site_b = $taskku->id_site_b; 
                                    $task_detail->total_hari_kerja = $taskku->total_hari_kerja;
                                    $task_detail->total_waktu_kerja = $taskku->total_waktu_kerja;
                                    $task_detail->down_start = $taskku->down_start;
                                    $task_detail->down_end = $taskku->down_end;
                                    $task_detail->save();
                                    
                                    $log = new TaskLog;
                                    $log->id_task = $task->id_task;
                                    $log->action = "CREATE";
                                    $log->status_to = 'OPEN';
                                    $log->changed_data_to = $task;
                                    $log->created_by = $task->created_by;
                                    $log->save();
                                }
                            }
                            
                        }
                       

                        // ===

                    })->$frequencies($tanggals, $clocks);
                }
        }

    }catch(\Exception $e){

        $tangkap = new TangkapError();
        $tangkap->title = "error scheduler";
        $tangkap->message = ''.$e ;
        $tangkap->save();

    }

        
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {

        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');

    }
}
