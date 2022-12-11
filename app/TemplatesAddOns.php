<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TemplatesAddOns extends Model
{
    protected $table = 'tb_templates_add_ons';
    
    public function section(){
        return $this->belongsTo('\App\TemplatesAddOnsSection', 'id_section');
    }
}
