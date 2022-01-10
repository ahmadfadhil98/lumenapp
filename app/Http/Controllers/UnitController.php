<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;
use stdClass;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listUnit = new stdClass();
        $itemUnit = Unit::get();
        $listUnit->detail_user = $itemUnit;
        return response()->json($listUnit);
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
        $this->validate($request, [
            'nama' => 'required',
            'homestay_id' => 'required',
            'harga' => 'required'
        ]);

        $nama = $request->input('nama');
        $homestay_id = $request->input('homestay_id');
        $harga = $request->input('harga');

        $units = Unit::create([
            'nama' => $nama,
            'homestay_id' => $homestay_id,
            'harga' => $harga
        ]);

        return response()->json(['message' => 'Data Berhasil Masuk ke Tabel Unit Homestay']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $unitList = new stdClass();
        $units = Unit::where('homestay_id', $id)->select('id', 'nama', 'harga', 'foto')->get();
        $unitList->jumlah = $units->count();
        $unitList->unit = $units;
        return response()->json($unitList);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function edit(Unit $unit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Unit $unit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Unit $unit)
    {
        //
    }
}
