<?php

namespace App\Http\Controllers;

use App\Models\genero;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GeneroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function genero()
    {
        $genero = genero::all();
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
    public function show(genero $genero)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(genero $genero)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, genero $genero)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(genero $genero)
    {
        //
    }
}
