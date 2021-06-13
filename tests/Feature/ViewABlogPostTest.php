<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Post;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

// I imported this use by myself, in older laravel version it imported by default
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ViewABlogPostTest extends TestCase
{
    use DatabaseMigrations;

    public function testCanViewABlogPost(){
        //put this so we can see detailed error not a rendered one (to a view): 
        $this->withoutExceptionHandling();

        //1- Arrangement
        //create a blog post
        $post = Post::create([
            'title' => 'A simple title',
            'body' => 'A simply body'
        ]);

        //2- Action
        //visiting a route
        $resp = $this->get("/posts/{$post->id}");

        //3- Assertion
        //assert status code 200 << means route and view working good
        $resp->assertStatus(200);

        //assert that we see post title
        $resp->assertSee($post->title);

        //assert that we see post body
        $resp->assertSee($post->body);

        //assert that we see post published date
        $resp->assertSee($post->created_at);
    }

    /**
     * @group post-not-found
     * 
     */

    public function testViewsA404PageWhenPostIsNotFound(){
        //put this so we can see detailed error not a rendered one (to a view): 
        //$this->withoutExceptionHandling();

        //1- Arrangement <<< Skipped <<<
        
        //2- Action
        $resp = $this->get('posts/INVALID_ID');
        
        //3- Assertion
        $resp->assertStatus(404);
        $resp->assertSee('The page you are looking for could not be found');
    }
    
}
