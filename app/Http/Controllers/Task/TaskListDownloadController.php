<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \App\Model\Task;
use \App\Model\TaskType;
use \App\Model\TaskSchedule;
use \App\Model\TaskDetail;
use \App\Model\TaskLog;
use \App\Model\TaskApproval;
use \App\Model\TaskLink;
use \App\Model\TaskImages;
use \App\Model\Status;
use \App\Model\Priority;
use \App\Model\Approver; 
use \App\Model\ApproverDetail;
use \App\Model\Technician;
use \App\Model\Region;
use \App\Model\Site;
use \App\Model\RootCaused;
use \App\Model\GroupCustomer;
use \App\Model\Checklist;
use \App\Model\ChecklistAnswer;
use \Auth;
use \Mail;
use \App\Templates;
use \App\TemplatesDefaultValue;
use DateTime;
use \App\TaskAddOns;
use \App\TaskAddOnsSection;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use \App\Model\Filter;
// use Maatwebsite\Excel\Excel;
// use App\Exports\UserMultiSheetExport;
use Maatwebsite\Excel\Excel;
use App\Exports\TasksExport;

class TaskListDownloadController extends Controller
{
    private $excel;

    public function __construct(Excel $excel){
        $this->excel = $excel;
    }
    public function download_list_excel_test(){

        // return Excel::download(new TasksExport(request()->query()), 'List-Task.xlsx');
       
        return $this->excel->download(new TasksExport(request()->query()), 'List-Task.xlsx');
    }
    public function download_list_pdf_test(){
        // return Excel::download(new TasksExport(request()->query()), 'List-Task.pdf');
       
        return $this->excel->download(new TasksExport(request()->query()), 'List-Task.pdf');
    }

}