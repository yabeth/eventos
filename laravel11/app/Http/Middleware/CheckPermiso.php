<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckPermiso
{
    
    public function handle($request, Closure $next)
    {
        
        $user = Auth::user();

        
        if (!$user->permisos->contains('nombre_ruta', $request->route()->getName())) {
            return redirect('sinpermiso'); 
        }

        return $next($request); 
    }
}
