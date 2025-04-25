<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class RegisterTest extends DuskTestCase
{
    use DatabaseMigrations;


    public function testUserCanRegister(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register') 
                    ->type('name', 'Test User') 
                    ->type('email', 'testuser@example.com') 
                    ->type('password', 'password') 
                    ->type('password_confirmation', 'password') 
                    ->press('REGISTER') 
                    ->assertPathIs('/dashboard')
                    ->assertSee('Test User'); 
        });
    }
}