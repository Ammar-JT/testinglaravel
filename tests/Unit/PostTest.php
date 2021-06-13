<?php

namespace Tests\Unit;

use App\Models\Post;

//I HAVE NO FUCKING IDEA WHY I MUST REPLACE THIS TestCase with the feature test's one!!!!
//use PHPUnit\Framework\TestCase;
use Tests\TestCase;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

use Illuminate\Foundation\Testing\Concerns\InteractsWithExceptionHandling;

class PostTest extends TestCase
{
    use DatabaseMigrations, InteractsWithExceptionHandling;

    /**
     * @group formatted-date
     */
    public function testCanGetCreatedAtFormattedDate(){
        //THIS SHIT WON'T WORK WITHOUT importing: 'InteractsWithExceptionHandling' 
        //.. but it will work in the feature test without the import, donno why!
        $this->withoutExceptionHandling();


        //1- Arrangement
        //create a blog post
        $post = Post::create([
            'title' => 'A simple title',
            'body' => 'A simply body'
        ]);

        //2- action
        //get the value by calling the method
        $formattedDate = $post->createdAt();

        //assertion
        //assert that returned value is as we expect
        $this->assertEquals(
            $post->created_at->toFormattedDateString(), $formattedDate
        );
    }
}
