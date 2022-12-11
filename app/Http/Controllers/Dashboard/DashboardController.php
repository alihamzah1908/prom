<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables as FacadesDataTables;

use App\Http\Controllers\Controller;
use \App\Model\Task;
use \App\Model\TaskDetail;
use \App\Model\Priority;
use \App\Model\Status;
use \App\Model\RootCaused;
use \App\Model\Region;
use \App\Model\Segment;
use \App\Model\Aktivasi;
use \App\Model\Customer;
use \App\Model\AktivasiStatus;
use \App\Model\AktivasiStatusCollocation;
use \App\Model\Site;
use \App\Model\SiteEntry;
use \App\Model\PermitLetter;
use \App\Model\SubCategory;
use \App\Model\Category;
use \App\Model\Capacity;
use \App\Model\TotalCapacity;
use \App\Model\Technician;

class DashboardController extends Controller
{
    public function index(){
       
        return view('dashboard.index_testing', compact('types'));
    }
}
