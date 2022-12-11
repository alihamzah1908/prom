<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TaskApproval extends Model
{
    protected $table = 'tb_task_approval';
    protected $primaryKey = 'id_task_approval';
    
    public function user(){
        return $this->belongsTo('\App\User', 'user_id');
    }
}
