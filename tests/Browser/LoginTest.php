<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LoginTest extends DuskTestCase
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
                    ->clickLink('Login')
                    ->assertSee('Login')
                    ->value('#email','lavada@gmail.com')
                    ->value('#password','admin123')
                    ->click('button[type="submit"]')
                    ->assertPathIs('/home')
                    ->assertSee('Lavada Queen')
                    ->click('.mdi-power');
        });
    }
}
