<?php

namespace Tests\Unit\Http\Controllers\Client;

use App\Http\Controllers\Client\OrderController;
use App\Http\Requests\OrderInforRequest;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Repositories\OrderDetail\OrderDetailRepositoryInterface;
use App\Repositories\OrderInfor\OrderInforRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;
use Mockery as m;

class OrderControllerTest extends TestCase
{
    protected $user;
    protected $mockOrderRepo;
    protected $mockOrderInfoRepo;
    protected $mockOrderDetailRepo;
    protected $mockProductRepo;
    protected $controller;
    protected $orderInforRequest;
    protected $dataOrderInfor;

    public function setUp()
    {
        parent::setUp();
        $this->afterApplicationCreated(function () {
            $this->mockOrderRepo = m::mock($this->app->make(OrderRepositoryInterface::class));
            $this->mockOrderInfoRepo = m::mock($this->app->make(OrderInforRepositoryInterface::class));
            $this->mockOrderDetailRepo = m::mock($this->app->make(OrderDetailRepositoryInterface::class));
            $this->mockProductRepo = m::mock($this->app->make(ProductRepositoryInterface::class));
        });

        $this->user = factory(User::class)->make();
        $this->user->id = 3;
        $this->controller = new OrderController(
            $this->mockOrderRepo, $this->mockOrderInfoRepo, $this->mockOrderDetailRepo, $this->mockProductRepo);
        $this->orderInforRequest = new OrderInforRequest();
        $this->dataOrderInfor = [
            'id' => 1,
            'name' => 'Demo Name Order',
            'phone' => '0988222111',
            'email' => 'demo.emailorder@gmail.com',
            'address' => 'information order testing',
            'city_id' => 1,
        ];
    }

    public function setUpCart()
    {
        $product = factory(Product::class)->make();
        $issetCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($issetCart);
        $cart->add($product, $product->id);
        session()->put('cart', $cart);
    }

    public function test_index_return_not_contain_cart()
    {
        $view = $this->controller->index();
        $this->assertEmpty($view->getData());
        $this->assertEquals('client.orders.index', $view->getName());
    }

    public function test_index_return_with_data()
    {
        $this->setUpCart();
        $view = $this->controller->index();

        $this->assertArrayHasKey('products', $view->getData());
        $this->assertArrayHasKey('totalPrice', $view->getData());
        $this->assertEquals('client.orders.index', $view->getName());
    }

    public function test_create_not_contain_cart()
    {
        $request = $this->orderInforRequest;
        $request->request->add($this->dataOrderInfor);
        $view = $this->controller->create($request);

        $this->assertEquals('client.orders.index', $view->getName());
        $this->assertEmpty($view->getData());
    }

    public function test_create_success()
    {
        $this->setUpCart();
        $this->be($this->user);
        $orderInfor = new OrderInforRequest($this->dataOrderInfor);
        $product = new Product([
            'id' => 1,
            'name' => 'prodcut testing name',
            'descripton' => 'product testing description',
            'price' => 50000,
            'quantity' => 1,
            'category_id' => 10,
        ]);
        $order = new Order([
            'id' => 1,
            'user_id' => $this->user->id,
            'order_infor_id' => $orderInfor->id,
            'status' => 1,
            'order_code' => 'testing_order_code',
            'total_price' => 50000,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        $this->mockOrderInfoRepo->shouldReceive('create')->once()->andReturn($orderInfor);
        $this->mockOrderRepo->shouldReceive('create')->once()->andReturn($order);
        $this->mockProductRepo->shouldReceive('findOrFail')->once()->andReturn($product);
        $this->mockProductRepo->shouldReceive('update')->once();
        $this->mockOrderDetailRepo->shouldReceive('create')->once();

        $request = $this->orderInforRequest;
        $request->request->add($this->dataOrderInfor);
        $view = $this->controller->create($request);

        $this->assertArrayHasKey('orderSuccess', $view->getData());
        $this->assertArrayHasKey('orderInfor', $view->getData());
        $this->assertArrayHasKey('orderCode', $view->getData());
        $this->assertArrayHasKey('products', $view->getData());
    }

    public function test_histories_return_view()
    {
        $this->be($this->user);
        $this->mockOrderRepo->shouldReceive('getOrderByUserId')->once();
        $view = $this->controller->histories();

        $this->assertArrayHasKey('orders', $view->getData());
        $this->assertEquals('client.orders.histories', $view->getName());
    }

    public function test_detail_return_view()
    {
        $this->mockOrderRepo->shouldReceive('findOrFail')->once();
        $view = $this->controller->detail(1);

        $this->assertArrayHasKey('order', $view->getData());
        $this->assertEquals('client.orders.detail', $view->getName());
    }
}
