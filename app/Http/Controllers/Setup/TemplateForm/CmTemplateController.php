<?php

namespace App\Http\Controllers\Setup\TemplateForm;

use App\Http\Controllers\Controller;
use App\Model\CmTemplate;
use Illuminate\Http\Request;

class CmTemplateController extends Controller
{
    public function index()
    {
        return view('setup.template_form.cmTemplate');
    }
}
