<?php

namespace App\Http\Controllers\Setup\Servicedesk;

use App\Http\Controllers\Controller;
use App\Model\RootCaused;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class RootcausedController extends Controller
{
    public function index()
    {
        $causeds = RootCaused::all();
        // dd($segments);
        return view('setup.servicedesk.rootcaused.index', compact('causeds'));
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'nama_rootcaused' => 'required|string|max:50',
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
            $rootcaused = RootCaused::firstOrcreate([
                'name_caused' => $request->nama_rootcaused,
                'desc_caused' => $request->description,
                'created_by' => $user->id,
                'updated_by' => $user->id,
            ]);
            // dd($segment);
            Alert::success('Rootcaused Berhasil di Uploud !!');
            return redirect()->route('rootcaused');
        } catch (\Exception $e) {
            //jika gagal, redirect ke form yang sama lalu membuat flash message error
            Alert::error('Rootcaused Gagal di Uploud !!');
            return redirect()->route('rootcaused');
        }
    }
    public function edit($id)
    {
        $rootcaused = RootCaused::where('id_caused', $id)->first();
        if ($rootcaused == null) {
            abort(404);
        }
        return view('setup.servicedesk.rootcaused.edit', compact('rootcaused'));
    }
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nama_rootcaused' => 'required|string|max:50',
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
            $rootcaused = RootCaused::where('id_caused', $id);
            $rootcaused->update([
                'name_caused' => $request->nama_rootcaused,
                'desc_caused' => $request->description,
                'created_by' => $user->id,
                'updated_by' => $user->id,
            ]);
            if ($rootcaused == null) {
                abort(404);
            }
            Alert::success('Rootcaused Berhasil di Update !!');
            return redirect()->route('rootcaused');
        } catch (\Exception $e) {
            Alert::error('Rootcaused Gagal di Update !!');
            return redirect()->route('rootcaused');
        }
    }
    public function delete($id)
    {
        $rootcaused = RootCaused::where('id_caused', $id);
        $rootcaused->delete();
        if ($rootcaused == null) {
            abort(404);
        }
        Alert::success('Rootcaused Berhasil di hapus !!');
        return redirect()->route('rootcaused');
    }
}
