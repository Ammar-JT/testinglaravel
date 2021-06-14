<?php

use App\Models\Post;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



/*
---------------
      t1
---------------

Route::get('/asdf', function () {
    return view('wel');
});

Route::get('/about', function(){
    return "About Me";
});

*/

//---------------
//      t1
//---------------

Route::get('/', function () {
    return view('welcome');
});

Route::get('/about', function(){
    return view('about');
});

Route::get('posts/{id}', [App\Http\Controllers\PostsController::class, 'index']);

Route::get('posts', [App\Http\Controllers\PostsController::class, 'showAllPosts']);

Route::post('store-post', [App\Http\Controllers\PostsController::class, 'storePost']);








//----------------------------------------------------------------------
//                Introduction to Testing using laravel ExampleTests
//-----------------------------------------------------------------------
/*
- Why test? cuz sometime a team member change some code by mistake, 
  .. which will destroy everything if you push the code to production!
  .. So, to avoid that you can make testing for every single function in your system!!
  .. which means if something changed, you're gonna know before pushing that to production
  .. and it will save your project.

- You have unit test and feature test, still donno the difference, 
  ..but you can check out the examples: tests/Feature/ExampleTest  + tests/Unit/ExampleTest 

- Ahhh, now I know the different: 
        Unit Test: for classes, models, methods and so on.. it's mostly for the dev point of view
        Feature Test: for requsts, for visiting page and so on.. mostly for the user point of view


- let's try break the example feature test by sending wrong view "view('wel')".. do the test: 
        vendor/bin/phpunit 
  it will give you error 500 (), now change the endpoint uri '/' >>>> '/asdf'
  .. do the test again, it will gives you 404 which means the endpoint doesn't even exist!

- ok, let's also try to break our unit test by returning false instead of true 
            $this->assertTrue(falses);




*/



//----------------------------------------------------------------------
//                  Writing Our First Test
//-----------------------------------------------------------------------
/*
- Usually you write code then you write test for that code, but we will use the opposite approch
  .. which is a test driven development, write test then write code. 

----------
    t1
----------
- to make a test for feature: 
        php artisan make:test AboutPageTest 
  For unit: 
        php artisan make:test AboutPageTest --unit
  but we want the feature now, so do the first one

- go see the AboutPageTest for: 
        //you use this function to see the error before render it into a view, cuz when laravel
        //.. see an error it render it to view, with this you see the error when testing,
        //.. without it you won't see a detailed infos about the error when run >> vendor/bin/phpunit <<: 
        $this->withoutExceptionHandling();


        //simply the test will send a get request to visit /about page.. and the response will stored in resp
        $resp = $this->get('/about');

        //here is the test assertion, you can do it as the one in ExampleTest.php: 
        $resp->assertStatus(200); 

        //or you can do this also: 
        $resp->assertSee('About Me'); 


        //now run to do all the test: 
        //      vendor/bin/phpunit

- to fix the 404 error just make the about route correctly
- to fix `Failed asserting that '' contains "About Me".`.... just return "About Me" in the route

----------
    t2
----------
- let's do the same test but returning a view instead of a string: 
        return view('welcome')
        return view('about')  
  to pass this test, view must contain 'About Me'
*/



//----------------------------------------------------------------------
//                Demo App using Test Driven Development 
//                + Test Class ViewABlogPostTest{}
//                + Test function testCanViewABlogPost()
//-----------------------------------------------------------------------
/*

- To make an app with this approach, Kati Frantz recommend to start thinking with feature test (user view)
  .. and for that, we should build functions and tests from the first things that user see to the less things:
        // viewing posts
        // view post

- Also, In every test usually we have 3 steps: 
        //1- Arrangement
        //2- Action
        //3- Assertion

- In the blog case, we will make that: 
        //1- Arrangement
            //create a blog post
        //2- Action
            //visiting a route
        //3- Assertion
            //assert status code 200 << means route and view working good
            //assert that we see post title 
            //assert that we see post body
            //assert that we see post published dates


- So, let's get started:
        php artisan make:test ViewABlogPostTest
  fill it with your tests

- do >> vendor/bin/phpunit << you will see the error details one by one while you fixing it
        error
        - make Post Model + import it in the test class
        error
        - fix the mass assignment problem
        error
        - set up db
        error: post table not founded
        - make migration
        error
        - Used DatabaseMigrations trait in your test class
        error
        - Added title and body columns to the posts table
        error: it render the error and didn't gave as detailed error 
        - added '$this->withoutExceptionHandling();' in the begining of 'ViewABlogPostTest' class's function
        error: NotFoundHttpException: GET http://testinglaravel.test/posts/1
        - create the route for the single post here
        error: Failed asserting that 'A simple title' contains "A simply body".
        - return a view for single post with post
        error
        - create the view post.blade.php
        error
        - we echo $post->title + $post->body
        error
        - echo created_at
        Success!!!!!

- DatabaseMigrations trait: will migrate tables >> after you done all your tests >> it roll the tables back!!!

- Now, all tests been passed, but the code is very bad and not scalable and not even using the mvc
  .. here we have to fix that by ourselfs, so.. make PostsController@index, yeah not even --resource

- Now, do the same, test >> error >> fix error => test >> error >> fix erro => test >> success!!

------

- we want to put a new test function inside the same class ViewABlogPostTest: 
        testViewsA404PageWhenPostIsNotFound()
- in this method we will skip the 1-arrang step cuz there is nothing to arrange

- now, If you want to run only this test not all the test, you can add it to group
  .. and to add it to group, USE THE COMMENT!!!!!!!
  .. yes, use the comment, write:
        /**
         * @group post-not-found
         * 
         *
         * /
        public function testViewsA404PageWhenPostIsNotFound(){}
  Incredible right???

- now, to run this test group do this: 
        vendor/bin/phpunit --group post-not-found

- let's back to business: 
        error: Trying to get property 'title' of non-object
        - fix >>> PostsController@index(id){ $post = Post::findOrFail($id);} <<< not just find($id)
        error: No query results for model [App\Models\Post] INVALID_ID
        - fix same $post::findOrFail($id) but with try{ $post::findOrFail($id); }catche($e){ return 'asdf';}
        error: Expected status code 404 but received 200.
        - we don't want it a success responde XD we want it a fail response!! use: abort(404, 'Page not found');
        error: NotFoundHttpException: GET http://testinglaravel.test/posts/INVALID_ID
        - Why? cuz abort() return the 404 ok, but didn't return a the view 404... so make views/errors/404.blade.php
          .. and the abort() function will call it automatically
        error: NotFoundHttpException: GET http://testinglaravel.test/posts/INVALID_ID 
        - Same error?? yes, why?? cuz we used >> $this->withoutExceptionHandling(); << in the test function,
          .. which means laravel won't render the error into a view, 
          .. which means abort() won't return the view that we made >> views/errors/404.blade.php <<
        error: Failed asserting that '' contains "The page you are looking for could not be found".
        - easy, just write taht in the 404.blade.php
        Success!!!!!!!!


        






*/




//----------------------------------------------------------------------
//                Demo App using Test Driven Development 
//                + Test function testViewsA404PageWhenPostIsNotFound()
//-----------------------------------------------------------------------
/*
- We want to put a new test function inside the same class ViewABlogPostTest: 
        testViewsA404PageWhenPostIsNotFound()
- in this method we will skip the 1-arrang step cuz there is nothing to arrange

- now, If you want to run only this test not all the test, you can add it to group
  .. and to add it to group, USE THE COMMENT!!!!!!!
  .. yes, use the comment, write:
        /**
         * @group post-not-found
         * 
         *
         * /
        public function testViewsA404PageWhenPostIsNotFound(){}
  Incredible right???

- now, to run this test group do this: 
        vendor/bin/phpunit --group post-not-found

- let's back to business: 
        error: Trying to get property 'title' of non-object
        - fix >>> PostsController@index(id){ $post = Post::findOrFail($id);} <<< not just find($id)
        error: No query results for model [App\Models\Post] INVALID_ID
        - fix same $post::findOrFail($id) but with try{ $post::findOrFail($id); }catche($e){ return 'asdf';}
        error: Expected status code 404 but received 200.
        - we don't want it a success responde XD we want it a fail response!! use: abort(404, 'Page not found');
        error: NotFoundHttpException: GET http://testinglaravel.test/posts/INVALID_ID
        - Why? cuz abort() return the 404 ok, but didn't return a the view 404... so make views/errors/404.blade.php
          .. and the abort() function will call it automatically
        error: NotFoundHttpException: GET http://testinglaravel.test/posts/INVALID_ID 
        - Same error?? yes, why?? cuz we used >> $this->withoutExceptionHandling(); << in the test function,
          .. which means laravel won't render the error into a view, 
          .. which means abort() won't return the view that we made >> views/errors/404.blade.php <<
        error: Failed asserting that '' contains "The page you are looking for could not be found".
        - easy, just write taht in the 404.blade.php
        Success!!!!!!!!

*/



//----------------------------------------------------------------------
//                Demo App using Test Driven Development 
//                + Test function testViewsA404PageWhenPostIsNotFound()
//-----------------------------------------------------------------------
/*
- We want to put a new test function inside the same class ViewABlogPostTest: 
        testViewsA404PageWhenPostIsNotFound()
- in this method we will skip the 1-arrang step cuz there is nothing to arrange

- now, If you want to run only this test not all the test, you can add it to group
  .. and to add it to group, USE THE COMMENT!!!!!!!
  .. yes, use the comment, write:
        /**
         * @group post-not-found
         * 
         *
         * /
        public function testViewsA404PageWhenPostIsNotFound(){}
  Incredible right???

- now, to run this test group do this: 
        vendor/bin/phpunit --group post-not-found

- let's back to business: 
        error: Trying to get property 'title' of non-object
        - fix >>> PostsController@index(id){ $post = Post::findOrFail($id);} <<< not just find($id)
        error: No query results for model [App\Models\Post] INVALID_ID
        - fix same $post::findOrFail($id) but with try{ $post::findOrFail($id); }catche($e){ return 'asdf';}
        error: Expected status code 404 but received 200.
        - we don't want it a success responde XD we want it a fail response!! use: abort(404, 'Page not found');
        error: NotFoundHttpException: GET http://testinglaravel.test/posts/INVALID_ID
        - Why? cuz abort() return the 404 ok, but didn't return a the view 404... so make views/errors/404.blade.php
          .. and the abort() function will call it automatically
        error: NotFoundHttpException: GET http://testinglaravel.test/posts/INVALID_ID 
        - Same error?? yes, why?? cuz we used >> $this->withoutExceptionHandling(); << in the test function,
          .. which means laravel won't render the error into a view, 
          .. which means abort() won't return the view that we made >> views/errors/404.blade.php <<
        error: Failed asserting that '' contains "The page you are looking for could not be found".
        - easy, just write taht in the 404.blade.php
        Success!!!!!!!!

*/


//----------------------------------------------------------------------
//           Demo App using Test Driven Development: Unit Tests
//-----------------------------------------------------------------------
/*
- Now we finished the basic feature test, we need a unit tests for a cleaner code
- make a feature test:
        php artisan make:test PostTest --unit

- now create a function, with the same testing steps: 
        public function testCanGetCreatedAtFormattedDate(){
            //same steps:
                //arrange
                    //create post
                //act
                    //get the value by calling the method
                //assertion
                    //assert that returned value is as we expect
        }

- fill the test class up, and make createdAt() function in the Post model

- I really don't know why, but replace: 
        use PHPUnit\Framework\TestCase;
  with: 
        use Tests\TestCase;
  first one is for unit test and second one for the feature test, but we won't use it
  .. even with uint test!! still donno why, but doing that the code works!

- I really must find the replacement of: 
                $this->withoutExceptionHandling();
  In Laravel 8, cuz that what makes the whole problem

*/


//---------------------------------------------------------------------------------------------------------
//          Demo App using Test Driven Development: All Posts + create posts (back to Feature Test)
//---------------------------------------------------------------------------------------------------------
/*
- do this: 
        php artisan make:test ViewAllBlogPostsTest

- easy, do it like the previous feature tests
- in this one, we just created 2 posts, and make sure that they exist in all post view

------

- do the same, this: 
        php artisan make:test CreatePostsTest
- in this one, we created a post,, and then we make sure that the exact post exist in dbs
*/


//---------------------------------------------------------------------------------------------------------
//          Demo App using Test Driven Development: 
//          testing validation
//---------------------------------------------------------------------------------------------------------
/*
- to test validation, we make sure that title is required in the validation and works well

- make function inside the same test class CreatePostsTest{} called:
        testTitleIsRequiredToCreatePost()
        testBodyIsRequiredToCreatePost()
- use assertSessionHasErrors() function to make sure there is an error session for validation


*/

//---------------------------------------------------------------------------------------------------------
//          Laravel Dusk (Testing Library)
//---------------------------------------------------------------------------------------------------------
/*
- php unit test is good, but it too traditional, you can use civilized library for testing 
  .. like Laravel Dusk

- Document is way much better than me in explaination: 
        https://laravel.com/docs/8.x/dusk

- add the depandancy in your project
        composer require --dev laravel/dusk

- if you want the dusk to act like a user and have auth, you should register it in service
  .. provider, but that is very dangorous if you are app in production, 
  .. NEVER put it in service provider of a production app

- install it in app: 
        php artisan dusk:install



*/


