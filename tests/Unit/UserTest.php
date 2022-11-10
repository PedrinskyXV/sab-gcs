<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class UserTest extends TestCase
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
        ->assertRedirect('/login'); # 302 redireccion a /login
    }

    /** @test •	Prueba de creación de registro de usuario con campos no validos. */
    public function agregar_registro_usuario_sin_cumplir_reglas()
    {
        $this->withoutMiddleware();        
        $test_usuario = [
            'name' => 'Pedro1523', #Numeros y letras no cumple regla String
            'email' => 'admin@example.com', #Correo ya existe no cumple regla unique
            'password' => 'testpassword',
            'confirm_password' => 'test2password', #No es igual no cumple regla confirmed
            'tipo_id' => '2', #String no permitido no cumple regla numeric
        ];

        $response = $this->post(route("users.store"), $test_usuario);
        $response->assertSessionHasErrors();
    }

    /** @test •	Prueba de eliminación de registro de un usuario. */
    public function eliminar_registro_usuario()
    {
        $this->withoutMiddleware();
        
        User::factory()->create();
        
        $ultimo_registro = User::all()->sortByDesc('id')->take(1)->values()->toArray();

        $response = $this->delete(route("users.destroy", $ultimo_registro[0]['id']));
        $response->assertRedirect(route('users.index'))->assertStatus(302);
    }
}
