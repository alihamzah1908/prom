<?php

namespace App\Http\Controllers\Setup\DataAdministration;

use App\Http\Controllers\Controller;
use App\Model\SystemLog;
use Illuminate\Http\Request;

class SystemLogController extends Controller
{
    public function index()
    {
        return view('setup.administration.systemlog');
    }
}
