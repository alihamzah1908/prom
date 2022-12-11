<?php

namespace App\Http\Controllers\Setup\TemplateForm;

use App\Http\Controllers\Controller;
use App\Model\CrTemplate;
use Illuminate\Http\Request;

class CrTemplateController extends Controller
{
    public function index()
    {
        return view('setup.template_form.crTemplate');
    }
}
