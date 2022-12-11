<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Redirect;
use Validator;
use Auth;
use Session;
use Illuminate\Support\Facades\Hash;
use File;
use \App\Templates;
use \App\TemplatesDefaultValue;
use \App\Model\Task;
use \App\Model\TaskDetail;
use \App\TemplatesAddOns;
use \App\TemplatesAddOnsSection;

class TaskTemplateController extends Controller
{
    public function index(Request $r, $id_type)
    {
        // $id_type = $r->id_type;
        switch($id_type){
            case 2:
                $id_type = 2;
                $template_view = 'setup.template_form.pmTemplate';
                break;
            case 3:
                $id_type = 3;
                $template_view = 'setup.template_form.crTemplate';
                break;
            case 4 : 
                $id_type = 4 ;
                $template_view = 'setup.template_form.plmTemplate';
                break;
            default:
                $id_type = 1;
                $template_view = 'setup.template_form.cmTemplate';
        }
        $task = new Task;
        $task_detail = new TaskDetail;
        $id_template = $id_type;
        $compact = compact(  'task', 'task_detail', 'id_type', 'template_view', 'id_template');
        return view('setup.template_form.index', $compact);
    }
    public function create(Request $r, $id_type)
    {
        $path = base_path("app/TaskTemplates/elements.json");
        $elements = json_decode(file_get_contents($path), true);
        $elements = $elements['elements'];
        
        $id_template = $id_type;
        switch($id_template){
            case 2:
                $id_template = 2;
                $task_type = 'task_templates.pmTaskTemplate';
                break;
            case 3:
                $id_template = 3;
                $task_type = 'task_templates.crTaskTemplate';
                break;
            case 4 : 
                $id_tempate = 4 ;
                $task_type = 'task_templates.plmTaskTemplate';
                break;
            default:
                $id_template = 1;
                $task_type = 'task_templates.cmTaskTemplate';
        }
        
        $task = new Task;
        $task_detail = new TaskDetail;
        $temp = new Templates;
        if($r->id){
            $temp = Templates::where('id', $r->id)->first();
            if(!$temp) $temp = new Templates;
            $deff = TemplatesDefaultValue::where('id_template', $temp->id)->first();
            if($deff){
                $task = $deff; $task_detail = $deff;
                $task->sub_category_name = $task->getSubCategory?$task->getSubCategory->sub_category_name:'-';
                $task->item_name = $task->getItem?$task->getItem->item_name:'-';
            }
        }
        if($r->from){
            $temp = Templates::where('id', $r->from)->first();
            if(!$temp) $temp = new Templates;
            $deff = TemplatesDefaultValue::where('id_template', $temp->id)->first();
            if($deff){
                $task = $deff; $task_detail = $deff;
                $task->sub_category_name = $task->getSubCategory?$task->getSubCategory->sub_category_name:'-';
                $task->item_name = $task->getItem?$task->getItem->item_name:'-';
            }
        }
        $section = TemplatesAddOnsSection::where('id_template', $temp->id)->get();
        
        $compact = compact('elements', 'section', 'task', 'task_detail', 'id_template', 'task_type', 'temp');
        // return response()->json($compact);
        return view('task_templates.create', $compact);
    }
    
    public function remove_template(Request $r, $type, $id){
        // public function remove_impact(Request $r, $type, $id_impact){
        $result = [];
        $result["status"] = false;
        $result["message"] = "";
        $result["newtoken"] = csrf_token();
       
        $d = Templates::where('id', $id)->first();
        $result["id"] = $id;
        $result["d"] = $d;
        if(!$d){
            $result["message"] = "Impact not found!";
            return response($result);
        }
        $d->delete();
        
        $result["status"] = true;
        $result["message"] = "Deleted successfully!";
        return response()->json($result);
        
        // $id->delete();
        // return back();
    
    }
    
    public function getTaskTemplate(Request $r)
    {
        $result = [];
        $result["status"] = false;
        $result["message"] = "";
        $result["newtoken"] = csrf_token();
        
        $template_name = $r->template_name;
        if($template_name){
            $path = base_path("app/TaskTemplates/$template_name.json");    
        }
        
        if(!file_exists($path)){
            $path = base_path("app/TaskTemplates/task_templates.json");
        }
        
        $d = json_decode(file_get_contents($path), true);
        
        $result["status"] = true;
        $result["data"] = $d;
        return response($result);
    } 
    
    public function task_templates(Request $r)
    {
        $result = [];
        $result["status"] = false;
        $result["message"] = "";
        $result["newtoken"] = csrf_token();
        $result["request"] = $r->all();
        
        $user = Auth::user();
        if(!$user){
            $result["message"] = "Please Login first!";
            return $result;
        }
        // return $result;
        $template_name = $r->template_name;
        $template_comments = $r->template_comments;
        $template=[];
        $template['template_name'] = $template_name;
        $template['template_comments'] = $template_comments;
        
        $path = base_path("app/TaskTemplates/$template_name.json");
        if(!file_exists($path)){
            File::put(base_path("app/TaskTemplates/$template_name.json"), []);
        }
        $temp = Templates::where('template_name', $template_name)->first();
        if(!$temp){
            $temp = new Templates;
            $temp->created_by = $user->id;
        }
        
        
        
        $fields = $r->fields;
        $parents = $r->parents;
        $parents_id = $r->parents_id;
        if(!$fields){
            $result["message"] = "No field given!";
            return $result;
        }
        $d = json_decode(file_get_contents($path), true);
        $new_parents = [];
        foreach($parents as $k => $v){
            $parent_title = $v;
            $v = str_replace(' ', '_', $v);
            $form = $parents[$k];
            $new_parents[$v]['title'] = $parent_title;
            $new_parents[$v]['id'] = $parents_id[$k];
            $field = [];
            foreach($fields as $k_f => $v_f){
                $arr_field = $fields[$k_f];
                $parent = $arr_field['parent'];
                
                
                $id = getIndex($arr_field, 'id');
                $name = getIndex($arr_field, 'name'); 
                $type = getIndex($arr_field, 'type');
                $default_value = getIndex($arr_field, 'default_value');
                $placeholder = getIndex($arr_field, 'placeholder');
                $min_length = getIndex($arr_field, 'min_length'); 
                $max_length = getIndex($arr_field, 'max_length'); 
                $min = getIndex($arr_field, 'min');
                $max = getIndex($arr_field, 'max');
                $pattern = getIndex($arr_field, 'pattern');
                $title = getIndex($arr_field, 'title'); 
                $autocomplete = getIndex($arr_field, 'autocomplete');
                $options = getIndex($arr_field, 'options');
                $rows = getIndex($arr_field, 'rows');
                $parent = getIndex($arr_field, 'parent');
                $parent = str_replace(' ', '_', $parent);
                
                if($parent == $parents_id[$k]){
                    $type = getIndex($arr_field, 'type', 'text');
                    $field[] = $this->setElement($id, $name, $type, $placeholder, $min_length, $max_length, $min, $max, $pattern, $title, $autocomplete, $options, $rows, $default_value, $parent);
                }
            }
            $temp->template_name = $template_name;
            $temp->template_comments = $template_comments;
            $temp->updated_by = $user->id;
            $temp->save();
            
            $new_parents[$v]['fields'] = $field;
            
        }
        // return $form;
        $d['template'] = $template;
        $d['parents'] = $new_parents;
        $newJsonString = json_encode($d);
        file_put_contents($path, $newJsonString);
        
        
        $result["message"] = "Updateded Successfully";
        $result["status"] = true;
        $result["data"] = $d;
        return response($result);
    } 
    
    public function new_task_templates_value(Request $r, $id_type)
    {
        $user = Auth::user();
        if(!$user){
            \Session::flash('message', "CSRF FAILED PLEASE RE-LOGIN!");
            \Session::flash('alert-class', 'alert-danger');
            return redirect()->back()->withInput($r->all());
        }
        
        $temp = new Templates;
        if($r->id){
            $temp = Templates::where('id', $r->id)->first();
        }
        $temp->id_task_type = $id_type;
        $temp->template_name = $r->template_name;
        $temp->template_comments = $r->template_comments;
        $temp->created_by = $user->id;
        $temp->updated_by = $user->id;
        // $temp->id = 1;
        $temp->save();
        if(true){
            $task = new TemplatesDefaultValue;
            if($r->id){
                $task = TemplatesDefaultValue::where('id_template', $r->id)->first();
            }
            $task->id_technician = $r->id_technician;
            $task->id_template = $temp->id;
            $task->id_task_type = $id_type;
            $task->id_category = $r->id_category;
            $task->id_sub_category = $r->id_sub_category;
            $task->id_item = $r->id_item;
            $task->description = $r->description;
            $task->subject = $r->subject;
            
            $task->id_region = $r->id_region;
            $task->id_location_a = $r->id_location_a;
            $task->id_site_a = $r->id_site_a;
            $task->created_by = $user->id;
            $task->checklist_periode = $r->checklist_periode;
            $task->id_checklist_category = json_encode($r->id_checklist_category);
            $task->request_start_time = $r->request_start_time;
            $task->request_complete_time = $r->request_complete_time;
            $task->id_mode = $r->id_mode;
            $task->id_impact = $r->id_impact;
            $task->impact_detail = $r->impact_detail;
            $task->id_priority = $r->id_priority;
            $task->id_root_caused = $r->id_root_caused;
            $task->id_asset = $r->id_asset;
            $task->id_group_internal = $r->id_group_internal;
            $task->id_group_customer = json_encode($r->id_group_customer);
            $task->id_location_b = $r->id_location_b;
            $task->id_site_b = $r->id_site_b;
            $task->total_hari_kerja = $r->total_hari_kerja;
            $task->total_waktu_kerja = $r->total_waktu_kerja;
            $task->down_start = $r->down_start;
            $task->down_end = $r->down_end;
            $task->save();
        }
        
        \Session::flash('message', "Task Created Successfully!");
        \Session::flash('alert-class', 'alert-success');
        \Session::flash('data', $task);
        return redirect()->to("/setup/template-form/$id_type");
    }
    
    public function template_addons(Request $r, $id_template){
        
        $path = base_path("app/TaskTemplates/elements.json");
        $elements = json_decode(file_get_contents($path), true);
        $elements = $elements['elements'];
        
        $task = new Task;
        $task_detail = new TaskDetail;
        $temp = new Templates;
        if($r->id){
            $temp = Templates::where('id', $r->id)->first();
            if(!$temp) $temp = new Templates;
            $deff = TemplatesDefaultValue::where('id_template', $temp->id)->first();
            if($deff){
                $task = $deff; $task_detail = $deff;
                $task->sub_category_name = $task->getSubCategory?$task->getSubCategory->sub_category_name:'-';
                $task->item_name = $task->getItem?$task->getItem->item_name:'-';
            }
        }
        if($r->from){
            $temp = Templates::where('id', $r->from)->first();
            if(!$temp) $temp = new Templates;
            $deff = TemplatesDefaultValue::where('id_template', $temp->id)->first();
            if($deff){
                $task = $deff; $task_detail = $deff;
                $task->sub_category_name = $task->getSubCategory?$task->getSubCategory->sub_category_name:'-';
                $task->item_name = $task->getItem?$task->getItem->item_name:'-';
            }
        }
        $section = TemplatesAddOnsSection::where('id_template', $temp->id)->get();
        
        $compact = compact('elements', 'section', 'task', 'task_detail', 'id_template', 'temp');
        return view('task_templates.template_add_ons', $compact);
    }
    public function template_add_ons(Request $r){
        $result = [];
        $result["status"] = false;
        $result["message"] = "";
        $result["newtoken"] = csrf_token();
        $result["request"] = $r->all();
        
        $user = Auth::user();
        if(!$user){
            $result["message"] = "Please Login first!";
            return $result;
        }
        
        $temp = Templates::where('id', $r->id)->first();
        if(!$temp){
            $result["message"] = "Template not found!";
            return $result;
        }
        
        $fields = $r->fields;
        $parents = $r->parents;
        $parents_id = $r->parents_id;
        if(!$fields){
            $result["message"] = "No field given!";
            return $result;
        }
        
        foreach(TemplatesAddOnsSection::where('id_template', $temp->id)->get() as $se){
            foreach(TemplatesAddOns::where('id_section', $se->id)->get() as $fi){
                $fi->delete();
            }
            $se->delete();
        }
        
        $new_parents = [];
        foreach($parents as $k => $v){
            $section = new TemplatesAddOnsSection;
            $section->name = $v;
            $section->section_id = $parents_id[$k];
            $section->id_template = $temp->id;
            $section->save();
            
            foreach($fields as $k_f => $v_f){
                $arr_field = $fields[$k_f];
                $parent = $arr_field['parent'];
                
                if($parent == $parents_id[$k]){
                    $field = new TemplatesAddOns;
                    $field->id_section = $section->id;
                    $field->type = getIndex($arr_field, 'type');
                    $field->field_id = getIndex($arr_field, 'id');
                    $field->name = getIndex($arr_field, 'name');
                    $field->default_value = getIndex($arr_field, 'default_value');
                    $field->save();
                }
            }
            
        }
        
        $result["message"] = "Updateded Successfully";
        $result["status"] = true;
        $result["data"] = $r->all();
        return response($result);
    }
    
    public function newData(Request $r){
        return $r->all();
    }
    public function setElement($id, $name, $type, $placeholder, $min_length, $max_length, $min, $max, $pattern, $title, $autocomplete, $options, $rows, $default_value, $parent){
        $field = [
                    "id" => $id,
                    "name" => $name,
                    "parent" => $parent,
                    "type" => $type,
                    "default_value" => $default_value
                  ];
        switch($type){
            case "select":
                $field["options"] = $options;
                break;
            case "textarea":
                $field["placeholder"] = $placeholder;
                $field["max_length"] = $max_length;
                $field["title"] = $title;
                $field["rows"] = $rows;
                break;
            case "radio":
                $field["options"] = $options;
                break;
            case "checkbox":
                $field["options"] = $options;
            case "EMPTY_ROW":
                $field["options"] = $options;
            default:
                $field["placeholder"] = $placeholder;
                $field["max_length"] = $max_length;
                $field["min_length"] = $min_length;
                $field["min"] = $min;
                $field["max"] = $max;
                $field["pattern"] = $pattern;
                $field["autocomplete"] = $autocomplete;
                $field["title"] = $title;
                $field["rows"] = $rows;
        }
        
        return $field;
    }
}




















