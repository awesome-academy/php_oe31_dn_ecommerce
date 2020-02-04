<?php

namespace Tests\Unit\Http\Controllers\Client;

use App\Models\Role;
use Tests\TestCase;
use App\Models\User;

class ProductControllerTest extends TestCase
{
    protected $user;

    protected function setUp()
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
    }

    public function test_index_return_view()
    {
        $response = $this->call('GET', 'products');
        $response->assertViewIs('client.products.index');
        $response->assertViewHas('products');
    }

    public function test_detail_return_view()
    {
        $response = $this->call('GET', 'product/1');
        $response->assertViewIs('client.products.detail');
        $response->assertViewHas('product');
    }

    public function test_detail_throw_exception()
    {
        $response = $this->call('GET', 'products/' . config('custome.count_item'));
        $response->assertStatus(404);
    }

    public function test_filter_return_view()
    {
        $response = $this->call('GET', 'products/filter/price_ascending');
        $response->assertViewIs('client.products.filter');
        $response->assertViewHas(['products', 'filterBy']);
    }

    public function test_comment_without_content()
    {
        $response = $this->actingAs($this->user)
            ->post(route('client.products.comment', ['id' => 1]), [
                'content' => '',
            ]);
        $response->assertSessionHasErrors('content');
    }

    public function test_comment_content_not_min()
    {
        $response = $this->actingAs($this->user)
            ->post(route('client.products.comment', ['id' => 1]), [
                'content' => 'abcxyzuio',
            ]);
        $response->assertSessionHasErrors('content');
    }

    public function test_comment_content_not_max()
    {
        $response = $this->actingAs($this->user)
            ->post(route('client.products.comment', ['id' => 1]), [
                'content' => str_repeat('abcxyzuioz', 110),
            ]);
        $response->assertSessionHasErrors('content');
    }

    public function test_comment_success()
    {
        $this->be($this->user);
        $response = $this->actingAs($this->user)
            ->post(route('client.products.comment', ['id' => 1]), [
                'content' => 'Can you show me about this product\'s price',
            ]);
        $response->assertStatus(302);
    }
}
