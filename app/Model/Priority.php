<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Priority extends Model
{
    protected $table = 'tb_priority';
    protected $primaryKey = 'id_priority';
    
    public function creator(){
        return $this->belongsTo('\App\User', 'created_by');
    }
    public function updater(){
        return $this->belongsTo('\App\User', 'updated_by');
    }
    public function taskType(){
        return $this->hasOne('App\Model\TaskType', 'id_type', 'id_task_type');
    }
}
