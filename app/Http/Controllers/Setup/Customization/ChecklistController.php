<?php

namespace App\Http\Controllers\Setup\Customization;

use App\Http\Controllers\Controller;
use App\Model\Task;
use App\Model\Checklist;
use App\Model\ChecklistAnswer;
use \App\Model\ChecklistCategory;
use \App\Model\Region;
use \App\Model\ChecklistPeriode;
use Illuminate\Http\Request;
use \Auth;

class ChecklistController extends Controller
{
    public function index(Request $r, $id_type)
    {
        $regions = Region::get();
        $checklist_periodes = ChecklistPeriode::get();
        $checklist_categories = ChecklistCategory::get();

        $type = \App\Model\TaskType::where('id_type', $id_type)->first();
         $list = Checklist::all();
        if(!$type){
            \Session::flash('message', 'Oppss! Something went wrong please reload and try again!');
            \Session::flash('alert-class', 'alert-danger');
            return \Redirect::to('/setup/Customization');
        }
        return view('setup.customization.checklist', compact('id_type', 'regions','checklist_periodes','checklist_categories'));
    }

    public function deleteImageAnswer(Request $r){
         $data = ChecklistAnswer::where('id_task', $r->id_task)->get();
    
    
   // return  response()->json($r->id_task);
        foreach($data as $d){
         $datas = json_decode($d->datas);
        
            foreach($datas as $ds){
             if($r->id_checklist == $ds->id_checklist){
                $key_image = $r->position;
                $images = $ds->image;
                $image = isset($images[$key_image])?$images[$key_image]:[];
                if($image) unset($images[$key_image]);
                $ds->image = $images;
                }
         }
        $d->datas = $datas;
         $d->save();
         
         if($data){
              $result["status"] = true;
         $result["message"] = "Deleted successfully!";
            return response()->json($result);
         }
         
         
    }
   
    
    }
    
    public function getData(Request $r, $id_type)
    {
        $columns = $r->columns;
        $order = $r->order;
        if($order[0]){
            $column = $order[0]['column']; 
            $orderBy = $columns[$column]['data'];
            $order_dir = $order['dir'];
        }else{
            $orderBy = 'id_checklist';
            $order_dir = 'ASC';
        }
        $data = Checklist::orderBy($orderBy, $order_dir);
        if($r->id_checklist) $data->where('id_checklist', $r->id_checklist);
        if($r->id_region) $data->where('id_region', $r->id_region);
        if($r->checklist_periode) $data->where('checklist_periode', $r->checklist_periode);
        
        $id_checklist_category = $r->id_checklist_category;
        if($id_checklist_category){
            if(!is_array($id_checklist_category)) $id_checklist_category = json_decode($id_checklist_category);
            if(!is_array($id_checklist_category)) $id_checklist_category = [$id_checklist_category];
            if(is_array($id_checklist_category)) $data->whereIn('id_checklist_category', $id_checklist_category);
        }
        
        // return $data->get();
        
        $draw = $r->get('draw');
        $limit = $r->get('length', 10);
        $offset = $r->get('start', 0);
        $timeout = $r->get('timeout', 0);

        $count = $data->count();
        // $data = $data->offset($offset)->limit($limit);
        $data = $data->get();
        
        foreach($data as $d){
            $d->category_name = isset($d->category)?$d->category->category_name:'';
            $d->periode_name = isset($d->periode)?$d->periode->periode_name:'';
            $d->region_name = isset($d->region)?$d->region->region_name:'';
        }
        $count_searched = count($data);
        $result = [];
        $result["data"] = $data;
        $result["draw"] = $draw;
        $result["recordsTotal"] = $count_searched;
        $result["recordsFiltered"] = $count;
        $result["limit"] = $limit;
        $result["offset"] = $offset;
        if ($orderBy) {
            $result['orderBy'] = $orderBy;
            $result['order_dir'] = $order_dir;
        }
        return response()->json($result);
    }
    
     public function remove_checklist(Request $r, $type, $id_checklist){
        $result = [];
        $result["status"] = false;
        $result["message"] = "";
        $result["newtoken"] = csrf_token();
       
        $d = Checklist::where('id_checklist', $id_checklist)->first();
        $result["id"] = $id_checklist;
        $result["d"] = $d;
        if(!$d){
            $result["message"] = "Checklist not found!";
            return response($result);
        }
        $d->delete();
        
        $result["status"] = true;
        $result["message"] = "Deleted successfully!";
        return response()->json($result);
    }
    public function getChecklistAnswer(Request $r, $id_type, $id_task)
    {
        $columns = $r->columns;
        $order = $r->order;
        if($order[0]){
            $column = $order[0]['column']; 
            $orderBy = $columns[$column]['data'];
            $order_dir = $order['dir'];
        }else{
            $orderBy = 'id';
            $order_dir = 'ASC';
        }
        $data = ChecklistAnswer::orderBy($orderBy, $order_dir);
        $data = $data->where('id_task', $id_task);
        
       // return response()->json($data->get());
        
       $result = getDataCustom($data, $r, 'id', 'id')->original;
        foreach($result['data'] as $d){
            $d->datas = json_decode($d->datas);
            $d->task;
        }
        return response()->json($result);
    }
    
    public function newData(Request $r, $id_type){
        $user = Auth::user();
        if(!$user){
            \Session::flash('message', "CSRF FAILED PLEASE RE-LOGIN!");
            \Session::flash('alert-class', 'alert-danger');
            return \Redirect::back();
        }
        $cek = Checklist::where('checklist_name', $r->checklist_name)
                          ->where('id_checklist_category', $r->id_checklist_category)
                          ->where('checklist_periode', $r->id_periode)
                          ->where('id_region', $r->id_region)
                          ->first();
        if($cek){
            \Session::flash('message', "CheckList with the same Name, Category, Periode & Region already on list!");
            \Session::flash('alert-class', 'alert-info');
            return \Redirect::back();
        }
        
        $d = new Checklist;
        $d->checklist_name = $r->checklist_name;
        $d->id_checklist_category = $r->id_checklist_category;
        $d->checklist_periode = $r->id_periode;
        $d->id_region = $r->id_region;
        $d->position = $r->position;//ini
        $d->save();
        
        \Session::flash('message', "Added Successfully");
        \Session::flash('alert-class', 'alert-success');
        return \Redirect::back();
    } 

    public function newData2(){
        $data = Checklist::get();
        $nomor = 1;
        foreach ($data as $d) {
            $data_checklist = Checklist::findOrFail($d->id_checklist);
            $data_checklist->position = $nomor++;
            $data_checklist->save();
        }
        return 'berhasil';
    }
    public function updateData(Request $r, $id_type){
        $user = Auth::user();
        if(!$user){
            \Session::flash('message', "CSRF FAILED PLEASE RE-LOGIN!");
            \Session::flash('alert-class', 'alert-danger');
            return \Redirect::back();
        }
        $cek = Checklist::where('checklist_name', $r->checklist_name)
                          ->where('id_checklist', '!=', $r->id_checklist)
                          ->where('id_checklist_category', $r->id_checklist_category)
                          ->where('checklist_periode', $r->id_periode)
                          ->where('id_region', $r->id_region)
                          ->first();
        if($cek){
            \Session::flash('message', "CheckList with the same Name, Category, Periode & Region already on list!");
            \Session::flash('alert-class', 'alert-info');
            return \Redirect::back();
        }
        
        $d = Checklist::where('id_checklist', $r->id_checklist)->first();
        if(!$d){
            \Session::flash('message', "CheckList does not exist!");
            \Session::flash('alert-class', 'alert-info');
            return \Redirect::back();
        }
        
        $d->checklist_name = $r->checklist_name;
        $d->id_checklist_category = $r->id_checklist_category;
        $d->checklist_periode = $r->id_periode;
        $d->id_region = $r->id_region;
        $d->position = $r->position; //ini
        $d->save();
        
        \Session::flash('message', "Updated Successfully");
        \Session::flash('alert-class', 'alert-success');
        return \Redirect::back();
    }    
    
    public function new_checklist_category(Request $r, $id_type){
        $user = Auth::user();
        if(!$user){
            \Session::flash('message', "CSRF FAILED PLEASE RE-LOGIN!");
            \Session::flash('alert-class', 'alert-danger');
            return \Redirect::back();
        }
        $cek = ChecklistCategory::where('category_name', $r->category_name)->first();
        if($cek){
            \Session::flash('message', "Category with the same Name already on list!");
            \Session::flash('alert-class', 'alert-info');
            return \Redirect::back();
        }
        
        $d = new ChecklistCategory;
        $d->category_name = $r->category_name;
        $d->save();
        
        \Session::flash('message', "Category Created Successfully");
        \Session::flash('alert-class', 'alert-success');
        return \Redirect::back();
    }
    
    public function new_checklist_periode(Request $r, $id_type){
        $user = Auth::user();
        if(!$user){
            \Session::flash('message', "CSRF FAILED PLEASE RE-LOGIN!");
            \Session::flash('alert-class', 'alert-danger');
            return \Redirect::back();
        }
        $cek = ChecklistPeriode::where('periode_name', $r->periode_name)->first();
        if($cek){
            \Session::flash('message', "Periode with the same Name already on list!");
            \Session::flash('alert-class', 'alert-info');
            return \Redirect::back();
        }
        
        $d = new ChecklistPeriode;
        $d->periode_name = $r->periode_name;
        $d->save();
        
        \Session::flash('message', "Periode Created Successfully");
        \Session::flash('alert-class', 'alert-success');
        return \Redirect::back();
    }
    
     public function update_checklist(Request $r){
        $result = [];
        $result["status"] = false;
        $result["message"] = "";
        
        
        
        $task = Task::where('id_task', $r->id_task)->first();
        if(!$task){
            $result["message"] = "Task not found!";
            return response($result);
        }
        if($task->id_task_type != 2){
            $result["message"] = "Required PM Type TASK to continue!";
            return response($result);
        }
        $task_detail  = $task->getDetail;
        if(!$task_detail){
            $result["message"] = "Task Detail not found!";
            return response($result);
        }
        $user = Auth::user();   $result["message"] = "CSRF FAILED PLEASE RE-LOGIN!";    if(!$user)  return response($result);
        $id_periode = $task_detail->checklist_periode;   $result["message"] = "Task periode not found!"; if(!$id_periode) return response($result);
        $id_checklist_category = $task_detail->id_checklist_category; $result["message"] = "Task Checklist Category not found!";  if(!$id_checklist_category) return response($result);
        $id_region = $task->id_region; $result["message"] = "Task Region not found!";  if(!$id_region) return response($result);
        
        $checklist = $r->checklist;
        if(!$checklist){
            $result["message"] = "Cheklist Required!";
            return response($result);
        }
        
        $noted = $r->note ;
        if($noted){
            $r_note = json_decode($noted);
        }
        $isMark = $r->mark ;
        if($isMark){
            $r_mark = json_decode($isMark);
        }
        $is_available = $r->is_available;
        if(!$is_available){
            $result["message"] = "Is Available Required!";
            return response($result);
        }
        $answers = $r->answers;
        if(!$answers){
            $result["message"] = "Answers Required!";
            return response($result);
        }
        
        $r_checklist = json_decode($checklist);
      //  $is_available = json_decode($is_available);
        $answers = json_decode($answers);
        $checklist = [];
        
        foreach($r_checklist as $key => $val){
            // where('checklist_periode', $id_periode)
            //                   ->where('id_checklist_category', $id_checklist_category)
            //                   ->where('id_region', $id_region)
            
            $check = Checklist::where('id_checklist', $val)
                              ->first();
            if($check){
                $c = new Checklist;
                $c->id_checklist = $check->id_checklist;
                $c->checklist_name = $check->checklist_name;
                $c->periode = isset($check->periode)?$check->periode->periode_name:'';
                $c->category = isset($check->category)?$check->category->category_name:'';
                $c->region = isset($check->region)?$check->region->region_name:'';
                $c->is_avaiable = $is_available[$key];
                $c->answer = $answers[$key];
                $c->noted = $r_note[$key];
                $c->mark_validator = $r_mark[$key];
                
                $image = 'default.png';
                $images[] = $r->image;
                 $imagex = [];
                if($images[$key]){
                    foreach($images[$key] as $key1 => $val1){
                        if($val1){
                            foreach($val1 as $key2 => $val2){
                                $file = $val2 ;
                                 if($file){
                                     
                                 $image = "CHECKLIST_IMAGE-" . md5(time()) . '.' .$file->getClientOriginalName();
                                 //$image = $file->getClientOriginalName();
                                  $file->move(public_path().'/checklist_image', $image);
                                 $imagex[] = $image ;
                    }
                            
                            }
                        }
                    }
                   // $file = getIndex($r->file('image'), $key, false);
                   $c->image = $imagex;
                }
                
              //  return response()->json($imagex);
                
                //   "id_checklist": 19,
                // "checklist_name": "Apakah kondisi cuaca dalam keadaan baik",
                // "periode": "MONTHLY",
                // "category": "Job Safety Analisis",
                // "region": "Project 4",
                // "is_avaiable": "OK",
                // "answer": "",
                // "image": "default.png"
                
                $checklist[] = $c;
                
            }
            // else{
            //     $params = ["id_task" => $r->id_task, "id_checklist" => $val, "id_periode" => $id_periode, "id_checklist_category" => $id_checklist_category, "id_region" => $id_region];
            //     $c = [ $params];
            //     $checklist[] = $c;
            // }
            
        }
        
        $answer = ChecklistAnswer::where('id_task', $task->id_task)->first();
        if(!$answer){
            $answer = new ChecklistAnswer;
        }
        $answer->id_task = $task->id_task;
        $answer->datas = json_encode($checklist);
        $answer->update();
        $data = [];
        $data['datas'] = $checklist;
        
        $result["status"] = true;
        $result["message"] = "Updated Successfully";
        $result["data"] = $data;
        return response($result);
    }
    
    public function task_checklist(Request $r, $id_type){
        $result = [];
        $result["status"] = false;
        $result["message"] = "";
        $result["newtoken"] = csrf_token();
        
        $task = Task::where('id_task', $r->id_task)->first();
        if(!$task){
            $result["message"] = "Task not found!";
            return response($result);
        }
        if($task->id_task_type != 2){
            $result["message"] = "Required PM Type TASK to continue!";
            return response($result);
        }
        $task_detail  = $task->getDetail;
        if(!$task_detail){
            $result["message"] = "Task Detail not found!";
            return response($result);
        }
        $user = Auth::user();   $result["message"] = "CSRF FAILED PLEASE RE-LOGIN!";    if(!$user)  return response($result);
        $id_periode = $task_detail->checklist_periode;   $result["message"] = "Task periode not found!"; if(!$id_periode) return response($result);
        $id_checklist_category = $task_detail->id_checklist_category; $result["message"] = "Task Checklist Category not found!";  if(!$id_checklist_category) return response($result);
        $id_region = $task->id_region; $result["message"] = "Task Region not found!";  if(!$id_region) return response($result);
        
        $checklist = $r->checklist;
        if(!$checklist){
            $result["message"] = "Cheklist Required!";
            return response($result);
        }
        $is_available = $r->is_available;
      
        if(!$is_available){
            $result["message"] = "Is Available Required!";
            return response($result);
        }
        $answers = $r->answers;
        if(!$answers){
            $result["message"] = "Answers Required!";
            return response($result);
        }
        
         $noted = $r->note ;
        if($noted){
            $r_note = json_decode($noted);
        }
        $isMark = $r->mark ;
        if($isMark){
            $r_mark = json_decode($isMark);
        }
        
        $r_checklist = json_decode($checklist);
        
       
        $is_available = stripslashes($is_available);
       $is_available = json_decode($is_available);
      // return $is_available;
      
        $answers = json_decode($answers);
        $checklist = [];
        $answer = ChecklistAnswer::where('id_task', $task->id_task)->first();
       
       if($answer){
        $checklist_answers = json_decode($answer->datas);
       }
        
        foreach($r_checklist as $key => $val){
            // where('checklist_periode', $id_periode)
            //                   ->where('id_checklist_category', $id_checklist_category)
            //                   ->where('id_region', $id_region)
            
            $check = Checklist::where('id_checklist', $val)
                              ->first();
                              
                              
            if($check){
                $c = new Checklist;
                $c->id_checklist = $check->id_checklist;
                $c->checklist_name = $check->checklist_name;
                $c->periode = isset($check->periode)?$check->periode->periode_name:'';
                $c->category = isset($check->category)?$check->category->category_name:'';
                $c->region = isset($check->region)?$check->region->region_name:'';
                $c->is_avaiable = $is_available[$key];
                $c->answer = $answers[$key];
                  
                //  return $is_available[$key];
               if($r->note){
                 $c->note = $r_note[$key];
               }
               if($r->mark){
                 $c->mark = $r_mark[$key];
               }
                // return response()->json($is_available[$key]);
                $image = 'default.png';
                 $images[] = $r->image;
                $imagex = [];
                if($answer){
                $ca = $checklist_answers[$key];
                $imagex = $ca->image;
               //if($ca->id_checklist == $check->id_checklist) $image = $ca->image;
                
                }
              

                
         if($r->image){
                $filex= getIndex($images[$key],$key,false);
                if($filex){
                    foreach($filex as $key1 => $val1){
                        $file = $val1 ;
                        if($file){
                            $image = "CHECKLIST_IMAGE-" . md5(time()) . '.' .$file->getClientOriginalName();
                            $file->move(public_path().'/checklist_image', $image);
                            $imagex[] = $image;
                        }
                    }
                }else{
                    $imagex = isset($ca->image)?$ca->image:[];
                    if($imagex){
                        $c->image = $imagex ;
                    }else{
                        $c->image = [];
                    }
                }
                $c->image = $imagex;
            }
            else{
                $imagex = isset($ca->image)?$ca->image:[];
                if($imagex){
                    $c->image = $imagex ;
                 }else{
                     $c->image = [];
                }
                
                $c->image = $imagex;
            }
                
                 $checklist[] = $c;
                
                
              
                
    
               
            }else{
                $params = ["id_task" => $r->id_task, "id_checklist" => $val, "id_periode" => $id_periode, "id_checklist_category" => $id_checklist_category, "id_region" => $id_region];
                $c = ["_err" => 404, "_err_msg" => "Checklist Not found", "_params" => $params];
                $checklist[] = $c;
            }
            
        }
        
        
        if(!$answer){
            $answer = new ChecklistAnswer;
        }
        $answer->id_task = $task->id_task;
        $answer->datas = json_encode($checklist);
        $answer->save();
        $data = [];
        $data['checklist'] = $checklist;
        
        $result["status"] = true;
        $result["message"] = "Updated Successfully";
        $result["data"] = $data;
        return response($result);
    }
    
}
