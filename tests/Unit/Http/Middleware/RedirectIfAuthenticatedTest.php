<?php

namespace Tests\Unit\Http\Middleware;

use App\Http\Middleware\Authenticate;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;

class RedirectIfAuthenticatedTest extends TestCase
{
    protected $user;

    public function setUp()
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
    }

    public function test_it_if_not_login()
    {
        $request = Request::create('/orders', 'GET');
        $middleware = new RedirectIfAuthenticated;
        $response = $middleware->handle($request, function () {});

        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(route('client.login.get'), $response->headers->get('Location'));
        $this->assertEquals(302, $response->status());
    }

    public function test_it_redirect_if_logged_in()
    {
        $request = new Request();
        $next = function ($request) {
            return new Response('Response Content');
        };

        $this->actingAs($this->user);
        $middleware = new RedirectIfAuthenticated;
        $response = $middleware->handle($request, $next);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(200, $response->status());
        $this->assertEquals('Response Content', $response->getContent());
    }
}
