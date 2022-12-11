<?php

namespace App\Http\Controllers\Setup\AktivasiLayanan;

use App\Http\Controllers\Controller;
use App\Model\Shelf;
use Illuminate\Http\Request;
use \Auth;

class ShelfController extends Controller
{
    public function index(Request $request)
    {
        return view('setup.aktivasi_layanan.shelf');
    }
    
    public function new_data(Request $r)
    {
        // return $r->all();
        $user = Auth::user();
        if(!$user){
            \Session::flash('message', "CSRF FAILED PLEASE RE-LOGIN!");
            \Session::flash('alert-class', 'alert-danger');
            return redirect()->back()->withInput($r->all());
        }
        
        $cek = Shelf::where('name_shelf', $r->name_shelf)->first();
        if($cek){
            \Session::flash('message', "Shelf with the same name already on list!");
            \Session::flash('alert-class', 'alert-info');
            return redirect()->back();
        }
        
        $d = new Shelf;
        $d->name_shelf = $r->name_shelf;
        $d->desc_shelf = $r->desc_shelf;
        $d->save();
        
        \Session::flash('message', "Shelf Created Successfully!");
        \Session::flash('alert-class', 'alert-success');
        return redirect()->back();
    }
    
    public function edit_data(Request $r)
    {
        
        $user = Auth::user();
        if(!$user){
            \Session::flash('message', "CSRF FAILED PLEASE RE-LOGIN!");
            \Session::flash('alert-class', 'alert-danger');
            return redirect()->back()->withInput($r->all());
        }
        
        
        $d = Shelf::where('id_Shelf', $r->id)->first();
        if(!$d){
            \Session::flash('message', "Opps something went wrong please try again!");
            \Session::flash('alert-class', 'alert-info');
            return redirect()->back();
        }
        
        $cek = Shelf::where('name_shelf', $r->name_shelf)->where('id_Shelf', '!=', $r->id)->first();
        if($cek){
            \Session::flash('message', "Shelf with the same name already on list!");
            \Session::flash('alert-class', 'alert-info');
            return redirect()->back();
        }
        
        $d->name_shelf = $r->name_shelf;
        $d->desc_shelf = $r->desc_shelf;
        $d->save();
        
        \Session::flash('message', "Shelf Updated Successfully!");
        \Session::flash('alert-class', 'alert-success');
        return redirect()->back();
    }
    
    public function getData(Request $r)
    {
        $columns = $r->columns;
        $order = $r->order;
        if($order[0]){
            $column = $order[0]['column']; 
            $orderBy = $columns[$column]['data'];
            $order_dir = $order['dir'];
        }else{
            $orderBy = 'id_Shelf';
            $order_dir = 'ASC';
        }
        $data = Shelf::orderBy($orderBy, $order_dir);
        if($r->id_Shelf) $data = $data->where('id_Shelf', $r->id_Shelf);
        if($r->id) $data = $data->where('id_Shelf', $r->id);
        $result = getDataCustom($data, $r, 'id_Shelf', 'id_Shelf')->original;
        
        foreach($result['data'] as $d){
        }
        return response()->json($result);
    }
}







