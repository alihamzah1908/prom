<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskAddOnsSection extends Model
{
    protected $table = 'tb_task_add_ons_section';
    
    public function fields(){
        return $this->hasMany('\App\TaskAddOns', 'id_section');
    }
}
