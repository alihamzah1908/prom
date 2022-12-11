<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ChecklistCategory extends Model
{
    protected $table = 'tb_checklist_category';
    protected $foreignKey = 'id_category';
}
