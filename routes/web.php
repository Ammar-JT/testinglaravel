<?php

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

Route::get('/asdf', function () {
    return view('welcome');
});




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

- let's try break the example feature test by sending wrong view "view('wel')".. do the test: 
        vendor/bin/phpunit 
  it will give you error 500 (), now change the endpoint uri '/' >>>> '/asdf'
  .. do the test again, it will gives you 404 which means the endpoint doesn't even exist!

- ok, let's also try to break our unit test by returning false instead of true 
            $this->assertTrue(falses);

*/



//----------------------------------------------------------------------
//                  Testing
//-----------------------------------------------------------------------
/*
- Usually you write code then you write test for that code, but we will use the opposite approch
  .. which is a test driven development, write test then write code. 


- to make a test for feature: 
        php artisan make:test AboutPageTest 
  For unit: 
        php artisan make:test AboutPageTest --unit
  but we want the feature now, so do the first one

*/
