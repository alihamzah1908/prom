<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class InboxChats extends Model
{
    protected $table = 'tb_inbox_chats';
    
    public function inbox(){
        return $this->belongsTo('\App\Model\Inbox', 'id_inbox');
    }
    public function sender(){
        return $this->belongsTo('\App\User', 'id_sender');
    }
}
