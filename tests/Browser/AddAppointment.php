<?php

namespace Tests\Browser;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AddAppointment extends DuskTestCase
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
                    ->visit('Transaction')
                    ->assertSee('Transaction')
                    ->clickLink('Transaction')
                    ->assertSee('Transaction')
                    ->click('#addtransaction')
                    ->value('#datepicker','06/12/2019')
                    ->value('#service',1)
                    ->click('@submit-transaction');
        });
    }
}
