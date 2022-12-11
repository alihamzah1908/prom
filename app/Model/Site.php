<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    protected $table = 'tb_site';
    protected $foreignKey = 'region_id';
    protected $fillable = [
        'site_id', 'region_id', 'name_site', 'address', 'head_manager', 'site_desc','kapasitas_kwh','kapasitas_genset','id_site_category','uid_site','latitude','longitude'
    ];

    public function region()
    {
        return $this->belongsTo('App\Model\Region', 'region_id');
    }
    public function manager()
    {
        return $this->belongsTo('App\User', 'head_manager');
    }
    public function site_cat()
    {
        return $this->belongsTo('App\Model\Site_Cat', 'id_site_category');
    }
}
