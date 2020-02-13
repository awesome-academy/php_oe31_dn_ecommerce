<?php

namespace Tests\Unit\Http\Controllers\Admin;

use App\Http\Controllers\Admin\UserController;
use App\Models\User;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Tests\TestCase;
use Mockery as m;

class UserControllerTest extends TestCase
{
    protected $mockUserRepo;
    protected $controller;
    protected $user;

    protected function setUp()
    {
        parent::setUp();
        $this->afterApplicationCreated(function () {
            $this->mockUserRepo = m::mock($this->app->make(UserRepositoryInterface::class));
        });
        $this->controller = new UserController($this->mockUserRepo);
        $this->user = factory(User::class)->make();
    }

    public function test_index_return_view()
    {
        $this->mockUserRepo->shouldReceive('paginate')->once();
        $view = $this->controller->index();

        $this->assertEquals('admin.users.index', $view->getName());
        $this->assertArrayHasKey('users', $view->getData());
    }

    public function test_lock_success_redirect()
    {
        $this->mockUserRepo->shouldReceive('update')
            ->once()->andReturn(true);
        $redirect = $this->controller->lock($this->user->id);

        $this->assertInstanceOf(RedirectResponse::class, $redirect);
    }

    public function test_active_success_redirect()
    {
        $this->mockUserRepo->shouldReceive('update')
            ->once()->andReturn(true);
        $redirect = $this->controller->active($this->user->id);

        $this->assertInstanceOf(RedirectResponse::class, $redirect);
    }
}
