<?php

namespace Tests\Integration;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /** 
     * Creado por: Pedro Pérez
     */

    use RefreshDatabase;

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
}
