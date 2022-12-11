<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    protected $table = 'tb_role';
    protected $primaryKey = 'id_role';
    
    public function creator()
    {
        return $this->belongsTo('\App\User', 'created_by');
    }
}
