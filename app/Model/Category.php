<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'tb_category';
    protected $primaryKey = 'id_category';
    
    public function sub_categories(){
        return $this->hasMany('\App\Model\SubCategory', 'id_category');
    }
    public function items()
    {
        return $this->hasMany('\App\Model\Item', 'id_category');
    }
    public function creator(){
        return $this->belongsTo('\App\User', 'created_by');
    }
    public function updater(){
        return $this->belongsTo('\App\User', 'updated_by');
    }
}
