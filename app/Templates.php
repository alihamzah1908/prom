<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Templates extends Model
{
    protected $table = 'tb_templates';
    
    public function creator(){
        return $this->belongsTo('\App\User', 'created_by');
    }
    public function updater(){
        return $this->belongsTo('\App\User', 'updated_by');
    }
}
