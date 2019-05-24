<?php

namespace Tests\Browser;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class PostTest extends DuskTestCase
{
   

    /**
     * A Dusk test example.z
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
                        ->click('#addpost')
                        ->assertSee('Add Post')
                        ->type('@title','Test1')
                        ->type('@content','This a content post need to be post')
                        ->attach('@image', __DIR__.'\man.png')
                        ->click('@post-submit');
                        
                        
           /*             $this->assertDatabaseHas('posts', ['id' => 2,
                                                            'user_id' => 1,
                                                            'image' => 'A5ox7jEcy13lCTE3.png',
                                                            'title' => 'Accessing Arguments in UI Events',
                                                            'content' => 'Test1231321321312', 
                                                            'created_at' => '2019-05-21 19:11:30',
                                                            'updated_at'=> '2019-05-21 19:11:30']);*/
          /*  $browser->visit('/')
                    ->assertSee('Laravel');*/
        });
    }

     /** @test */
 
}
