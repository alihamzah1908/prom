<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ChecklistPeriode extends Model
{
    protected $table = 'tb_checklist_periode';
    protected $foreignKey = 'id_periode';
    
     public function task()
    {
        return $this->belongsTo('App\Model\Task', 'checklist_periode');
    }
    
    
}
