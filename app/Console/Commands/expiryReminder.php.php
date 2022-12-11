<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use \App\Model\TaskSchedule;
use \App\Model\Task;

class taskexpiryReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'task:expiry';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'expriry reminder';

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
        log::info('test cron');

        // $now = date('Y-m-d H:i:s');
        // $nowMin1 = date('Y-m-d H:i:s', strtotime("$now -1 Hours"));
        // $tasks = \App\Model\Task::join('tb_task_detail', 'tb_task_detail.id_task', 'tb_task.id_task')
        //     ->where('tb_task.id_technician', 106)
        //     ->whereTime('tb_task_detail.request_complete_time', $nowMin1)->whereIn('id_status', [12, 24, 35])->get();
        // $msg = "expriry reminder start";
        // \Log::info("NEAR EXPIRED TASK: " . count($tasks));
        // foreach ($tasks as $task) {
        //     if ($task) {
        //         $technician = $task->technician;
        //         $msg = "expriry reminder get Technichian";
        //         if ($technician) {
        //             $user = $technician->user;
        //             $msg = "expriry reminder get user";
        //             if ($user) {
        //                 $tokens = [];
        //                 if ($user->firebase_token) $tokens[] = $user->firebase_token;
        //                 if ($user->firebase_token_web) $tokens[] = $user->firebase_token_web;
        //                 $msg = "expriry reminder get token";
        //                 if (count($tokens)) {
        //                     $msg = "expriry reminder sended";
        //                     sendTaskNotif($task, $tokens, "Task akan kadaluarsa", "Task#$task->task_uid akan kadaluarsa");
        //                     save_notif($task, $tokens, "Update Task", "task has been updated", "UPDATE_TASK");
        //                 }
        //             }
        //         }
        //     }
        //     \Log::info($msg);
        // }
    }
}
