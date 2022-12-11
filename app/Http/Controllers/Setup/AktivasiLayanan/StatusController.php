<?php

namespace App\Http\Controllers\Setup\AktivasiLayanan;

use App\Http\Controllers\Controller;
use App\Model\AktivasiStatus;
use Illuminate\Http\Request;
use \Auth;

class StatusController extends Controller
{
    public function index(Request $request)
    {
        return view('setup.aktivasi_layanan.status');
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
        
        $cek = AktivasiStatus::where('name', $r->name)->first();
        if($cek){
            \Session::flash('message', "AktivasiStatus with the same name already on list!");
            \Session::flash('alert-class', 'alert-info');
            return redirect()->back();
        }
        
        $d = new AktivasiStatus;
        $d->name = $r->name;
        $d->description = $r->description;
        // $d->save();
        
        // \Session::flash('message', "AktivasiStatus Created Successfully!");
        // \Session::flash('alert-class', 'alert-success');
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
        
        
        $d = AktivasiStatus::where('id', $r->id)->first();
        if(!$d){
            \Session::flash('message', "Opps something went wrong please try again!");
            \Session::flash('alert-class', 'alert-info');
            return redirect()->back();
        }
        
        $cek = AktivasiStatus::where('name', $r->name)->where('id', '!=', $r->id)->first();
        if($cek){
            \Session::flash('message', "AktivasiStatus with the same name already on list!");
            \Session::flash('alert-class', 'alert-info');
            return redirect()->back();
        }
        
        $d->name = $r->name;
        $d->description = $r->description;
        $d->save();
        
        \Session::flash('message', "AktivasiStatus Updated Successfully!");
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
            $orderBy = 'id';
            $order_dir = 'ASC';
        }
        $data = AktivasiStatus::orderBy($orderBy, $order_dir);
        if($r->id) $data = $data->where('id', $r->id);
        if($r->id) $data = $data->where('id', $r->id);
        $result = getDataCustom($data, $r, 'id', 'id')->original;
        
        foreach($result['data'] as $d){
        }
        return response()->json($result);
    }
}







