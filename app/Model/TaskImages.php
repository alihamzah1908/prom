<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TaskImages extends Model
{
    protected $table = 'tb_task_images';
    
    public function task(){
        return $this->belongsTo('\App\Model\Task', 'id_task');
    }
}
 