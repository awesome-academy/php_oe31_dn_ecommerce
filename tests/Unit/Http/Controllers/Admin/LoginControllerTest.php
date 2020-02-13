<?php

namespace Tests\Unit\Http\Controllers\Admin;

use App\Http\Controllers\Admin\LoginController;
use App\Http\Requests\LoginRequest;
use App\Models\Role;
use App\Repositories\User\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tests\TestCase;
use Mockery as m;

class LoginControllerTest extends TestCase
{
    protected $mockUserRepo;
    protected $controller;
    protected $loginRequest;

    protected function setUp()
    {
        parent::setUp();
        $this->afterApplicationCreated(function () {
            $this->mockUserRepo = m::mock($this->app->make(UserRepositoryInterface::class));
        });
        $this->controller = new LoginController($this->mockUserRepo);
        $this->loginRequest = new LoginRequest();
    }

    public function test_login_return_view()
    {
        $view = $this->controller->loginGet();

        $this->assertEquals('admin.login', $view->getName());
    }

    public function test_login_post_email_is_null_redirect()
    {
        $request = $this->loginRequest;
        $request->request->add([
            'email' => 'null.email@gmail.com',
            'password' => '123456',
        ]);
        $this->mockUserRepo->shouldReceive('getUserByEmail')->once();
        $redirect = $this->controller->loginPost($request);

        $this->assertArrayHasKey('status', $redirect->getSession()->all());
        $this->assertInstanceOf(RedirectResponse::class, $redirect);
    }

    public function test_login_exception()
    {
        $user = factory(User::class)->make();
        $this->mockUserRepo->shouldReceive('getUserByEmail')
            ->once()->andReturn($user);
        $request = $this->loginRequest;
        $request->request->add([
            'email' => $user->email,
            'password' => $user->password,
        ]);

        $this->expectException(HttpException::class);
        $redirect = $this->controller->loginPost($request);
    }

    public function test_login_success_redirect()
    {
        $redirect = $this->post(route('admin.login.post', [
            'email' => 'admin@gmail.com',
            'password' => 'secret',
        ]));

        $redirect->assertRedirect(route('admin.home.index'));
    }

    public function test_logout_success_redirect()
    {
        $redirect = $this->get(route('admin.logout'));

        $redirect->assertRedirect(route('admin.login.get'));
    }
}
