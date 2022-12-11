<?php

namespace App\Http\Controllers\Setup\TemplateForm;

use App\Http\Controllers\Controller;
use App\Model\PlmTemplate;
use Illuminate\Http\Request;

class PlmTemplateController extends Controller
{
    public function index()
    {
        return view('setup.template_form.plmTemplate');
    }
}
