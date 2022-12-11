<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TaskType extends Model
{
    protected $table = 'tb_tasktype';
    protected $primaryKey = 'id_type';

    protected $fillable = [
        'id_type', 'type_name', 'type_desc', 'type_status', 'color'
    ];
}
 