<?php

namespace App\Http\Controllers;
use App\Models\modalidad;
use App\Models\canal;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
class CanalController extends Controller
{
   
      public function canal()
    {
        $modalidades = modalidad::all();
        $canales = canal::with(['modalidades'])->get();
        return response()->json([ 'modalidades' => $modalidades,'canales' => $canales
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
    public function show(canal $canal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(canal $canal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, canal $canal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(canal $canal)
    {
        //
    }
}
