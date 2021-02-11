<?php

namespace App\Http\Controllers\api;

use App\Cliente;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\VehiculoResource;
use App\Vehiculo;
use Illuminate\Support\Facades\DB;


class VehiculosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vehiculos = DB::table('clientes')
            ->join('vehiculos', 'clientes.id', '=', 'vehiculos.cliente_id')
            ->select('vehiculos.*', 'clientes.nombre', 'clientes.apellidos')
            ->paginate(10);

        return $vehiculos;
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
            'placa' => 'required|unique:vehiculos',
            'tipo' => 'required',
            'cliente_id' => 'required',
        ]);

        $vehiculo = Vehiculo::create([
            'placa' => $data['placa'],
            'tipo' => $data['tipo'],
            'cliente_id' => $data['cliente_id'],
        ]);

        return new VehiculoResource($vehiculo);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Vehiculo $vehiculo)
    {
        return new VehiculoResource($vehiculo);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show_cliente(Cliente $cliente)
    {

        $cliente_id = $cliente->id;
        $vehiculos = Vehiculo::where('cliente_id', $cliente_id)->get();
        return VehiculoResource::collection($vehiculos);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Vehiculo $vehiculo, Request $request)
    {
        $id =  $vehiculo->id;

        $data = $request->validate([
            'placa' => "required|unique:vehiculos,placa,$id",
            'tipo' => 'required',
            'cliente_id' => 'required',
        ]);

        $vehiculo->update($data);

        return new VehiculoResource($vehiculo);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vehiculo $vehiculo)
    {
        $vehiculo->delete();
        return response(null, 204);
    }
}
