<?php
namespace App\Http\Controllers;
use App\Models\informe;
use App\Models\tipoinforme;
use App\Models\evento;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;  
USE DB;

class InformeController extends Controller
{
    public function informe()
    {
      
         $eventos = evento::all();
        $eventoss = DB::table('evento as ev')
        ->leftJoin('informe as inf', 'ev.idevento', '=', 'inf.idevento')
        ->whereNull('inf.idevento')
        ->select('ev.*')
        ->get();
        $tipoinformes = tipoinforme::all();
        $informes = informe::with(['evento'])->get();
        return view('Vistas.informe', compact('informes', 'eventos','eventoss','tipoinformes'));
    }
    public function create()
    {
        
    }
    public function store(Request $request)
    {
        try {  
            $request->validate([  
                'rta' => 'required|file|mimes:pdf,docx',   
            ]);  
            
            $file = $request->file('rta');  
            $filename = $file->getClientOriginalName();  
            $file->storeAs('public/informe', $filename);  
            $rta = 'informe/' . $filename;  
        
            DB::statement('CALL CRinfor(?,?,?,?)', [  
                $request->input('idevento'),  
                $request->input('fecpres'),  
                $request->input('idTipinfor'),  
                $rta  
            ]);  

            $informeRecienCreado = DB::table('informe')
            ->where('idevento', $request->input('idevento'))
            ->where('fecpres', $request->input('fecpres'))
            ->where('idTipinfor', $request->input('idTipinfor'))
            ->orderBy('idinforme', 'desc')
            ->first();
        if ($informeRecienCreado && Auth::check()) {
            $idinformeNuevo = $informeRecienCreado->idinforme;
            $nombreUsuario = Auth::user()->nomusu;
            DB::table('informe_auditoria')
                ->where('idoriginal', $idinformeNuevo)
                ->orderBy('fecha_operacion', 'desc') 
                ->limit(1) 
                ->update(['nombreusuario' => $nombreUsuario]);
    
        }

            return redirect()->back()->with('success', 'Se registró correctamente el informe');  
            
        } catch (ValidationException $e) {  
            return redirect()->back()->with('swal_error', 'Solo se permiten archivos PDF y DOCX.');  
        } catch (\Illuminate\Database\QueryException $e) {  
            $errorCode = $e->errorInfo[1];  
            if ($errorCode == 1644) {  
                $errorMessage = $e->errorInfo[2];  
                return redirect()->back()->with('swal_error', $errorMessage);  
            }  
            throw $e;  
        }
     
    }
    public function show(informe $informe)
    {
        
    }
    public function edit($idinforme)
    {
        $eventos = evento::all();
        $informes = informe::findOrFail($idinforme);
        return view('Vistas.informe', compact('informes', 'eventos'));
    }
    public function update(Request $request, $idinforme)
    {
        try {  
            $request->validate([  
                'idevento' => 'required|integer',  
                'fecpres' => 'required|date',  
                'idTipinfor' => 'required|string',  
                'rta' => 'nullable|file|mimes:pdf,docx'  
            ]);  
        
            $rutaArchivoCompleta = null;  
        
            if ($request->hasFile('rta')) {  
                $nombreArchivo = $request->file('rta')->getClientOriginalName();  
                $rutaArchivo = $request->file('rta')->storeAs('public/informe', $nombreArchivo);  
                $rutaArchivoCompleta = 'informe/' . $nombreArchivo;  
            } else {  
                $informeExistente = DB::table('informe')->where('idinforme', $idinforme)->first();  
                $rutaArchivoCompleta = $informeExistente->rta ?? null;   
            }  
        
            $result = DB::select('CALL MDinforme(?,?,?,?,?)', [  
                $idinforme,  
                $request->input('idevento'),  
                $request->input('fecpres'),  
                $request->input('idTipinfor'),  
                $rutaArchivoCompleta  
            ]);  
        



            if ($idinforme && Auth::check()) {
                $nombreUsuario = Auth::user()->nomusu;
                $updated = DB::table('informe_auditoria')
                    ->where('idoriginal', $idinforme)
                    ->orderBy('fecha_operacion', 'desc') 
                    ->limit(1) 
                    ->update(['nombreusuario' => $nombreUsuario]);
            
                if (!$updated) {
                    Log::warning("No se encontró registro para actualizar en evento_auditoria para ideventooriginal {$idevento}");
                }
            }


            return redirect()->back()->with('success', '¡Se modifico exitosamente!');  
        
        } catch (\Illuminate\Database\QueryException $e) {  
            $errorCode = $e->errorInfo[1];  
            if ($errorCode == 1451) {  
                return redirect()->back()->with('swal_error', 'No se puede modificar');  
            } elseif ($errorCode == 1644) {  
                $errorMessage = $e->errorInfo[2];  
                return redirect()->back()->with('swal_error', $errorMessage);  
            } else {  
                return redirect()->back()->with('swal_error', 'Ocurrió un error al intentar insertar ?');  
            }  
        } catch (\Illuminate\Validation\ValidationException $e) {  
            return redirect()->back()->with('swal_error', 'Solo se permite docX y pdf');  
        } catch (\Exception $e) {  
            return redirect()->back()->with('swal_error', 'Ocurrió un error inesperado al intentar insertar');  
        }
   
   
   
    }
   
   
        public function destroy($informe)
    {
        $result = DB::select('CALL ELIinforme(?)', [
            $informe
        ]);

        if ($informe && Auth::check()) {
            $nombreUsuario = Auth::user()->nomusu;
            DB::table('informe_auditoria')
                ->where('idoriginal', $informe)
                ->orderBy('fecha_operacion', 'desc') 
                ->limit(1) 
                ->update(['nombreusuario' => $nombreUsuario]);
    
        }

        $message = $result[0]->{'No se puede eliminar'} ?? 'Se eliminó correctamente';
        return redirect()->back()->with('success', $message);
   
    }

    public function buscar(Request $request)
    {
        $query = $request->input('search'); 
    
        $informes = informe::WhereHas('evento', function($q) use ($query) {
                                $q->where('eventnom', 'LIKE', '%' . $query . '%');
                            })
                            ->get();
    
        $output = '';
        foreach ($informes as $index =>$infor) {
            $output .= '<tr>
                <td>' . ($index + 1) . '</td>
                <td>' . $infor->fecpres . '</td>
                <td>' . $infor->ipoinforme->nomtinform. '</td>
                   <td>' . $infor->evento->eventnom . '</td>
                <td>' . $infor->rta . '</td>
             
                <td>
                    <div class="btn-group action-buttons">
                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#edit' . $infor->idinforme . '"><i class="bi bi-pencil"></i></button>
                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete' . $infor->idinforme . '"><i class="bi bi-trash"></i></button>
                    </div>
                </td>
            </tr>';
        }
        return response($output); 
    }
    
}
