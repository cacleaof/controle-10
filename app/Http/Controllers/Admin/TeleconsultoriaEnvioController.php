<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\TeleconsultoriaEnvio;
use Illuminate\Http\Request;
use DB;

class TeleconsultoriaEnvioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teleconsultoria = TeleconsultoriaEnvio::all();
        return view('admin.smart.teleconsultoria', compact('teleconsultoria'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TeleconsultoriaEnvio  $teleconsultoriaEnvio
     * @return \Illuminate\Http\Response
     */
    public function show(TeleconsultoriaEnvio $teleconsultoriaEnvio)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TeleconsultoriaEnvio  $teleconsultoriaEnvio
     * @return \Illuminate\Http\Response
     */
    public function edit(TeleconsultoriaEnvio $teleconsultoriaEnvio)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TeleconsultoriaEnvio  $teleconsultoriaEnvio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TeleconsultoriaEnvio $teleconsultoriaEnvio)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TeleconsultoriaEnvio  $teleconsultoriaEnvio
     * @return \Illuminate\Http\Response
     */
    public function destroy(TeleconsultoriaEnvio $teleconsultoriaEnvio)
    {
        //
    }
}
