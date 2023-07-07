<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;

use App\Models\EstabelecimentoSaude;
use Illuminate\Http\Request;
use DB;


class EstabelecimentoSaudeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $estabelecimento =  EstabelecimentoSaude::all();
        return view('admin.smart.estabelecimento', compact('estabelecimento'));
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
     * @param  \App\Models\EstabelecimentoSaude  $estabelecimentoSaude
     * @return \Illuminate\Http\Response
     */
    public function show(EstabelecimentoSaude $estabelecimentoSaude)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EstabelecimentoSaude  $estabelecimentoSaude
     * @return \Illuminate\Http\Response
     */
    public function edit(EstabelecimentoSaude $estabelecimentoSaude)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EstabelecimentoSaude  $estabelecimentoSaude
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EstabelecimentoSaude $estabelecimentoSaude)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EstabelecimentoSaude  $estabelecimentoSaude
     * @return \Illuminate\Http\Response
     */
    public function destroy(EstabelecimentoSaude $estabelecimentoSaude)
    {
        //
    }
}
