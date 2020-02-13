<?php

namespace Tests\Unit\Http\Controllers\Admin;

use App\Http\Controllers\Admin\RevenueController;
use App\Models\Order;
use App\Repositories\Order\OrderRepositoryInterface;
use Carbon\Carbon;
use Tests\TestCase;
use Mockery as m;

class RevenueControllerTest extends TestCase
{
    protected $mockOrderRepo;
    protected $controller;
    protected $orders;

    protected function setUp()
    {
        parent::setUp();
        $this->afterApplicationCreated(function () {
            $this->mockOrderRepo = m::mock($this->app->make(OrderRepositoryInterface::class));
        });
        $this->controller = new RevenueController($this->mockOrderRepo);
        $this->orders = $orders = Order::orderBy('created_at', 'ASC')
            ->where('status', Order::SUCCESS)
            ->whereYear('created_at', Carbon::now()->year)
            ->get();
    }

    public function test_index_return_view()
    {
        $orders = Order::orderBy('created_at', 'DESC')->get();
        $this->mockOrderRepo->shouldReceive('orderBy')
            ->once()->andReturn($orders);

        $view = $this->controller->index();
        $this->assertEquals('admin.revenue.index', $view->getName());
        $this->assertArrayHasKey('years', $view->getData());
    }

    public function test_getCurrentMonth_return_json()
    {

        $this->mockOrderRepo->shouldReceive('getByTime')
            ->once()->andReturn($this->orders);
        $response = $this->controller->getCurrentMonth();

        $this->assertArrayHasKey('item', $response->getOriginalContent());
        $this->assertArrayHasKey('money', $response->getOriginalContent());
        $this->assertArrayHasKey('title', $response->getOriginalContent());
    }

    public function test_filterRevenue_return_json()
    {
        $this->mockOrderRepo->shouldReceive('getByTime')
            ->once()->andReturn($this->orders);
        $response = $this->controller->filterRevenue();

        $this->assertArrayHasKey('item', $response->getOriginalContent());
        $this->assertArrayHasKey('money', $response->getOriginalContent());
        $this->assertArrayHasKey('title', $response->getOriginalContent());
    }
}
