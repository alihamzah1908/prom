<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ApproverDetail extends Model
{
    protected $table = 'tb_detail_approver';
    protected $primaryKey = 'id_detail_approver';
    
    public function user(){
        return $this->belongsTo('\App\User', 'user_id');
    }
}
