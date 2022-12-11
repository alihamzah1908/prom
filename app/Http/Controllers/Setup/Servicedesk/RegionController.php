<?php

namespace App\Http\Controllers\Setup\Servicedesk;

use App\Http\Controllers\Controller;
use App\Model\Region;
use App\Model\Site;
use App\Model\Site_Cat;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class RegionController extends Controller
{
    public function getRegion(Request $r)
    {
        $s = Region::orderBy('region_name', 'desc');
        // dd($s);

        if ($r->q) {
            $s = $s->where('region_name', 'LIKE', '%' . $r->q . '%');
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
            $orderBy = 'region_id';
            $order_dir = 'ASC';
        }
        $data = Region::orderBy($orderBy, $order_dir);
        if($r->id) $data = $data->where('region_id', $r->id);
        $result = getDataCustom($data, $r, 'region_id', 'region_name')->original;
        return response()->json($result);
    }
    public function index()
    {
        $regions = Region::all();
        // dd($region);
        return view('setup.servicedesk.region.index', compact('regions'));
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'nama_region' => 'required|string|max:50',
            'description' => 'required|string|max:200'
        ]);
        try {
            $region = Region::firstOrcreate([
                'region_name' => $request->nama_region,
                'region_desc' => $request->description
            ]);
            Alert::success('Region Name' . $region->region_name . '  Berhasil di Uploud !!');
            return redirect()->route('region');
        } catch (\Exception $e) {
            //jika gagal, redirect ke form yang sama lalu membuat flash message error
            Alert::error('Region Gagal di Uploud !!');
            return redirect()->route('region');
        }
    }
    public function edit($id)
    {
        $region = Region::where('region_id', $id)->first();
        if ($region == null) {
            abort(404);
        }
        return view('setup.servicedesk.region.edit', compact('region'));
    }
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nama_region' => 'required|string|max:50',
            'description' => 'required|string|max:200'
        ]);
        try {
            $region = Region::where('region_id', $id);
            $region->update([
                'region_name' => $request->nama_region,
                'region_desc' => $request->description
            ]);
            if ($region == null) {
                abort(404);
            }
            Alert::success('Region Berhasil di Update !!');
            return redirect()->route('region');
        } catch (\Exception $e) {
            Alert::error('Region Gagal di Update !!');
            return redirect()->route('region');
        }
    }
    public function delete($id)
    {
        $program = Region::where('region_id', $id);
        $program->delete();
        if ($program == null) {
            abort(404);
        }
        Alert::success('Region Berhasil di hapus !!');
        return redirect()->route('region');
    }
}
