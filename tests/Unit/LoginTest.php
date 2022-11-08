<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /** 
     * Creado por: Pedro Pérez
     */

    use RefreshDatabase;

    /** @test Prueba de vista de login */
    public function ir_a_login()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
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
