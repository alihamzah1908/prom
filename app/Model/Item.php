<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'tb_item';
    protected $primaryKey = 'id_item';
    
    public function category()
    {
        return $this->belongsTo('\App\Model\Category', 'id_category');
    }
    public function sub_category()
    {
        return $this->belongsTo('\App\Model\SubCategory', 'id_sub_category');
    }
}
