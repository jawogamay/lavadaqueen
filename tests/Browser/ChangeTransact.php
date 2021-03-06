<?php

namespace Tests\Browser;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ChangeTransact extends DuskTestCase
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
                    ->visit('Transaction')
                    ->assertSee('Transaction')
                    ->clickLink('Transaction')
                    ->assertSee('Transaction Table')
                    ->click('@edittransact')
                    /*->type('@weight','23')*/
                    ->click('@submit-weight');
        });
    }
}
