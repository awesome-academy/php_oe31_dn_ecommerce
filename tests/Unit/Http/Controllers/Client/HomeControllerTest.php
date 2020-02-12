<?php

namespace Tests\Unit\Http\Controllers\Client;

use App\Http\Controllers\Client\HomeController;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\Trend\TrendRepositoryInterface;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery as m;

class HomeControllerTest extends TestCase
{
    protected $mockProductRepo;
    protected $mockTrendRepo;

    public function setUp()
    {
        $this->afterApplicationCreated(function () {
            $this->mockProductRepo = m::mock($this->app->make(ProductRepositoryInterface::class));
            $this->mockTrendRepo = m::mock($this->app->make(TrendRepositoryInterface::class));
        });
        parent::setUp();
    }

    public function test_index_return_view()
    {
        $this->mockTrendRepo->shouldReceive('getFirstTrend')->once();
        $this->mockProductRepo->shouldReceive('getRelatedProduct')->once();
        $controller = new HomeController($this->mockProductRepo, $this->mockTrendRepo);
        $view = $controller->index();

        $this->assertEquals('client.home.index', $view->getName());
        $this->assertArrayHasKey('productRelateds', $view->getData());
        $this->assertArrayHasKey('trend', $view->getData());
    }
}
