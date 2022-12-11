<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    protected $table = 'tb_sub_category';
    protected $primaryKey = 'id_sub_category';
    
    
    public function category()
    {
        return $this->belongsTo('\App\Model\Category', 'id_category');
    }
    public function items()
    {
        return $this->hasMany('\App\Model\Item', 'id_sub_category');
    }
    public function creator(){
        return $this->belongsTo('\App\User', 'created_by');
    }
    public function updater(){
        return $this->belongsTo('\App\User', 'updated_by');
    }
}
