<?php

namespace App\Http\Controllers;

use App\Models\Modalidad;
use App\Models\Canal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class CanalController extends Controller
{
    // Obtener todos los canales
    public function index()
    {
        try {
            $canales = Canal::with('modalidad')->get();
            
            $resultado = $canales->map(function($canal) {
                return [
                    'id' => $canal->idcanal,
                    'nombre' => $canal->canal,
                    'idmodal' => $canal->idmodal,
                    'modalidad' => optional($canal->modalidad)->modalidad ?? 'Sin modalidad'
                ];
            });

            return response()->json($resultado);
            
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Obtener canales por modalidad
    public function getPorModalidad($idmodal)
    {
        try {
            $canales = Canal::with('modalidad')
                ->where('idmodal', $idmodal)
                ->get();
            
            $resultado = $canales->map(function($canal) {
                return [
                    'id' => $canal->idcanal,
                    'nombre' => $canal->canal,
                    'idmodal' => $canal->idmodal,
                    'modalidad' => optional($canal->modalidad)->modalidad ?? 'Sin modalidad'
                ];
            });

            return response()->json($resultado);
            
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Crear canal
    public function store(Request $request)
    {
        try {
            $request->validate([
                'canal' => 'required|string|max:100',
                'idmodal' => 'required|integer|exists:modalidad,idmodal'
            ]);

            DB::statement('CALL CRCanal(?, ?)', [
                $request->canal,
                $request->idmodal
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Canal creado exitosamente'
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    // Actualizar canal
    public function update(Request $request, $idcanal)
    {
        try {
            $request->validate([
                'canal' => 'required|string|max:100',
                'idmodal' => 'required|integer|exists:modalidad,idmodal'
            ]);

            DB::statement('CALL MDCanal(?, ?, ?)', [
                $idcanal,
                $request->canal,
                $request->idmodal
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Canal actualizado exitosamente'
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    // Eliminar canal
    public function destroy($idcanal)
    {
        try {
            DB::statement('CALL EliCanal(?)', [$idcanal]);

            return response()->json([
                'success' => true,
                'message' => 'Canal eliminado exitosamente'
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }
}