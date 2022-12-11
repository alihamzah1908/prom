<?php

namespace App\Http\Controllers\Setup\Servicedesk;

use App\Http\Controllers\Controller;
use App\Model\Segment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class SegmentController extends Controller
{
    public function index()
    {
        $segments = Segment::all();
        // dd($segments);
        return view('setup.servicedesk.segment.index', compact('segments'));
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
            $orderBy = 'id_segment';
            $order_dir = 'ASC';
        }
        $data = Segment::orderBy($orderBy, $order_dir);
        
        $result = getDataCustom($data, $r, 'id_segment', 'segment_name')->original;
        return response()->json($result);
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'segment_name' => 'required|string|max:50',
            'segment_desc' => 'required|string|max:200'
        ]);
        $user = Auth::user();
        if (!$user) {
            $message = "CSRF FAILED PLEASE RE-LOGIN!";
            Session::flash('message', $message);
            Session::flash('alert-class', 'alert-danger');
            return Redirect::back();
        }
        try {
            $segment = Segment::firstOrcreate([
                'segment_name' => $request->segment_name,
                'segment_desc' => $request->segment_desc,
                'created_by' => $user->id,
                'updated_by' => $user->id,
            ]);
            // dd($segment);
            Alert::success('Segment Berhasil di Uploud !!');
            return redirect()->route('segment');
        } catch (\Exception $e) {
            //jika gagal, redirect ke form yang sama lalu membuat flash message error
            Alert::error('Segment Gagal di Uploud !!');
            return redirect()->route('segment');
        }
    }
    public function edit($id)
    {
        $segment = Segment::where('id_segment', $id)->first();
        if ($segment == null) {
            abort(404);
        }
        return view('setup.servicedesk.segment.edit', compact('segment'));
    }
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'segment_name' => 'required|string|max:50',
            'segment_desc' => 'required|string|max:200'
        ]);
        $user = Auth::user();
        if (!$user) {
            $message = "CSRF FAILED PLEASE RE-LOGIN!";
            Session::flash('message', $message);
            Session::flash('alert-class', 'alert-danger');
            return Redirect::back();
        }
        try {
            $segment = Segment::where('id_segment', $id);
            $segment->update([
                'segment_name' => $request->segment_name,
                'segment_desc' => $request->segment_desc,
                'created_by' => $user->id,
                'updated_by' => $user->id,
            ]);
            if ($segment == null) {
                abort(404);
            }
            Alert::success('Segment Berhasil di Update !!');
            return redirect()->route('segment');
        } catch (\Exception $e) {
            Alert::error('segment Gagal di Update !!');
            return redirect()->route('segment');
        }
    }
    public function delete($id)
    {
        $program = Segment::where('id_segment', $id);
        $program->delete();
        if ($program == null) {
            abort(404);
        }
        Alert::success('segment Berhasil di hapus !!');
        return redirect()->route('region');
    }
}
