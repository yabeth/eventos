<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TipresolucionAgrad;
use Illuminate\Support\Facades\DB;

class TipresolucionAgradController extends Controller {
    public function index() {
        $tipresolucagrd = TipresolucionAgrad::all();
        return view('Vistas.tipresolucionagrad', compact('tipresolucagrd'));
    }

    public function store(Request $request) {
        $request->validate(['tipoagradeci' => 'required|string|max:255',]);
        TipresolucionAgrad::create(['tipoagradeci' => $request->tipoagradeci,]);
        return redirect()->back()->with('success', 'Tipo de agradecimiento agregado correctamente.');
    }

    public function update(Request $request, $id) {
        $request->validate(['tipoagradeci' => 'required|string|max:255',]);
        $item = TipresolucionAgrad::findOrFail($id);
        $item->update(['tipoagradeci' => $request->tipoagradeci,]);
        return redirect()->back()->with('success', 'Tipo de agradecimiento actualizado correctamente.');
    }

    // public function destroy($id) {
    //     $item = TipresolucionAgrad::findOrFail($id);
    //     $item->delete();
    //     return redirect()->back()->with('success', 'Tipo de agradecimiento eliminado correctamente.');
    // }

    public function destroy($id) {
        $item = TipresolucionAgrad::findOrFail($id);
        $resultado = DB::select('CALL PA_EliminarTipresolAgra(?, ?)', [$id, $item->tipoagradeci]);
        $mensaje = $resultado[0]->mensaje ?? 'Operación realizada';
        if (str_contains($mensaje, 'no se puede')) {
            return redirect()->back()->with('error', $mensaje);
        }
        return redirect()->back()->with('success', $mensaje);
    }

}

