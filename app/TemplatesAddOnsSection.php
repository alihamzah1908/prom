<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TemplatesAddOnsSection extends Model
{
    protected $table = 'tb_templates_add_ons_section';
    
    public function fields(){
        return $this->hasMany('\App\TemplatesAddOns', 'id_section');
    }
}
