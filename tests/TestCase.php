<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use App\Models\User;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected $user;

    public function signIn($user=null)
    {
        if(!$user)
        {
            $user=User::factory()->create();
        }

        $this->user=$user;

        $this->actingAs($this->user);

        return $this;
    }
}
