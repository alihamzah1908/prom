<?php

namespace App\Http\Controllers\Setup\AktivasiLayanan;

use App\Http\Controllers\Controller;
use App\Model\CID;
use Illuminate\Http\Request;
use \Auth;

class CidController extends Controller
{
    public function index(Request $request)
    {
        return view('setup.aktivasi_layanan.cid');
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
        
        $cek = CID::where('cid_name', $r->cid_name)->first();
        if($cek){
            \Session::flash('message', "CID with the same name already on list!");
            \Session::flash('alert-class', 'alert-info');
            return redirect()->back();
        }
        
        $d = new CID;
        $d->cid_name = $r->cid_name;
        $d->cid_desc = $r->cid_desc;
        $d->save();
        
        \Session::flash('message', "CID Created Successfully!");
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
        
        
        $d = CID::where('id_cid', $r->id)->first();
        if(!$d){
            \Session::flash('message', "Opps something went wrong please try again!");
            \Session::flash('alert-class', 'alert-info');
            return redirect()->back();
        }
        
        $cek = CID::where('cid_name', $r->cid_name)->where('id_cid', '!=', $r->id)->first();
        if($cek){
            \Session::flash('message', "CID with the same name already on list!");
            \Session::flash('alert-class', 'alert-info');
            return redirect()->back();
        }
        
        $d->cid_name = $r->cid_name;
        $d->cid_desc = $r->cid_desc;
        $d->save();
        
        \Session::flash('message', "CID Updated Successfully!");
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
            $orderBy = 'id_cid';
            $order_dir = 'ASC';
        }
        $data = CID::orderBy($orderBy, $order_dir);
        if($r->id_cid) $data = $data->where('id_cid', $r->id_cid);
        if($r->id) $data = $data->where('id_cid', $r->id);
        $result = getDataCustom($data, $r, 'id_cid', 'id_cid')->original;
        
        foreach($result['data'] as $d){
        }
        return response()->json($result);
    }
}







