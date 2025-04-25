<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testLoginPageCanBeRendered(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->assertSee('LOG IN'); 
        });
    }

    /**
     * Test if a user can log in with valid credentials.
     */
    public function testUserCanLoginWithValidCredentials(): void
    {
        $user = User::factory()->create([
            'email' => 'testuser@example.com',
            'password' => bcrypt('password'),
        ]);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit('/login')
                    ->type('email', $user->email)
                    ->type('password', 'password')
                    ->press('LOG IN') // Pastikan tombol login memiliki teks "LOGIN"
                    ->assertPathIs('/dashboard') // Pastikan diarahkan ke dashboard
                    ->assertSee($user->name); // Pastikan nama pengguna terlihat
        });
    }

    /**
     * Test if a user cannot log in with invalid credentials.
     */
    public function testUserCannotLoginWithInvalidCredentials(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->type('email', 'invalid@example.com')
                    ->type('password', 'wrongpassword')
                    ->press('LOG IN') // Pastikan tombol login memiliki teks "LOGIN"
                    ->assertPathIs('/login') // Pastikan tetap di halaman login
                    ->assertSee('These credentials do not match our records.'); // Pesan error
        });
    }
}