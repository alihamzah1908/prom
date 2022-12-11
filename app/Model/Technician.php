<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Technician extends Model
{
    protected $table = 'tb_technician';
    protected $primaryKey = 'id_technician';
    
    public function user()
    {
        return $this->belongsTo('\App\User', 'user_id');
    }
    public function site()
    {
        return $this->belongsTo('\App\Mode\Site', 'site_id');
    }
}
