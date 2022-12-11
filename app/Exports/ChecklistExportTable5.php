<?php

namespace App\Exports;

use DateTime;
use App\Model\Task;
use App\Model\Site;
use App\Model\Region;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromArray;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithTitle;

class ChecklistExportTable5 implements FromView, ShouldAutoSize{
    use Exportable;

    private $id_region;
    public function __construct(int $id_region){
        $this->id_region = $id_region;
    }

    public function view(): View{
        $id_region = $this->id_region ;
        $ids = $this->id_region;
        $form_tahun = date('Y');
        $form_bulan = date('F');
        $year = date('Y');
        $month = date('m');
        $name = 'PM Site';
        $no_5 = 0;
        $selected_region = Region::where('region_id', $ids)->get();
        
        //for table 5
        $tb_5_year = date('y');
        $tb_5_month = date('m');
        $tb_5_week_0_first = \Carbon\Carbon::now()->startOfMonth()->subDays(10)->toDateString();
        $tb_5_week_0_last = \Carbon\Carbon::now()->startOfMonth()->subDays(1)->toDateString();
        $tb_5_week_1_first = \Carbon\Carbon::now()->startOfMonth()->toDateString();
        $tb_5_week_1_last = \Carbon\Carbon::now()->startOfMonth()->addDays(6)->toDateString();
        $tb_5_week_2_first = \Carbon\Carbon::now()->startOfMonth()->addDays(7)->toDateString();
        $tb_5_week_2_last = \Carbon\Carbon::now()->startOfMonth()->addDays(13)->toDateString();
        $tb_5_week_3_first = \Carbon\Carbon::now()->startOfMonth()->addDays(14)->toDateString();
        $tb_5_week_3_last = \Carbon\Carbon::now()->startOfMonth()->addDays(20)->toDateString();
        $tb_5_week_4_first = \Carbon\Carbon::now()->startOfMonth()->addDays(21)->toDateString();
        $tb_5_week_4_last = \Carbon\Carbon::now()->endOfMonth()->toDateString();

        //date table 5
        $month_before = date('m', strtotime($tb_5_week_0_first));
        $tb_5_week_0_date_first = date('d', strtotime($tb_5_week_0_first));
        $tb_5_week_0_date_last = date('d', strtotime($tb_5_week_0_last));
        $tb_5_week_1_date_first = date('d', strtotime($tb_5_week_1_first));
        $tb_5_week_1_date_last = date('d', strtotime($tb_5_week_1_last));
        $tb_5_week_2_date_first = date('d', strtotime($tb_5_week_2_first));
        $tb_5_week_2_date_last = date('d', strtotime($tb_5_week_2_last));
        $tb_5_week_3_date_first = date('d', strtotime($tb_5_week_3_first));
        $tb_5_week_3_date_last = date('d', strtotime($tb_5_week_3_last));
        $tb_5_week_4_date_first = date('d', strtotime($tb_5_week_4_first));
        $tb_5_week_4_date_last = date('d', strtotime($tb_5_week_4_last));
        
        //first last table 5
        $tb_5_w_0_0 = $year.'-'.$month_before.'-'.$tb_5_week_0_date_first;
        $tb_5_w_0_1 = $year.'-'.$month_before.'-'.$tb_5_week_0_date_last;

        $tb_5_w_1_0 = $year.'-'.$month.'-'.$tb_5_week_1_date_first;
        $tb_5_w_1_1 = $year.'-'.$month.'-'.$tb_5_week_1_date_last;

        $tb_5_w_2_0 = $year.'-'.$month.'-'.$tb_5_week_2_date_first;
        $tb_5_w_2_1 = $year.'-'.$month.'-'.$tb_5_week_2_date_last;

        $tb_5_w_3_0 = $year.'-'.$month.'-'.$tb_5_week_3_date_first;
        $tb_5_w_3_1 = $year.'-'.$month.'-'.$tb_5_week_3_date_last;

        $tb_5_w_4_0 = $year.'-'.$month.'-'.$tb_5_week_4_date_first;
        $tb_5_w_4_1 = $year.'-'.$month.'-'.$tb_5_week_4_date_last;

        // TABLE 5
        $site_table_5 = Site::select('site_id','name_site','region_id','kapasitas_genset')
                            ->where('region_id', $id_region)
                            ->where('id_site_category', 2) // terminal station
                            ->orWhere('region_id', $id_region)
                            ->where('id_site_category', 4) //repeater
                            ->orWhere('region_id', $id_region)
                            ->where('id_site_category', 3) //interkoneksi
                            ->get();
        foreach($site_table_5 as $st5 => $val){
            $id_site = $val->site_id;
            //task week 0
            $task_week_0 = Task::whereYear('tb_task.created_at',$year)
                                        // ->whereMonth('tb_task.created_at', $month_before)
                                        ->where('tb_task.created_at', '>=', $tb_5_w_0_0)
                                        ->where('tb_task.created_at', '<=', $tb_5_w_0_1)
                                        ->where('tb_task.is_deleted', '0')
                                        ->where('tb_task.id_site_a', $id_site)
                                        ->where('tb_task.id_task_type','2')
                                        ->where('tb_task.id_region',$id_region)
                                        ->where('tb_task.subject', 'like', '%' . $name . '%')  
                                        ->join('tb_detail_task', 'tb_task.id_task', '=', 'tb_detail_task.id_task')
                                        ->where('tb_detail_task.created_at', '>=', $tb_5_w_0_0)
                                        ->where('tb_detail_task.created_at', '<=', $tb_5_w_0_1)
                                        ->where('tb_detail_task.checklist_periode','1')
                                        ->join('tb_checklist_answers', 'tb_task.id_task', '=', 'tb_checklist_answers.id_task')
                                        ->where('tb_checklist_answers.created_at', '>=', $tb_5_w_0_0)
                                        ->where('tb_checklist_answers.created_at', '<=', $tb_5_w_0_1)
                                        ->select('tb_checklist_answers.id_task','tb_checklist_answers.datas')
                                        ->get();
            
            if(empty($task_week_0[0])){
                $val->tw_0_jam = 0;
                $val->tw_0_menit = 0;
                $val->id_task_week_0 = null;
            }
            if(!empty($task_week_0[0])){
                $decode_array_m = json_decode($task_week_0[0]->datas);
                $val->id_task_week_0 = $task_week_0[0]->id_task;
                foreach($decode_array_m as $k=>$v){
                    $array_m_key[$k] = $v->id_checklist;
                }

                $id_running = 2287;

                $search_key_running = array_search($id_running, $array_m_key);

                $tw_0_data_running = $decode_array_m[$search_key_running];

                $tw_0_running = $tw_0_data_running->answer;
                if(empty($tw_0_data_running->answer)){
                    $val->tw_0_jam = 0;
                    $val->tw_0_menit = 0;
                }
                if(!empty($tw_0_data_running->answer)){
                    $tw_0_data_hour = str_ireplace( array( 'H', 'h'), '/', $tw_0_running);
                    $tw_0_data_hour_2 = str_ireplace( array( 'M', 'm'), '', $tw_0_data_hour);
                    $tw_0_data_hour_3 = explode("/", $tw_0_data_hour_2, 2);
                    $val->tw_0_jam = $tw_0_data_hour_3[0];
                    //note : ini aku belum paham,bntu ini nanti den
                 //   $val->tw_0_menit = $tw_0_data_hour_3[1];
                }
                
            }

            //task week 1
            $task_week_1 = Task::whereYear('tb_task.created_at',$year)
                                        ->whereMonth('tb_task.created_at', $month)
                                        ->where('tb_task.created_at', '>=', $tb_5_w_1_0)
                                        ->where('tb_task.created_at', '<=', $tb_5_w_1_1)
                                        ->where('tb_task.is_deleted', '0')
                                        ->where('tb_task.id_site_a', $id_site)
                                        ->where('tb_task.id_task_type','2')
                                        ->where('tb_task.id_region',$id_region)
                                        ->where('tb_task.subject', 'like', '%' . $name . '%')  
                                        ->join('tb_detail_task', 'tb_task.id_task', '=', 'tb_detail_task.id_task')
                                        ->where('tb_detail_task.created_at', '>=', $tb_5_w_1_0)
                                        ->where('tb_detail_task.created_at', '<=', $tb_5_w_1_1)
                                        ->where('tb_detail_task.checklist_periode','1')
                                        ->join('tb_checklist_answers', 'tb_task.id_task', '=', 'tb_checklist_answers.id_task')
                                        ->where('tb_checklist_answers.created_at', '>=', $tb_5_w_1_0)
                                        ->where('tb_checklist_answers.created_at', '<=', $tb_5_w_1_1)
                                        ->select('tb_checklist_answers.id_task','tb_checklist_answers.datas')
                                        ->get();
            
            if(empty($task_week_1[0])){
                $val->tw_1_jam = 0;
                $val->tw_1_menit = 0;
                $val->id_task_week_1 = null;
            }
            if(!empty($task_week_1[0])){
                $decode_array_m = json_decode($task_week_1[0]->datas);
                $val->id_task_week_1 = $task_week_1[0]->id_task;
                foreach($decode_array_m as $k=>$v){
                    $array_m_key[$k] = $v->id_checklist;
                }

                $id_running = 2287;

                $search_key_running = array_search($id_running, $array_m_key);

                $tw_1_data_running = $decode_array_m[$search_key_running];

                $tw_1_running = $tw_1_data_running->answer;
                if(empty($tw_1_data_running->answer)){
                    $val->tw_1_jam = 0;
                    $val->tw_1_menit = 0;
                }
                if(!empty($tw_1_data_running->answer)){
                    $tw_1_data_hour = str_ireplace( array( 'H', 'h'), '/', $tw_1_running);
                    $tw_1_data_hour_2 = str_ireplace( array( 'M', 'm'), '', $tw_1_data_hour);
                    $tw_1_data_hour_3 = explode("/", $tw_1_data_hour_2, 2);
                    $val->tw_1_jam = $tw_1_data_hour_3[0];
                    $val->tw_1_menit = $tw_1_data_hour_3[1];
                }
                
            }
            
            //task week 2
            $task_week_2 = Task::whereYear('tb_task.created_at',$year)
                                        ->whereMonth('tb_task.created_at', $month)
                                        ->where('tb_task.created_at', '>=', $tb_5_w_2_0)
                                        ->where('tb_task.created_at', '<=', $tb_5_w_2_1)
                                        ->where('tb_task.is_deleted', '0')
                                        ->where('tb_task.id_site_a', $id_site)
                                        ->where('tb_task.id_task_type','2')
                                        ->where('tb_task.id_region',$id_region)
                                        ->where('tb_task.subject', 'like', '%' . $name . '%')  
                                        ->join('tb_detail_task', 'tb_task.id_task', '=', 'tb_detail_task.id_task')
                                        ->where('tb_detail_task.created_at', '>=', $tb_5_w_2_0)
                                        ->where('tb_detail_task.created_at', '<=', $tb_5_w_2_1)
                                        ->where('tb_detail_task.checklist_periode','1')
                                        ->join('tb_checklist_answers', 'tb_task.id_task', '=', 'tb_checklist_answers.id_task')
                                        ->where('tb_checklist_answers.created_at', '>=', $tb_5_w_2_0)
                                        ->where('tb_checklist_answers.created_at', '<=', $tb_5_w_2_1)
                                        ->select('tb_checklist_answers.id_task','tb_checklist_answers.datas')
                                        ->get();
            
            if(empty($task_week_2[0])){
                $val->tw_2_jam = 0;
                $val->tw_2_menit = 0;
                $val->id_task_week_2 = null;
            }
            if(!empty($task_week_2[0])){
                $decode_array_m = json_decode($task_week_2[0]->datas);
                $val->id_task_week_2 = $task_week_2[0]->id_task;
                foreach($decode_array_m as $k=>$v){
                    $array_m_key[$k] = $v->id_checklist;
                }

                $id_running = 2287;

                $search_key_running = array_search($id_running, $array_m_key);

                $tw_2_data_running = $decode_array_m[$search_key_running];

                $tw_2_running = $tw_2_data_running->answer;
                if(empty($tw_2_data_running->answer)){
                    $val->tw_2_jam = 0;
                    $val->tw_2_menit = 0;
                }
                if(!empty($tw_2_data_running->answer)){
                    $tw_2_data_hour = str_ireplace( array( 'H', 'h'), '/', $tw_2_running);
                    $tw_2_data_hour_2 = str_ireplace( array( 'M', 'm'), '', $tw_2_data_hour);
                    $tw_2_data_hour_3 = explode("/", $tw_2_data_hour_2, 2);
                    $val->tw_2_jam = $tw_2_data_hour_3[0];
                    $val->tw_2_menit = $tw_2_data_hour_3[1];
                }
                
            }
            //task week 3
            $task_week_3 = Task::whereYear('tb_task.created_at',$year)
                                        ->whereMonth('tb_task.created_at', $month)
                                        ->where('tb_task.created_at', '>=', $tb_5_w_3_0)
                                        ->where('tb_task.created_at', '<=', $tb_5_w_3_1)
                                        ->where('tb_task.is_deleted', '0')
                                        ->where('tb_task.id_site_a', $id_site)
                                        ->where('tb_task.id_task_type','2')
                                        ->where('tb_task.id_region',$id_region)
                                        ->where('tb_task.subject', 'like', '%' . $name . '%')  
                                        ->join('tb_detail_task', 'tb_task.id_task', '=', 'tb_detail_task.id_task')
                                        ->where('tb_detail_task.created_at', '>=', $tb_5_w_3_0)
                                        ->where('tb_detail_task.created_at', '<=', $tb_5_w_3_1)
                                        ->where('tb_detail_task.checklist_periode','1')
                                        ->join('tb_checklist_answers', 'tb_task.id_task', '=', 'tb_checklist_answers.id_task')
                                        ->where('tb_checklist_answers.created_at', '>=', $tb_5_w_3_0)
                                        ->where('tb_checklist_answers.created_at', '<=', $tb_5_w_3_1)
                                        ->select('tb_checklist_answers.id_task','tb_checklist_answers.datas')
                                        ->get();
            
            if(empty($task_week_3[0])){
                $val->tw_3_jam = 0;
                $val->tw_3_menit = 0;
                $val->id_task_week_3 = null;
            }
            if(!empty($task_week_3[0])){
                $decode_array_m = json_decode($task_week_3[0]->datas);
                $val->id_task_week_3 = $task_week_3[0]->id_task;
                foreach($decode_array_m as $k=>$v){
                    $array_m_key[$k] = $v->id_checklist;
                }

                $id_running = 2287;

                $search_key_running = array_search($id_running, $array_m_key);

                $tw_3_data_running = $decode_array_m[$search_key_running];

                $tw_3_running = $tw_3_data_running->answer;
                if(empty($tw_3_data_running->answer)){
                    $val->tw_3_jam = 0;
                    $val->tw_3_menit = 0;
                }
                if(!empty($tw_3_data_running->answer)){
                    $tw_3_data_hour = str_ireplace( array( 'H', 'h'), '/', $tw_3_running);
                    $tw_3_data_hour_2 = str_ireplace( array( 'M', 'm'), '', $tw_3_data_hour);
                    $tw_3_data_hour_3 = explode("/", $tw_3_data_hour_2, 2);
                    $val->tw_3_jam = $tw_3_data_hour_3[0];
                    $val->tw_3_menit = $tw_3_data_hour_3[1];
                }
                
            }
            //task week 4
            $task_week_4 = Task::whereYear('tb_task.created_at',$year)
                                        ->whereMonth('tb_task.created_at', $month)
                                        ->where('tb_task.created_at', '>=', $tb_5_w_4_0)
                                        ->where('tb_task.created_at', '<=', $tb_5_w_4_1)
                                        ->where('tb_task.is_deleted', '0')
                                        ->where('tb_task.id_site_a', $id_site)
                                        ->where('tb_task.id_task_type','2')
                                        ->where('tb_task.id_region',$id_region)
                                        ->where('tb_task.subject', 'like', '%' . $name . '%')  
                                        ->join('tb_detail_task', 'tb_task.id_task', '=', 'tb_detail_task.id_task')
                                        ->where('tb_detail_task.created_at', '>=', $tb_5_w_4_0)
                                        ->where('tb_detail_task.created_at', '<=', $tb_5_w_4_1)
                                        ->where('tb_detail_task.checklist_periode','1')
                                        ->join('tb_checklist_answers', 'tb_task.id_task', '=', 'tb_checklist_answers.id_task')
                                        ->where('tb_checklist_answers.created_at', '>=', $tb_5_w_4_0)
                                        ->where('tb_checklist_answers.created_at', '<=', $tb_5_w_4_1)
                                        ->select('tb_checklist_answers.id_task','tb_checklist_answers.datas')
                                        ->get();
            
            if(empty($task_week_4[0])){
                $val->tw_4_jam = 0;
                $val->tw_4_menit = 0;
                $val->id_task_week_4 = null;
            }
            if(!empty($task_week_4[0])){
                $decode_array_m = json_decode($task_week_4[0]->datas);
                $val->id_task_week_4 = $task_week_4[0]->id_task;
                foreach($decode_array_m as $k=>$v){
                    $array_m_key[$k] = $v->id_checklist;
                }

                $id_running = 2287;

                $search_key_running = array_search($id_running, $array_m_key);

                $tw_4_data_running = $decode_array_m[$search_key_running];

                $tw_4_running = $tw_4_data_running->answer;
                if(empty($tw_4_data_running->answer)){
                    $val->tw_4_jam = 0;
                    $val->tw_4_menit = 0;
                }
                if(!empty($tw_4_data_running->answer)){
                    $tw_4_data_hour = str_ireplace( array( 'H', 'h'), '/', $tw_4_running);
                    $tw_4_data_hour_2 = str_ireplace( array( 'M', 'm'), '', $tw_4_data_hour);
                    $tw_4_data_hour_3 = explode("/", $tw_4_data_hour_2, 2);
                    $val->tw_4_jam = $tw_4_data_hour_3[0];
                    $val->tw_4_menit = $tw_4_data_hour_3[1];
                }
                
            }

            if((float)$val->tw_1_menit >= (float)$val->tw_0_menit){
                $a_w_1 = (float)$val->tw_1_jam - (float)$val->tw_0_jam;
                $b_w_1 = (float)$val->tw_1_menit - (float)$val->tw_0_menit;
                $hitung_w_1 = ($a_w_1 + $b_w_1)/60;
                $total_rh_w_1 = 0.21 * (float)$val->kapasitas_genset * $hitung_w_1;
                $val->w_1 = number_format($total_rh_w_1,2);
            }
            if((float)$val->tw_1_menit < (float)$val->tw_0_menit){
                $a_w_1_before = (float)$val->tw_1_jam - 1;
                $a_w_1 = $a_w_1_before - (float)$val->tw_0_jam;
                $b_w_1_before = (float)$val->tw_1_menit + 60;
                $b_w_1 = $b_w_1_before - (float)$val->tw_0_menit;
                $hitung_w_1 = ($a_w_1 + $b_w_1)/60;
                $total_rh_w_1 = 0.21 * (float)$val->kapasitas_genset * $hitung_w_1;
                $val->w_1 = number_format($total_rh_w_1,2);
                // $val->w_1 = "0.21 *".$val->kapasitas_genset."* (".$a_w_1."+".$b_w_1.") / 60" ;
                // $val->w_1_1 = ($a_w_1 + $b_w_1)/60 ;
            }
            
            if((float)$val->tw_2_menit >= (float)$val->tw_1_menit){
                $a_w_2 = (float)$val->tw_2_jam - (float)$val->tw_1_jam;
                $b_w_2 = (float)$val->tw_2_menit - (float)$val->tw_1_menit;
                $hitung_w_2 = ($a_w_2 + $b_w_2)/60;
                $total_rh_w_2 = 0.21 * (float)$val->kapasitas_genset * $hitung_w_2;
                $val->w_2 = number_format($total_rh_w_2,2);
            }
            if((float)$val->tw_2_menit < (float)$val->tw_1_menit){
                $a_w_2_before = (float)$val->tw_2_jam - 1;
                $a_w_2 = $a_w_2_before - (float)$val->tw_1_jam;
                $b_w_2_before = (float)$val->tw_2_menit + 60;
                $b_w_2 = $b_w_2_before - (float)$val->tw_1_menit;
                $hitung_w_2 = ($a_w_2 + $b_w_2)/60;
                $total_rh_w_2 = 0.21 * (float)$val->kapasitas_genset * $hitung_w_2;
                $val->w_2 = number_format($total_rh_w_2,2);
            }
            
            if((float)$val->tw_3_menit >= (float)$val->tw_2_menit){
                $a_w_3 = (float)$val->tw_3_jam - (float)$val->tw_2_jam;
                $b_w_3 = (float)$val->tw_3_menit - (float)$val->tw_2_menit;
                $hitung_w_3 = ($a_w_3 + $b_w_3)/60;
                $total_rh_w_3 = 0.21 * (float)$val->kapasitas_genset * $hitung_w_3;
                $val->w_3 = number_format($total_rh_w_3,2);
            }
            if((float)$val->tw_3_menit < (float)$val->tw_2_menit){
                $a_w_3_before = (float)$val->tw_3_jam - 1;
                $a_w_3 = (float)$val->tw_3_jam - (float)$val->tw_2_jam;
                $b_w_3_before = (float)$val->tw_3_menit + 60;
                $b_w_3 = $b_w_3_before - (float)$val->tw_2_menit;
                $hitung_w_3 = ($a_w_3 + $b_w_3)/60;
                $total_rh_w_3 = 0.21 * (float)$val->kapasitas_genset * $hitung_w_3;
                $val->w_3 = number_format($total_rh_w_3,2);
            }

            if((float)$val->tw_4_menit >= (float)$val->tw_3_menit){
                $a_w_4 = (float)$val->tw_4_jam - (float)$val->tw_3_jam;
                $b_w_4 = (float)$val->tw_4_menit - (float)$val->tw_3_menit;
                $hitung_w_4 = ($a_w_4 + $b_w_4)/60;
                $total_rh_w_4 = 0.21 * (float)$val->kapasitas_genset * $hitung_w_4;
                $val->w_4 = number_format($total_rh_w_4,2);
            }
            if((float)$val->tw_4_menit < (float)$val->tw_3_menit){
                $a_w_4_before = (float)$val->tw_4_jam - 1;
                $a_w_4 = $a_w_4_before - (float)$val->tw_3_jam;
                $b_w_4_before = (float)$val->tw_4_menit + 60;
                $b_w_4 = $b_w_4_before - (float)$val->tw_3_menit;
                $hitung_w_4 = ($a_w_4 + $b_w_4)/60;
                $total_rh_w_4 = 0.21 * (float)$val->kapasitas_genset * $hitung_w_4;
                $val->w_4 = number_format($total_rh_w_4,2);
            }

            $val->w_total = $val->w_1 + $val->w_2 + $val->w_3 + $val->w_4;
        }

        return view('form_bulanan.download_table_5', [
            'site_table_5' => $site_table_5,
            'no_5'=>$no_5,
            'ids'=>$ids,
            'form_tahun'=>$form_tahun,
            'form_bulan'=>$form_bulan,
            'selected_region'=>$selected_region,
        ]);
    }


    // private $year;

    // private $month;

    // // private $fileName = "users.xlsx";
    // public function __construct(int $year, int $month){
    //     $this->year = $year;
    //     $this->month = $month;
    // }
    
    // public function query()
    // {
    //     // dd(User::with('address')->first());
    //     return User::query()->with('address')->whereYear('created_at', $this->year)->whereMonth('created_at', $this->month);
    // }

    // public function map($user):array{
    //     return [
    //         $user->id,
    //         $user->email,
    //         $user->address->country,
    //         $user->created_at,
    //     ];
    // }

    // public function headings(): array{
    //     return [
    //         '#',
    //         'email',
    //         'country',
    //         'create at',
    //     ];
    // }

    // public function registerEvents():array{
    //     return [
    //         AfterSheet::class => function (AfterSheet $event){
    //             $event->sheet->getStyle('A8:D8')->applyFromArray([
    //                 'font' => [
    //                     'bold' => true,
    //                 ],
    //                 'borders' => [
    //                     'outline' => [
    //                         'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
    //                         'color' => ['argb' => 'FFFF0000'],
    //                     ],
    //                 ]
    //             ]);
    //         }
    //     ];
    // }

    // public function drawings()
    // {
    //     $drawing = new Drawing();
    //     $drawing->setName('Logo');
    //     $drawing->setDescription('This is my logo');
    //     $drawing->setPath(public_path('logo_crowd.png'));
    //     $drawing->setHeight(90);
    //     $drawing->setCoordinates('B2');

    //     return $drawing;
    // }

    // public function startCell():string{
    //     return 'A8';
    // }

    // public function title(): string
    // {
    //     // return 'a';
    //     return DateTime::createFromFormat('!m', $this->month)->format('F');
    // }

}
