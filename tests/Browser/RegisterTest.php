<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class RegisterTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->clickLink('Register')
                    ->assertSee('Register')
                    ->value('#name','Nino Orendain')
                    ->value('#phone','472195796')
                    ->value('#email','ninomasbang212@gmail.com')
                    ->value('#password','test1234')
                    ->value('#password-confirm','test1234')
                    ->click('button[type="submit"]')
                    ->assertPathIs('/email/verify');
        });
    }
}
