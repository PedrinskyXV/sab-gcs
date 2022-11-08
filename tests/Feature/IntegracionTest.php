<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IntegracionTest extends TestCase
{

    /**
     * My test implementation
     */
    public function testLoginFunciona()
    {
        $this->visit('/login');
        $this->type('admin@example.com', 'null');
        $this->type('password', 'null');
        $this->press('Entrar');
        $this->seePageIs('/dashboard');
        $this->see('Dashboard');

    }
}
