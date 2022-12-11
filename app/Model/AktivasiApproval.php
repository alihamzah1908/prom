<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AktivasiApproval extends Model
{
    protected $table = 'tb_aktivasi_approval';
    protected $primaryKey = 'id_approval';
    
    public function aktivasi(){
        return $this->belongsTo('\App\Model\Aktivasi', 'id_aktivasi');
    }
    public function approver1()
    {
        return $this->belongsTo('App\User', 'approver_1');
    }
    public function approver2()
    {
        return $this->belongsTo('App\User', 'approver_2');
    }
    public function approver3()
    {
        return $this->belongsTo('App\User', 'approver_3');
    }
    public function cid()
    {
        return $this->belongsTo('App\Model\CID', 'approver_2_cid');
    }
}
