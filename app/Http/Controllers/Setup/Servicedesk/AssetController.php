<?php

namespace App\Http\Controllers\Setup\Servicedesk;

use App\Http\Controllers\Controller;
use App\Model\Asset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;

class AssetController extends Controller
{
    public function index()
    {
        $assets = Asset::all();
        // dd($assets);
        return view('setup.servicedesk.asset.index', compact('assets'));
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
            $orderBy = 'id_asset';
            $order_dir = 'ASC';
        }
        $data = Asset::orderBy($orderBy, $order_dir);
        
        $result = getDataCustom($data, $r, 'id_asset', 'nama_asset')->original;
        return response()->json($result);
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'nama_asset' => 'required|string|max:50',
            'departement' => 'required|string|max:200',
            'description' => 'required|string|max:200'
        ]);
        $user = Auth::user();
        if (!$user) {
            $message = "CSRF FAILED PLEASE RE-LOGIN!";
            Session::flash('message', $message);
            Session::flash('alert-class', 'alert-danger');
            return Redirect::back();
        }
        try {
            $asset = Asset::firstOrcreate([
                'name' => $request->nama_asset,
                'departement' => $request->departement,
                'description' => $request->description,
                'created_by' => $user->id,
                'updated_by' => $user->id,
            ]);
            // dd($asset);
            Alert::success('Asset Name ' . $asset->name . '  Berhasil di Uploud !!');
            return redirect()->route('asset');
        } catch (\Exception $e) {
            //jika gagal, redirect ke form yang sama lalu membuat flash message error
            Alert::error('Asset Gagal di Uploud !!');
            return redirect()->route('asset');
        }
    }
    public function edit($id)
    {
        $asset = Asset::where('id_asset', $id)->first();
        if ($asset == null) {
            abort(404);
        }
        return view('setup.servicedesk.asset.edit', compact('asset'));
    }
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nama_asset' => 'required|string|max:50',
            'departement' => 'required|string|max:200',
            'description' => 'required|string|max:200'
        ]);
        $user = Auth::user();
        if (!$user) {
            $message = "CSRF FAILED PLEASE RE-LOGIN!";
            Session::flash('message', $message);
            Session::flash('alert-class', 'alert-danger');
            return Redirect::back();
        }
        try {
            $asset = Asset::where('id_asset', $id);
            $asset->update([
                'name' => $request->nama_asset,
                'departement' => $request->departement,
                'description' => $request->description,
                'created_by' => $user->id,
                'updated_by' => $user->id,
            ]);
            if ($asset == null) {
                abort(404);
            }
            Alert::success('Asset Berhasil di Update !!');
            return redirect()->route('asset');
        } catch (\Exception $e) {
            Alert::error('Asset Gagal di Update !!');
            return redirect()->route('asset');
        }
    }
    public function delete($id)
    {
        $program = Asset::where('id_asset', $id);
        $program->delete();
        if ($program == null) {
            abort(404);
        }
        Alert::success('Asset Berhasil di hapus !!');
        return redirect()->route('region');
    }
}
