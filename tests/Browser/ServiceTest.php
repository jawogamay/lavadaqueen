<?php

namespace Tests\Browser;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ServiceTest extends DuskTestCase
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
                     ->visit('Service')
                     ->clickLink('Service')
                      ->assertSee('Service Table')
                       ->click('#addservice')
                       ->assertSee('Add Service')
                       ->type('@service','Drying')
                        ->type('@price','23')
                      ->click('@submit');
                   
        });
    }
}
