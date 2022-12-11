<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Redirect;
use Validator;
use Auth;
use Session;
use Illuminate\Support\Facades\Hash;
use \App\UserLocation;
use \App\Model\Technician;

class UserLocationController extends Controller
{
    public function index(Request $r){
        return view('user_location.index');
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
        $data = UserLocation::orderBy($orderBy, $order_dir);
        if($r->id_technician) $data->where('id_technician', $r->id_technician);
        if($r->id_site) $data->where('id_site', $r->id_site);
        
        $result = getDataCustom($data, $r, 'id', 'latitude')->original;
        foreach($result['data'] as $d){
            $d->technician;
            $d->site;
        }
        return response()->json($result);
    }
    public function getMapboxLocation(Request $r)
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
        $data = UserLocation::orderBy($orderBy, $order_dir);
        if($r->id_technician) $data->where('id_technician', $r->id_technician);
        if($r->id_site) $data->where('id_site', $r->id_site);
        
        $features = [];
        $result = getDataCustom($data, $r, 'id', 'latitude')->original;
        foreach($result['data'] as $d){
            $technician = $d->technician;
            $site = $d->site;
            $features['type'] = "Feature";
            $features['properties'] = [
                                    "description" => "<table><thead><tr><td>Technician</td><td>: $technician->name_technician</td></tr><tr><td>SITE</td><td>: $site->name_site</td></tr></thead></table>"
                                    ];
            $features['geometry'] = [
                                    "type" => "Point",
                                    "coordinates" => [$d->longitude, $d->latitude],
                                    ];
        }
        $data = [];
        $data['type'] = "FeatureCollection";
        $data['features'] = [$features];
        
        $result = [];
        $result['type'] = "geojson";
        $result['data'] = $data;
        return $result;
    }
    public function submitData(Request $r){
        $result = [];
        $result["status"] = false;
        $result["message"] = "";
        $result["newtoken"] = csrf_token();
        
        $c = Technician::where('id_technician', $r->id_technician)->first();
        if(!$c){
            $result["message"] = "Technician not found!";
            return response($result);
        }
        
        $d = UserLocation::where('id_technician', $r->id_technician)->first();
        if(!$d){
            $d = new UserLocation;
        }
        $d->id_technician = $r->id_technician;
        $d->latitude = $r->latitude;
        $d->longitude = $r->longitude;
        $d->id_site = $r->id_site;
        $d->save();
        
        $d->technician;
        $d->site;
        
        $result["status"] = true;
        $result["message"] = "Location Updated Successfully";
        $result["data"] = $d;
        return response($result);
    }    
}




















