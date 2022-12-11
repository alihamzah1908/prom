<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $table = 'tb_status';
    protected $primaryKey = 'id_status';
    
    public function creator(){
        return $this->belongsTo('\App\User', 'created_by');
    }
    public function updater(){
        return $this->belongsTo('\App\User', 'updated_by');
    }
    
    public function task(){
        return $this->hasMany('\App\Model\Task', 'id_status');
    }
    
    public function taskType(){
        return $this->hasOne('App\Model\TaskType', 'id_type', 'task_type_id');
    }
}
