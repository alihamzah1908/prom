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

class ChecklistExportTable3 implements FromView, ShouldAutoSize{
    use Exportable;

    private $id_region;

    public function __construct(int $id_region){
        $this->id_region = $id_region;
    }

    public function view(): View{
        $ids = $this->id_region;
        $form_tahun = date('Y');
        $form_bulan = date('F');
        $year = date('Y');
        $month = date('m');
        $name = 'PM Site';
        $no_3 = 0;
        $selected_region = Region::where('region_id', $ids)->get();

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

        return view('form_bulanan.download_table_3', [
            'site_table_3'=>  $site_table_3,
            'no_3'=>$no_3,
            'ids'=>$ids,
            'selected_region' => $selected_region,
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
