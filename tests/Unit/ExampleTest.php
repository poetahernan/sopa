<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\SopaController

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {


        $s= new  SopaController(['dato']) 
        $this->assertTrue($s->has('dato'));
        $this->assertTrue($s->has('otro'));
        
        //$this->assertTrue(true);
        
        
    }
}
