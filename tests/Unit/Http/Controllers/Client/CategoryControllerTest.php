<?php

namespace Tests\Unit\Http\Controllers\Client;

use App\Http\Controllers\Client\CategoryController;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Tests\TestCase;
use Mockery as m;

class CategoryControllerTest extends TestCase
{
    protected $mockCategoryRepo;
    protected $mockProductRepo;

    public function setUp()
    {
        $this->afterApplicationCreated(function () {
            $this->mockProductRepo = m::mock($this->app->make(ProductRepositoryInterface::class));
            $this->mockCategoryRepo = m::mock($this->app->make(CategoryRepositoryInterface::class));
        });
        parent::setUp();
    }

    public function test_detail_throw_exception()
    {
        $response = $this->call('GET', route('client.category.detail', ['id' => 0]));
        $this->assertNotNull($response->exception->getMessage());
        $response->assertStatus(500);
    }

    public function test_detail_return_view_with_data()
    {
        $this->mockCategoryRepo->shouldReceive('findOrFail');
        $this->mockProductRepo->shouldReceive('getByCategoryId')->once();
        $controller = new CategoryController($this->mockCategoryRepo, $this->mockProductRepo);
        $view = $controller->detail(1);

        $this->assertEquals('client.categories.detail', $view->getName());
        $this->assertArrayHasKey('products', $view->getData());
        $this->assertArrayHasKey('category', $view->getData());
    }

    public function test_query_product_with_category_id()
    {
        $this->mockCategoryRepo->shouldReceive('findOrFail')->once();
        $this->mockProductRepo->shouldReceive('filterByCategoryId')->once();
        $controller = new CategoryController($this->mockCategoryRepo, $this->mockProductRepo);
        $view = $controller->filter(1, config('custome.filter_by.price_descending'));

        $this->assertEquals('client.categories.filter', $view->getName());
        $this->assertArrayHasKey('products', $view->getData());
        $this->assertArrayHasKey('filterBy', $view->getData());
    }
}
