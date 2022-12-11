<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AktivasiApproverDetail extends Model
{
    protected $table = 'tb_aktivasi_approver_detail';
    
    public function user(){
        return $this->belongsTo('\App\User','user_id');
    }
}
