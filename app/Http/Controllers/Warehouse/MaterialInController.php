<?php

namespace App\Http\Controllers\Warehouse;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class MaterialInController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data["data"] = DB::select('SELECT a.id, b.material_name, a.qty as qty_in, c.qty as qty_out, 
        a.qty - c.qty as available, 
        d.unit
        FROM material_ins as a
        JOIN materials as b ON a.material_id=b.id
        LEFT JOIN material_outs as c ON c.material_id=b.id
        JOIN units as d ON a.unit_id=d.id');
        $data["unit"] = \App\Model\Unit::all();
        $data["project"] = \App\Model\Project::all();
        return view('warehouse.material-in.index', $data);
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
        $data = new \App\Model\Material_in();
        $data->material_id = $request["material_id"];
        $data->unit_id = $request["unit_id"];
        $data->location_id = $request["location_id"];
        $data->project_id = $request["project_id"];
        $data->qty = $request["qty"];
        $data->save();
        return redirect(route('materialin.index'));
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


    public function get_material(Request $request)
    {
        if ($request["type"] == 'out') {
            $data = DB::select('SELECT a.material_name as value, a.id FROM `materials` as a
            JOIN material_ins as b
            ON a.id=b.material_id AND material_name LIKE "%' . $request->get('search') . '%"');
        } else {
            $data = DB::table('materials')
                ->select('material_name as value', 'id')
                ->where('material_name', 'LIKE', '%' . $request->get('search') . '%')
                ->get();
        }
        return response()->json($data);
    }

    public function get_location(Request $request)
    {
        if ($request["type"] == 'out') {
            $data = DB::select('SELECT a.location_name as value, a.id FROM `locations` as a
            JOIN material_ins as b
            WHERE a.id=b.location_id AND location_name LIKE "%' . $request->get('search') . '%"');
        } else {
            $data = DB::table('locations')
                ->select('location_name as value', 'id')
                ->where('location_name', 'LIKE', '%' . $request->get('search') . '%')
                ->get();
        }
        return response()->json($data);
    }
}
