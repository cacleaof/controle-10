<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\ObjetoAprendizagem;
use App\Models\TeleeducacaoAtividade;
use Illuminate\Http\Request;
use DB;

class ObjetoAprendizagemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $objeto = ObjetoAprendizagem::all();
        return view('admin.smart.objeto_aprendizagem',compact('objeto'));
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
     * @param  \App\Models\ObjetoAprendizagem  $objetoAprendizagem
     * @return \Illuminate\Http\Response
     */
    public function show(ObjetoAprendizagem $objetoAprendizagem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ObjetoAprendizagem  $objetoAprendizagem
     * @return \Illuminate\Http\Response
     */
    public function edit(ObjetoAprendizagem $objetoAprendizagem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ObjetoAprendizagem  $objetoAprendizagem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ObjetoAprendizagem $objetoAprendizagem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ObjetoAprendizagem  $objetoAprendizagem
     * @return \Illuminate\Http\Response
     */
    public function destroy(ObjetoAprendizagem $objetoAprendizagem)
    {
        //
    }
}
