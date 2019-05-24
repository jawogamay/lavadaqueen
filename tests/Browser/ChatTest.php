<?php

namespace Tests\Browser;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ChatTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->browse(function ($first, $second) {
            $first->loginAs(User::find(1))
                 ->visit('/private')
                 ->waitForText('Message')
                 ->assertSee('SEND');

            $second->loginAs(User::find(2))
                    ->visit('/private')
                    ->waitForText('Message')
                     ->type('@message', 'Testing')
                    ->press('SEND');

          /*  $first->waitForText('Hey Taylor')*/
                /*  ->assertSee('Jeffrey Way');*/


        });
    }
}
