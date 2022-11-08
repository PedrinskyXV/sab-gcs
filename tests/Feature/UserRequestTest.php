<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserRequestTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Creado por: Pedro Pérez
     */
    

    /** @test •	Prueba acceso a la ruta de la administración de usuarios sin credenciales registradas. */
    #Devuelve 302 para redireccionar a el /login
    public function ir_a_control_usuarios_sin_credenciales()
    {
        $this->get('/users')
        ->assertStatus(302); # 302 redireccion a /login
    }

    /** @test •	Prueba acceso a la ruta de la administración de usuarios con credenciales registradas. */
    public function ir_a_control_usuarios_con_credenciales()
    {
        $user_logeado = User::factory()->create();            

        $credenciales = [
            "email" => $user_logeado->email,
            "password" => 'password',
        ];

        $response = $this->post('/login', $credenciales);
        $response->assertRedirect('/dashboard');
        $this->assertCredentials($credenciales);
        $this->get('/users')
            ->assertStatus(200);
    }

    /** @test •	Prueba de creación de registro de usuario con campos validos. */
    public function agregar_registro_usuario_con_reglas()
    {
        $user_logeado = User::factory()->create();
        $test_usuario = [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => 'testpassword',
            'password_confirmation' => 'testpassword',
            'tipo_id' => 1,
        ];

        $response = $this->actingAs($user_logeado)->post(route("users.store"), $test_usuario);
        $response->assertSessionHasNoErrors()->assertRedirect('/users')->assertStatus(302);
    }

    /** @test •	Prueba de creación de registro de usuario con campos no validos. */
    public function agregar_registro_usuario_sin_cumplir_reglas()
    {
        $user_logeado = User::factory()->create();
        $test_usuario = [
            'name' => 'Pedro1523', #Numeros y letras no cumple regla String
            'email' => 'admin@example.com', #Correo ya existe no cumple regla unique
            'password' => 'testpassword',
            'confirm_password' => 'test2password', #No es igual no cumple regla confirmed
            'tipo_id' => '2', #String no permitido no cumple regla numeric
        ];

        $response = $this->actingAs($user_logeado)->post(route("users.store"), $test_usuario);
        $response->assertSessionHasErrors();
    }

    /** @test •	Prueba de actualización de registro de un usuario con campos validos. */
    public function editar_registro_usuario_cumpliendo_reglas()
    {
        $user_logeado = User::factory()->create();

        $test_usuario = [
            'name' => 'Nuevo Nombre',
            'email' => 'nuevo@correo.com',
            'tipo_id' => 1,
        ];

        $response = $this->actingAs($user_logeado)->put(route("users.update", 1), $test_usuario);

        $db_test_usuario = User::find(1);

        $this->assertEquals($db_test_usuario['name'], $test_usuario['name']);
        $this->assertEquals($db_test_usuario['email'], $test_usuario['email']);

        $response->assertSessionHasNoErrors()->assertRedirect('/users')->assertStatus(302);
        
    }

    /** @test •	Prueba de eliminación de registro de un usuario. */
    public function eliminar_registro_usuario()
    {
        $user_logeado = User::factory()->create();
        
        $ultimo_registro = User::all()->sortByDesc('id')->take(1)->values()->toArray();

        $response = $this->actingAs($user_logeado)->delete(route("users.destroy", $ultimo_registro[0]['id']));
        $response->assertRedirect(route('users.index'))->assertStatus(302);
    }
}
