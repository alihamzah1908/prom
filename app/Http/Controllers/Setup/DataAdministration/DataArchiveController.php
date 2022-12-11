<?php

namespace App\Http\Controllers\Setup\DataAdministration;

use App\Http\Controllers\Controller;
use App\Model\DataArchive;
use Illuminate\Http\Request;

class DataArchiveController extends Controller
{
    public function index()
    {
        return view('setup.administration.dataarchive');
    }
}
