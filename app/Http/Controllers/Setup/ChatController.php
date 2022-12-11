<?php

namespace App\Http\Controllers\Setup;

use App\Http\Controllers\Controller;
use App\Model\Chat;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function chat()
    {
        return view('setup.chat.index');
    }
}
