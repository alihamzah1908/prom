<?php

namespace App\Http\Controllers\Setup\UserPermission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function role()
    {
        return view('setup.userpermission.index');
    }
    public function admin()
    {
        return view('setup.userpermission.admin');
    }
    public function technician()
    {
        return view('setup.userpermission.technician');
    }
    public function validator()
    {
        return view('setup.userpermission.validator');
    }
    public function visitor()
    {
        return view('setup.userpermission.visitor');
    }
    public function groupEksternal()
    {
        return view('setup.userpermission.groupEksternal');
    }
    public function groupInternal()
    {
        return view('setup.userpermission.groupInternal');
    }

    public function detailrole()
    {
        $title['title'] = 'user permission';
        $header_title['header_title'] = 'User & Permissions';
        return view('setup.userpermission.detailrole', $title, $header_title);
    }
    public function departement()
    {
        return view('setup.userpermission.departemen');
    }
}
