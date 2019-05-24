<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LoginAddPostComponent extends DuskTestCase
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
                    ->visit('Post')
                        ->assertSee('Post')
                        ->clickLink('Post')
                        ->assertSee('Post Table')
                        ->click('#addpost')
                        ->assertSee('Add Post')
                        ->type('@title','Test')
                        ->type('@content','This a content post need to be post')
                        ->attach('@image', __DIR__.'\man.png')
                        ->click('@post-submit');
        });
    }
}
