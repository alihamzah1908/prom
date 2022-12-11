<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserLocation extends Model
{
    protected $table = 'tb_user_location';
    
    public function site(){
        return $this->belongsTo('\App\Model\Site', 'id_site', 'site_id');
    }
    public function technician(){
        return $this->belongsTo('\App\Model\Technician', 'id_technician');
    }
}
