<?php

namespace App\Http\Controllers;

use App\Models\munu;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MunuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function menu()
    {
        $menu=menu::all();
        return view('Vistas.menu',compact('menu'));
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
    public function show(munu $munu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(munu $munu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, munu $munu)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(munu $munu)
    {
        //
    }
}
