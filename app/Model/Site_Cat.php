<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Site_Cat extends Model
{
    protected $table = 'tb_site_cat';
    protected $primaryKey = 'site_cat_id';
    protected $fillable = [
        'site_cat_id', 'site_cat_name', 'desc', 'status',
    ];
    public function site()
    {
        return $this->hasMany('App\Model\Site');
    }
}
