<?php

namespace App\Http\Controllers;

use App\Models\modalidad;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
class ModalidadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function modalidad()
    {
        $modalidad = modalidad::all();
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(modalidad $modalidad)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(modalidad $modalidad)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, modalidad $modalidad)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(modalidad $modalidad)
    {
        //
    }
}
