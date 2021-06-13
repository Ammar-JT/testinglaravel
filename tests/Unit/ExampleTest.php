<?php

namespace Tests\Unit;

//php unit is a unit testing class, so the test unit in laravel is actually built on 
//.. the unit test of php:
use PHPUnit\Framework\TestCase;
// try in cli: 
//       vendor/bin/phpunit
//it will do all the test



class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_example()
    {
        $this->assertTrue(true);
    }
}
