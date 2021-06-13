<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;


class ViewAllBlogPostsTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * @group posts
     *
     */
    public function testCanViewAllBlogPosts(){
        $this->withoutExceptionHandling();

        //arrange 
        $post1 = Post::create([
            'title' => 'A simple title',
            'body' => 'A simply body'
        ]);

        $post2 = Post::create([
            'title' => 'A simple title2',
            'body' => 'A simply body2'
        ]);
        


        //act
        $resp = $this->get('/posts');

        //assert
        $resp->assertStatus(200);
        $resp->assertSee($post1->title);
        $resp->assertSee($post2->title);

        $resp->assertSee($post1->body);
        $resp->assertSee($post2->body);
        
    }
    
}
