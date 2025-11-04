<?php

namespace App\Http\Controllers;

use App\Models\persona;
use App\Models\genero;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PersonaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function persona()
    {
        $generos = genero::all();
        $personas = persona::with(['genero'])->get();
        return response()->json([
            'generos' => $generos,
            'personas' => $personas
        ]);
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
    public function show(persona $persona)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(persona $persona)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, persona $persona)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(persona $persona)
    {
        //
    }
}
