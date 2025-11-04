<?php

namespace App\Http\Controllers;

use App\Models\Participante;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ParticipanteController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function buscarPorDni($dni)
     {
         $participante = Participante::where('dni', $dni)->first();
         return response()->json($participante);
     }
     
    public function index()
    {
        //
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
    public function show(Participante $participante)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Participante $participante)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Participante $participante)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Participante $participante)
    {
        //
    }
}
