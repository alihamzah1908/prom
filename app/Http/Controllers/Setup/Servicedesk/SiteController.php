<?php

namespace App\Http\Controllers\Setup\Servicedesk;

use App\Http\Controllers\Controller;
use App\Model\Region;
use App\Model\Site;
use App\Model\Site_Cat;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class SiteController extends Controller
{
    public function getSiteCat(Request $r)
    {
        $s = Site_Cat::orderBy('site_cat_id', 'desc');
        // dd($s);

        if ($r->q) {
            $s = $s->where('site_cat_name', 'LIKE', '%' . $r->q . '%');
        }
        $s = $s->get();

        return response()->json($s);
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
            $orderBy = 'site_id';
            $order_dir = 'ASC';
        }
        $data = Site::orderBy($orderBy, $order_dir);
        if($r->site_id) $data = $data->where('site_id', $r->site_id);
        if($r->id_region) $data = $data->where('region_id', $r->id_region);
        $result = getDataCustom($data, $r, 'site_id', 'name_site')->original;
        
        foreach($result['data'] as $d){
            $d->region;
            $d->manager;
        }
        return response()->json($result);
    }
    public function index(Request $request)
    {
        $regions = Region::all();
        $site_cats = Site_Cat::all();
        $sites = Site::orderBy('site_id', 'DESC')->get();
        // dd($sites);
        return view('setup.servicedesk.site.index', compact('sites', 'regions', 'site_cats'));
    }
    public function new(Request $request)
    {
        $regions = Region::all();
        $site_cats = Site_Cat::all();
        $sites = Site::orderBy('site_id', 'DESC')->get();
        return view('setup.servicedesk.site.new', compact('sites', 'regions', 'site_cats'));
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'name_site' => 'required|string|max:50',
            'uid_site' => 'required|string',
            'region_name' => 'required|string',
            'id_site_category' => 'required|string',
            'address' => 'required|string',
            'latitude' => 'required|string',
            'longitude' => 'required|string',
            'head_manager' => 'required|string',
            'description' => 'required|string|max:200',
            'kapasitas_kwh' => 'required|numeric',
            'kapasitas_genset' => 'required|numeric'
        ]);
        $region = Site::firstOrcreate([
            'name_site' => $request->name_site,
            'uid_site' => $request->uid_site,
            'region_id' => $request->region_name,
            'id_site_category' => $request->id_site_category,
            'site_desc' => $request->description,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'address' => $request->address,
            'head_manager' => $request->head_manager,
            'kapasitas_kwh'=>$request->kapasitas_kwh,
            'kapasitas_genset'=>$request->kapasitas_genset,
        ]);
        Alert::success('Site Name' . $region->name_site . '  Berhasil di Uploud !!');
        return redirect()->route('sites');
    }
    public function edit($id)
    {
        $regions = Region::all();
        $site_cats = Site_Cat::all();
        $sites = Site::where('site_id', $id)->first();
        if ($sites == null) {
            abort(404);
        }
        return view('setup.servicedesk.site.edit', compact('sites', 'regions', 'site_cats'));
    }
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name_site' => 'required|string|max:50',
            'uid_site' => 'required|string',
            'region_name' => 'required|string',
            'id_site_category' => 'required|string',
            'address' => 'required|string',
            'latitude' => 'required|string',
            'longitude' => 'required|string',
            'head_manager' => 'required|string',
            'description' => 'required|string|max:200',
            'kapasitas_kwh' => 'required|numeric',
            'kapasitas_genset' => 'required|numeric'
        ]);
        try {
            $sites = Site::where('site_id', $id);
            $sites->update([
                'name_site' => $request->name_site,
                'uid_site' => $request->uid_site,
                'region_id' => $request->region_name,
                'id_site_category' => $request->id_site_category,
                'site_desc' => $request->description,
                'address' => $request->address,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'head_manager' => $request->head_manager,
                'kapasitas_kwh'=>$request->kapasitas_kwh,
            'kapasitas_genset'=>$request->kapasitas_genset,
            ]);
            if ($sites == null) {
                abort(404);
            }
            Alert::success('Site Berhasil di Update !!');
            return redirect()->route('sites');
        } catch (\Exception $e) {
            Alert::error('Site Gagal di Update !!');
            return redirect()->route('sites');
        }
    }
    public function delete($id)
    {
        $sites = Site::where('site_id', $id);
        $sites->delete();
        if ($sites == null) {
            abort(404);
        }
        Alert::success('Site Berhasil di hapus !!');
        return redirect()->route('sites');
    }
}
