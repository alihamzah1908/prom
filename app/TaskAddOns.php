<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskAddOns extends Model
{
    protected $table = 'tb_task_add_ons';
    
    public function section(){
        return $this->belongsTo('\App\TaskAddOnsSection', 'id_section');
    }
}
