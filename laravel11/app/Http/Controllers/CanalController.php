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

  public function getPorModalidad($idmodal)
    {
        try {
            $canales = canal::where('idmodal', $idmodal)->get();
            
            $resultado = $canales->map(function($canal) {
                return [
                    'id' => $canal->idcanal,
                    'nombre' => $canal->canal,
                    'idmodal' => $canal->idmodal,
                    'modalidad' => optional($canal->modalidad)->modalidad ?? 'Sin modalidad'
                ];
            });

            return response()->json($resultado);
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }



    public function create()
    {
        
    }

    public function store(Request $request)
    {
        
    }

    public function show(canal $canal)
    {
        
    }
    public function edit(canal $canal)
    {
    }
    public function update(Request $request, canal $canal)
    {
        
    }

    public function destroy(canal $canal)
    {
        
    }
}

