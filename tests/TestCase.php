<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use App\Models\User;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Acting as an admin
     */
    protected function actingAsAdmin()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        return $this;
    }
}
