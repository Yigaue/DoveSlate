<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function SignIn($user = null)
    {
        $user = $user ?: factory('App\User')->create();

        // receive the passed in user, but if there is none then create one
       $this->actingAs($user);

       return $user;
    }
}
