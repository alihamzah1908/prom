<?php

namespace App\Http\Controllers\Setup\AktivasiLayanan;

use App\Http\Controllers\Controller;
use App\Model\Slot;
use Illuminate\Http\Request;
use \Auth;

class SlotController extends Controller
{
    public function index(Request $request)
    {
        return view('setup.aktivasi_layanan.slot');
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
        
        $cek = Slot::where('name_slot', $r->name_slot)->first();
        if($cek){
            \Session::flash('message', "Slot with the same name already on list!");
            \Session::flash('alert-class', 'alert-info');
            return redirect()->back();
        }
        
        $d = new Slot;
        $d->name_slot = $r->name_slot;
        $d->desc_slot = $r->desc_slot;
        $d->save();
        
        \Session::flash('message', "Slot Created Successfully!");
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
        
        
        $d = Slot::where('id_slot', $r->id)->first();
        if(!$d){
            \Session::flash('message', "Opps something went wrong please try again!");
            \Session::flash('alert-class', 'alert-info');
            return redirect()->back();
        }
        
        $cek = Slot::where('name_slot', $r->name_slot)->where('id_slot', '!=', $r->id)->first();
        if($cek){
            \Session::flash('message', "Slot with the same name already on list!");
            \Session::flash('alert-class', 'alert-info');
            return redirect()->back();
        }
        
        $d->name_slot = $r->name_slot;
        $d->desc_slot = $r->desc_slot;
        $d->save();
        
        \Session::flash('message', "Slot Updated Successfully!");
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
            $orderBy = 'id_slot';
            $order_dir = 'ASC';
        }
        $data = Slot::orderBy($orderBy, $order_dir);
        if($r->id_slot) $data = $data->where('id_slot', $r->id_slot);
        if($r->id) $data = $data->where('id_slot', $r->id);
        $result = getDataCustom($data, $r, 'id_slot', 'id_slot')->original;
        
        foreach($result['data'] as $d){
        }
        return response()->json($result);
    }
}







