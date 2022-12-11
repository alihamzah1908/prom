<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SiteEntry extends Model
{
    protected $table = 'tb_site_entry';
    protected $primaryKey = 'id_site_entry';
    
    public function region()
    {
        return $this->belongsTo('App\Model\Region', 'id_region');
    }
    public function site()
    {
        return $this->belongsTo('App\Model\Site', 'id_site', 'site_id');
    }
    public function getLog()
    {
        return $this->hasMany('App\Model\SiteEntryLog', 'id_site_entry');
    }
    public function approver1()
    {
        return $this->belongsTo('App\User', 'approver_1');
    }
    public function approver2()
    {
        return $this->belongsTo('App\User', 'approver_2');
    }
    public function createdBy()
    {
        return $this->belongsTo('App\User', 'created_by');
    }
    public function creator(){
        return $this->belongsTo('\App\User', 'created_by');
    }
    // public function updater(){
    //     return $this->belongsTo('\App\User', 'updated_by');
    // }
}
