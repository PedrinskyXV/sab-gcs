<?php

namespace Tests\Regression;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserMethodTest extends TestCase
{
    /**
     * Creado por: Pedro Pérez
     */

    use RefreshDatabase;

    /** @test • Prueba de creación de registro de usuario con campos validos una vez logeado. */
    public function metodo_agregar_registro_usuario()
    {
        $this->get('/login')->assertStatus(200);

        $user_logeado = User::factory()->create();

        $credenciales = [
            "email" => $user_logeado->email,
            "password" => 'password',
        ];

        $response = $this->post(route("login"), $credenciales);
        $this->assertCredentials($credenciales);
        $response->assertRedirect('/dashboard');
        $this->get('/users')->assertStatus(200);
        $this->get('/users/create')->assertStatus(200);

        $test_usuario = [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => 'testpassword',
            'password_confirmation' => 'testpassword',
            'tipo_id' => 1,
        ];

        $response = $this->post(route("users.store"), $test_usuario);
        $response->assertSessionHasNoErrors()->assertRedirect('/users');
    }

    /** @test • Prueba de modificación de registro de usuario con campos validos una vez logeado. */
    public function metodo_editar_registro_usuario()
    {
        $this->get('/login')->assertStatus(200);

        $user_logeado = User::factory()->create();

        $credenciales = [
            "email" => $user_logeado->email,
            "password" => 'password',
        ];

        $response = $this->post(route("login"), $credenciales);
        $this->assertCredentials($credenciales);
        $response->assertRedirect('/dashboard');
        $this->get('/users')->assertStatus(200);
        $this->get('/users/1/edit')->assertStatus(200);

        $test_usuario = [
            'name' => 'Nuevo Nombre',
            'email' => 'nuevo@correo.com',
            'tipo_id' => 1,
        ];

        $response = $this->put(route("users.update", 1), $test_usuario);

        $db_test_usuario = User::find(1);

        $this->assertEquals($db_test_usuario['name'], $test_usuario['name']);
        $this->assertEquals($db_test_usuario['email'], $test_usuario['email']);

        $response->assertSessionHasNoErrors()->assertRedirect('/users')->assertStatus(302);
    }

    /** @test •    Prueba de eliminación de registro de un usuario una vez logeado. */
    public function metodo_eliminar_registro_usuario()
    {

        $this->get('/login')->assertStatus(200);

        $user_logeado = User::factory()->create();

        $credenciales = [
            "email" => $user_logeado->email,
            "password" => 'password',
        ];

        $response = $this->post(route("login"), $credenciales);
        $this->assertCredentials($credenciales);
        $response->assertRedirect('/dashboard');
        $this->get('/users')->assertStatus(200);

        $ultimo_registro = User::all()->sortByDesc('id')->take(1)->values()->toArray();

        $response = $this->delete(route("users.destroy", $ultimo_registro[0]['id']));
        $response->assertRedirect(route('users.index'))->assertStatus(302);
    }

}
