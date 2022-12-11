<?php

namespace App\Exports;
use App\Model\Task;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class UserMultiSheetExport implements WithMultipleSheets
{
    private $year;

    public function __construct(int $year)
    {
        $this->year = $year;
    }

    public function sheets(): array
    {
        $sheets = [];
        $coll = collect(['22']);
        // $a = Task::where('id_status', '=' , $coll )->count('id_task');
        
        // $day_now = date("Y-m-d", strtotime("0 days"));
        // $day_1 = date("Y-m-d", strtotime("-1 days"));
        // $day_2 = date("Y-m-d", strtotime("-2 days"));
        // $day_3 = date("Y-m-d", strtotime("-3 days"));
        // $day_4 = date("Y-m-d", strtotime("-4 days"));
        // $day_5 = date("Y-m-d", strtotime("-5 days"));
        // $day_6 = date("Y-m-d", strtotime("-6 days"));
        // $day_7 = date("Y-m-d", strtotime("-7 days"));
        // $coll_day = collect([$day_now,$day_1, $day_2, $day_3, $day_4, $day_5, $day_6, $day_7]);
        
        
        // $b = Task::where('id_task_type', '=', '2')->whereDate('created_at', '=', date('Y-m-d', strtotime("-7 days")))->where('id_status', '=' , $coll )
        // ->orwhereDate('created_at', '=', date('Y-m-d', strtotime("-6 days")))->where('id_task_type', '=', '2')->where('id_status', '=' , $coll )
        // ->orwhereDate('created_at', '=', date('Y-m-d', strtotime("-5 days")))->where('id_task_type', '=', '2')->where('id_status', '=' , $coll )
        // ->orwhereDate('created_at', '=', date('Y-m-d', strtotime("-4 days")))->where('id_task_type', '=', '2')->where('id_status', '=' , $coll )
        // ->orwhereDate('created_at', '=', date('Y-m-d', strtotime("-3 days")))->where('id_task_type', '=', '2')->where('id_status', '=' , $coll )
        // ->orwhereDate('created_at', '=', date('Y-m-d', strtotime("-2 days")))->where('id_task_type', '=', '2')->where('id_status', '=' , $coll )
        // ->orwhereDate('created_at', '=', date('Y-m-d', strtotime("-1 days")))->where('id_task_type', '=', '2')
        // ->orwhereDate('created_at', '=', date('Y-m-d', strtotime("0 days")))->where('id_task_type', '=', '2')
        // ->where('id_status', '=' , $coll )->get();
        
        $year = date('Y');
        $month = date('m');
        $tb_5_week_0_first = \Carbon\Carbon::now()->subDays(6)->toDateString();
        $tb_5_week_0_date_first = date('d', strtotime($tb_5_week_0_first));
        $tb_5_w_0_0 = $year.'-'.$month.'-'.$tb_5_week_0_date_first;
        // dd($tb_5_w_0_0);
        
        
        $b = Task::where('id_task_type', '=', '2')->where('id_status', '=', '22')->where('is_deleted', '=', '0')->where('tb_task.created_at', '>=', $tb_5_w_0_0)->get();
        // dd($b);

        // for ($month = 1; $month <= 12; $month++) {
        //     $sheets[] = new UsersExport($this->year, $month);
        // }
        
        foreach($b as $c){
            $d = $c->id_task;
            $e = $c->task_uid;
            $subject = $c->subject;
            $sheets[] = new UsersExport($this->year, $d, $e,$subject);
        }
        // dd($sheets);
        return $sheets;
    }
}