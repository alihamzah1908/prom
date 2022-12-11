<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TaskSchedule extends Model
{
    protected $table = 'tb_task_schedule';
    protected $primaryKey = 'id_task';
    
    public function getType(){
        return $this->belongsTo('\App\Model\TaskType', 'id_task_type');
    }
    public function getStatus(){
        return $this->belongsTo('\App\Model\Status', 'id_status');
    }
    public function getStatusPerType(){
        return $this->belongsTo('\App\Model\Status', 'id_task_type');
    }
    public function checklist_answers(){
        return $this->belongsTo('\App\Model\ChecklistAnswer', 'id_task', 'id_task');
    }
    public function getCategory(){
        return $this->belongsTo('\App\Model\Category', 'id_category');
    }
    public function getSubCategory(){
        return $this->belongsTo('\App\Model\SubCategory', 'id_sub_category');
    }
    public function getItem(){
        return $this->belongsTo('\App\Model\Item', 'id_item');
    }
    
    public function getApproval(){
        return $this->hasMany('\App\Model\TaskApproval','id_task');
    }
    public function getRegion(){
        return $this->belongsTo('\App\Model\Region', 'id_region');
    }
    //   public function getChecklistPeriode(){
    //     return $this->belongsTo('\App\Model\ChecklistPeriode', 'checklist_periode');
    // }
    public function getLocationA(){
        return $this->belongsTo('\App\Model\Segment', 'id_location_a');
    }
    public function getSite(){
        return $this->belongsTo('\App\Model\Site', 'id_site_a', 'site_id');
    }
    public function getTechnician(){
        return $this->belongsTo('\App\Model\Technician', 'id_technician');
    }
    
    public function getDetail(){
        return $this->belongsTo('\App\Model\TaskDetail', 'id_task', 'id_task');
    }
    public function getLog(){
        return $this->hasMany('\App\Model\TaskLog', 'id_task');
    }
    public function getImages(){
        return $this->hasMany('\App\Model\TaskImages', 'id_task');
    }
    public function creator(){
        return $this->belongsTo('\App\User', 'created_by');
    }
    public function updater(){
        return $this->belongsTo('\App\User', 'updated_by');
    }
    public function inbox(){
        return $this->belongsTo('\App\Model\Inbox', 'id_task', 'id_task');
    }
    public function getSubject(){
        return $this->belongsTo('\App\Model\Segment', 'subject');
    }
}
 