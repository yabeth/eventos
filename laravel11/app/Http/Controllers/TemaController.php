<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Tipotema;

class TemaController extends Controller {

    public function index() {
        $tema = Tipotema::all();
        return view('Vistas.tema', compact('tema'));
    }

    public function store(Request $request) {
        $request->validate(['tema' => 'required|string|max:255']);
        if (Tipotema::where('tema', $request->tema)->exists()) {
            return redirect()->back()->with('error', 'Dato ya existe.')->withInput();
        }
        Tipotema::create(['tema' => $request->tema]);
        return redirect()->back()->with('success', 'Tema agregado correctamente.');
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
        $item = Tipotema::findOrFail($id);
        $item->delete();
        return redirect()->back()->with('success', 'Tema eliminado correctamente.');
    }
}
