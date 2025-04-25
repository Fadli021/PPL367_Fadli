<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\Note;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class EditNotesTest extends DuskTestCase
{
    use DatabaseMigrations;


    public function testUserCanEditNote(): void
    {
        $user = User::factory()->create();
        $note = Note::factory()->create([
            'penulis_id' => $user->id,
            'title' => 'Original Title',
            'description' => 'Original Content',
        ]);

        $this->browse(function (Browser $browser) use ($user, $note) {
            $browser->loginAs($user)
                    ->visit('/edit-note-page/' . $note->id)
                    ->type('title', 'Updated Title')
                    ->type('description', 'Updated Content')
                    ->press('UPDATE') 
                    ->assertPathIs('/notes') 
                    ->assertSee('Updated Title') 
                    ->assertSee('Updated Content');
        });
    }
}