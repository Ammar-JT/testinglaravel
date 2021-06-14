<?php

namespace Tests\Browser;

use App\Models\Post;
use App\Models\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LoginTest extends DuskTestCase
{
    use DatabaseMigrations;
    /**
     * @group login
     */
    public function testAUserCanLogin(){
        $user = User::factory()->create();
              //User::factory()->count(5)->create(); << can be used

        // notice that you didn't pass the user through parameter,
        //.. but instead you used >> use ($user) << which is a shit i donno about it:s
        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit('/login')
                    ->type('email', $user->email)
                    ->type('password', 'password')
                    ->press('Login')
                    ->assertPathIs('/home');
        });
    }

    /**
     * @group posts-page
     * 
     */
    public function testAUserCanViewAPost(){
        $post = Post::factory()->create();

        $this->browse(function (Browser $browser) use ($post) {
            $browser->visit('/posts')
                    ->clickLink('View Post Details')
                    ->assertPathIs("/posts/$post->id")
                    ->assertSee($post->title)
                    ->assertSee($post->createdAt());
        });
    

    }













    /*
    
     * A Dusk test example.
     *
     * @return void
    
    public function testExample()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertSee('Laravel');
        });
    }
    */
}
