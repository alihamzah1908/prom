<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Aktivasi extends Model
{
    protected $table = 'tb_active_service';
    
    public function type(){
        return $this->belongsTo('\App\Model\AktivasiType', 'id_type_service');
    }
    public function customer(){
        return $this->belongsTo('\App\Model\Customer', 'id_customer');
    }
    public function site(){
        return $this->belongsTo('\App\Model\Site', 'id_site', 'site_id');
    }
    public function region(){
        return $this->belongsTo('\App\Model\Region', 'id_region');
    }
    public function segment(){
        return $this->belongsTo('\App\Model\Segment', 'id_segment');
    }
    public function location(){
        return $this->belongsTo('\App\Model\Segment', 'id_segment');
    }
    public function cord(){
        return $this->belongsTo('\App\Model\Cord', 'id_cord');
    }
    public function cid(){
        return $this->belongsTo('\App\Model\CID', 'id_cid');
    }
     public function capacity(){
        return $this->belongsTo('\App\Model\Capacity', 'capasity');
    }
    public function status(){
        return $this->belongsTo('\App\Model\AktivasiStatus', 'id_status');
    }
    public function status_collocation(){
        return $this->belongsTo('\App\Model\AktivasiStatusCollocation', 'id_status');
    }
    public function getLog(){
        return $this->hasMany('\App\Model\AktivasiLog', 'id_aktivasi', 'id');
    }
}
