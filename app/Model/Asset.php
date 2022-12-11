<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    protected $table = 'tb_asset';
    protected $primaryKey = 'id_asset';
    protected $fillable = [
        'id_asset', 'name', 'departement', 'description', 'created_by', 'updated_at'
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
