<?php

namespace Tests\Browser;

use App\Models\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreatePostTest extends DuskTestCase
{
    use DatabaseMigrations;
    /**
     * @group create-post
     */
    public function testAuthUserCanCreatePost()
    {
        $user = User::factory()->create();
        
        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                    ->visit('/create-post')
                    ->type('title', 'New Post')
                    ->type('body', 'New Body')
                    ->press('Save Post')
                    ->assertPathIs('/posts')
                    ->assertSee('New Post')
                    ->assertSee('New Body');
        });
    }


    /**
     * @group create-post-auth
     */
    public function testOnlyAuthUserCanCreatePost()
    {
        
        $this->browse(function (Browser $browser){
            $browser->visit('/create-post')
                    ->assertPathIs('/login');
        });
    }
}
