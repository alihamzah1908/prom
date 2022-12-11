<?php

namespace App\Http\Controllers\Setup\Customization;

use App\Http\Controllers\Controller;
use App\Model\Tasktype;
use Illuminate\Http\Request;

class TasktypeController extends Controller
{
    public function index()
    {
        return view('setup.customization.tasktype');
    }
}
