<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function SignIn($user = null)
    {
        // receive the passed in user, but if there is none then create one
        return $this->actingAs($user ?: factory('App\User')->create());
    }
}
