<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SiteEntryLog extends Model
{
    protected $table = 'tb_site_entry_log';
    protected $primaryKey = 'id_log';
    
    public function creator()
    {
        return $this->belongsTo('App\User', 'created_by');
    }
    public function site_entry()
    {
        return $this->belongsTo('App\Model\SiteEntry', 'id_site_entry', 'id_site_entry');
    }
}
