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

class ChecklistExportTable4 implements FromView, ShouldAutoSize{
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
        $no_4 = 0;
        $datelastDayofMonth = \Carbon\Carbon::now()->endOfMonth()->subDays(7)->toDateString();
        $real = \Carbon\Carbon::now()->endOfMonth()->toDateString();
        $reallast = date('d',strtotime($real));
        $lastdate =date('d',strtotime($datelastDayofMonth));
        $last = $year.'-'.$month.'-'.$lastdate;
        $latest = $year.'-'.$month.'-'.$reallast;
        $selected_region = Region::where('region_id', $ids)->get();

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
                $val->persentase_beban = number_format(380*((float)$val->r->answer + (float)$val->s->answer + (float)$val->t->answer) / 3 * 1.73 / $val->kapasitas_kwh * 100, 2).' %';
            }

        }

        return view('form_bulanan.download_table_4', [
            'site_table_4' => $site_table_4,
            'no_4'=>$no_4,
            'ids'=>$ids,
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
