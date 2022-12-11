<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Segment extends Model
{
    protected $table = 'tb_segment';
    protected $primaryKey = 'id_segment';
    protected $fillable = [
        'id_segment', 'segment_name', 'segment_desc', 'created_by', 'updated_at'
    ];
    public function creator()
    {
        return $this->belongsTo('\App\User', 'created_by');
    }
    public function updater()
    {
        return $this->belongsTo('\App\User', 'updated_by');
    }
    
    public function task(){
        return $this->hasMany('\App\Model\Task', 'subject');
    }
}
