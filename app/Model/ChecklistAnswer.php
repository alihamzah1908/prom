<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ChecklistAnswer extends Model
{
    protected $table = 'tb_checklist_answers';
    
    public function task(){
        return $this->belongsTo('\App\Model\Task','id_task');
    }
}
