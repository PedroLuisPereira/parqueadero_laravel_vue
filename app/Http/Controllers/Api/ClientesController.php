<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ClienteResource;
use Illuminate\Support\Facades\Auth;
use App\Cliente;
use App\Vehiculo;

class ClientesController extends Controller
{

    public function __construct()
    {
        // $datos = [
        //     'email' => "druped@hotmail.com",
        //     'password' => "123456"
        // ];

        // $respuesta = Auth::attempt($datos);
        // $this->middleware('auth');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ClienteResource::collection(Cliente::paginate(50));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listar()
    {
        return ClienteResource::collection(Cliente::get());
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'numero_documento' => 'required|unique:clientes',
            'nombre' => 'required',
            'apellidos' => 'required',
            'placa' => 'required|unique:vehiculos',
            'tipo' => 'required',
        ]);

        $cliente = Cliente::create([
            'numero_documento' => $data['numero_documento'],
            'nombre' => $data['nombre'],
            'apellidos' => $data['apellidos'],
        ]);

        $vehiculo = Vehiculo::create([
            'placa' => $data['placa'],
            'tipo' => $data['tipo'],
            'cliente_id' => $cliente->id,
        ]);

        return new ClienteResource($cliente);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Cliente $cliente)
    {
        return new ClienteResource($cliente);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Cliente $cliente, Request $request)
    {
        $id =  $cliente->id;

        $data = $request->validate([
            'numero_documento' => "required|unique:clientes,numero_documento,$id",
            'nombre' => 'required',
            'apellidos' => 'required',
        ]);

        $cliente->update($data);
        
        return new ClienteResource($cliente);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cliente $cliente)
    {
        $vehiculos = Vehiculo::where('cliente_id', $cliente->id)->get();
        if (count($vehiculos) > 0) {
            return response()->json(["message" => "No se puede elimiar registro"], 403);
        } else {
            $cliente->delete();
            return response(null, 204);
        }
    }
}
