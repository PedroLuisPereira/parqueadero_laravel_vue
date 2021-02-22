<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Str;

class AuthController extends Controller
{

    public function formulario()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        //validaciones
        $datos = $request->validate([
            'email' => 'required|email|string',
            'password' => 'required|string',
        ]);

        $respuesta = Auth::attempt($datos); //compara los datos con la bd

        if ($respuesta) {
            //crear token
            $id = Auth::id();
            $user = User::find(1);
            $api_token = Str::random(60);
            $user->api_token = $api_token;
            $user->save();
            //redireccionar con el token
            return redirect('/')->with(['token' => $api_token]);
        } else {
            return back()->withErrors(["datos" => "Credenciales no concuerdan"])->withInput(request(['email']));
        }
    }

    public function logout()
    {
        //modificar el token
        $id = Auth::id();
        $user = User::find(1);
        $api_token = Str::random(60);
        $user->api_token = $api_token;
        $user->save();

        Auth::logout();
        return redirect()->route('auth.formulario');
    }
}
