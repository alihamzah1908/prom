<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \App\Model\Task;
use \App\Model\TaskDetail;
use \App\Model\Priority;
use \App\Model\Status;
use \App\Model\RootCaused;
use \App\Model\Region;
use \App\Model\Segment;
use \App\Model\Aktivasi;
use \App\Model\Customer;
use \App\Model\AktivasiStatus;
use \App\Model\AktivasiStatusCollocation;
use \App\Model\Site;
use \App\Model\SiteEntry;
use \App\Model\PermitLetter;
use \App\Model\SubCategory;
use \App\Model\Category;
use \App\Model\Capacity;
use \App\Model\TotalCapacity;
use \App\Model\Technician;

class HomeServerController extends Controller
{
    private $colors_name = [ 'blue' => "#007bff",
                        'indigo' => "#6610f2",
                        'purple' => "#6f42c1",
                        'pink' => "#e83e8c",
                        'red' => "#dc3545",
                        'orange' => "#fd7e14",
                        'yellow' => "#ffc107",
                        'green' => "#28a745",
                        'teal' => "#20c997",
                        'cyan' => "#17a2b8",
                        'white' => "#ffffff",
                        'gray' => "#6c757d",
                        'gray_dark' => "#343a40",
                        'primary' => "#007bff",
                        'secondary' => "#6c757d",
                        'success' => "#28a745",
                        'info' => "#17a2b8",
                        'warning' => "#ffc107",
                        'danger' => "#dc3545",
                        'light' => "#f8f9fa",
                        'dark' => "#343a40"
                       ];
    private $colors_index = ["#007bff","#6610f2","#6f42c1","#e83e8c","#dc3545","#fd7e14","#ffc107","#28a745","#20c997","#17a2b8","#007bff","#28a745","#17a2b8","#ffc107","#dc3545","#f8f9fa"];
    
    public function index()
    {
        $view = request()->view;
        $r_view = request()->view;
        if($view == "LAYANAN"){
            $view = "dashboard.aktivasi";
        }elseif($view == "SITE_ENTRY"){
            $view = "dashboard.site_entry";
        }elseif($view == "PERMIT_LETTER"){
            $view = "dashboard.permit_letter";
        }else{
            $view = "dashboard.task";
            $r_view = "TASK";
        }
        $date = date('Y-m-d');
        
        
        $firstDayUTS = mktime(0, 0, 0, date("m", strtotime($date)), 1, date("Y", strtotime($date)));
        $lastDayUTS = mktime(0, 0, 0, date("m", strtotime($date)), date('t', strtotime($date)), date("Y", strtotime($date)));
        
        $start = date("Y-m-d", $firstDayUTS);
        $finish = date("Y-m-d", $lastDayUTS);
        
        $datas = [];
        $labels = [];
        
        $label = [];
        $data_sub = [];
        
        foreach(Technician::where('region_id', '=', '9')->get() as $key => $d){
            $label[] = $d->name_technician;
            $data_sub2[] = Task::where('id_region', '=', '9')
                        ->where('id_task_type', '=','2')
                        ->where('id_technician', $d->id_technician)
                        ->whereBetween('created_at', ["$start 00:00:00", "$finish 23:59:59"])
                        ->count();
            $data_sub[] = Task::where('tb_task.id_region', '=','9')
                        ->where('id_task_type','=', '2')
                        ->where('id_technician', $d->id_technician)
                        ->whereIn('tb_task.id_status', collect(['22','34','42']))
                        ->whereBetween('created_at', ["$start 00:00:00", "$finish 23:59:59"])
                        ->count();
            
                        
        }
        $datas['pencapaian'] = $data_sub;
        $datas['target'] = $data_sub2;
        
        $data = [];
        $data['dataset'] = $datas;
        // $a = ['data1' => $data_sub, data_sub2];
        // $b= $a['data_sub'];
        // dd($datas['target']);
        return view('dashboard.dashboard', compact('view', 'r_view','data_sub', 'data_sub2','label', 'datas'));
    }

    public function test()
    {
        return view('dashboard.test');
    }
    
    public function dashboard_data_clicked(Request $r)
    {
        $type = $r->type;
        $name = $r->x_value;
        $url = '';
        // return $r->all();
        switch($type){
            case 'TASK_ROOT_CAUSED' :$rc = RootCaused::where('name_caused', $name)->first();
                if($rc) $url = "/task?id_caused=$rc->id_caused";
                break;
            case 'TASK_REGION'      :$rc = Region::where('region_name', $name)->first();
                if($rc) $url = "/task?id_region=$rc->region_id";
                break;
            case 'TASK_SEGMENT'     :$rc = Segment::where('segment_name', $name)->first();
                if($rc) $url = "/task?id_location_a=$rc->id_segment";
                break;
            case 'TASK_PRIORITY'    :$rc = Priority::where('priority_name', $name)->first();
                if($rc) $url = "/task?id_priority=$rc->id_priority";
                break;
            case 'TASK_STATUS'      :$rc = Status::where('status_name', $name)->first();
                if($rc) $url = "/task?id_status=$rc->id_status";
                break;
            case 'TASK_FREQUENCY'      :$rc = Site::where('name_site', $name)->first();
                if($rc) $url = "/task?id_site_frequency=$rc->site_id";
                break;
                
            case 'AKTIVASI_REGION'  :$rc = Region::where('region_name', $name)->first();
                if($rc) $url = "/aktivasi-layanan?id_region=$rc->region_id&id_type_service=$r->id_type_service";
                break;
            case 'AKTIVASI_SEGMENT' :$rc = Segment::where('segment_name', $name)->first();
                if($rc) $url = "/aktivasi-layanan?id_segment=$rc->id_segment&id_type_service=$r->id_type_service";
                break;
            case 'AKTIVASI_CUSTOMER':$rc = Customer::where('name_customer', $name)->first();
                if($rc) $url = "/aktivasi-layanan?id_customer=$rc->id_customer&id_type_service=$r->id_type_service";
                break;
            case 'AKTIVASI_STATUS'  :$rc = AktivasiStatus::where('name', $name)->first();
                if($rc) $url = "/aktivasi-layanan?id_status=$rc->id&id_type_service=$r->id_type_service";
                break;
            case 'AKTIVASI_CAPASITY':$rc = $name;
                if($rc) $url = "/aktivasi-layanan?capasity=$rc&id_type_service=$r->id_type_service";
                break;
            case 'AKTIVASI_1GB'  :$rc = Capacity::where('capacity_name', $name)->first();
                if($rc) $url = "/aktivasi-layanan?id_status=$rc->id&id_type_service=$r->id_type_service";
                break;
            case 'AKTIVASI_10GB'  :$rc = Capacity::where('capacity_name', $name)->first();
                if($rc) $url = "/aktivasi-layanan?id_status=$rc->id&id_type_service=$r->id_type_service";
                break;
            case 'AKTIVASI_PER_REGION'  :$rc = Region::where('region_name', $name)->first();
                if($rc) $url = "/aktivasi-layanan?id_region=$rc->region_id&id_type_service=$r->id_type_service";
                break;
                
            case 'SITE_ENTRY_STATUS':$rc = $name;
                if($rc) $url = "/site-permit?type=site-entry&status=$rc";
                break;
            case 'SITE_ENTRY_REGION':$rc = Region::where('region_name', $name)->first();
                if($rc) $url = "/site-permit?type=site-entry&id_region=$rc->region_id";
                break;
            case 'SITE_ENTRY_SITE'  :$rc = Site::where('name_site', $name)->first();
                if($rc) $url = "/site-permit?type=site-entry&id_site=$rc->site_id";
                break;
            
            case 'PERMIT_LETTER_REGION':$rc = Region::where('region_name', $name)->first();
                if($rc) $url = "/site-permit?type=permit-letter&id_region=$rc->region_id";
                break;
            case 'PERMIT_LETTER_SITE':$rc = Site::where('name_site', $name)->first();
                if($rc) $url = "/site-permit?type=permit-letter&id_site=$rc->site_id";
                break;
            case 'PERMIT_LETTER_STATUS':$rc = $name;
                if($rc) $url = "/site-permit?type=permit-letter&status=$rc";
                break;
            default:
                $url = "";
                // return $r->all();
        }
        return redirect()->to($url);
        return $r->all();
    }
    
    public function getDashboardData(Request $r){
        $id_task_type = $r->get('id_task_type', 1);
        $date = $r->get('date', date('Y-m-d'));
        $data = [];
        $data["by_priority"] = $this->getByPriority($id_task_type);
        $data["by_status"] = $this->getByStatus($id_task_type);
        $data["by_root_caused"] = $this->getByRootCaused($id_task_type);
        $data["by_region"] = $this->getByRegion($id_task_type);
        $data["by_segment"] = $this->getBySegment($id_task_type);
        $data["this_week"] = $this->getThisWeek($id_task_type, $date);
        $data["this_month"] = $this->getThisMonth($id_task_type, $date);
        $data["by_pencapaian_pm"] = $this->getByPencapaianPM($id_task_type, $date);
        $data["by_pencapaian_pm_project_dki"] = $this->getByPencapaianPMProjectDki($id_task_type, $date);
        $data["by_pencapaian_pm_project_4"] = $this->getByPencapaianPMProject4($id_task_type, $date);
        $data["by_pencapaian_pm_project_5"] = $this->getByPencapaianPMProject5($id_task_type, $date);
        $data["by_pencapaian_pm_project_6"] = $this->getByPencapaianPMProject6($id_task_type, $date);
        $data["by_pencapaian_pm_project_7"] = $this->getByPencapaianPMProject7($id_task_type, $date);
        $data["by_pencapaian_pm_project_8A"] = $this->getByPencapaianPMProject8A($id_task_type, $date);
        $data["by_pencapaian_pm_project_8B"] = $this->getByPencapaianPMProject8B($id_task_type, $date);
        
        
        $data["site_frequency"] = $this->getSiteCompare($id_task_type);
        if(in_array($r->type, ['by_priority','by_status','by_root_caused','by_region','by_segment','this_week','this_month', 'site_frequency'])) return $data[$r->type];
        
        return $data;
    }
    public function getAktivasiDashboardData(Request $r){
        $id_type_service = $r->get('id_type_service', 1);
        $date = $r->get('date', date('Y-m-d'));
        $data = [];
        $data["by_customer"] = $this->getAktivasiByCustomer($id_type_service);
        $data["by_status"] = $this->getAktivasiByStatus($id_type_service);
        $data["by_capasity"] = $this->getAktivasiByCapasity($id_type_service);
        $data["by_1gb"] = $this->getAktivasiBy1gb($id_type_service);
        $data["by_10gb"] = $this->getAktivasiBy10gb($id_type_service);
        $data["by_per_region"] = $this->getAktivasiByPerRegion($id_type_service);
        $data["by_region"] = $this->getAktivasiByRegion($id_type_service);
        $data["by_segment"] = $this->getAktivasiBySegment($id_type_service);
        $data["this_week"] = $this->getAktivasiThisWeek($id_type_service, $date);
        $data["this_month"] = $this->getAktivasiThisMonth($id_type_service, $date);
        
        if(in_array($r->type, ['by_customer','by_status','by_capasity','by_1gb','by_10gb','by_per_region','by_region','by_segment','this_week','this_month'])) return $data[$r->type];
        
        return $data;
    }
    public function getSiteEntryDashboardData(Request $r){
        $id_type_service = $r->get('id_type_service', 1);
        $date = $r->get('date', date('Y-m-d'));
        $data = [];
        $data["by_site"] = $this->getSiteEntryBySite($id_type_service);
        $data["by_status"] = $this->getSiteEntryByStatus($id_type_service);
        $data["by_region"] = $this->getSiteEntryByRegion($id_type_service);
        $data["this_week"] = $this->getSiteEntryThisWeek($id_type_service, $date);
        $data["this_month"] = $this->getSiteEntryThisMonth($id_type_service, $date);
        
        if(in_array($r->type, ['by_site','by_status','by_region','this_week','this_month'])) return $data[$r->type];
        
        return $data;
    }
    public function getPermitLetterDashboardData(Request $r){
        $id_type_service = $r->get('id_type_service', 1);
        $date = $r->get('date', date('Y-m-d'));
        $data = [];
        $data["by_site"] = $this->getPermitLetterBySite($id_type_service);
        $data["by_status"] = $this->getPermitLetterByStatus($id_type_service);
        $data["by_region"] = $this->getPermitLetterByRegion($id_type_service);
        $data["this_week"] = $this->getPermitLetterThisWeek($id_type_service, $date);
        $data["this_month"] = $this->getPermitLetterThisMonth($id_type_service, $date);
        
        if(in_array($r->type, ['by_site','by_status','by_region','this_week','this_month'])) return $data[$r->type];
        
        return $data;
    }
    
    ###########################/*TASK*/##############################
    // WITH JOIN
    public function getByPriority($id_task_type){
        $datas = [];
        $labels = [];
        $colors = [];
        
        $priorities = Priority::get();
        foreach($priorities as $key => $priority){
            $label = $priority->priority_name;
            // $data['labels'] = $label . '$prio1';
            $data['labels'] = $label;
            $data['dataset'] = Task::join('tb_detail_task', 'tb_task.id_task', 'tb_detail_task.id_task')
                                    ->where('tb_task.id_task_type', $id_task_type)
                                    ->where('tb_detail_task.id_priority', $priority->id_priority)
                                    ->count();
            
            // $dataset1[] = $data['dataset'];
            // $prio1 = array_sum($dataset1);
            
        
            if($data['dataset'] > 0){
                $labels[] = $label. " (4)";
                $datas[] = $data;
                $colors[] = $this->colors_index[$key];
            }
         }
        //ket
                // $prio1 = array_sum($dataset1);
                
        //xket
        
        $data = [];
        $data['dataset'] = $datas;
        $data['labels'] = $labels;
        // // $data['prio1'] = $prio1;
        $data['colors'] = $colors;
        return $data;
    }
    public function getByRootCaused($id_task_type){
        $date1 = date("Y-m-d");
        $date2 = date("Y-m-d",strtotime("-1 Months"));
        $date3 = date("Y-m-d",strtotime("-2 Months"));
        
        $month1_name = date('Y F', strtotime($date1));
        $month2_name = date('Y F', strtotime($date2));
        $month3_name = date('Y F', strtotime($date3));
        
        $datas = [];
        $labels = [];
        
        $m1_d = []; $m2_d = []; $m3_d = [];
        foreach(RootCaused::get() as $key => $ini){
            $ydate1 = date('Y', strtotime($date1)); 
            $ydate2 = date('Y', strtotime($date2)); 
            $ydate3 = date('Y', strtotime($date3));
            $mdate1 = date('m', strtotime($date1)); 
            $mdate2 = date('m', strtotime($date2)); 
            $mdate3 = date('m', strtotime($date3));
            
            $data1 = Task::join('tb_detail_task', 'tb_task.id_task', 'tb_detail_task.id_task')
                            ->where('tb_task.id_task_type', $id_task_type)
                            ->where('tb_detail_task.id_root_caused', $ini->id_caused)
                          ->whereYear('tb_task.created_at', $ydate1)
                          ->whereMonth('tb_task.created_at', $mdate1)
                          ->count();
                           
            $m1_d[] = $data1;
            
            $data2 = Task::join('tb_detail_task', 
                                'tb_task.id_task', 
                                'tb_detail_task.id_task')
                                ->where('tb_task.id_task_type', $id_task_type)
                                ->where('tb_detail_task.id_root_caused', $ini->id_caused)
                          ->whereYear('tb_task.created_at', $ydate2)
                          ->whereMonth('tb_task.created_at', $mdate2)
                          ->count();
            $m2_d[] = $data2;
            
            $data3 = Task::join('tb_detail_task', 
                                'tb_task.id_task', 
                                'tb_detail_task.id_task')
                                ->where('tb_task.id_task_type', $id_task_type)
                                ->where('tb_detail_task.id_root_caused', $ini->id_caused)
                          ->whereYear('tb_task.created_at', $ydate3)
                          ->whereMonth('tb_task.created_at', $mdate3)
                          ->count();
            $m3_d[] = $data3;
            $total_count =  $data1 + $data2 + $data3;
            $labels[] = $ini->name_caused; //. " ($total_count)";
            
        }
        
        $t_1 = array_sum($m1_d);
        $t_2 = array_sum($m2_d);
        $t_3 = array_sum($m3_d);
        
        
        
        $t_11 = array($m1_d[0],$m2_d[0],$m3_d[0]);
        $t_22 = array($m1_d[1],$m2_d[1],$m3_d[1]);
        $t_33 = array($m1_d[2],$m2_d[2],$m3_d[2]);
        
        $month1_name = $month1_name . " ($t_1)";
        $month2_name = $month2_name . " ($t_2)";
        $month3_name = $month3_name . " ($t_3)";
        //ket
        
        $deni = array_sum($t_11);
        $deno = array_sum($t_22);
        $doni = array_sum($t_33);
        
        $datax1[0] = $labels[0] . " ($deni)";
        $datax1[1] = $labels[1] . " ($deno)";
        $datax1[2] = $labels[2] . " ($doni)";
        //data & xket
        $datas[$datax1[0]] = $t_11 ;
        $datas[$datax1[1]] = $t_22 ;
        $datas[$datax1[2]] = $t_33 ;
        
        //xdata
        $labels_show[0] = $month1_name;
        $labels_show[1] = $month2_name;
        $labels_show[2] = $month3_name;
        
        $data = [];
        $data['dataset'] = $datas;
        $data['labels'] = $labels_show;
        return $data;
    }
    
    // WITHOUT JOIN
    public function getByStatus($id_task_type){
        $datas = [];
        $labels = [];
        $colors = [];
        // $dataset = [];
        foreach(Status::get() as $d){
            $ini = [];
            $label = $d->status_name;
            $ini['labels'] = $label;
            $ini['dataset'] = Task::where('id_status', $d->id_status)
                                    ->where('id_task_type', $id_task_type)
                                    ->count();
            
            // $dataset[] = $ini['dataset'];
            
            if($ini['dataset'] > 0){
                $labels[] = $label;
                $datas[] = $ini;
                $colors[] = $d->color;
            }
        }
        // $den1 = array_sum($dataset);
        
        $data = [];
        $data['dataset'] = $datas;
        $data['labels'] = $labels;
        $data['colors'] = $colors;
        return $data;
    }
    public function getByRegion($id_task_type){
        
        $datas = [];
        $labels = [];
        
        
        
        $subs = SubCategory::get();
        foreach($subs as $sub){
            
            $label = [];
            $data_sub = [];
            foreach(Region::get() as $key => $d){
                $label[] = $d->region_name;
                $data_sub[] = Task::where('id_region', $d->region_id)
                                ->where('id_task_type', $id_task_type)
                                ->where('id_sub_category', $sub->id_sub_category)
                                ->count();
            }
            $datas[$sub->sub_category_name] = $data_sub;
            $labels = $label;
        }
        
        //$datas = $datas['General']; jika ingin ambil satu
        $data = [];
        $data['dataset'] = $datas;
        $data['labels'] = $labels;
        return $data;
        
    }
    public function getByPencapaianPM($id_task_type, $date){
        $date = date('Y-m-d', strtotime($date));
        
        $firstDayUTS = mktime (0, 0, 0, date("m", strtotime($date)), 1, date("Y", strtotime($date)));
        $lastDayUTS = mktime (0, 0, 0, date("m", strtotime($date)), date('t', strtotime($date)), date("Y", strtotime($date)));
        
        $start = date("Y-m-d", $firstDayUTS);
        $finish = date("Y-m-d", $lastDayUTS);
        
        $datas = [];
        $labels = [];
        
        $label = [];
        $data_sub = [];
            
        foreach(Region::get() as $key => $d){
            $label[] = $d->region_name;
            $data_sub[] = Task::where('tb_task.id_region', $d->region_id)
                        ->where('id_task_type', $id_task_type)
                        ->whereIn('tb_task.id_status', collect(['22','34','42']))
                        ->whereBetween('created_at', ["$start 00:00:00", "$finish 23:59:59"])
                        ->count();
            $data_sub2[] = Task::where('id_region', $d->region_id)
                        ->where('id_task_type', $id_task_type)
                        ->whereBetween('created_at', ["$start 00:00:00", "$finish 23:59:59"])
                        ->count();
        }   
            
        $labels = $label;

        $datas['Pencapaian'] = $data_sub;
        $datas['Target'] = $data_sub2;

        $data = [];
        $data['dataset'] = $datas;
        $data['labels'] = $labels;
        return $data;
                
    }
    public function getByPencapaianPMProjectDki($id_task_type, $date){
        $date = date('Y-m-d', strtotime($date));
        
        $firstDayUTS = mktime(0, 0, 0, date("m", strtotime($date)), 1, date("Y", strtotime($date)));
        $lastDayUTS = mktime(0, 0, 0, date("m", strtotime($date)), date('t', strtotime($date)), date("Y", strtotime($date)));
        
        $start = date("Y-m-d", $firstDayUTS);
        $finish = date("Y-m-d", $lastDayUTS);
        
        $datas = [];
        $labels = [];
        
        $label = [];
        $data_sub = [];
        
        foreach(Technician::where('region_id', '=', '8')->get() as $key => $d){
            $label[] = $d->name_technician;
            $data_sub[] = Task::where('tb_task.id_region', '=', '8')
                        ->where('id_task_type', $id_task_type)
                        ->where('id_technician', $d->id_technician)
                        ->whereIn('tb_task.id_status', collect(['22','34','42']))
                        ->whereBetween('created_at', ["$start 00:00:00", "$finish 23:59:59"])
                        ->count();
            
            $data_sub2[] = Task::where('id_region', '=', '8')
                        ->where('id_task_type', $id_task_type)
                        ->where('id_technician', $d->id_technician)
                        ->whereBetween('created_at', ["$start 00:00:00", "$finish 23:59:59"])
                        ->count();
        }
        $labels = $label;
        
        $datas['Pencapaian'] = $data_sub;
        $datas['Target'] = $data_sub2;
        
        $data = [];
        $data['dataset'] = $datas;
        $data['labels'] = $labels;
        return $data;
    }
    public function getByPencapaianPMProject4($id_task_type, $date){
        $date = date('Y-m-d', strtotime($date));
        
        $firstDayUTS = mktime (0, 0, 0, date("m", strtotime($date)), 1, date("Y", strtotime($date)));
        $lastDayUTS = mktime (0, 0, 0, date("m", strtotime($date)), date('t', strtotime($date)), date("Y", strtotime($date)));
        
        $start = date("Y-m-d", $firstDayUTS);
        $finish = date("Y-m-d", $lastDayUTS);
        
        $datas = [];
        $labels = [];
        
        $label = [];
        $data_sub = [];
            
        foreach(Technician::where('region_id','=','9')->get() as $key => $d){
            $label[] = $d->name_technician;
            $data_sub[] = Task::where('tb_task.id_region', '=','9')
                        ->where('id_task_type', $id_task_type)
                        ->where('id_technician', $d->id_technician)
                        ->whereIn('tb_task.id_status', collect(['22','34','42']))
                        ->whereBetween('created_at', ["$start 00:00:00", "$finish 23:59:59"])
                        ->count();
            $data_sub2[] = Task::where('id_region', '=','9')
                        ->where('id_task_type', $id_task_type)
                        ->where('id_technician', $d->id_technician)
                        ->whereBetween('created_at', ["$start 00:00:00", "$finish 23:59:59"])
                        ->count();
        }   
            
        $labels = $label;

        $datas['Pencapaian'] = $data_sub;
        $datas['Target'] = $data_sub2;

        $data = [];
        $data['dataset'] = $datas;
        $data['labels'] = $labels;
        return $data;
                
    }
    public function getByPencapaianPMProject5($id_task_type, $date){
        $date = date('Y-m-d', strtotime($date));
        
        $firstDayUTS = mktime(0, 0, 0, date("m", strtotime($date)), 1, date("Y", strtotime($date)));
        $lastDayUTS = mktime(0, 0, 0, date("m", strtotime($date)), date('t', strtotime($date)), date("Y", strtotime($date)));
        
        $start = date("Y-m-d", $firstDayUTS);
        $finish = date("Y-m-d", $lastDayUTS);
        
        $datas = [];
        $labels = [];
        
        $label = [];
        $data_sub = [];
        
        foreach(Technician::where('region_id', '=', '10')->get() as $key => $d){
            $label[] = $d->name_technician;
            $data_sub[] = Task::where('tb_task.id_region', '=', '10')
                        ->where('id_task_type', $id_task_type)
                        ->where('id_technician', $d->id_technician)
                        ->whereIn('tb_task.id_status', collect(['22', '34', '42']))
                        ->whereBetween('created_at', ["$start 00:00:00", "$finish 23:59:59"])
                        ->count();
            
            $data_sub2[] = Task::where('id_region', '=', '10')
                        ->where('id_task_type', $id_task_type)
                        ->where('id_technician', $d->id_technician)
                        ->whereBetween('created_at', ["$start 00:00:00", "$finish 23:59:59"])
                        ->count();
        }
        
        $labels = $label;
        
        $datas['Pencapaian'] = $data_sub;
        $datas['Target'] = $data_sub2;
        
        $data = [];
        $data['dataset'] = $datas;
        $data['labels'] = $labels;
        return $data;
    }
    public function getByPencapaianPMProject6($id_task_type, $date){
        $date = date('Y-m-d', strtotime($date));
        
        $firstDayUTS = mktime(0, 0, 0, date("m", strtotime($date)), 1, date("Y", strtotime($date)));
        $lastDayUTS = mktime(0, 0, 0, date("m", strtotime($date)), date('t', strtotime($date)), date("Y", strtotime($date)));
        
        $start = date("Y-m-d", $firstDayUTS);
        $finish = date("Y-m-d", $lastDayUTS);
        
        $datas = [];
        $labels = [];
        
        $label = [];
        $data_sub = [];
        
        foreach(Technician::where('region_id', '=', '11')->get() as $key => $d){
            $label[] = $d->name_technician;
            $data_sub[] = Task::where('tb_task.id_region', '=', '11')
                        ->where('id_task_type', $id_task_type)
                        ->where('id_technician', $d->id_technician)
                        ->whereIn('tb_task.id_status', collect(['22','34','42']))
                        ->whereBetween('created_at', ["$start 00:00:00", "$finish 23:59:59"])
                        ->count();
            $data_sub2[] = Task::where('id_region', '=', '11')
                        ->where('id_task_type', $id_task_type)
                        ->where('id_technician', $d->id_technician)
                        ->whereBetween('created_at', ["$start 00:00:00", "$finish 23:59:59"])
                        ->count();
        }
        $labels = $label;
        
        $datas['Pencapaian'] = $data_sub;
        $datas['Target'] = $data_sub2;
        
        $data = [];
        $data['dataset'] = $datas;
        $data['labels'] = $labels;
        return $data;
    }
    public function getByPencapaianPMProject7($id_task_type, $date){
        $date = date('Y-m-d', strtotime($date));
        
        $firstDayUTS = mktime(0, 0, 0, date("m", strtotime($date)), 1, date("Y", strtotime($date)));
        $lastDayUTS = mktime(0, 0, 0, date("m", strtotime($date)), date('t', strtotime($date)), date("Y", strtotime($date)));
        
        $start = date("Y-m-d", $firstDayUTS);
        $finish = date("Y-m-d", $lastDayUTS);
        
        $datas = [];
        $labels = [];
        
        $label = [];
        $data_sub = [];
        
        foreach(Technician::where('region_id', '=', '12')->get() as $key => $d){
            $label[] = $d->name_technician;
            $data_sub[] = Task::where('tb_task.id_region', '=', '12')
                        ->where('id_task_type', $id_task_type)
                        ->where('id_technician', $d->id_technician)
                        ->whereIn('tb_task.id_status', collect(['22', '34', '42']))
                        ->whereBetween('created_at', ["$start 00:00:00", "$finish 23:59:59"])
                        ->count();
            $data_sub2[] = Task::where('id_region', '=', '12')
                        ->where('id_task_type', $id_task_type)
                        ->where('id_technician', $d->id_technician)
                        ->whereBetween('created_at', ["$start 00:00:00", "$finish 23:59:59"])
                        ->count();
        }
        
        $labels = $label;
        
        $datas['Pencapaian'] = $data_sub;
        $datas['Target'] = $data_sub2;
        
        $data = [];
        $data['dataset'] = $datas;
        $data['labels'] = $labels;
        return $data;
    }
    public function getByPencapaianPMProject8A($id_task_type, $date){
        $date = date('Y-m-d', strtotime($date));
        
        $firstDayUTS = mktime(0, 0, 0, date("m", strtotime($date)), 1, date("Y", strtotime($date)));
        $lastDayUTS = mktime(0, 0, 0, date("m", strtotime($date)), date('t', strtotime($date)), date("Y", strtotime($date)));
        
        $start = date("Y-m-d", $firstDayUTS);
        $finish = date("Y-m-d", $lastDayUTS);
        
        $datas = [];
        $labels = [];
        
        $label = [];
        $data_sub = [];
        
        foreach(Technician::where('region_id', '=', '13')->get() as $key => $d){
            $label[] = $d->name_technician;
            $data_sub[] = Task::where('tb_task.id_region', '=', '13')
                        ->where('id_task_type', $id_task_type)
                        ->where('id_technician', $d->id_technician)
                        ->whereIn('tb_task.id_status', collect(['22','34','42']))
                        ->whereBetween('created_at', ["$start 00:00:00", "$finish 23:59:59"])
                        ->count();
                        
            $data_sub2[] = Task::where('id_region', '=', '13')
                            ->where('id_task_type', $id_task_type)
                            ->where('id_technician', $d->id_technician)
                            ->whereBetween('created_at', ["$start 00:00:00", "$finish 23:59:59"])
                            ->count();
        }
        $labels = $label;
        
        $datas['Pencapaian'] = $data_sub;
        $datas['Target'] = $data_sub2;
        
        $data = [];
        $data['dataset'] = $datas;
        $data['labels'] = $labels;
        return $data;
    }
    public function getByPencapaianPMProject8B($id_task_type, $date){
        $date = date('Y-m-d', strtotime($date));
        
        $firstDayUTS = mktime(0, 0, 0, date("m", strtotime($date)), 1, date("Y", strtotime($date)));
        $lastDayUTS = mktime(0, 0, 0, date("m", strtotime($date)), date('t', strtotime($date)), date("Y", strtotime($date)));
        
        $start = date("Y-m-d", $firstDayUTS);
        $finish = date("Y-m-d", $lastDayUTS);
        
        $datas = [];
        $labels = [];
        
        $label = [];
        $data_sub = [];
        
        foreach(Technician::where('region_id', '=', '14')->get() as $key => $d){
            $label[] = $d->name_technician;
            $data_sub[] = Task::where('tb_task.id_region', '=','14')
                        ->where('id_task_type', $id_task_type)
                        ->where('id_technician', $d->id_technician)
                        ->whereIn('tb_task.id_status', collect(['22','34','42']))
                        ->whereBetween('created_at', ["$start 00:00:00", "$finish 23:59:59"])
                        ->count();
            $data_sub2[] = Task::where('id_region', '=', '14')
                        ->where('id_task_type', $id_task_type)
                        ->where('id_technician', $d->id_technician)
                        ->whereBetween('created_at', ["$start 00:00:00", "$finish 23:59:59"])
                        ->count();
                        
        }
        $labels = $label;
        
        $datas['Pencapaian'] = $data_sub;
        $datas['Target'] = $data_sub2;
        
        $data = [];
        $data['dataset'] = $datas;
        $data['labels'] = $labels;
        return $data;
    }
    public function getBySegment($id_task_type){
       if (1 != 1){
            $datas = [];
        $labels = [];
        
        foreach(Segment::get() as $key=>$d){
            $labels[] = $d->segment_name;
            $datas[] = Task::where('id_location_a', $d->id_segment)->where('id_task_type', $id_task_type)->count();
        }
        $data = [];
        $data['dataset'] = $datas;
        $data['labels'] = $labels;
        return $data;
       }
       $datas = [];
        $labels = [];
        
        
        
        $subs = SubCategory::get();
        foreach($subs as $sub){
            
            $label = [];
            $data_sub = [];
            foreach(Region::get() as $key => $d){
                $label[] = $d->region_name;
                $data_sub[] = Task::where('id_region', $d->region_id)
                                ->where('id_task_type', $id_task_type)
                                ->where('id_sub_category', $sub->id_sub_category)
                                ->count();
            }
            $datas[$sub->sub_category_name] = $data_sub;
            $labels = $label;
        }
        
        $datas = $datas['fo cut'];
        $data = [];
        $data['dataset'] = $datas;
        $data['labels'] = $labels;
        return $data;
    }
    
    public function getSiteCompare($id_task_type){
        $date1 = date("Y-m-d");
        $date2 = date("Y-m-d", strtotime("-1 Months"));
        $date3 = date("Y-m-d", strtotime("-2 Months"));
        
        $month1_name = date('Y F', strtotime($date1));
        $month2_name = date('Y F', strtotime($date2));
        $month3_name = date('Y F', strtotime($date3));
        
        $datas = [];
        $labels = [];
        
        $m1_d = []; $m2_d = []; $m3_d = [];
        
        foreach(Region::get() as $key => $ini){
            $ydate1 = date('Y', strtotime($date1)); 
            $ydate2 = date('Y', strtotime($date2)); 
            $ydate3 = date('Y', strtotime($date3));
            
            $mdate1 = date('m', strtotime($date1)); 
            $mdate2 = date('m', strtotime($date2)); 
            $mdate3 = date('m', strtotime($date3));
            
            $data1 = Task::where('tb_task.id_task_type', $id_task_type)
                            ->where('id_region', $ini->region_id)
                            ->whereYear('tb_task.created_at', $ydate1)
                            ->whereMonth('tb_task.created_at', $mdate1)
                            ->get()
                            ->sum('resolved_time');
                           
            $m1_d[] = $data1;
            
            $data2 = Task::where('tb_task.id_task_type', $id_task_type)
                            ->where('id_region', $ini->region_id)
                            ->whereYear('tb_task.created_at', $ydate2)
                            ->whereMonth('tb_task.created_at', $mdate2)
                            ->sum('resolved_time');
            $m2_d[] = $data2;
            
            $data3 = Task::where('tb_task.id_task_type', $id_task_type)
                            ->where('id_region', $ini->region_id)
                            ->whereYear('tb_task.created_at', $ydate3)
                            ->whereMonth('tb_task.created_at', $mdate3)
                            ->sum('resolved_time');
            $m3_d[] = $data3;
            
           
            $labels[] = $ini->region_name;
            
        }
        
        $t_1 = array_sum($m1_d);
        $t_2 = array_sum($m2_d);
        $t_3 = array_sum($m3_d);
        
        
        
        $t_11 = array($m1_d[0],$m2_d[0],$m3_d[0]);
        $t_22 = array($m1_d[1],$m2_d[1],$m3_d[1]);
        $t_33 = array($m1_d[2],$m2_d[2],$m3_d[2]);
        $t_44 = array($m1_d[3],$m2_d[3],$m3_d[3]);
        $t_55 = array($m1_d[4],$m2_d[4],$m3_d[4]);
        $t_66 = array($m1_d[5],$m2_d[5],$m3_d[5]);
        
        $month1_name = $month1_name . " ($t_1)";
        $month2_name = $month2_name . " ($t_2)";
        $month3_name = $month3_name . " ($t_3)";
        //ket
        
        $deni = array_sum($t_11);
        $deno = array_sum($t_22);
        $doni = array_sum($t_33);
        $deni1 = array_sum($t_44);
        $deno1 = array_sum($t_55);
        $doni1 = array_sum($t_66);
        
        $datax1[0] = $labels[0] . " ($deni)";
        $datax1[1] = $labels[1] . " ($deno)";
        $datax1[2] = $labels[2] . " ($doni)";
        $datax1[3] = $labels[3] . " ($deni1)";
        $datax1[4] = $labels[4] . " ($deno1)";
        $datax1[5] = $labels[5] . " ($doni1)";
        //data & xket
        $datas[$datax1[0]] = $t_11 ;
        $datas[$datax1[1]] = $t_22 ;
        $datas[$datax1[2]] = $t_33 ;
        $datas[$datax1[3]] = $t_44 ;
        $datas[$datax1[4]] = $t_55 ;
        $datas[$datax1[5]] = $t_66 ;
        
        //xdata
        $labels_show[0] = $month1_name;
        $labels_show[1] = $month2_name;
        $labels_show[2] = $month3_name;
        
        $data = [];
        $data['dataset'] = $datas;
        $data['labels'] = $labels_show;
        return $data;
        
        if (2 != 2){
        
        }
        
        if(3 != 3){
            $date1 = date("Y-m-d");
        $date2 = date("Y-m-d",strtotime("-1 Months"));
        $date3 = date("Y-m-d",strtotime("-2 Months"));
        
        $month1_name = date('Y F', strtotime($date1));
        $month2_name = date('Y F', strtotime($date2));
        $month3_name = date('Y F', strtotime($date3));
        
        $datas = [];
        $labels = [];
        
        $m1_d = []; $m2_d = []; $m3_d = [];
        foreach(Task::get() as $key => $ini){
            $ydate1 = date('Y', strtotime($date1)); 
            $ydate2 = date('Y', strtotime($date2)); 
            $ydate3 = date('Y', strtotime($date3));
            $mdate1 = date('m', strtotime($date1)); 
            $mdate2 = date('m', strtotime($date2)); 
            $mdate3 = date('m', strtotime($date3));
            
            $data1 = Task::join('tb_region', 'tb_task.id_region', 'tb_region.region_id')
                            ->where('tb_task.id_task_type', $id_task_type)
                            ->where('tb_task.id_region', $ini->id_region)
                          ->whereYear('tb_task.created_at', $ydate1)
                          ->whereMonth('tb_task.created_at', $mdate1)
                          ->count();
                           
            $m1_d[] = $data1;
            
            $data2 = Task::join('tb_region', 'tb_task.id_region', 'tb_region.region_id')
                            ->where('tb_task.id_task_type', $id_task_type)
                            ->where('tb_task.id_region', $ini->id_region)
                          ->whereYear('tb_task.created_at', $ydate2)
                          ->whereMonth('tb_task.created_at', $mdate2)
                          ->count();
            $m2_d[] = $data2;
            
            $data3 = Task::join('tb_region', 'tb_task.id_region', 'tb_region.region_id')
                            ->where('tb_task.id_task_type', $id_task_type)
                            ->where('tb_task.id_region', $ini->id_region)
                          ->whereYear('tb_task.created_at', $ydate3)
                          ->whereMonth('tb_task.created_at', $mdate3)
                          ->count();
            $m3_d[] = $data3;
            $total_count =  $data1 + $data2 + $data3;
            $labels[] = $ini->name_region; //. " ($total_count)";
            
        }
        
        $t_1 = array_sum($m1_d);
        $t_2 = array_sum($m2_d);
        $t_3 = array_sum($m3_d);
        
        
        
        $t_11 = array($m1_d[0],$m2_d[0],$m3_d[0]);
        $t_22 = array($m1_d[1],$m2_d[1],$m3_d[1]);
        $t_33 = array($m1_d[2],$m2_d[2],$m3_d[2]);
        
        $month1_name = $month1_name . " ($t_1)";
        $month2_name = $month2_name . " ($t_2)";
        $month3_name = $month3_name . " ($t_3)";
        //ket
        
        $deni = array_sum($t_11);
        $deno = array_sum($t_22);
        $doni = array_sum($t_33);
        
        $datax1[0] = $labels[0] . " ($deni)";
        $datax1[1] = $labels[1] . " ($deno)";
        $datax1[2] = $labels[2] . " ($doni)";
        //data & xket
        $datas[$datax1[0]] = $t_11 ;
        $datas[$datax1[1]] = $t_22 ;
        $datas[$datax1[2]] = $t_33 ;
        
        //xdata
        $labels_show[0] = $month1_name;
        $labels_show[1] = $month2_name;
        $labels_show[2] = $month3_name;
        
        $data = [];
        $data['dataset'] = $datas;
        $data['labels'] = $labels_show;
        return $data;
        
        }
        
        if(4 != 4){
            $datas = [];
        $datas2 = [];
        $labels = [];
        
        $task = Task::where('id_task_type', $id_task_type)->get();
        $site_a = [];
        $site_b = [];
        $site_ids = [];
        foreach($task as $v){
            $detail = $v->getDetail;
            $c_a = 1;
            $c_b = 1;
            
            if(getIndex($site_a, $v->id_site_a)) $c_a = $site_a[$v->id_site_a] + 1;
            $site_a[$v->id_site_a] = $c_a;
            
            
            $b = '';
            if($detail) $b = $detail->id_site_b;
            
            if(getIndex($site_b, $detail->id_site_b)) $c_b = $site_b[$detail->id_site_b] + 1;
            $site_b[$b] = $c_b;
            
            if(!getIndex($site_a, $detail->id_site_b)) $site_a[$detail->id_site_b] = 0;
            if(!getIndex($site_b, $v->id_site_a)) $site_b[$v->id_site_a] = 0;
            
            if(!in_array($v->id_site_a, $site_ids)) $site_ids[] = $v->id_site_a;
            if(!in_array($detail->id_site_b, $site_ids)) $site_ids[] = $detail->id_site_b;
        }
        $name_site = [];
        $sites = Site::whereIn('site_id', $site_ids)->get();
        foreach($sites as $site){
            $name_site[$site->site_id] = $site->name_site;
        }
        
        // sort($site_ids);
        foreach($site_ids as $key => $val){
            $labels[] = getIndex($name_site, $val, "");
            // $name_site[$val];
        }
        
        $site_a = array_values($site_a);
        $site_b = array_values($site_b);
        
        $data = [];
        $data['dataset'] = ['SITE A' => $site_a, 'SITE B' => $site_b];
        $data['labels'] = $labels;
        return $data;
        }
        
    }
    
    // OTHERS
    public function getThisWeek($id_task_type, $date){
        
        $date = date('Y-m-d', strtotime($date));
        
        $start = (date('D', strtotime($date)) != 'Mon') ? date('Y-m-d', strtotime('last Monday', strtotime($date))) : date('Y-m-d');
        $finish = (date('D', strtotime($date)) != 'Sun') ? date('Y-m-d', strtotime('next Sunday', strtotime($date))) : date('Y-m-d');
        
        $date = createDateRangeArray($start, $finish);
        $datas = [];
        $status = Status::where('task_type_id', $id_task_type)->get(); //pembeda
        foreach($status as $s_key => $status){
            
            $name = str_replace(' ', '_', $status->status_name);
            
            // if($s_key > 15) $s_key = $s_key / 2;
            // $color = $this->colors_index[$s_key];
            $color = $status->color;
            
            $dataset = [];
            foreach($date as $key => $val){
                $task = Task::where('id_status', $status->id_status)
                        ->where('id_task_type', $id_task_type)
                        //->where('task_type_id', $task_type_id)
                        ->whereBetween('created_at', ["$val 00:00:00", "$val 23:59:59"])
                        ->count();
                
                $dataset[] = $task;
            }
            //ket
                $mon1 = array_sum($dataset);
                
            //xket
            $datas[$name]['labels'] = $name . " ($mon1)";
            $datas[$name]['color'] = $color;
            $datas[$name]['dataset'] = $dataset;
        }
        $label_date = [];
        foreach($date as $k=>$d){
            $label_date[] = date('d', strtotime($d));
        }
        
        $data = [];
        $data['dataset'] = $datas;
        $data['labels'] = $label_date;
        
        
        return $data;
    }
    public function getThisMonth($id_task_type, $date){
        $date = date('Y-m-d', strtotime($date));
        
        $firstDayUTS = mktime (0, 0, 0, date("m", strtotime($date)), 1, date("Y", strtotime($date)));
    $lastDayUTS = mktime (0, 0, 0, date("m", strtotime($date)), date('t', strtotime($date)), date("Y", strtotime($date)));
    
    $start = date("Y-m-d", $firstDayUTS);
    $finish = date("Y-m-d", $lastDayUTS);
    
        $date = createDateRangeArray($start, $finish);
        $datas = [];
        $status = Status::where('task_type_id', $id_task_type)->get(); //pembeda
        foreach($status as $s_key => $status){
            
            $name = str_replace(' ', '_', $status->status_name);
            
            // if($s_key > 15) $s_key = $s_key / 2;
            // $color = $this->colors_index[$s_key];
            $color = $status->color;
            
            $dataset = [];
            foreach($date as $key => $val){
                $task = Task::where('id_status', $status->id_status)
                        ->where('id_task_type', $id_task_type)
                        //->where('task_type_id', $task_type_id)
                        ->whereBetween('created_at', ["$val 00:00:00", "$val 23:59:59"])
                        ->count();
                
                $dataset[] = $task;
            }
            //ket
                $mon2 = array_sum($dataset);
                
            //xket
            $datas[$name]['labels'] = $name . " ($mon2)";
            $datas[$name]['color'] = $color;
            $datas[$name]['dataset'] = $dataset;
        }
        $label_date = [];
        foreach($date as $k=>$d){
            $label_date[] = date('d', strtotime($d));
        }
        $data = [];
        $data['dataset'] = $datas;
        $data['labels'] = $label_date;
        
        
        return $data;
    }
    
    ###########################/*AKTIVASI*/##############################
    public function getAktivasiByCustomer($id_type_service){
        $datas = [];
        $labels = [];
        $colors = [];
        
        $customers = Customer::get();
        foreach($customers as $key => $customer){
            $label = $customer->name_customer;
            $data['labels'] = $label;
            $data['dataset'] = Aktivasi::where('id_type_service', $id_type_service)
                                    ->where('id_customer', $customer->id_customer)
                                    ->count();
        
            if($data['dataset'] > 0){
                $labels[] = $label;
                $datas[] = $data;
                $colors[] = $this->colors_index[$key];
            }
        }
        $data = [];
        $data['dataset'] = $datas;
        $data['labels'] = $labels;
        $data['colors'] = $colors;
        return $data;
    }
    public function getAktivasiByStatus($id_type_service){
        $datas = [];
        $labels = [];
        $colors = [];
        if($id_type_service == 3){
           $status = AktivasiStatusCollocation::get(); 
        }else{
            $status = AktivasiStatus::get();
        }
        foreach($status as $key=>$d){
            $ini = [];
            $label = $d->name;
            $ini['labels'] = $label;
            $ini['dataset'] = Aktivasi::where('id_status', $d->id)->where('id_type_service', $id_type_service)->count();
            
            if($ini['dataset'] > 0){
                $labels[] = $label;
                $datas[] = $ini;
                $colors[] = $this->colors_index[$key];
            }
        }
        $data = [];
        $data['dataset'] = $datas;
        $data['labels'] = $labels;
        $data['colors'] = $colors;
        return $data;
    }
    public function getAktivasiByCapasity($id_type_service){
        
        
        if (2==2){
            $datas = [];
            $labels = [];
            $colors = [];
        
            $customers = Capacity::get();
            foreach($customers as $key => $customer){
                $label = $customer->capacity_name;
                $data['labels'] = $label;
                $data['dataset'] = Aktivasi::where('id_type_service', $id_type_service)
                                    ->where('capasity', $customer->id_capacity)
                                    ->count();
        
                // $dataku1 = $terpakai;
                // $data['labels'] = "$label (Used) ($dataku1)";
                
                
                
                if($data['dataset'] > 0){
                    $labels[] = $label;
                    $datas[] = $data;
                    $colors[] = $this->colors_index[$key];
                }
            }
        $data = [];
        $data['dataset'] = $datas;
        $data['labels'] = $labels;
        $data['colors'] = $colors;
        return $data;
        }
    }
    public function getAktivasiBy1gb($id_type_service){
        
        if (1==1){
            $datas = [];
            $labels = [];
            $colors = [];
            
            $cs = Capacity::get();
            foreach($cs as $key => $c){
                $label = $c->capacity_name;
                // $data['labels'] = "$label (Used)";
                
                $terpakai = Aktivasi::where('id_type_service', $id_type_service)
                                    ->where('capasity', $c->id_capacity)
                                    ->where('capasity', '=', 1)
                                    ->count();
                
                $data['dataset'] = $terpakai;
                
                $dataku1 = $terpakai;
                $data['labels'] = "$label (Used) ($dataku1)";
                
                 if($data['dataset']  > 0){
                    $labels[] = $label;
                    $datas[] = $data;
                    
                    $colors[] = $this->colors_index[4];
                 }
                
                
            }
            foreach($cs as $key => $c){
                $label = $c->capacity_name;
                $dataku = 10;
                
                
                
                
                $total = TotalCapacity::join('tb_capacity','tb_total_capacity.capacity_id','tb_capacity.id_capacity')
                                    ->where('tb_total_capacity.capacity_id',  $c->id_capacity)
                                    ->where('capacity_id', '=', 1)
                                    ->sum('tb_total_capacity.total');
                                    
                $terpakai = Aktivasi::where('id_type_service', $id_type_service)
                                    ->where('capasity', '=', 1) // dihilangkan jika ingin capacity semuanya
                                    ->where('capasity', $c->id_capacity)
                                    ->count();
                
                $data['dataset'] = $total - $terpakai;
                $dataku2 = $total - $terpakai;
                $data['labels'] = "$label (Available) ($dataku)";
                
                 if($data['dataset']  > 0){ // dihilangkan jika ingin capasity semuanya
                    $labels[] = $label;
                    $datas[] = $data;
                    
                    $colors[] = $this->colors_index[5];
                 }
                
                
            }
            
            
            $data = [];
            $data['dataset'] = $datas;
            $data['labels'] = $labels;
            $data['colors'] = $colors;
            return $data;
        }
    }
    public function getAktivasiBy10gb($id_type_service){
        
        if (1==1){
            $datas = [];
            $labels = [];
            $colors = [];
            
            $cs = Capacity::get();
            foreach($cs as $key => $c){
                $label = $c->capacity_name;
                $data['labels'] = "$label (Used)";
                
                $terpakai = Aktivasi::where('id_type_service', $id_type_service)
                                    ->where('capasity', $c->id_capacity)
                                    ->where('capasity', '=', 2)
                                    ->count();
                
                $data['dataset'] = $terpakai;
                $dataku1 = $terpakai;
                $data['labels'] = "$label (Used) ($dataku1)";
                
                 if($data['dataset']  > 0){
                    $labels[] = $label;
                    $datas[] = $data;
                    
                    // $colors[] = $this->colors_index[$key];
                    $colors[] = $this->colors_index[7];
                 }
                
                
            }
            foreach($cs as $key => $c){
                $label = $c->capacity_name;
                $data['labels'] = "$label (Available)"; // boleh dipakai boleh ga
                
                
                
                $total = TotalCapacity::join('tb_capacity','tb_total_capacity.capacity_id','tb_capacity.id_capacity')
                                    ->where('tb_total_capacity.capacity_id',  $c->id_capacity)
                                    ->where('capacity_id', '=', 2)
                                    ->sum('tb_total_capacity.total');
                                    
                $terpakai = Aktivasi::where('id_type_service', $id_type_service)
                                    ->where('capasity', '=', 2) // dihilangkan jika ingin capacity semuanya
                                    ->where('capasity', $c->id_capacity)
                                    ->count();
                
                $data['dataset'] = $total - $terpakai;
                $dataku2 = $total - $terpakai;
                $data['labels'] = "$label (Available) ($dataku2)";
                
                 if($data['dataset']  > 0){ // dihilangkan jika ingin capasity semuanya
                    $labels[] = $label;
                    $datas[] = $data;
                    
                    // $colors[] = $this->colors_index[$key];
                    $colors[] = $this->colors_index[8];
                 }
                
                
            }
            
            
            $data = [];
            $data['dataset'] = $datas;
            $data['labels'] = $labels;
            $data['colors'] = $colors;
            return $data;
        }
        if (1!=1){
            $datas = [];
            $labels = [];
            $colors = [];
        
            $cs = Capacity::get();
            foreach($cs as $key => $c){
                $label = $c->capacity_name;
                $data['labels'] = $label;
                $data2['labels'] = $label;
                $data['dataset'] = Aktivasi::where('id_type_service', $id_type_service)
                                    ->where('capasity', $c->id_capacity)
                                    ->where('capasity', '=', 2)
                                    //->sum('capasity');
                                    ->count();
        
                
                                    
                
                if($data['dataset']  > 0){
                    $labels[] = $label;
                    $datas[] = $data;
                    
                    $colors[] = $this->colors_index[$key];
                }
                
            }
        $data = [];
        $data['dataset'] = $datas;
        $data['labels'] = $labels;
        $data['colors'] = $colors;
        return $data;
        
        }
        if (2!=2){
            $datas = [];
            $labels = [];
            $colors = [];
        
            $customers = Capacity::get();
            foreach($customers as $key => $customer){
                $label = $customer->capacity_name;
                $data['labels'] = $label;
                $data['dataset'] = Aktivasi::where('id_type_service', $id_type_service)
                                    ->where('capasity', $customer->id_capacity)
                                    ->count();
        
                if($data['dataset'] > 0){
                    $labels[] = $label;
                    $datas[] = $data;
                    $colors[] = $this->colors_index[$key];
                }
            }
        $data = [];
        $data['dataset'] = $datas;
        $data['labels'] = $labels;
        $data['colors'] = $colors;
        return $data;
        }
    }
    public function getAktivasiByPerRegion($id_type_service){
        $datas = [];
        $labels = [];
        
        foreach(TotalCapacity::get() as $key => $b){
        foreach(Capacity::get() as $key => $c){
            $label = [];
            $data_sub = [];
            
            foreach(Region::get() as $key => $d){
                $label[] = $d->region_name;
                $data_sub[] = Aktivasi::where('id_region', $d->region_id)
                ->where('capasity', $c -> id_capacity)
                ->where('id_type_service', $id_type_service)
                //->sum('total');
                ->count();
            }
            
            $datasum = array_sum($data_sub);
            
            
            $datas[$c->capacity_name.' ('.$datasum.') '] = $data_sub;
            $labels = $label;
            
            
            
        }
        }
        
        
        $data = [];
        $data['dataset'] = $datas;
        $data['labels'] = $labels;
        return $data;
    }
    public function getAktivasiByRegion($id_type_service){
        if (1==1){
            $datas = [];
            $labels = [];
        
            foreach(Region::get() as $key => $d){
                $labels[] = $d->region_name;
                $datas[] = Aktivasi::where('id_region', $d->region_id)
                ->where('id_type_service', $id_type_service)
                ->count();
            }
            $data = [];
            $data['dataset'] = $datas;
            $data['labels'] = $labels;
            return $data;
        }
        if (2!=2){
            $datas = [];
            $labels = [];
        
        
        
        
        foreach(Aktivasi::get() as $sub){
            
            $label = [];
            $data_sub = [];
            foreach(Region::get() as $key => $d){
                $labels[] = $d->region_name;
                $datas[] = Aktivasi::where('id_region', $d->region_id)
                ->where('id_type_service', $id_type_service)
                ->count();
            }
            $datas[$sub->sub_category_name] = $data_sub;
            $labels = $label;
        }
        
        //$datas = $datas['General']; jika ingin ambil satu
        $data = [];
        $data['dataset'] = $datas;
        $data['labels'] = $labels;
        return $data;
        }
    }
    
    public function getAktivasiBySegment($id_type_service){
        $datas = [];
        $labels = [];
        
        foreach(Segment::get() as $key => $d){
            $labels[] = $d->segment_name;
            $datas[] = Aktivasi::where('id_segment', $d->id_segment)->where('id_type_service', $id_type_service)->count();
        }
        $data = [];
        $data['dataset'] = $datas;
        $data['labels'] = $labels;
        return $data;
    }
    public function getAktivasiThisWeek($id_type_service, $date){
        $date = date('Y-m-d', strtotime($date));
        
        $start = (date('D', strtotime($date)) != 'Mon') ? date('Y-m-d', strtotime('last Monday', strtotime($date))) : date('Y-m-d');
        $finish = (date('D', strtotime($date)) != 'Sun') ? date('Y-m-d', strtotime('next Sunday', strtotime($date))) : date('Y-m-d');
        
        $date = createDateRangeArray($start, $finish);
        $datas = [];
        if($id_type_service == 3){
            $status = AktivasiStatusCollocation::get(); 
        }else{
            $status = AktivasiStatus::get();
        }
        foreach($status as $s_key => $status){
            
            $name = str_replace(' ', '_', $status->name);
            
            if($s_key > 15) $s_key = $s_key / 2;
            $color = $this->colors_index[$s_key];
            // $color = $status->color;
            
            $dataset = [];
            foreach($date as $key => $val){
                $task = Aktivasi::where('id_status', $status->id)->where('id_type_service', $id_type_service)->whereBetween('created_at', ["$val 00:00:00", "$val 23:59:59"])->count();
                $dataset[] = $task;
            }
            $datas[$name]['labels'] = $name;
            $datas[$name]['color'] = $color;
            $datas[$name]['dataset'] = $dataset;
        }
        $label_date = [];
        foreach($date as $k=>$d){
            $label_date[] = date('d', strtotime($d));
        }
        $data = [];
        $data['dataset'] = $datas;
        $data['labels'] = $label_date;
        
        
        return $data;
    }
    public function getAktivasiThisMonth($id_type_service, $date){
        $date = date('Y-m-d', strtotime($date));
        
        $firstDayUTS = mktime (0, 0, 0, date("m", strtotime($date)), 1, date("Y", strtotime($date)));
        $lastDayUTS = mktime (0, 0, 0, date("m", strtotime($date)), date('t', strtotime($date)), date("Y", strtotime($date)));
        
        $start = date("Y-m-d", $firstDayUTS);
        $finish = date("Y-m-d", $lastDayUTS);
        $date = createDateRangeArray($start, $finish);
        
        $date = createDateRangeArray($start, $finish);
        $datas = [];
        if($id_type_service == 3){
            $status = AktivasiStatusCollocation::get(); 
        }else{
            $status = AktivasiStatus::get();
        }
        foreach($status as $s_key => $status){
            
            $name = str_replace(' ', '_', $status->name);
            
            if($s_key > 15) $s_key = $s_key / 2;
            $color = $this->colors_index[$s_key];
            // $color = $status->color;
            
            $dataset = [];
            foreach($date as $key => $val){
                $task = Aktivasi::where('id_status', $status->id)->where('id_type_service', $id_type_service)->whereBetween('created_at', ["$val 00:00:00", "$val 23:59:59"])->count();
                $dataset[] = $task;
            }
            $datas[$name]['labels'] = $name;
            $datas[$name]['color'] = $color;
            $datas[$name]['dataset'] = $dataset;
        }
        $label_date = [];
        foreach($date as $k=>$d){
            $label_date[] = date('d', strtotime($d));
        }
        $data = [];
        $data['dataset'] = $datas;
        $data['labels'] = $label_date;
        
        
        return $data;
    }
    
    ###########################/*SITE_ENTRY*/##############################
    public function getSiteEntryBySite(){
        $datas = [];
        $labels = [];
        
        foreach(Site::get() as $key => $d){
            $labels[] = $d->name_site;
            $datas[] = SiteEntry::where('id_site', $d->site_id)->count();
        }
        $data = [];
        $data['dataset'] = $datas;
        $data['labels'] = $labels;
        return $data;
    }
    public function getSiteEntryByRegion(){
        $datas = [];
        $labels = [];
        
        foreach(Region::get() as $key => $d){
            $labels[] = $d->region_name;
            $datas[] = SiteEntry::where('id_region', $d->region_id)->count();
        }
        $data = [];
        $data['dataset'] = $datas;
        $data['labels'] = $labels;
        return $data;
    }
    public function getSiteEntryByStatus(){
        $datas = [];
        $labels = [];
        $colors = [];
        $status = ['CHECKIN', 'CHECKOUT'];
        foreach($status as $key=>$d){
            $ini = [];
            $label = $d;
            $ini['labels'] = $label;
            $ini['dataset'] = SiteEntry::where('status', $d)->count();
            
            if($ini['dataset'] > 0){
                $labels[] = $label;
                $datas[] = $ini;
                $colors[] = $this->colors_index[$key];
            }
        }
        $data = [];
        $data['dataset'] = $datas;
        $data['labels'] = $labels;
        $data['colors'] = $colors;
        return $data;
    }
    public function getSiteEntryThisWeek($date){
        $date = date('Y-m-d', strtotime($date));
        
        $start = (date('D', strtotime($date)) != 'Mon') ? date('Y-m-d', strtotime('last Monday', strtotime($date))) : date('Y-m-d');
        $finish = (date('D', strtotime($date)) != 'Sun') ? date('Y-m-d', strtotime('next Sunday', strtotime($date))) : date('Y-m-d');
        
        $date = createDateRangeArray($start, $finish);
        $datas = [];
        $statuss = ['CHECKIN', 'CHECKOUT'];
        foreach($statuss as $s_key => $status){
            
            $name = str_replace(' ', '_', $status);
            
            if($s_key > 15) $s_key = $s_key / 2;
            $color = $this->colors_index[$s_key];
            // $color = $status->color;
            
            $dataset = [];
            foreach($date as $key => $val){
                $task = SiteEntry::where('status', $status)->whereBetween('created_at', ["$val 00:00:00", "$val 23:59:59"])->count();
                $dataset[] = $task;
            }
            $datas[$name]['labels'] = $name;
            $datas[$name]['color'] = $color;
            $datas[$name]['dataset'] = $dataset;
        }
        $label_date = [];
        foreach($date as $k=>$d){
            $label_date[] = date('d', strtotime($d));
        }
        $data = [];
        $data['dataset'] = $datas;
        $data['labels'] = $label_date;
        
        
        return $data;
    }
    public function getSiteEntryThisMonth($date){
        $date = date('Y-m-d', strtotime($date));
        
        $firstDayUTS = mktime (0, 0, 0, date("m", strtotime($date)), 1, date("Y", strtotime($date)));
        $lastDayUTS = mktime (0, 0, 0, date("m", strtotime($date)), date('t', strtotime($date)), date("Y", strtotime($date)));
        
        $start = date("Y-m-d", $firstDayUTS);
        $finish = date("Y-m-d", $lastDayUTS);
        $date = createDateRangeArray($start, $finish);
        
        $date = createDateRangeArray($start, $finish);
        $datas = [];
        $statuss = ['CHECKIN', 'CHECKOUT'];
        foreach($statuss as $s_key => $status){
            
            $name = str_replace(' ', '_', $status);
            
            if($s_key > 15) $s_key = $s_key / 2;
            $color = $this->colors_index[$s_key];
            // $color = $status->color;
            
            $dataset = [];
            foreach($date as $key => $val){
                $task = SiteEntry::where('status', $status)->whereBetween('created_at', ["$val 00:00:00", "$val 23:59:59"])->count();
                $dataset[] = $task;
            }
            $datas[$name]['labels'] = $name;
            $datas[$name]['color'] = $color;
            $datas[$name]['dataset'] = $dataset;
        }
        $label_date = [];
        foreach($date as $k=>$d){
            $label_date[] = date('d', strtotime($d));
        }
        $data = [];
        $data['dataset'] = $datas;
        $data['labels'] = $label_date;
        
        
        return $data;
    }
    
    public function getPermitLetterBySite(){
        $datas = [];
        $labels = [];
        
        foreach(Site::get() as $key => $d){
            $labels[] = $d->name_site;
            $datas[] = PermitLetter::where('id_site', $d->site_id)->count();
        }
        $data = [];
        $data['dataset'] = $datas;
        $data['labels'] = $labels;
        return $data;
    }
    public function getPermitLetterByRegion(){
        $datas = [];
        $labels = [];
        
        foreach(Region::get() as $key => $d){
            $labels[] = $d->region_name;
            $datas[] = PermitLetter::where('id_region', $d->region_id)->count();
        }
        $data = [];
        $data['dataset'] = $datas;
        $data['labels'] = $labels;
        return $data;
    }
    public function getPermitLetterByStatus(){
        $datas = [];
        $labels = [];
        $colors = [];
        $status = ['PENDING', 'APPROVED', 'REJECTED'];
        foreach($status as $key=>$d){
            $ini = [];
            $label = $d;
            $ini['labels'] = $label;
            $ini['dataset'] = PermitLetter::where('status', $d)->count();
            
            if($ini['dataset'] > 0){
                $labels[] = $label;
                $datas[] = $ini;
                $colors[] = $this->colors_index[$key];
            }
        }
        $data = [];
        $data['dataset'] = $datas;
        $data['labels'] = $labels;
        $data['colors'] = $colors;
        return $data;
    }
    public function getPermitLetterThisWeek($date){
        $date = date('Y-m-d', strtotime($date));
        
        $start = (date('D', strtotime($date)) != 'Mon') ? date('Y-m-d', strtotime('last Monday', strtotime($date))) : date('Y-m-d');
        $finish = (date('D', strtotime($date)) != 'Sun') ? date('Y-m-d', strtotime('next Sunday', strtotime($date))) : date('Y-m-d');
        
        $date = createDateRangeArray($start, $finish);
        $datas = [];
        $statuss = ['PENDING', 'APPROVED', 'REJECTED'];
        foreach($statuss as $s_key => $status){
            
            $name = str_replace(' ', '_', $status);
            
            if($s_key > 15) $s_key = $s_key / 2;
            $color = $this->colors_index[$s_key];
            // $color = $status->color;
            
            $dataset = [];
            foreach($date as $key => $val){
                $task = PermitLetter::where('status', $status)->whereBetween('created_at', ["$val 00:00:00", "$val 23:59:59"])->count();
                $dataset[] = $task;
            }
            $datas[$name]['labels'] = $name;
            $datas[$name]['color'] = $color;
            $datas[$name]['dataset'] = $dataset;
        }
        $label_date = [];
        foreach($date as $k=>$d){
            $label_date[] = date('d', strtotime($d));
        }
        $data = [];
        $data['dataset'] = $datas;
        $data['labels'] = $label_date;
        
        
        return $data;
    }
    public function getPermitLetterThisMonth($date){
        $date = date('Y-m-d', strtotime($date));
        
        $firstDayUTS = mktime (0, 0, 0, date("m", strtotime($date)), 1, date("Y", strtotime($date)));
        $lastDayUTS = mktime (0, 0, 0, date("m", strtotime($date)), date('t', strtotime($date)), date("Y", strtotime($date)));
        
        $start = date("Y-m-d", $firstDayUTS);
        $finish = date("Y-m-d", $lastDayUTS);
        $date = createDateRangeArray($start, $finish);
        
        $date = createDateRangeArray($start, $finish);
        $datas = [];
        $statuss = ['PENDING', 'APPROVED', 'REJECTED'];
        foreach($statuss as $s_key => $status){
            
            $name = str_replace(' ', '_', $status);
            
            if($s_key > 15) $s_key = $s_key / 2;
            $color = $this->colors_index[$s_key];
            // $color = $status->color;
            
            $dataset = [];
            foreach($date as $key => $val){
                $task = PermitLetter::where('status', $status)->whereBetween('created_at', ["$val 00:00:00", "$val 23:59:59"])->count();
                $dataset[] = $task;
            }
            $datas[$name]['labels'] = $name;
            $datas[$name]['color'] = $color;
            $datas[$name]['dataset'] = $dataset;
        }
        $label_date = [];
        foreach($date as $k=>$d){
            $label_date[] = date('d', strtotime($d));
        }
        $data = [];
        $data['dataset'] = $datas;
        $data['labels'] = $label_date;
        
        
        return $data;
    }
}






