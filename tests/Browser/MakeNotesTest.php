<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class MakeNotesTest extends DuskTestCase
{
    use DatabaseMigrations;

  
    public function testUserCanCreateNote(): void
    {
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                    ->visit('/create-note') 
                    ->type('title', 'My First Note') 
                    ->type('description', 'This is the content of my first note.')
                    ->press('CREATE') 
                    ->assertPathIs('/notes') 
                    ->assertSee('My First Note') 
                    ->assertSee('This is the content of my first note.');
        });
    }
}