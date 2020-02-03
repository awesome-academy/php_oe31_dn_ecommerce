<?php

namespace Tests\Unit\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    public function test_fillable_attributes()
    {
        $user = new User();

        $this->assertEquals([
            'name',
            'phone',
            'email',
            'password',
            'gender',
            'birthdate',
            'address',
            'city_id',
            'role_id',
            'status',
        ], $user->getFillable());
    }

    public function test_hidden_attributes()
    {
        $user = new User();

        $this->assertEquals([
            'password',
        ], $user->getHidden());
    }

    public function test_relationship_with_city_model()
    {
        $user = new User();

        $this->assertInstanceOf(BelongsTo::class, $user->city());
    }

    public function test_relationship_with_role_model()
    {
        $user = new User();

        $this->assertInstanceOf(BelongsTo::class, $user->role());
    }

    public function test_relationship_with_rating_model()
    {
        $user = new User();

        $this->assertInstanceOf(HasMany::class, $user->ratings());
    }

    public function test_relationship_with_comment_model()
    {
        $user = new User();

        $this->assertInstanceOf(HasMany::class, $user->comments());
    }
}
