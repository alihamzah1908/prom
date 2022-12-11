<?php

namespace App\Excels;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class Task implements FromView{
    
    public function view(): View
    {
        return view('task.excel', [
            'data' => []
        ]);
    }
}
