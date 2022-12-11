<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use \App\Model\TaskSchedule;
use \App\Model\Task;

class taskPm extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sg:taskPm';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $tasks = TaskSchedule::all();
        foreach ($tasks as $taskku){
            // $frequency = $taskku->frequency;

            // $real = new Task;

            // $real->nama = $a->name;
            // $category->description = $a->description;

            // $category->save();
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
            
            // if(true){
                $task = new Task;
                $task->task_uid = $uid;
                $task->id_technician = 1;
                $task->id_task_type = 1;
                
                // if ($taskku->id_task_type == 1){
                //   $task->id_status = 1;  
                // }
                // else if ($taskku->id_task_type == 2 ){
                //    $task->id_status = 12;   
                // }
                // else if ($taskku->id_task_type == 4 ){
                //      $task->id_status = 24; 
                // }
                // else{
                //     $task->id_status = 35; 
                    
                // }
                
                $task->id_category = 1;
                $task->id_sub_category = 1;
                $task->id_item = 1;
                $task->description = 1;
                $task->subject = $taskku->subject;
                $task->id_region = 1;
                $task->id_location_a = 1;
                $task->id_site_a = 1;
                $task->created_by = 1;
                // $task->frequency = $taskku->frequency;
                
                $attachment = 'default.png';
                $task->attachment = $attachment;
                $task->save();
            
        }
    }
}
