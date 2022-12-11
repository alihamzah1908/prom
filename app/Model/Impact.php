<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Impact extends Model
{
    protected $table = 'tb_impact';
    protected $primaryKey = 'id_impact';
    
    public function creator(){
        return $this->belongsTo('\App\User', 'created_by');
    }
    public function updater(){
        return $this->belongsTo('\App\User', 'updated_by');
    }
}
