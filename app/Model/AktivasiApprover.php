<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AktivasiApprover extends Model
{
    protected $table = 'tb_aktivasi_approver';
    protected $primaryKey = 'id_approver';
    
    public function region(){
        return $this->belongsTo('\App\Model\Region', 'id_region');
    }
    public function site(){
        return $this->belongsTo('\App\Model\Site', 'id_site', 'site_id');
    }
    public function type(){
        return $this->belongsTo('\App\Model\AktivasiType', 'id_type');
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
}
