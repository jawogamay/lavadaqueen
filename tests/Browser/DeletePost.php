<?php

namespace Tests\Browser;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class DeletePost extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->browse(function (Browser $browser) {
           $browser->loginAs(User::find(1))
                    ->visit('Post')
                    ->assertSee('Post')
                        ->clickLink('Post')
                        ->assertSee('Post Table')
                        ->assertSee('Modify')
                        ->click('#delete')
                        ->click('.swal2-confirm');
                    /*->click('#delete')
                    ->click('.swal2-confirm ');*/
        });
    }
}
