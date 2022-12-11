<?php

namespace App\Http\Controllers\Setup\AktivasiLayanan;

use App\Http\Controllers\Controller;
use App\Model\Cord;
use Illuminate\Http\Request;
use \Auth;

class CordController extends Controller
{
    public function index(Request $request)
    {
        return view('setup.aktivasi_layanan.cord');
    }
    
    public function new_cord(Request $r)
    {
        $user = Auth::user();
        if(!$user){
            \Session::flash('message', "CSRF FAILED PLEASE RE-LOGIN!");
            \Session::flash('alert-class', 'alert-danger');
            return redirect()->back()->withInput($r->all());
        }
        
        $cek = Cord::where('name_cord', $r->name_cord)->first();
        if($cek){
            \Session::flash('message', "Cord with the same name already on list!");
            \Session::flash('alert-class', 'alert-info');
            return redirect()->back();
        }
        
        $d = new Cord;
        $d->name_cord = $r->name_cord;
        $d->description = $r->description;
        $d->save();
        
        \Session::flash('message', "Cord Created Successfully!");
        \Session::flash('alert-class', 'alert-success');
        return redirect()->back();
    }
    
    public function edit_cord(Request $r)
    {
        
        $user = Auth::user();
        if(!$user){
            \Session::flash('message', "CSRF FAILED PLEASE RE-LOGIN!");
            \Session::flash('alert-class', 'alert-danger');
            return redirect()->back()->withInput($r->all());
        }
        
        
        $d = Cord::where('id_cord', $r->id)->first();
        if(!$d){
            \Session::flash('message', "Opps something went wrong please try again!");
            \Session::flash('alert-class', 'alert-info');
            return redirect()->back();
        }
        
        $cek = Cord::where('name_cord', $r->name_cord)->where('id_cord', '!=', $r->id)->first();
        if($cek){
            \Session::flash('message', "Cord with the same name already on list!");
            \Session::flash('alert-class', 'alert-info');
            return redirect()->back();
        }
        
        $d->name_cord = $r->name_cord;
        $d->description = $r->description;
        $d->save();
        
        \Session::flash('message', "Cord Updated Successfully!");
        \Session::flash('alert-class', 'alert-success');
        return redirect()->back();
    }
    
    public function getCord(Request $r)
    {
        $columns = $r->columns;
        $order = $r->order;
        if($order[0]){
            $column = $order[0]['column']; 
            $orderBy = $columns[$column]['data'];
            $order_dir = $order['dir'];
        }else{
            $orderBy = 'id_cord';
            $order_dir = 'ASC';
        }
        $data = Cord::orderBy($orderBy, $order_dir);
        if($r->id_cord) $data = $data->where('id_cord', $r->id_cord);
        if($r->id) $data = $data->where('id_cord', $r->id);
        $result = getDataCustom($data, $r, 'id_cord', 'id_cord')->original;
        
        foreach($result['data'] as $d){
        }
        return response()->json($result);
    }
}







