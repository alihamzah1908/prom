<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PermitLetterDetail extends Model
{
    protected $table = 'tb_permit_letter_detail';
    protected $primaryKey = 'id_permit_letter_detail';
    
    public function permit_letter(){
        return $this->belongsTo('\App\Model\PermitLetter', 'id_permit_letter');
    }
}
