<?php

namespace App\Http\Controllers\Setup\Customization;

use App\Http\Controllers\Controller;
use App\Model\Category;
use App\Model\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class ItemController extends Controller
{
    public function getData(Request $r, $id_type)
    {
        $columns = $r->columns;
        $order = $r->order;
        if ($order[0]) {
            $order = $order[0];
            $column = $order['column'];
            $column = $columns[$column];
            $orderBy = $column['data'];
            $order_dir = $order['dir'];

            $data = Item::orderBy($orderBy, $order_dir);
        } else {
            $orderBy = false;
            $data = Item::orderBy('id_item', 'ASC');
        }

        $data = $data->where('id_task_type', $id_type);

        $name = $r->name;
        $id = $r->id;
        if ($id) {
            $data = $data->where('id_item', $id);
        }
        
        $id_sub_category = $r->id_sub_category;
        if ($id_sub_category) {
            $data = $data->where('id_sub_category', $id_sub_category);
        }
        
        $id_category = $r->id_category;
        if ($id_category) {
            $data = $data->where('id_category', $id_category);
        }

        if (!$name) {
            $name = $r->search['value'];
        }

        if ($name) {
            $data = $data->where(function ($data) use ($name) {
                $data->where('item_name', 'like', '%' . $name . '%');
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
            $d->sub_category_name = $d->sub_category?$d->sub_category->sub_category_name:'-';
            // $d->created_by_name = $d->creator->name;
            // $d->updated_by_name = $d->updater->name;
            // $d->sub_categories;
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
    
    public function newData(Request $r, $id_type)
    {

        $user = Auth::user();
        if (!$user) {
            Session::flash('message', "CSRF FAILED PLEASE RE-LOGIN!");
            Session::flash('alert-class', 'alert-danger');
            return Redirect::back();
        }
        $cek = Item::where('item_name', $r->item_name)->where('id_category', $r->id_category)->where('id_sub_category', $r->id_sub_category)->where('id_task_type', $id_type)->first();
        if ($cek) {
            Session::flash('message', "Item with the same name already on list!");
            Session::flash('alert-class', 'alert-info');
            return Redirect::back();
        }

        $d = new Item;
        $d->id_task_type = $id_type;
        $d->id_category = $r->id_category;
        $d->id_sub_category = $r->id_sub_category;
        $d->item_name = $r->item_name;
        // $d->item_status = $r->status;
        $d->item_desc = $r->description;
        $d->save();

        Session::flash('message', "Added Successfully");
        Session::flash('alert-class', 'alert-success');
        return Redirect::back();
    }

    public function updateData(Request $r, $id_type)
    {
        $id = $r->id;
        $user = Auth::user();
        if (!$user) {
            $message = "CSRF FAILED PLEASE RE-LOGIN!";
            Session::flash('message', $message);
            Session::flash('alert-class', 'alert-danger');
            return Redirect::back();
        }
        $d = Item::where('id_item', $id)->where('id_task_type', $id_type)->first();
        if (!$d) {
            $message = "Item does not exist!";
            Session::flash('message', $message);
            Session::flash('alert-class', 'alert-danger');
            return Redirect::back();
        }
        $cek = Item::where('item_name', $r->item_name)->where('id_category', $r->id_category)->where('id_sub_category', $r->id_sub_category)->where('id_task_type', $id_type)->first();
        if ($cek) {
            $message = "Item with the same name already on list!";
            Session::flash('message', $message);
            Session::flash('alert-class', 'alert-info');
            return Redirect::back();
        }

        $d->id_category = $r->id_category;
        $d->id_sub_category = $r->id_sub_category;
        $d->item_name = $r->item_name;
        $d->item_desc = $r->description;
        $d->save();

        Session::flash('message', "Updated Successfully");
        Session::flash('alert-class', 'alert-success');
        return Redirect::back();
    }
}
