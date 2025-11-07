<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TipresolucionAgrad;

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

    public function destroy($id) {
        $item = TipresolucionAgrad::findOrFail($id);
        $item->delete();
        return redirect()->back()->with('success', 'Tipo de agradecimiento eliminado correctamente.');
    }
}

