<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\ChecklistExport;
use App\Exports\ChecklistExportTable3;
use App\Exports\ChecklistExportTable4;
use App\Exports\ChecklistExportTable5;
use App\Excels\Detail_Task;
use Maatwebsite\Excel\Excel;
use App\Model\Task;
use App\Model\Site;
use App\Model\Region;

class FormBulananController extends Controller
{
    public function index($id_region){
        $year = date('Y');
        $month = 11;
        $form_tahun = date('Y');
        $form_bulan = 11;
        $name = 'PM Site';
        $no = 0;
        $no_3 = 0;
        $no_4 = 0;
        $no_5 = 0;
        $datelastDayofMonth = \Carbon\Carbon::now()->endOfMonth()->subDays(7)->toDateString();
        $real = \Carbon\Carbon::now()->endOfMonth()->toDateString();
        $reallast = date('d',strtotime($real));
        $lastdate =date('d',strtotime($datelastDayofMonth));
        $last = $year.'-'.$month.'-'.$lastdate;
        $latest = $year.'-'.$month.'-'.$reallast;
        $regions = Region::get();
        $selected_region = Region::where('region_id', $id_region)->get();
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

        // setiap region punya site -> site_table_2
        $site_table_2 = Site::where('region_id', $id_region)
                            ->where('id_site_category', 2) // terminal station
                            ->orWhere('region_id', $id_region)
                            ->where('id_site_category', 4) //repeater
                            ->orWhere('region_id', $id_region)
                            ->where('id_site_category', 3) //interkoneksi
                            ->get();
        $full_data_2 = $site_table_2;
        foreach($site_table_2 as $st2=>$val){
            $id_site = $val->site_id;
            $val->task_bulanan = Task::whereYear('tb_task.created_at',$year)
                                        ->whereMonth('tb_task.created_at', $month)
                                        ->where('tb_task.id_site_a', $id_site)
                                        ->where('tb_task.id_task_type','2')
                                        ->where('tb_task.id_region',$id_region)
                                        ->where('tb_task.subject', 'like', '%' . $name . '%') 
                                        ->join('tb_detail_task', 'tb_task.id_task', '=', 'tb_detail_task.id_task')
                                        ->where('tb_detail_task.checklist_periode','2')
                                        ->join('tb_checklist_answers', 'tb_task.id_task', '=', 'tb_checklist_answers.id_task')
                                        ->get();
            $val->task_mingguan = Task::where('tb_task.created_at', '>=', $last)
                                        ->where('tb_task.created_at', '<=', $latest)
                                        ->where('tb_task.id_site_a', $id_site)
                                        ->where('tb_task.id_task_type','2')
                                        ->where('tb_task.id_region',$id_region)
                                        ->where('tb_task.subject', 'like', '%' . $name . '%')  
                                        ->join('tb_detail_task', 'tb_task.id_task', '=', 'tb_detail_task.id_task')
                                        ->where('tb_detail_task.checklist_periode','1')
                                        ->join('tb_checklist_answers', 'tb_task.id_task', '=', 'tb_checklist_answers.id_task')
                                        ->get();
            if(empty($val->task_bulanan[0])){
                $val->power_ground = 'empty';
                $val->ats = 'empty';
                $val->rectifier = 'empty';
            }
            if(!empty($val->task_bulanan[0])){
                $decode_array_m = json_decode($val->task_bulanan[0]->datas);
                foreach($decode_array_m as $k => $v){
                    $array_m_key[$k]= $v->id_checklist;
                }
                $id_power_ground = 2422;
                $id_ats = 2417;
                $id_rectifier = 2457;

                $search_key_power_ground = array_search($id_power_ground, $array_m_key);
                $search_key_ats = array_search($id_ats, $array_m_key);
                $search_key_rectifier = array_search($id_rectifier, $array_m_key);

                $val->data_power_ground = $decode_array_m[$search_key_power_ground];
                $val->data_ats = $decode_array_m[$search_key_ats];
                $val->data_rectifier = $decode_array_m[$search_key_rectifier];

                $val->power_ground = $val->data_power_ground->is_avaiable;
                $val->ats = $val->data_ats->is_avaiable;
                $val->rectifier = $val->data_rectifier->is_avaiable;
                $val->id_bulanan = $val->task_bulanan[0]->id_task;
            }
            if(empty($val->task_mingguan[0])){
                $val->pln = 'empty';
                $val->genset = 'empty';
                $val->solar = 'empty';
            }
            if(!empty($val->task_mingguan[0])){
                $decode_array_m = json_decode($val->task_mingguan[0]->datas);

                $array_m_key = [];
                foreach($decode_array_m as $k=>$v){
                    $array_m_key[$k] = $v->id_checklist;
                }

                $id_pln = 2263;
                $id_genset = 2290;
                $id_solar = 2296;

                $search_key_pln = array_search($id_pln, $array_m_key);
                $search_key_genset = array_search($id_genset, $array_m_key);
                $search_key_solar = array_search($id_solar, $array_m_key);

                $val->data_pln = $decode_array_m[$search_key_pln];
                $val->data_genset = $decode_array_m[$search_key_genset];
                $val->data_solar = $decode_array_m[$search_key_solar];

                $val->pln = $val->data_pln->is_avaiable;
                $val->genset = $val->data_genset->is_avaiable;
                $val->solar = $val->data_solar->is_avaiable;
                $val->id_mingguan = $val->task_mingguan[0]->id_task;
            }
            $val->keterangan = 'Empty';
            if($val->power_ground == 'OK' || $val->ats == 'OK' || $val->rectifier == 'OK' || $val->pln == 'OK' || $val->genset == 'OK' || $val->solar == 'OK'){
                $val->keterangan = 'Semua OK';
            }
            if($val->power_ground == 'NOT OK' || $val->ats == 'NOT OK' || $val->rectifier == 'NOT OK' || $val->pln == 'NOT OK' || $val->genset == 'NOT OK' && $val->solar == 'NOT OK'){
                $val->keterangan = 'Ada data yang tidak OK';
            }
        
            
        }

        
        // TABLE 3
        $site_table_3 = Site::where('region_id', $id_region)
                            ->where('id_site_category', 2) // terminal station
                            ->orWhere('region_id', $id_region)
                            ->where('id_site_category', 4) //repeater
                            ->orWhere('region_id', $id_region)
                            ->where('id_site_category', 3) //interkoneksi
                            ->get();
        
        $full_data_3 = $site_table_3;

        foreach($site_table_3 as $st3=>$val){
            $id_site = $val->site_id;
            $val->task_bulanan = Task::join('tb_detail_task', 'tb_task.id_task', '=', 'tb_detail_task.id_task')
                                        ->join('tb_checklist_answers', 'tb_task.id_task', '=', 'tb_checklist_answers.id_task')
                                        ->where('tb_task.is_deleted', '0')
                                        ->where('tb_task.id_site_a', $id_site)
                                        ->where('tb_task.id_task_type','2')
                                        ->where('tb_task.id_region',$id_region)
                                        ->whereYear('tb_task.created_at',$year)
                                        ->whereMonth('tb_task.created_at', $month)
                                        ->where('tb_detail_task.checklist_periode','2')
                                        ->where('tb_task.subject', 'like', '%' . $name . '%')    
                                        ->get();
            if(empty($val->task_bulanan[0])){
                $val->tower = 'Empty';
                $val->shelter = 'Empty';
                $val->site = 'Empty';
                $val->akses = 'Empty';
            }

            if(!empty($val->task_bulanan[0])){
                $decode_array_m = json_decode($val->task_bulanan[0]->datas);
                $array_m_key = [];
                foreach($decode_array_m as $k => $v){
                    $array_m_key[$k]= $v->id_checklist;
                }
                $id_tower = 2425;
                $id_shelter = 2449;
                $id_site = 2425;
                $id_akses = 2425;

                $search_key_tower = array_search($id_tower, $array_m_key);
                $search_key_shelter = array_search($id_shelter, $array_m_key);
                $search_key_site = array_search($id_site, $array_m_key);
                $search_key_akses = array_search($id_akses, $array_m_key);

                $val->id_bulanan = $val->task_bulanan[0]->id_task;

                $val->data_tower = $decode_array_m[$search_key_tower];
                $val->data_shelter = $decode_array_m[$search_key_shelter];
                $val->data_site = $decode_array_m[$search_key_site];
                $val->data_akses = $decode_array_m[$search_key_akses];


                $val->tower = $val->data_tower->is_avaiable;
                $val->shelter = $val->data_shelter->is_avaiable;
                $val->site = $val->data_site->is_avaiable;
                $val->akses = $val->data_akses->is_avaiable;
            }
            $val->keterangan_3 = 'Empty';
            if($val->tower == 'OK' || $val->shelter == 'OK' || $val->site == 'OK' || $val->akses == 'OK'){
                $val->keterangan_3 = 'Semua OK';
            }
            if($val->tower == 'NOT OK' || $val->shelter == 'NOT OK' || $val->site == 'NOT OK' || $val->akses == 'NOT OK'){
                $val->keterangan_3 = 'Ada yang tidak OK';
            }
        }

        // TABLE 4
        $site_table_4 = Site::where('region_id', $id_region)
                            ->where('id_site_category', 2) // terminal station
                            ->orWhere('region_id', $id_region)
                            ->where('id_site_category', 3) //interkoneksi
                            ->get();
        $full_data_4 = $site_table_4;
        foreach($site_table_4 as $st4 =>$val){
            $id_site = $val->site_id;
            $val->task_mingguan = Task::join('tb_detail_task', 'tb_task.id_task', '=', 'tb_detail_task.id_task')
                                        ->join('tb_checklist_answers', 'tb_task.id_task', '=', 'tb_checklist_answers.id_task')
                                        ->where('tb_task.is_deleted', '0')
                                        ->where('tb_task.id_site_a', $id_site)
                                        ->where('tb_task.id_task_type','2')
                                        ->where('tb_task.created_at', '>=', $last)
                                        ->where('tb_task.created_at', '<=', $latest)
                                        ->where('tb_detail_task.checklist_periode','1')
                                        ->where('tb_task.subject', 'like', '%' . $name . '%')    
                                        ->get();
                        
            if (empty($val->task_mingguan[0])) {
                
                $val->kapasitas_kwh = null;
                $val->beban_aman = null;
                $val->r_s = null;
                $val->s_t = null;
                $val->r_t = null;
                $val->r_n = null;
                $val->s_n = null;
                $val->t_n = null;
                $val->r = null;
                $val->s = null;
                $val->t = null;
                $val->beban_total = null;
                $val->persentase_beban = null;
                $val->id_mingguan = null;
            }
                 
            if (!empty($val->task_mingguan[0])) {
                $decode_array_m = json_decode($val->task_mingguan[0]->datas);

                $array_m_key = [];
                foreach($decode_array_m as $k=>$v){
                    $array_m_key[$k] = $v->id_checklist;
                }
                $r_s = 2263;
                $s_t = 2264;
                $r_t = 2265;
                $r_n = 2266;
                $s_n = 2267;
                $t_n = 2268;
                $r = 2270;
                $s = 2271;
                $t = 2272;
                $search_key_r_s = array_search($r_s, $array_m_key);
                $search_key_s_t = array_search($s_t, $array_m_key);
                $search_key_r_t = array_search($r_t, $array_m_key);
                $search_key_r_n = array_search($r_n, $array_m_key);
                $search_key_s_n = array_search($s_n, $array_m_key);
                $search_key_t_n = array_search($t_n, $array_m_key);
                $search_key_r = array_search($r, $array_m_key);
                $search_key_s = array_search($s, $array_m_key);
                $search_key_t = array_search($t, $array_m_key);

                $val->id_mingguan = $val->task_mingguan[0]->id_task;
                $val->r_s = $decode_array_m[$search_key_r_s];
                $val->s_t = $decode_array_m[$search_key_s_t];
                $val->r_t = $decode_array_m[$search_key_r_t];
                $val->r_n = $decode_array_m[$search_key_r_n];
                $val->s_n = $decode_array_m[$search_key_s_n];
                $val->t_n = $decode_array_m[$search_key_t_n];
                $val->r = $decode_array_m[$search_key_r];
                $val->s = $decode_array_m[$search_key_s];
                $val->t = $decode_array_m[$search_key_t];
                $val->beban_kapasitas_kwh = (float)$val->kapasitas_kwh;
                $val->beban_aman = (float)$val->kapasitas_kwh / 100 * 80;
                $val->beban_total = number_format(380*((float)$val->r->answer + (float)$val->s->answer + (float)$val->t->answer) / 3 * 1.73, 2);
                // dd(preg_replace("/[^0-9]/","",$val->r->answer));
                $val->persentase_beban = number_format(380* ( 
                     floatval(preg_replace("/[^0-9]/","",$val->r->answer)) + 
                    floatval(preg_replace("/[^0-9]/","",$val->s->answer)) + 
                    floatval(preg_replace("/[^0-9]/","",$val->t->answer))
                    ) / 3 * 1.73 / 
                    floatval(preg_replace("/[^0-9]/","",$val->kapasitas_kwh)) * 100, 2).' %';
            }

        }

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

                $id_running = 2740;

                $search_key_running = array_search($id_running, $array_m_key);

                $tw_0_data_running = $decode_array_m[$search_key_running];

                $tw_0_running = $tw_0_data_running->answer;
                if(empty($tw_0_data_running->answer)){
                    $val->tw_0_jam = 0;
                    $val->tw_0_menit = 0;
                }
                if(!empty($tw_0_data_running->answer)){
                    $tw_0_data_hour = str_ireplace( array( 'H', 'h'), '', $tw_0_running);
                    $tw_0_data_hour_2 = str_ireplace( array( 'M', 'm'), '', $tw_0_data_hour);
                    $tw_0_data_hour_3 = explode("/", $tw_0_data_hour_2, 2);
                    $val->tw_0_jam = $tw_0_data_hour_3[0];
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

                $id_running = 2740;

                $search_key_running = array_search($id_running, $array_m_key);

                $tw_1_data_running = $decode_array_m[$search_key_running];

                $tw_1_running = $tw_1_data_running->answer;
                if(empty($tw_1_data_running->answer)){
                    $val->tw_1_jam = 0;
                    $val->tw_1_menit = 0;
                }
                if(!empty($tw_1_data_running->answer)){
                    $tw_1_data_hour = str_ireplace( array( 'H', 'h'), '', $tw_1_running);
                    $tw_1_data_hour_2 = str_ireplace( array( 'M', 'm'), '', $tw_1_data_hour);
                    $tw_1_data_hour_3 = explode("/", $tw_1_data_hour_2, 2);
                    $val->tw_1_jam = $tw_1_data_hour_3[0];
                   // $val->tw_1_menit = $tw_1_data_hour_3[1];
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

                $id_running = 2740;

                $search_key_running = array_search($id_running, $array_m_key);

                $tw_2_data_running = $decode_array_m[$search_key_running];

                $tw_2_running = $tw_2_data_running->answer;
                if(empty($tw_2_data_running->answer)){
                    $val->tw_2_jam = 0;
                    $val->tw_2_menit = 0;
                }
                if(!empty($tw_2_data_running->answer)){
                    $tw_2_data_hour = str_ireplace( array( 'H', 'h'), '', $tw_2_running);
                    $tw_2_data_hour_2 = str_ireplace( array( 'M', 'm'), '', $tw_2_data_hour);
                    $tw_2_data_hour_3 = explode("/", $tw_2_data_hour_2, 2);
                    $val->tw_2_jam = $tw_2_data_hour_3[0];
                    //note : ini masi saya comment den
                 //   $val->tw_2_menit = $tw_2_data_hour_3[1];
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

                // $id_running = 2287;
                $id_running = 2740;

                $search_key_running = array_search($id_running, $array_m_key);

                $tw_3_data_running = $decode_array_m[$search_key_running];

                $tw_3_running = $tw_3_data_running->answer;
                if(empty($tw_3_data_running->answer)){
                    $val->tw_3_jam = 0;
                    $val->tw_3_menit = 0;
                }
                if(!empty($tw_3_data_running->answer)){
                    $tw_3_data_hour = str_ireplace( array( 'H', 'h'), '', $tw_3_running);
                    $tw_3_data_hour_2 = str_ireplace( array( 'M', 'm'), '', $tw_3_data_hour);
                    $tw_3_data_hour_3 = explode("/", $tw_3_data_hour_2, 2);
                    $val->tw_3_jam = $tw_3_data_hour_3[0];
                    // $val->tw_3_menit = $tw_3_data_hour_3[1];
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

                $id_running = 2740;

                $search_key_running = array_search($id_running, $array_m_key);

                $tw_4_data_running = $decode_array_m[$search_key_running];

                $tw_4_running = $tw_4_data_running->answer;
                if(empty($tw_4_data_running->answer)){
                    $val->tw_4_jam = 0;
                    $val->tw_4_menit = 0;
                }
                // dd(str_ireplace( array( 'H', 'h'), '/', $tw_4_running));
                if(!empty($tw_4_data_running->answer)){
                    $tw_4_data_hour = str_ireplace( array( 'H', 'h'), '', $tw_4_running);
                    $tw_4_data_hour_2 = str_ireplace( array( 'M', 'm'), '', $tw_4_data_hour);
                    $tw_4_data_hour_3 = explode("/", $tw_4_data_hour_2, 2);
                    $val->tw_4_jam = $tw_4_data_hour_3[0];
                    // $val->tw_4_menit = $tw_4_data_hour_3[1];
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
        // return response()->json($site_table_5);
        return view('form_bulanan.index', compact('form_tahun','form_bulan','site_table_2','no','site_table_3','no_3','site_table_4','no_4', 'site_table_5', 'no_5','selected_region','regions'));
    }

    

    private $excel;

    public function __construct(Excel $excel){
        $this->excel = $excel;
    }
    public function download_table_2($id_region){
        $regions = Region::where('region_id', $id_region)->get();
        $name = $regions[0]->region_name;
        $year = date('Y');
        $month = date('F');

       
        return $this->excel->download(new ChecklistExport($id_region), 'Table-2 ['.$name.'-'.$month.'-'.$year.'].xlsx');
    }

    public function download_table_3($id_region){
        $regions = Region::where('region_id', $id_region)->get();
        $name = $regions[0]->region_name;
        $year = date('Y');
        $month = date('F');
        return $this->excel->download(new ChecklistExportTable3($id_region), 'Table-3 ['.$name.'-'.$month.'-'.$year.'].xlsx');
    }

    public function download_table_4($id_region){
        $regions = Region::where('region_id', $id_region)->get();
        $name = $regions[0]->region_name;
        $year = date('Y');
        $month = date('F');
        return $this->excel->download(new ChecklistExportTable4($id_region), 'Table-4 ['.$name.'-'.$month.'-'.$year.'].xlsx');
    }

    public function download_table_5($id_region){
        $regions = Region::where('region_id', $id_region)->get();
        $name = $regions[0]->region_name;
        $year = date('Y');
        $month = date('F');
        return $this->excel->download(new ChecklistExportTable5($id_region), 'Table-5 ['.$name.'-'.$month.'-'.$year.'].xlsx');
    }
}
