<?php

namespace App\Excels;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class Detail_Task implements FromView{
    
    public function view(): View
    {
        return view('task.excel_detail', [
            'data' => []
        ]);
    }
}
