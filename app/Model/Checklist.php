<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Checklist extends Model
{
    protected $table = 'tb_checklist';
    protected $primaryKey = 'id_checklist';
    
    public function category(){
        return $this->belongsTo('\App\Model\ChecklistCategory', 'id_checklist_category', 'id_category');
    }
    public function periode(){
        return $this->belongsTo('\App\Model\ChecklistPeriode', 'checklist_periode', 'id_periode');
    }
    public function region(){
        return $this->belongsTo('\App\Model\Region', 'id_region');
    }
    
    public function creator(){
        return $this->belongsTo('\App\User', 'created_by');
    }
    public function updater(){
        return $this->belongsTo('\App\User', 'updated_by');
    }
    //dari sini
    protected $fillable = [
        'checklist_periode',
        'id_checklist_category',
        'id_region',
        'checklist_name',
        'checklist_desc',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
        'deleted_at',
        'position',
    ];

    public function saveQuietly(){
        return static::withoutEvents(function(){
            return $this->save();
        });
    }
    //sampai sini
}
