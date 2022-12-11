<?php

namespace App\Http\Controllers\Setup\Customization;

use App\Http\Controllers\Controller;
use App\Model\Category;
use Illuminate\Http\Request;
use \Auth;
class CategoryController extends Controller
{
    public function index(Request $r, $id_type)
    {
        $type = \App\Model\TaskType::where('id_type', $id_type)->first();
        if(!$type){
            \Session::flash('message', 'Oppss! Something went wrong please reload and try again!');
            \Session::flash('alert-class', 'alert-danger');
            return \Redirect::to('/setup/Customization');
        }
        $category = Category::where('id_task_type', $id_type)->get();
        return view('setup.customization.category', compact('id_type', 'category'));
    }
    
    public function getData(Request $r, $id_type)
    {
        $columns = $r->columns;
        $order = $r->order;
        if($order[0]){
            $order = $order[0];
            $column = $order['column']; 
            $column = $columns[$column];
            $orderBy = $column['data'];
            $order_dir = $order['dir'];
    
            $data = Category::orderBy($orderBy, $order_dir);
        }else{
            $orderBy = false;
            $data = Category::orderBy('id_category','ASC');
        }
        
      
        $data = $data->where('id_task_type', $id_type);
        
        $name = $r->name;
        $id = $r->id;
        if($id){
            $data = $data->where('id_category', $id);
        }
        
        if(!$name){
            $name = $r->search['value'];
        }
        
        if($name){
            $data = $data->where(function ($data) use($name) {
                            $data->where('category_name', 'like', '%' . $name . '%');
                          });
            
        }
        
        $draw = $r->get('draw');
        $limit = $r->get('length', 10);
        $offset = $r->get('start', 0);
        $timeout = $r->get('timeout', 0);
        
        $count = $data->count();
        $data = $data->offset($offset)->limit($limit);
        $data = $data->get();
        
        foreach($data as $d){
            $d->created_by_name = $d->creator->name;
            $d->updated_by_name = $d->updater->name;
            foreach($d->sub_categories as $sub){
                $sub->items;
            };
        }
        
        $count_searched = count($data);
        $result = [];
        $result["r"] = $r->all();
        $result["data"] = $data;
        $result["draw"] = $draw;
        $result["recordsTotal"] = $count_searched;
        $result["recordsFiltered"] = $count;
        $result["limit"] = $limit;
        $result["offset"] = $offset;
        if($orderBy){
            $result['orderBy'] = $orderBy;
            $result['order_dir'] = $order_dir;   
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
        $cek = Category::where('category_name', $r->category_name)->where('id_task_type', $id_type)->first();
        if($cek){
            \Session::flash('message', "Category with the same name already on list!");
            \Session::flash('alert-class', 'alert-info');
            return \Redirect::back();
        }
        
        $d = new Category;
        $d->id_task_type = $id_type;
        $d->category_name = $r->category_name;
        $d->category_desc = $r->category_desc;
        $d->created_by = $user->id;
        $d->updated_by = $user->id;
        $d->save();
        
        \Session::flash('message', "Added Successfully");
        \Session::flash('alert-class', 'alert-success');
        return \Redirect::back();
    }    
    
    public function updateData(Request $r, $id_type){
        $id = $r->id;
        $user = Auth::user();
        if(!$user){
            $message = "CSRF FAILED PLEASE RE-LOGIN!";
            \Session::flash('message', $message);
            \Session::flash('alert-class', 'alert-danger');
            return \Redirect::back();
        }
        $d = Category::where('id_category', $id)->where('id_task_type', $id_type)->first();
        if(!$d){
            $message = "Category does not exist!";
            \Session::flash('message', $message);
            \Session::flash('alert-class', 'alert-danger');
            return \Redirect::back();
        }
        $cek = Category::where('category_name', $r->category_name)->where('id_category', $id)->where('id_task_type', $id_type)->first();
        if($cek){
            $message = "Category with the same name already on list!";
            \Session::flash('message', $message);
            \Session::flash('alert-class', 'alert-info');
            return \Redirect::back();
        }
        
        $d->id_task_type = $id_type;
        $d->category_name = $r->category_name;
        $d->category_desc = $r->category_desc;
        $d->created_by = $user->id;
        $d->updated_by = $user->id;
        $d->save();
        
        \Session::flash('message', "Updated Successfully");
        \Session::flash('alert-class', 'alert-success');
        return \Redirect::back();
    }   
    public function remove_category(Request $r, $type, $id_category){
        $result = [];
        $result["status"] = false;
        $result["message"] = "";
        $result["newtoken"] = csrf_token();
       
        $d = Category::where('id_category', $id_category)->first();
        $result["id"] = $id_category;
        $result["d"] = $d;
        if(!$d){
            $result["message"] = "Category not found!";
            return response($result);
        }
        $d->delete();
        
        $result["status"] = true;
        $result["message"] = "Deleted successfully!";
        return response()->json($result);
    }
}
