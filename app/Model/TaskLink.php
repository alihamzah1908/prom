<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TaskLink extends Model
{
    protected $table = 'tb_task_link';
    protected $primaryKey = 'id_link';
    
    public function task_1(){
        return $this->belongsTo('\App\Model\Task', 'id_task_1');
    }
    public function task_2(){
        return $this->belongsTo('\App\Model\Task', 'id_task_2');
    }
    
    public function technician_1(){
        return $this->belongsTo('\App\Model\Technician', 'id_technician_1');
    }
    public function technician_2(){
        return $this->belongsTo('\App\Model\Technician', 'id_technician_2');
    }
}
 