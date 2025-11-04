<?php

namespace App\Http\Controllers;

use App\Models\tiporesolucion;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class TiporesolucionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function tiporesolucion()
    {
        $tiporesoluciones=tiporesolucion::all();
        return view('Vistas.tiporesolucion',compact('tiporesoluciones'));
    }
    public function create()
    {
        
    }
    public function store(Request $request) {
        DB::statement('CALL CRTipoResolucion(?)', [
            $request->input('nomtiprs')
        ]); 
        return redirect()->back()->with('success', '¡Tipo de resolución agregada exitosamente!');
    }

    public function show(tiporesolucion $tiporesolucion)
    {
        
    }
    public function edit($idTipresol)
    {
        $tiporesoluciones=tiporesolucion::findOrFail($idTipresol); 
        return view('Vistas.tiporesolucion',compact('tiporesoluciones'));
    }
    public function update(Request $request, $idTipresol)
    {
        $result = DB::select('CALL UPTipoResolucion(?, ?)', [
            $idTipresol,
            $request->input('nomtiprs')
        ]);
        return redirect()->back()->with('success', '¡Se modifico exitosamente!');
        
    }
    public function destroy($idTipresol)  
    {  
        try {   
            $result = DB::select('call ELTipoResolucion(?)', [$idTipresol]);  
      
            return redirect()->back()->with('success', '¡Se eliminó correctamente!');  
            
        } catch (\Illuminate\Database\QueryException $e) {   
            $errorCode = $e->errorInfo[1];  
    
            if ($errorCode === 45000) { 
                $errorMessage = $e->getMessage(); 
                return redirect()->back()->with('error', $errorMessage);  
            } else {  
                return redirect()->back()->with('error', 'Tipo de resolución no se puede eliminar.');  
            }  
        }  
    }
    



}
