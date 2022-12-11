<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AktivasiLog extends Model
{
    protected $table = 'tb_aktivasi_log';
    protected $primaryKey = 'id_log';
    
    public function creator(){
        return $this->belongsTo('\App\User', 'created_by');
    }
    public function updater(){
        return $this->belongsTo('\App\User', 'updated_by');
    }
    //   public function capacity(){
    //     return $this->belongsTo('\App\Model\Capacity', 'capasity');
    // }
    
}
 