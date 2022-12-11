<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TotalCapacity extends Model
{
    protected $table = 'tb_total_capacity';
    protected $primaryKey = 'id_total_capacity';
    
    
    public function capasity()
    {
        return $this->belongsTo('\App\Model\Capacity', 'id_capacity');
    }
    public function aktivasi()
    {
        return $this->belongsTo('\App\Model\Aktivasi', 'capasity');
    }
}
