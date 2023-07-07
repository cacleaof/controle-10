<?php

namespace App\Http\Controllers\Admin;

use App\Models\TelediagnosticoEnvio;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TelediagnosticoEnvioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $telediagnostico = TelediagnosticoEnvio::all();
        return view('admin.smart.telediagnostico', compact('telediagnostico'));
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
     * @param  \App\Models\TelediagnosticoEnvio  $telediagnosticoEnvio
     * @return \Illuminate\Http\Response
     */
    public function show(TelediagnosticoEnvio $telediagnosticoEnvio)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TelediagnosticoEnvio  $telediagnosticoEnvio
     * @return \Illuminate\Http\Response
     */
    public function edit(TelediagnosticoEnvio $telediagnosticoEnvio)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TelediagnosticoEnvio  $telediagnosticoEnvio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TelediagnosticoEnvio $telediagnosticoEnvio)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TelediagnosticoEnvio  $telediagnosticoEnvio
     * @return \Illuminate\Http\Response
     */
    public function destroy(TelediagnosticoEnvio $telediagnosticoEnvio)
    {
        //
    }
}
