<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_example()
    {
        //this gives you the response of visiting '/'
        $response = $this->get('/');

        //this asserStatus() function make sure that visiting '/' will give you status 200
        $response->assertStatus(200);


        //so, the whole testing feature here only to make sure that visiting the '/'
        //.. will give you status 200 and nothing else!
    }
}
