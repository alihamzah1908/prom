<?php

namespace App\Http\Controllers\Setup\TemplateForm;

use App\Http\Controllers\Controller;
use App\Model\PmTemplate;
use Illuminate\Http\Request;

class PmTemplateController extends Controller
{
    public function index()
    {
        return view('setup.template_form.pmTemplate');
    }
}
