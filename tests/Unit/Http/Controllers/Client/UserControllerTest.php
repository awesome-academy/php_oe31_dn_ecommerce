<?php

namespace Tests\Unit\Http\Controllers\Client;

use App\Http\Controllers\Client\UserController;
use App\Http\Requests\UserUpdateRequest;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Tests\TestCase;
use App\Models\User;
use Mockery as m;

class UserControllerTest extends TestCase
{
    protected $user;
    protected $mockUserRepo;
    protected $controller;
    protected $userUpdateRequest;

    protected function setUp()
    {
        parent::setUp();
        $this->user = factory(User::class)->make();
        $this->afterApplicationCreated(function () {
            $this->mockUserRepo = m::mock($this->app->make(UserRepositoryInterface::class));
        });
        $this->controller = new UserController($this->mockUserRepo);
        $this->userUpdateRequest = new UserUpdateRequest();
    }

    public function test_profile_return_view()
    {
        $this->mockUserRepo->shouldReceive('getCurrentUser')->once();
        $view = $this->controller->profile();

        $this->assertEquals('client.users.profile', $view->getName());
        $this->assertArrayHasKey('user', $view->getData());
    }

    public function test_update_error_validation()
    {
        $response = $this->actingAs($this->user)
            ->post(route('client.user.update', ['id' => 1]), []);

        $response->assertSessionHasErrors('name');
        $response->assertSessionHasErrors('phone');
        $response->assertSessionHasErrors('email');
        $response->assertSessionHasErrors('city');
    }

    public function test_update_success_redirect()
    {
        $this->be($this->user);
        $this->mockUserRepo->shouldReceive('update')
            ->once()->andReturn(true);
        $request = $this->userUpdateRequest;
        $data = [
            'name' => 'New name update',
            'phone' => '0988222111',
            'email' => 'email.update.test@gmail.com',
            'address' => 'information address testing',
            'city' => 1,
        ];
        $request->request->add($data);
        $redirect = $this->controller->update($request);

        $this->assertInstanceOf(RedirectResponse::class, $redirect);
        $this->assertEquals(302, $redirect->status());
        $this->assertArrayHasKey('updateSuccess', $redirect->getSession()->all());
    }
}
