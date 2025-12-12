<?php

namespace App\Http\Controllers;

use App\Models\tipousuario;
use App\Models\usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login()
    {
        $tipousuarios = tipousuario::all();
        return view('Vistas.login', compact('tipousuarios'));
    }
public function authenticate(Request $request)
    {
        $request->validate([
            'nomusu' => 'required|string',
            'pasword' => 'required|string',
            'idTipUsua' => 'required|integer',
        ]);
    
        $user = usuario::where('nomusu', $request->input('nomusu'))
                        ->where('idTipUsua', $request->input('idTipUsua'))
                        ->first();
    
        if ($user) {
            
            $password_plana_ingresada = $request->input('pasword');
            
            $hash_ingresado = hash('sha256', $password_plana_ingresada);
            
            if ($hash_ingresado === $user->pasword) { 
            
            
                session(['usuario' => $user]);
                session()->regenerate();
                Auth::login($user);
                Log::info('User authenticated:', ['usuario' => $user]);
                return redirect()->route('principal');
            }
        }
        
        Log::info('Authentication failed for user:', ['nomusu' => $request->input('nomusu')]);
        return back()->withErrors([
            'error' => 'El usuario o la contraseña son incorrectos.',
        ]);
    }
  public function authenticatee(Request $request)
    {
        
        $request->validate([
            'nomusu' => 'required|string',
            'pasword' => 'required|string',
            'idTipUsua' => 'required|integer',
        ]);
    
        $user = usuario::where('nomusu', $request->input('nomusu'))
                        ->where('idTipUsua', $request->input('idTipUsua')) 
                        ->first();
    
        if ($user) {
            $hash_ingresado = hash('sha256', $request->input('pasword'));
            
            if ($hash_ingresado === $user->pasword) {
                session(['usuario' => $user]);
                session()->regenerate();

                Auth::login($user);
                Log::info('User authenticated:', ['usuario' => $user]);
                
                return redirect()->route('principal');
            }
        }
    
        return back()->withErrors([
            'error' => 'El usuario o la contraseña son incorrectos.',
        ]);
    }
}
