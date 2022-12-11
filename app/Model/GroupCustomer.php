<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class GroupCustomer extends Model
{
    protected $table = 'tb_group_customer';
    protected $primaryKey = 'id_group';
    
    public function getUsers(){
        return $this->hasMany('\App\Model\GroupUser', 'id_group');
    }
}
 