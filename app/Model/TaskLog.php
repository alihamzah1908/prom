<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TaskLog extends Model
{
    protected $table = 'tb_task_log';
    protected $primaryKey = 'id_log';
    
    public function creator(){
        return $this->belongsTo('\App\User', 'created_by');
    }
    public function updater(){
        return $this->belongsTo('\App\User', 'updated_by');
    }
}
 