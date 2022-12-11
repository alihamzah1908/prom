<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Approver extends Model
{
    protected $table = 'tb_approver';
    protected $primaryKey = 'id_approver';
    
    public function region(){
        return $this->belongsTo('\App\Model\Region', 'id_region');
    }
    public function task_type(){
        return $this->belongsTo('\App\Model\TaskType', 'id_task_type');
    }
    public function detail(){
        return $this->hasMany('\App\Model\ApproverDetail', 'id_approver');
    }
}
