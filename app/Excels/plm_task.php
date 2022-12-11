<?php

namespace App\Excels;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class plm_task implements FromView{
    
    public function view(): View
    {
        return view('task.plm_task_excel', [
            'data' => []
        ]);
    }
}
