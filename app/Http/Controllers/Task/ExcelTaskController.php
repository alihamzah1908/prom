<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \App\Model\Task;
use \App\Model\TaskSchedule;
use \App\Model\TaskDetail;
use \App\Model\TaskLog;
use \App\Model\TaskApproval;
use \App\Model\TaskLink;
use \App\Model\TaskImages;
use \App\Model\Status;
use \App\Model\Approver;
use \App\Model\ApproverDetail;
use \App\Model\Technician;
use \App\Model\Region;
use \App\Model\Site;
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
use Maatwebsite\Excel\Excel;
use App\Exports\UserMultiSheetExport;

class ExcelTaskController extends Controller
{

    
    private $excel;

    public function __construct(Excel $excel){
        $this->excel = $excel;
    }

    public function export7days(){
        $year = date('Y');
        $month = date('F');
        $now = \Carbon\Carbon::now()->toDateString();
        $before = \Carbon\Carbon::now()->subDay(6)->toDateString();
        return $this->excel->download(new UserMultiSheetExport(2021), 'Task PM 7 Days dari '.$before.' sampai '.$now.'.xlsx');
    }

}