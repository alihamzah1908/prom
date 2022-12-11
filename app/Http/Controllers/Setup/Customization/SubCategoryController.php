<?php

namespace App\Http\Controllers\Setup\Customization;

use App\Http\Controllers\Controller;
use App\Model\SubCategory;
use App\Model\Category;
use Illuminate\Http\Request;
use \Auth;
class SubCategoryController extends Controller
{
    public function getSubCat(Request $r, $id_type)
    {
        $columns = $r->columns;
        $order = $r->order;
        if ($order[0]) {
            $order = $order[0];
            $column = $order['column'];
            $column = $columns[$column];
            $orderBy = $column['data'];
            $order_dir = $order['dir'];

            $data = SubCategory::orderBy($orderBy, $order_dir);
        } else {
            $orderBy = false;
            $data = SubCategory::orderBy('id_sub_category', 'ASC');
        }

        $data = $data->where('id_task_type', $id_type);

        $name = $r->name;
        $id = $r->id;
        if ($id) {
            $data = $data->where('id_sub_category', $id);
        }
        
        $id_category = $r->id_category;
        
       // return json_encode($id_category);
        if ($id_category) {
            $data = $data->where('id_category', $id_category);
        }

        if (!$name) {
            $name = $r->search['value'];
        }

        if ($name) {
            $data = $data->where(function ($data) use ($name) {
                $data->where('sub_category_name', 'like', '%' . $name . '%');
            });
        }

        $draw = $r->get('draw');
        $limit = $r->get('length', 10);
        $offset = $r->get('start', 0);
        $timeout = $r->get('timeout', 0);

        $count = $data->count();
        $data = $data->offset($offset)->limit($limit);
        $data = $data->get();

        foreach ($data as $d) {
            $d->category_name = $d->category?$d->category->category_name:'-';
            $d->created_by_name = $d->creator?$d->creator->name:'-';
            $d->updated_by_name = $d->updater?$d->updater->name:'-';
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
        if ($orderBy) {
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
        $c = Category::where('id_category', $r->id_category)->first();
        if(!$c){
            \Session::flash('message', "Category does not exist!");
            \Session::flash('alert-class', 'alert-danger');
            return \Redirect::back();
        }
        $cek = SubCategory::where('sub_category_name', $r->category_name)->where('id_task_type', $id_type)->first();
        if($cek){
            \Session::flash('message', "SubCategory with the same name already on list!");
            \Session::flash('alert-class', 'alert-info');
            return \Redirect::back();
        }
        
        $d = new SubCategory;
        $d->id_task_type = $id_type;
        $d->sub_category_name = $r->sub_category_name;
        $d->sub_category_desc = $r->sub_category_desc;
        $d->id_category = $r->id_category;
        $d->created_by = $user->id;
        $d->updated_by = $user->id;
        $d->save();
        
        \Session::flash('message', "Added Successfully");
        \Session::flash('alert-class', 'alert-success');
        return \Redirect::back();
    }    
    
    public function updateData($id_type, Request $r){
        $id = $r->id;
        $user = Auth::user();
        if(!$user){
            \Session::flash('message', "CSRF FAILED PLEASE RE-LOGIN!");
            \Session::flash('alert-class', 'alert-danger');
            return \Redirect::back();
        }
        $d = SubCategory::where('id_sub_category', $id)->first();
        if(!$d){
            \Session::flash('message', "Sub Category does not exist!");
            \Session::flash('alert-class', 'alert-danger');
            return \Redirect::back();
        }
        $c = Category::where('id_category', $r->id_category)->first();
        if(!$c){
            \Session::flash('message', "Category does not exist!");
            \Session::flash('alert-class', 'alert-danger');
            return \Redirect::back();
        }
        $cek = SubCategory::where('sub_category_name', $r->category_name)->where('id_sub_category', $id)->first();
        if($cek){
            \Session::flash('message', "SubCategory with the same name already on list!");
            \Session::flash('alert-class', 'alert-info');
            return \Redirect::back();
        }
        
        
        $d->sub_category_name = $r->sub_category_name;
        $d->sub_category_desc = $r->sub_category_desc;
        $d->id_category = $r->id_category;
        $d->created_by = $user->id;
        $d->updated_by = $user->id;
        $d->save();
        
        \Session::flash('message', "Updated Successfully");
        \Session::flash('alert-class', 'alert-success');
        return \Redirect::back();
    }    
    
    
}
