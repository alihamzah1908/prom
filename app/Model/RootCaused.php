<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class RootCaused extends Model
{
    protected $table = 'tb_rootcaused';
    protected $primaryKey = 'id_caused';
    protected $fillable = [
        'id_caused', 'name_caused', 'desc_caused', 'created_by', 'updated_at'
    ];
    public function creator()
    {
        return $this->belongsTo('\App\User', 'created_by');
    }
    public function updater()
    {
        return $this->belongsTo('\App\User', 'updated_by');
    }
}
