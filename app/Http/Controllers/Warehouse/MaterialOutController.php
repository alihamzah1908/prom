<?php

namespace App\Http\Controllers\Warehouse;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class MaterialOutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data["data"] = DB::table('material_outs as a')
            ->select('a.*', 'b.material_name', 'c.project_name', 'd.location_name', 'e.unit')
            ->leftJoin('materials as b', 'a.material_id', 'b.id')
            ->leftJoin('projects as c', 'a.project_id', 'c.id')
            ->leftJoin('locations as d', 'a.location_id', 'd.id')
            ->leftJoin('units as e', 'a.unit_id', 'e.id')
            ->where('a.status', 'on going')
            ->orderBy('id', 'desc')
            ->get();
        $data["unit"] = \App\Model\Unit::all();
        $data["project"] = \App\Model\Project::all();
        return view('warehouse.material-out.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = new \App\Model\Material_out();
        $data->material_id = $request["material_id"];
        $data->unit_id = $request["unit_id"];
        $data->location_id = $request["location_id"];
        $data->project_id = $request["project_id"];
        $data->qty = $request["qty"];
        $data->status = 'on going';
        $data->save();
        return redirect(route('materialout.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function approval(Request $request)
    {
        $data = DB::table('material_outs as a');
        $data->select('a.*', 'b.material_name', 'c.project_name', 'd.location_name', 'e.unit');
        $data->leftJoin('materials as b', 'a.material_id', 'b.id');
        $data->leftJoin('projects as c', 'a.project_id', 'c.id');
        $data->leftJoin('locations as d', 'a.location_id', 'd.id');
        $data->leftJoin('units as e', 'a.unit_id', 'e.id');
        if (request()->segments()[2] == 'approval') {
            $data->where('a.status', 'on going');
            $result["data"] = $data->get();
            return view('warehouse.on-going-approval.index', $result);
        } else {
            $data->where('a.status', 'approved');
            $result["data"] = $data->get();
            return view('warehouse.material-approved.index', $result);
        }
    }

    public function approve(Request $request)
    {
        $data = \App\Model\Material_out::find($request["id"]);
        $data->status = 'approved';
        $data->save();
        return response(["status" => 200]);
    }
}
