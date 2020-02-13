<?php

namespace Tests\Unit\Http\Controllers\Admin;

use App\Http\Controllers\Admin\OrderController;
use App\Repositories\Order\OrderRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Tests\TestCase;
use Mockery as m;

class OrderControllerTest extends TestCase
{
    protected $mockOrderRepo;
    protected $controller;

    protected function setUp()
    {
        parent::setUp();
        $this->afterApplicationCreated(function () {
            $this->mockOrderRepo = m::mock($this->app->make(OrderRepositoryInterface::class));
        });
        $this->controller = new OrderController($this->mockOrderRepo);
    }

    public function test_index_return_view()
    {
        $this->mockOrderRepo->shouldReceive('paginate')->once();
        $view = $this->controller->index();

        $this->assertEquals('admin.orders.index', $view->getName());
        $this->assertArrayHasKey('orders', $view->getData());
    }

    public function test_show_return_view()
    {
        $this->mockOrderRepo->shouldReceive('findOrFail')->once();
        $view = $this->controller->show(1);

        $this->assertEquals('admin.orders.detail', $view->getName());
        $this->assertArrayHasKey('order', $view->getData());
    }

    public function test_delete_success_redirect()
    {
        $this->mockOrderRepo->shouldReceive('delete')
            ->once()->andReturn(true);
        $redirect = $this->controller->delete(1);

        $this->assertInstanceOf(RedirectResponse::class, $redirect);
    }

    public function test_changeSucess_success_redirect()
    {
        $this->mockOrderRepo->shouldReceive('update')
            ->once()->andReturn(true);
        $redirect = $this->controller->changeSuccess(1);

        $this->assertInstanceOf(RedirectResponse::class, $redirect);
    }

    public function test_changePending_success_redirect()
    {
        $this->mockOrderRepo->shouldReceive('update')
            ->once()->andReturn(true);
        $redirect = $this->controller->changePending(1);

        $this->assertInstanceOf(RedirectResponse::class, $redirect);
    }

    public function test_changeCancel_success_redirect()
    {
        $this->mockOrderRepo->shouldReceive('update')
            ->once()->andReturn(true);
        $redirect = $this->controller->changeCancel(1);

        $this->assertInstanceOf(RedirectResponse::class, $redirect);
    }
}
