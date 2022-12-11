<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PermitLetter extends Model
{
    protected $table = 'tb_permit_letter';
    protected $primaryKey = 'id_permit_letter';
    
    public function pengunjung(){
        return $this->hasMany('\App\Model\PermitLetterDetail', 'id_permit_letter', 'id_permit_letter');
    }
    
    public function region(){
        return $this->belongsTo('\App\Model\Region', 'id_region');
    }
    public function site(){
        return $this->belongsTo('\App\Model\Site', 'id_site','site_id');
    }
    public function createdBy(){
        return $this->belongsTo('\App\User', 'created_by');
    }
}
