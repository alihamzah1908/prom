<?php

namespace App\Http\Controllers\Setup\AktivasiLayanan;

use App\Http\Controllers\Controller;
use App\Model\AktivasiStatusCollocation;
use Illuminate\Http\Request;
use \Auth;

class StatusCollocationController extends Controller
{
    public function index(Request $request)
    {
        return view('setup.aktivasi_layanan.status_collocation');
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
        
        $cek = AktivasiStatusCollocation::where('name', $r->name)->first();
        if($cek){
            \Session::flash('message', "AktivasiStatusCollocation with the same name already on list!");
            \Session::flash('alert-class', 'alert-info');
            return redirect()->back();
        }
        
        $d = new AktivasiStatusCollocation;
        $d->name = $r->name;
        $d->description = $r->description;
        $d->save();
        
        \Session::flash('message', "AktivasiStatusCollocation Created Successfully!");
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
        
        
        $d = AktivasiStatusCollocation::where('id_AktivasiStatusCollocation', $r->id)->first();
        if(!$d){
            \Session::flash('message', "Opps something went wrong please try again!");
            \Session::flash('alert-class', 'alert-info');
            return redirect()->back();
        }
        
        $cek = AktivasiStatusCollocation::where('name', $r->name)->where('id_AktivasiStatusCollocation', '!=', $r->id)->first();
        if($cek){
            \Session::flash('message', "AktivasiStatusCollocation with the same name already on list!");
            \Session::flash('alert-class', 'alert-info');
            return redirect()->back();
        }
        
        $d->name = $r->name;
        $d->description = $r->description;
        $d->save();
        
        \Session::flash('message', "AktivasiStatusCollocation Updated Successfully!");
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
            $orderBy = 'id_AktivasiStatusCollocation';
            $order_dir = 'ASC';
        }
        $data = AktivasiStatusCollocation::orderBy($orderBy, $order_dir);
        if($r->id_AktivasiStatusCollocation) $data = $data->where('id_AktivasiStatusCollocation', $r->id_AktivasiStatusCollocation);
        if($r->id) $data = $data->where('id_AktivasiStatusCollocation', $r->id);
        $result = getDataCustom($data, $r, 'id_AktivasiStatusCollocation', 'id_AktivasiStatusCollocation')->original;
        
        foreach($result['data'] as $d){
        }
        return response()->json($result);
    }
}







