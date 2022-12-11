<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\AfterSheet;
use App\Model\Task;

class TasksExport implements FromCollection, WithMapping,ShouldAutoSize, WithHeadings, WithStyles, WithCustomStartCell, WithEvents
{
    
    public function __construct(array $params)
    {
        $this->id_type = $params['id_type'] ?? null;
        $this->id_region = $params['id_region'] ?? null;
        $this->id_status = $params['id_status'] ?? null;
        $this->created_at_when = $params['created_at_when'] ?? null;
        $this->created_at_until = $params['created_at_until'] ?? null;
        $this->id_task = $params['id_task'] ?? null;
        $this->subject = $params['subject'] ?? null;
        $this->id_priority = $params['id_priority'] ?? null;
        $this->id_root = $params['id_root'] ?? null;
        $this->completed_at_when = $params['completed_at_when'] ?? null;
        $this->completed_at_until = $params['completed_at_until'] ?? null;
        $this->technician = $params['technician'] ?? null;
        $this->name_site_a = $params['name_site_a'] ?? null;
        $this->name_site_b = $params['name_site_b'] ?? null;
    }
    
    
    public function collection()
    {
        $tasks = Task::when($this->id_type, function($tasks){
                            $tasks = $tasks->where('id_task_type', $this->id_type);
                    })->when($this->id_region, function($tasks){
                            $tasks = $tasks->where('id_region', $this->id_region);
                    })->when($this->id_status, function($tasks){
                            $tasks = $tasks->where('id_status', $this->id_status);
                    })->when($this->created_at_when, function($tasks){
                            $tasks = $tasks->where('created_at','>=', date('Y-m-d 00:00:00', strtotime($this->created_at_when)));
                    })->when($this->created_at_until, function($tasks){
                            $tasks = $tasks->where('created_at','<=', date('Y-m-d 23:59:59', strtotime($this->created_at_until)));
                    })->when($this->id_task, function($tasks){
                            $tasks = $tasks->where('task_uid', 'like', '%'.$this->id_task.'%');
                    })->when($this->subject, function($tasks){
                            $tasks = $tasks->where('subject', 'like', '%'.$this->subject.'%');
                    })->when($this->id_priority, function($tasks){
                        $tasks = $tasks->whereHas('taskDetail', function ($tasks) {
                            return $tasks->where('id_priority', $this->id_priority);
                        });
                    })->when($this->id_root, function($tasks){
                        $tasks = $tasks->whereHas('taskDetail', function($tasks){
                            return $tasks->where('id_root_caused', $this->id_root);
                        });
                    })->when($this->completed_at_when, function($tasks){
                        $tasks = $tasks->whereHas('taskDetail', function($tasks){
                            return $tasks->where('request_complete_time', '>=', date('Y-m-d 00:00:00', strtotime($this->completed_at_when)));
                        });
                    })->when($this->completed_at_until, function($tasks){
                        $tasks = $tasks->whereHas('taskDetail', function($tasks){
                            return $tasks->where('request_complete_time', '<=', date('Y-m-d 23:59:59', strtotime($this->completed_at_until)));
                        });
                    })->when($this->technician, function($tasks){
                        $tasks = $tasks->whereHas('technician', function($tasks){
                            return $tasks->where('name_technician', 'like', '%'.$this->technician.'%');
                        });
                    })->when($this->name_site_a, function($tasks){
                        $tasks = $tasks->whereHas('siteA', function($tasks){
                            return $tasks->where('name_site', 'like', '%'.$this->name_site_a.'%');
                        });
                    })->when($this->name_site_b, function($tasks){
                        $tasks = $tasks->whereHas('taskDetail', function($tasks){
                            $tasks = $tasks->whereHas('siteB', function($tasks){
                                return $tasks->where('name_site', 'like', '%'.$this->name_site_b.'%');
                            });
                        });
                    })->latest()->get();

                 $tasks =    $tasks->where('is_deleted',0);
        return $tasks;
    }

    public function startCell(): string
    {
        return 'A1';
    }

    public function map($tasks): array
    {
         $detail = $tasks->getDetail;
         $status = $tasks->status->status_name;
        
        return [
            $tasks->id_task,
            $tasks->task_uid,
            $tasks->status->status_name ?? '',
            $tasks->getType->type_name ?? '',
            $tasks->getRegion->region_name ?? '',
          
            $tasks->subject,
            $tasks->technician->name_technician ?? '',
            $detail->request_start_time,
            $detail->request_complete_time,
             $tasks->time_complete,
            $tasks->created_at->format('Y-m-d H:i:s'),
        ];
    }

    public function headings(): array
    {
        return [
            'No',
            'Task ID',
            'Status',
            'Task Type',
            'Region',
            'Subject',
            'Technician',
            'Request start time',
            'Request complete time',
            'Time Completed',
            'Created At'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],

            // Styling a specific cell by coordinate.
            // 'B2' => ['font' => ['italic' => true]],

            // Styling an entire column.
             'C'  => ['font' => ['size' => 10]],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {

                
                $event->sheet
                    ->getPageSetup()
                    ->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE)->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A3);;                 
            },
        ];
     }
    
}
