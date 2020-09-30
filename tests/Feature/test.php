<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\product;

class test extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     *
     *
     */
    protected $product;

    public function setUp() :void
    {
        $this->product = new product('coca','2000');
    }
    public function testExample()
    {

        $this->assertEquals('coca',$this->product->name());
    }

    public function test_product_has_price()
    {
        $this->assertEquals('2000',$this->product->price());

    }
}
