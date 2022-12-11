<?php

namespace App\Exports;

// use App\User;
use App\Model\Task;
use App\Model\ChecklistAnswer;
use DateTime;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Illuminate\Contracts\View\View;

class UsersExport implements
    ShouldAutoSize,
    // WithMapping,
    WithHeadings,
    // WithEvents,
    FromView,
    WithCustomStartCell,
    WithTitle
{
    use Exportable;

    private $year;

    private $month;
    
    private $d;
    
    private $e;
    
    private $subject;

    public function __construct(int $year, int $d, string $e, string $subject)
    {
        $this->year = $year;
        // $this->month = $month;
        $this->id = $d;
        $this->uid = $e;
        $this->subject = $subject;
    }

    public function view(): View {
        // $coll = collect(['22']);
        // $task = Task::where('id_task_type', 2)->where('id_status', '=' , $coll )->get();
    	return view('task.detail_7days_excel', [
    		'checklists' => ChecklistAnswer::where('id_task', $this->id)->whereYear('created_at', $this->year)->get(),
    		'ids' => $this->id,
            // 'checklists' => ChecklistAnswer::get(),
    	]);
    }
    
    // public function query()
    // {
    //     // $coll = collect(['22',  '34', '42']);
        
    //     // $task = Task::where('id_status', '=' , $coll )->get();
    //     // // dd($task);
        
        
        
    //     // return  ChecklistAnswer::query()->with('task')->join('tb_task', 'tb_task.id_task','tb_checklist_answers.id_task')->where('tb_task.id_status', '=','22')->where('tb_task.id_task', $task)
    //     //     ->whereYear('tb_checklist_answers.created_at', $this->year);
    //     //     // ->whereMonth('created_at', $this->month);
        
    //     return  ChecklistAnswer::query()->with('task')->where('id_task', $this->id)
    //         ->whereYear('created_at', $this->year);
            
    //         // ->whereMonth('created_at', $this->month);
    // }

    // public function map($checklistanswer): array
    // {
    //     // $var = array();
    //     // $mku = $checklistanswer->datas;
    //     // $var[] = json_decode($mku, true);
    //     // foreach ($mku as $key => $mk) {
    //     //       echo "{$key}. Nama: {$mk->id_checklist} <br>";
    //     //     }
        
    //     $aku = ChecklistAnswer::query()->where('id_task', $this->id)->first();
    //     $mku = $aku->datas;
    //     $var[] = json_decode($mku, true);
    //     $var1 = $var[0];
    //     dd($var1);
        
    //     // foreach ($mku as $key => $mk) {
    //     //     //   echo "{$key}. Nama: {$mk->id_checklist} <br>";
    //     //       dd($mk);
    //     //     }
        

    //     return [
    //         $checklistanswer->task['id_task'],
    //         $checklistanswer->id,
    //         // $mk->id_checklist,
    //         $checklistanswer->datas,
    //         $checklistanswer->created_at
    //     ];
    // }

    public function headings(): array
    {
        return [
            'id_task',

            'id2',
            'Datas',
            // 'Country',
            'Created At'
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getStyle('A8:D8')->applyFromArray([
                    'font' => [
                        'bold' => true
                    ]
                ]);
            }
        ];
    }


    public function startCell(): string
    {
        return 'A8';
    }

    public function title(): string
    {
        
        $c = $this->uid;
        $b = $c.'-'.$this->subject;
        return $b;
    }
}