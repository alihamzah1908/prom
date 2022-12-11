<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SiteEntryApprover extends Model
{
    protected $table = 'tb_site_entry_approver';
    protected $primaryKey = 'id_approver';
    
    public function site()
    {
        return $this->belongsTo('App\Model\Site', 'id_site', 'site_id');
    }
    
    public function approver1()
    {
        return $this->belongsTo('App\User', 'approver_1');
    }
    public function approver2()
    {
        return $this->belongsTo('App\User', 'approver_2');
    }
}
