<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Inbox extends Model
{
    protected $table = 'tb_inbox';
    
    public function chats(){
        return $this->hasMany('\App\Model\InboxChats', 'id_inbox');
    }
    public function task(){
        return $this->belongsTo('\App\Model\Task', 'id_task');
    }
}
