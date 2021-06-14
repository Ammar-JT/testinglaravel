<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Post;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreatePostsTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @group create-post
     * 
     */
    public function testCanCreatePost(){
        $this->withoutExceptionHandling();

        //arrane

        //act
        //NOTICE: we didn't use >> Post::create << we used the route >> /store-post <<
        //.. doing that we make sure the route and the controller working well: 
        $resp = $this->post('/store-post', [
            'title' => 'new post title',
            'body' => 'new post body'
        ]);

        //assert
        $this->assertDatabaseHas('posts', [
            'title' => 'new post title',
            'body' => 'new post body'
        ]);

        //no need for this, I just did that to follow the courese: 
        //.. and it means we make sure the db is refreshed:
        $post = Post::find(1);

        $this->assertEquals('new post title', $post->title);
        $this->assertEquals('new post body', $post->body);


    }

    //this test validation, we make sure title is required and the app validate that

    /**
     * @group title-required
     * 
     */
    public function testTitleIsRequiredToCreatePost(){ 
        //$this->withoutExceptionHandling();

        //arrange
        //action
        //NOTICE: we didn't use >> Post::create << we used the route >> /store-post <<
        //.. doing that we make sure the route and the controller working well: 
        $resp = $this->post('/store-post', [
            'title' => null,
            'body' => 'new post body'
        ]);

        //assert
        //this function make sure that the validation session an error, 
        //.. but how exactally it specify title..... i donno: 
        $resp->assertSessionHasErrors('title');
    }

    /**
     * @group body-required
     * 
     */
    public function testBodyIsRequiredToCreatePost(){ 
        //$this->withoutExceptionHandling();

        //arrange
        //action
        //NOTICE: we didn't use >> Post::create << we used the route >> /store-post <<
        //.. doing that we make sure the route and the controller working well: 
        $resp = $this->post('/store-post', [
            'title' => 'new post tile',
            'body' => null
        ]);

        //assert
        //this function make sure that the validation session an error, 
        //.. but how exactally it specify title..... i donno: 
        $resp->assertSessionHasErrors('body');
    }
}
