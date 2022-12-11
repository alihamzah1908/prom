<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Mode extends Model
{
    protected $table = 'tb_mode';
    protected $primaryKey = 'id_mode';
    
    public function creator(){
        return $this->belongsTo('\App\User', 'created_by');
    }
    public function updater(){
        return $this->belongsTo('\App\User', 'updated_by');
    }
}
