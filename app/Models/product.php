<?php

namespace App\Models;

class product{

    protected $name;
    protected $price;

    public function name()
    {
        return $this->name;
    }


    public function __construct($name,$price)
    {
        $this->name=$name;
        $this->price=$price;
    }


    public function price(){
        return $this->price;
    }
}
