<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $table = 'tb_region';
    protected $primaryKey = 'region_id';
    protected $fillable = [
        'region_id', 'region_name', 'region_desc',
    ];
    public function site()
    {
        return $this->hasMany('App\Model\Site');
    }
    public function task()
    {
        return $this->hasMany('App\Model\Task', 'id_region');
    }
    public function aktivasi()
    {
        return $this->hasMany('App\Model\Aktivasi', 'id_region');
    }
}
