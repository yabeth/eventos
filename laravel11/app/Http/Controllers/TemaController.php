<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Tipotema;
use Illuminate\Support\Facades\DB;

class TemaController extends Controller {

    public function index() {
        $tema = Tipotema::all();
        return view('Vistas.tema', compact('tema'));
    }

    // public function store(Request $request) {
    //     $request->validate(['tema' => 'required|string|max:255']);
    //     if (Tipotema::where('tema', $request->tema)->exists()) {
    //         return redirect()->back()->with('error', 'Dato ya existe.')->withInput();
    //     }
    //     Tipotema::create(['tema' => $request->tema]);
    //     return redirect()->back()->with('success', 'Tema agregado correctamente.');
    // }

    public function store(Request $request) {
        $request->validate(['tema' => 'required|string|max:255']);
        $resultado = DB::select('CALL PA_CrearTema(?)', [$request->tema]);
        $mensaje = $resultado[0]->mensaje ?? 'Operación realizada';
        if (str_contains($mensaje, 'ya existe')) {
            return redirect()->back()->with('error', $mensaje)->withInput();
        }
        return redirect()->back()->with('success', $mensaje);
    }

    public function update(Request $request, $id) {
        $request->validate(['tema' => 'required|string|max:255']);
        if (Tipotema::where('tema', $request->tema)->where('idtema', '!=', $id)->exists()) {
            return redirect()->back()->with('error', 'Dato ya existe.')->withInput();
        }
        $item = Tipotema::findOrFail($id);
        $item->update(['tema' => $request->tema]);
        return redirect()->back()->with('success', 'Tema actualizado correctamente.');
    }
 
    public function destroy($id) {
        $tema = Tipotema::findOrFail($id);
        $resultado = DB::select('CALL PA_EliminarTema(?, ?)', [$id, $tema->tema]);
        $mensaje = $resultado[0]->mensaje ?? 'Operación realizada';
        if (str_contains($mensaje, 'no se puede')) {
            return redirect()->back()->with('error', $mensaje);
        }
        return redirect()->back()->with('success', $mensaje);
    }
}
