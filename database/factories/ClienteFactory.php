<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Cliente;
use Faker\Generator as Faker;

$factory->define(Cliente::class, function (Faker $faker) {
    return [
        'numero_documento' => $faker->unique()->randomNumber(5),
        'nombre' => $faker->firstName(),
        'apellidos' => $faker->lastName,
    ];
});
