<?php

namespace Tests\Unit\Http\Controllers\Admin;

use App\Http\Controllers\Admin\ProductController;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Image;
use App\Models\Product;
use App\Repositories\Image\ImageRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use Mockery as m;

class ProductControllerTest extends TestCase
{
    protected $controller;
    protected $mockProductRepo;
    protected $mockImageRepo;
    protected $productRequest;
    protected $productUpdateRequest;
    protected $product;
    protected $imageProduct;
    protected $dataUpdatRequest;

    protected function setUp()
    {
        parent::setUp();
        $this->afterApplicationCreated(function () {
            $this->mockProductRepo = m::mock($this->app->make(ProductRepositoryInterface::class));
            $this->mockImageRepo = m::mock($this->app->make(ImageRepositoryInterface::class));
        });
        $this->controller = new ProductController($this->mockProductRepo, $this->mockImageRepo);
        $this->productRequest = new ProductRequest();
        $this->productUpdateRequest = new ProductUpdateRequest();
        $this->product = factory(Product::class)->make();
        $this->product->id = 1;
        $this->imageProduct = new Image([
            'id' => 1,
            'name' => 'testing_imge_product',
            'type' => Image::FIRST,
            'product_id' => $this->product->id,
        ]);
        $this->dataUpdatRequest = $this->product->toArray();
        $this->dataUpdatRequest['image'] = UploadedFile::fake()->image('testing_product.jpg');
    }

    public function test_index_return_view()
    {
        $this->mockProductRepo->shouldReceive('paginate')->once();
        $view = $this->controller->index();

        $this->assertEquals('admin.products.index', $view->getName());
        $this->assertArrayHasKey('products', $view->getData());
    }

    public function test_create_return_view()
    {
        $view = $this->controller->create();
        $this->assertEquals('admin.products.create', $view->getName());
    }

    public function test_store_success()
    {

        $this->mockProductRepo->shouldReceive('create')
            ->andReturn($this->product)->once();
        $request = $this->productRequest;
        $request->request->add($this->dataUpdatRequest);
        $request->setMethod('POST');
        $redirect = $this->controller->store($request);

        $this->assertInstanceOf(RedirectResponse::class, $redirect);
        $this->assertEquals(302, $redirect->status());
        $this->assertArrayHasKey('createSuccess', $redirect->getSession()->all());
    }

    public function test_show_return_view()
    {
        $view = $this->controller->show(1);

        $this->assertEquals('admin.products.detail', $view->getName());
        $this->assertArrayHasKey('product', $view->getData());
    }

    public function test_update_success()
    {
        $request = $this->productUpdateRequest;
        $request->request->add($this->dataUpdatRequest);
        $request->setMethod('PUT');

        $this->mockImageRepo->shouldReceive('update')->once()->andReturn(true);
        $this->mockProductRepo->shouldReceive('update')->once()->andReturn(true);
        $this->mockImageRepo->shouldReceive('getFirstImageByProductId')
            ->once()->andReturn($this->imageProduct);
        $redirect = $this->controller->update($request, 1);

        $this->assertInstanceOf(RedirectResponse::class, $redirect);
        $this->assertEquals(302, $redirect->status());
        $this->assertArrayHasKey('updateSuccess', $redirect->getSession()->all());
    }

    public function test_delete_success_redirect()
    {
        $this->mockProductRepo->shouldReceive('delete')
            ->once()->andReturn(true);
        $redirect = $this->controller->delete(1);

        $this->assertInstanceOf(RedirectResponse::class, $redirect);
        $this->assertEquals(302, $redirect->status());
    }
}
