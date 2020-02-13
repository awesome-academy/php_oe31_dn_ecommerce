<?php

namespace Tests\Unit\Http\Controllers\Admin;

use App\Http\Controllers\Admin\HomeController;
use App\Models\Order;
use App\Repositories\Order\OrderRepositoryInterface;
use Tests\TestCase;
use Mockery as m;

class HomeControllerTest extends TestCase
{
    protected $mockOrderRepo;
    protected $controller;

    protected function setUp()
    {
        parent::setUp();
        $this->afterApplicationCreated(function () {
            $this->mockOrderRepo = m::mock($this->app->make(OrderRepositoryInterface::class));
        });
        $this->controller = new HomeController($this->mockOrderRepo);

    }

    public function test_index_return_view()
    {
        $view = $this->controller->index();

        $this->assertEquals('admin.home.index', $view->getName());
    }

    public function test_statistic_return_json()
    {
        $orders = Order::orderBy('created_at', 'DESC')->take(7);
        $this->mockOrderRepo->shouldReceive('getOrderLatest')
            ->once()->andReturn($orders);
        $response = $this->controller->statistic();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertArrayHasKey('data_price', $response->getOriginalContent());
        $this->assertArrayHasKey('data_created_at', $response->getOriginalContent());
        $this->assertArrayHasKey('title', $response->getOriginalContent());
    }
}
