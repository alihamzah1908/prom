<?php

namespace App\Http\Controllers\Setup\AktivasiLayanan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \Auth;

class AktivasiLayananController extends Controller
{
    public function index(Request $request)
    {
        return view('setup.aktivasi_layanan.aktivasi_layanan');
    }
}







