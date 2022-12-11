<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TemplatesDefaultValue extends Model
{
    protected $table = 'tb_templates_default_value';
    
    public function getType(){
        return $this->belongsTo('\App\Model\TaskType', 'id_task_type');
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
    public function getRegion(){
        return $this->belongsTo('\App\Model\Region', 'id_region');
    }
    public function getLocationA(){
        return $this->belongsTo('\App\Model\Segment', 'id_location_a');
    }
    public function getSite(){
        return $this->belongsTo('\App\Model\Site', 'id_site', 'site_id');
    }
    public function getTechnician(){
        return $this->belongsTo('\App\Model\Technician', 'id_technician');
    }
    
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
    public function getChecklistCategory(){
        return $this->belongsTo('\App\Model\Category', 'id_checklist_category');
    }
    public function template(){
        return $this->belongsTo('\App\Template', 'id_template');
    }
    public function creator(){
        return $this->belongsTo('\App\User', 'created_by');
    }
    public function updater(){
        return $this->belongsTo('\App\User', 'updated_by');
    }
}
