<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class UsersTest extends TestCase

{
    use DatabaseMigrations;

    /**
     * Checks whether current user instance is the authenticated user.
     */
    public function test_a_user_instance_can_be_identified_as_myself()
    {
        $user = factory('App\User')->create();
        $myself = $user->isMyself($user);

        $this->assertTrue($myself);
    }

    /**
     * Checks whether the current user does not have administrator privileges.
     */
    public function test_a_user_instance_can_be_identified_as_a_non_administrator()
    {
        $user = factory('App\User')->create();

        $this->assertNotTrue($user->isAdmin());
    }

    /**
     * Checks whether the current user does have administrator privileges.
     */
    public function test_a_user_instance_can_be_identified_as_an_administrator()
    {
        $user = factory('App\User')->create(['is_admin' => 1]);

        $this->assertNotFalse($user->isAdmin());
    }
}
