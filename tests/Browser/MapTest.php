<?php

namespace Tests\Browser;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class MapTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(2))
                     ->visit('Locate Shop')
                     ->assertSee('Locate Shop')
                     ->clickLink('Locate Shop')
                     ->value('#origin-input','Cebu City, Cebu, Philippines')
                   /*  -value('#destination-input','Lavada')*/
                     ->value('#mode-selector','changemode-transit');
        });
    }
}
