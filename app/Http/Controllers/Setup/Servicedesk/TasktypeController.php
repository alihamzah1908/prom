<?php

namespace App\Http\Controllers\Setup\Servicedesk;

use App\Http\Controllers\Controller;
use App\Model\TaskType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;

class TasktypeController extends Controller
{
    public function index()
    {
        $tasks = TaskType::all();
        // dd($assets);
        return view('setup.servicedesk.task_type.index', compact('tasks'));
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
            $orderBy = 'id_type';
            $order_dir = 'ASC';
        }
        $data = TaskType::orderBy($orderBy, $order_dir);
        
        $result = getDataCustom($data, $r, 'id_type', 'type_name')->original;
        
        foreach($result['data'] as $d){
            
        }
        return response()->json($result);
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'type_name' => 'required|string|max:50',
            'type_description' => 'required|string|max:200',
            'type_status' => 'required|integer|max:100',
            'color' => 'required|string',
        ]);
        $user = Auth::user();
        if (!$user) {
            $message = "CSRF FAILED PLEASE RE-LOGIN!";
            Session::flash('message', $message);
            Session::flash('alert-class', 'alert-danger');
            return Redirect::back();
        }
        try {
            $task = TaskType::firstOrcreate([
                'type_name' => $request->type_name,
                'type_desc' => $request->type_description,
                'type_status' => $request->type_status,
                'color' => $request->color,
            ]);
            // dd($asset);
            Alert::success('Task Type Berhasil di Uploud !!');
            return redirect()->route('taskType');
        } catch (\Exception $e) {
            //jika gagal, redirect ke form yang sama lalu membuat flash message error
            Alert::error('Task Type Gagal di Uploud !!');
            return redirect()->route('taskType');
        }
    }
    public function edit($id)
    {
        $task = TaskType::where('id_type', $id)->first();
        if ($task == null) {
            abort(404);
        }
        return view('setup.servicedesk.task_type.edit', compact('task'));
    }
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'type_name' => 'required|string|max:50',
            'type_description' => 'required|string|max:200',
            'type_status' => 'required|integer|max:100',
            'color' => 'required|string',
        ]);
        $user = Auth::user();
        if (!$user) {
            $message = "CSRF FAILED PLEASE RE-LOGIN!";
            Session::flash('message', $message);
            Session::flash('alert-class', 'alert-danger');
            return Redirect::back();
        }
        try {
            $asset = TaskType::where('id_type', $id);
            $asset->update([
                'type_name' => $request->type_name,
                'type_desc' => $request->type_description,
                'type_status' => $request->type_status,
                'color' => $request->color,
            ]);
            if ($asset == null) {
                abort(404);
            }
            Alert::success('Task Type Berhasil di Update !!');
            return redirect()->route('taskType');
        } catch (\Exception $e) {
            Alert::error('Task Type Gagal di Update !!');
            return redirect()->route('taskType');
        }
    }
    public function delete($id)
    {
        $taskType = TaskType::where('id_type', $id);
        $taskType->delete();
        if ($taskType == null) {
            abort(404);
        }
        Alert::success('Task Type Berhasil di hapus !!');
        return redirect()->route('taskType');
    }
}
