<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /** 
     * Creado por: Pedro Pérez
     */

    use RefreshDatabase;

    /** @test •	Prueba acceso a la ruta del formulario de Login */
    public function ir_a_login()
    {
        $this->get('/login')
            ->assertStatus(200);        
    }

    /** @test Prueba de autenticación de usuario con credenciales validas */
    public function autentificar_usuario()
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
        
    }

    /** @test •	Prueba de autenticación de usuario con credenciales no validas */
    public function no_autentificar_usuario_con_credenciales_invalidas()
    {        
        $credenciales = [
            "email" => "test2@mail.com", #correo inexistente en la base de datos
            "password" => "testpassword"
        ];

        $this->assertInvalidCredentials($credenciales);
    }

    /** @test •	Prueba de campo email requerido para autentificarse.*/
    public function email_es_requerido_para_autentificarse()
    {
        $credenciales = [
            "email" => null,
            "password" => "testpassword"
        ];

        $response = $this->from('/login')->post('/login', $credenciales);
        $response->assertRedirect('/login')->assertSessionHasErrors('email');
    }

    /** @test •	Prueba de campo contraseña requerido para autentificarse.*/
    public function password_es_requerido_para_autentificarse()
    {
        $credenciales = [
            "email" => "test@mail.com",
            "password" => null,
        ];

        $response = $this->from('/login')->post('/login', $credenciales);

        $response->assertRedirect('/login')
            ->assertSessionHasErrors('password');
    }
}
