<?php

namespace App\Http\Controllers;

use App\Models\tipousuario;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class TipousuarioController extends Controller
{
    public function tipousuario()
    {
        $tipousuarios=tipousuario::all();
        return view('Vistas.tipousuario',compact('tipousuarios'));
    }
    public function create()
    {
        
    }
    public function store(Request $request) {
        DB::statement('CALL CRTipoUsuario(?)', [
            $request->input('tipousu')
        ]); 
        return redirect()->back()->with('success', '¡Tipo de usuario fue agregada exitosamente!');
    }

    public function show(tipousuario $tipousuario)
    {
        
    }
    public function edit($idTipUsua)
    {
        $tipousuarios=tipousuario::findOrFail($idTipUsua); 
        return view('Vistas.tipousuario',compact('tipousuarios'));
    }
    public function update(Request $request, $idTipUsua)
    {
        $result = DB::select('CALL UPTipoUsuario(?, ?)', [
            $idTipUsua,
            $request->input('tipousu')
        ]);
        return redirect()->back()->with('success', '¡Se modifico exitosamente!');
        
    }
    public function destroy($idTipUsua)  
    {  
        try {   
            $result = DB::select('call ELITipousuario(?)', [$idTipUsua]);  
      
            return redirect()->back()->with('success', '¡Se eliminó correctamente!');  
            
        } catch (\Illuminate\Database\QueryException $e) {   
            $errorCode = $e->errorInfo[1];  
    
            if ($errorCode === 45000) { 
                $errorMessage = $e->getMessage(); 
                return redirect()->back()->with('error', $errorMessage);  
            } else {  
                return redirect()->back()->with('error', 'Tipo de usuario no se puede eliminar.');  
            }  
        }  
    }
    



}
