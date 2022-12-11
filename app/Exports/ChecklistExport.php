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

class ChecklistExport implements FromView, ShouldAutoSize{
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
        $no = 0;

       
        $datelastDayofMonth = \Carbon\Carbon::now()->endOfMonth()->subDays(7)->toDateString();
        $real = \Carbon\Carbon::now()->endOfMonth()->toDateString();
        $reallast = date('d',strtotime($real));
        $lastdate =date('d',strtotime($datelastDayofMonth));
        $last = $year.'-'.$month.'-'.$lastdate;
        $latest = $year.'-'.$month.'-'.$reallast;
        $selected_region = Region::where('region_id', $ids)->get();

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

        return view('form_bulanan.download_table_2', [
            'site_table_2'=>  $site_table_2,
            'no'=>$no,
            'selected_region'=>$selected_region,
            'form_tahun'=>$form_tahun,
            'form_bulan'=>$form_bulan,
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
