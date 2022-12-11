<?php

namespace App\Http\Controllers\Setup\AktivasiLayanan;

use App\Http\Controllers\Controller;
use App\Model\Layanan;
use Illuminate\Http\Request;
use \Auth;

class LayananController extends Controller
{
    public function index(Request $request)
    {
        return view('setup.aktivasi_layanan.layanan');
    }
    
    public function new_layanan(Request $r)
    {
        $user = Auth::user();
        if(!$user){
            \Session::flash('message', "CSRF FAILED PLEASE RE-LOGIN!");
            \Session::flash('alert-class', 'alert-danger');
            return redirect()->back()->withInput($r->all());
        }
        
        $cek = Layanan::where('name_layanan', $r->name_cord)->first();
        if($cek){
            \Session::flash('message', "Layanan with the same name already on list!");
            \Session::flash('alert-class', 'alert-info');
            return redirect()->back();
        }
        
        $d = new Layanan;
        $d->name_layanan = $r->name_layanan;
        $d->desc_layanan = $r->desc_layanan;
        $d->save();
        
        \Session::flash('message', "Layanan Created Successfully!");
        \Session::flash('alert-class', 'alert-success');
        return redirect()->back();
    }
    
     public function remove_layanan(Request $r, $id_layanan){
        $result = [];
        $result["status"] = false;
        $result["message"] = "";
        $result["newtoken"] = csrf_token();
       
        $d = Layanan::where('id_layanan', $id_layanan)->first();
        $result["id"] = $id_layanan;
        $result["d"] = $d;
        if(!$d){
            $result["message"] = "Layanan not found!";
            return response($result);
        }
        $d->delete();
        
        $result["status"] = true;
        $result["message"] = "Deleted successfully!";
        return response()->json($result);
    }
    
    
    public function edit_layanan(Request $r)
    {
        
        $user = Auth::user();
        if(!$user){
            \Session::flash('message', "CSRF FAILED PLEASE RE-LOGIN!");
            \Session::flash('alert-class', 'alert-danger');
            return redirect()->back()->withInput($r->all());
        }
        
        
        $d = Layanan::where('id_layanan', $r->id)->first();
        if(!$d){
            \Session::flash('message', "Opps something went wrong please try again!");
            \Session::flash('alert-class', 'alert-info');
            return redirect()->back();
        }
        
        $cek = Layanan::where('name_layanan', $r->name_layanan)->where('id_layanan', '!=', $r->id)->first();
        if($cek){
            \Session::flash('message', "Layanan with the same name already on list!");
            \Session::flash('alert-class', 'alert-info');
            return redirect()->back();
        }
        
        $d->name_layanan = $r->name_layanan;
        $d->desc_layanan = $r->desc_layanan;
        $d->save();
        
        \Session::flash('message', "Layanan Updated Successfully!");
        \Session::flash('alert-class', 'alert-success');
        return redirect()->back();
    }
    
    public function getLayanan(Request $r)
    {
        //return response()->json('');
        $columns = $r->columns;
        $order = $r->order;
        if($order[0]){
            $column = $order[0]['column']; 
            $orderBy = $columns[$column]['data'];
            $order_dir = $order['dir'];
        }else{
            $orderBy = 'id_layanan';
            $order_dir = 'ASC';
        }
        $data = Layanan::orderBy($orderBy, $order_dir);
        if($r->id_layanan) $data = $data->where('id_layanan', $r->id_layanan);
        if($r->id) $data = $data->where('id_layanan', $r->id);
        $result = getDataCustom($data, $r, 'id_layanan', 'id_layanan')->original;
        
        foreach($result['data'] as $d){
        }
        return response()->json($result);
    }
}







