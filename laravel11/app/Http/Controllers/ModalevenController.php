<?php
namespace App\Http\Controllers;

use App\Models\evento;
use Illuminate\Http\Request;

class ModalevenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function modaleven()
    {
        $eventos = evento::where('idestadoeve', 2)->get();
        return view('Vistas.modaleven', compact('eventos'));
    }

    // Los demás métodos pueden quedar vacíos si no los estás utilizando
    public function create() {}
    public function store(Request $request) {}
    public function show(evento $evento) {}
    public function edit(evento $evento) {}
    public function update(Request $request, evento $evento) {}
    public function destroy(evento $evento) {}
}
