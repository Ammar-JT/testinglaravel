<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AboutPageTest extends TestCase
{
    public function testCanViewAboutPage(){
        //you use this function to see the error before render it into a view, cuz when laravel
        //.. see an error it render it to view, with this you see the error when testing:
        $this->withoutExceptionHandling();


        //simply the test will send a get request to visit /about page.. and the response will stored in resp
        $resp = $this->get('/about');

        //here is the test assertion, you can do it as the one in ExampleTest.php: 
        $resp->assertStatus(200);

        //or you can do this also, which means the returning response should contain 'About Me'
        //.. not nessisary equal to 'About Me': s
        $resp->assertSee('About Me');


        //now run: 
        //      vendor/bin/phpunit

    }
}
