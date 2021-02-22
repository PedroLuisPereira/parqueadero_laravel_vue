<?php

namespace Tests\Feature;

use Carbon\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Cliente;

class ClientesTest extends TestCase
{
    //crear nuevamente las migraciones
    use RefreshDatabase;

    public function testIndex()
    {
        $clientes = Factory(Cliente::class, 5)->create();
        $response = $this->getJson('/api/clientes/');
        $response->assertStatus(200);
        $response->assertJsonCount(5);
        $response->assertJson($clientes->toArray());
    }


    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testShow()
    {
        //crear el cliente
        $cliente = Factory(Cliente::class)->create([
            "numero_documento"  => "123456",
            "nombre" => "julieta",
            "apellidos" => "Ramos"
        ]);
        //hacer la solitud
        $response = $this->get('/api/clientes/' . $cliente->id);
        //codigo de respuesta
        $response->assertStatus(200);
        // ver los valores que estan en la respuesta
        $response->assertJsonFragment([
            "id" => $cliente->id,
            "numero_documento"  => "123456",
            "nombre" => "julieta",
            "apellidos" => "Ramos"
        ]);
    }

    public function testStore()
    {
        $response = $this->post('/api/clientes', [
            'numero_documento' => '127485',
            'nombre' => 'Julieta',
            'apellidos' => 'Diaz Lopez'
        ]);
        $response->assertStatus(201);
        $this->assertCount(1, Cliente::all());
    }

    public function testUpdate()
    {
        $response = $this->post('/api/clientes', [
            'numero_documento' => '127485',
            'nombre' => 'Julieta',
            'apellidos' => 'Diaz Lopez'
        ]);

       
        $this->assertCount(1, Cliente::all());
        $cliente = Cliente::first();

        $response = $this->put('/api/clientes' . $cliente->id, [
             'numero_documento' => '1274852',
             'nombre' => 'Julieta2',
             'apellidos' => 'Diaz Lopez2'
        ]);

        
        $this->assertEquals('1274852', Cliente::first()->numero_documento);
        $this->assertEquals('Julieta2', Cliente::first()->nombre);
        $this->assertEquals('Diaz Lopez2', Cliente::first()->nombre);

        $response->assertStatus(200);
    }
}
