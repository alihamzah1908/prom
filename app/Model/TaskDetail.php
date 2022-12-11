<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TaskDetail extends Model
{
    protected $table = 'tb_detail_task';
    protected $primaryKey = 'id_detail_task';
    
    public function getMode(){
        return $this->belongsTo('\App\Model\Mode', 'id_mode');
    }
    public function getImpact(){
        return $this->belongsTo('\App\Model\Impact', 'id_impact');
    }
    public function getPriority(){
        return $this->belongsTo('\App\Model\Priority', 'id_priority');
    }
    public function getRootCaused(){
        return $this->belongsTo('\App\Model\RootCaused', 'id_root_caused');
    }
     
    public function getAsset(){
        return $this->belongsTo('\App\Model\Asset', 'id_asset');
    }
    public function getGroupInternal(){
        return $this->belongsTo('\App\Model\GroupInternal', 'id_group_internal');
    }
    public function getGroupCustomer(){
        return $this->belongsTo('\App\Model\GroupCustomer', 'id_group_customer');
    }
    public function getLocationB(){
        return $this->belongsTo('\App\Model\Segment', 'id_segment');
    }
    public function getLocationB2(){
        return $this->belongsTo('\App\Model\Segment', 'id_location_b');
    }
    public function getSiteB(){
        return $this->belongsTo('\App\Model\Site', 'id_site_b', 'site_id');
    }
    public function getChecklistCategory(){
        return $this->belongsTo('\App\Model\Category', 'id_checklist_category');
    }
     public function getChecklistPeriode(){
        return $this->belongsTo('\App\Model\ChecklistPeriode', 'id_periode');
    }

    public function priority(){
        return $this->hasOne('\App\Model\Priority', 'id_priority', 'id_priority');
    }

    public function siteB(){
        return $this->hasOne('\App\Model\Site', 'site_id', 'id_site_b');
    }
   
}
 