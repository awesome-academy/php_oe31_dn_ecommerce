<?php

namespace Tests\Unit\Http\Controllers\Client;

use App\Http\Controllers\Client\ProductController;
use App\Http\Requests\CommentRequest;
use App\Http\Requests\RatingRequest;
use App\Models\Comment;
use App\Repositories\Comment\CommentRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\Rating\RatingRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Tests\TestCase;
use App\Models\User;
use Mockery as m;

class ProductControllerTest extends TestCase
{
    protected $user;
    protected $mockCommentRepo;
    protected $mockProductRepo;
    protected $mockRatingRepo;
    protected $controller;
    protected $commentRequest;
    protected $ratingRequest;

    protected function setUp()
    {
        parent::setUp();
        $this->user = factory(User::class)->make();
        $this->afterApplicationCreated(function () {
            $this->mockProductRepo = m::mock($this->app->make(ProductRepositoryInterface::class));
            $this->mockCommentRepo = m::mock($this->app->make(CommentRepositoryInterface::class));
            $this->mockRatingRepo = m::mock($this->app->make(RatingRepositoryInterface::class));
        });
        $this->controller = new ProductController($this->mockCommentRepo, $this->mockProductRepo, $this->mockRatingRepo);
        $this->commentRequest = new CommentRequest();
        $this->ratingRequest = new RatingRequest();
    }

    public function test_index_return_view()
    {
        $this->mockProductRepo->shouldReceive('paginate')->once();
        $view = $this->controller->index();

        $this->assertEquals('client.products.index', $view->getName());
        $this->assertArrayHasKey('products', $view->getData());
    }

    public function test_detail_return_view()
    {
        $this->mockProductRepo->shouldReceive('findOrFail')->once();
        $view = $this->controller->detail(1);

        $this->assertEquals('client.products.detail', $view->getName());
        $this->assertArrayHasKey('product', $view->getData());
    }

    public function test_detail_throw_exception()
    {
        $response = $this->call('GET', route('client.products.detail', ['id' => 0]));

        $this->assertNotNull($response->exception->getMessage());
        $response->assertStatus(500);
    }

    public function test_filter_return_view()
    {
        $this->mockProductRepo->shouldReceive('filter')->once();
        $view = $this->controller
            ->filter(config('custome.filter_by.price_ascending'), config('custome.paginate_pro'));

        $this->assertEquals('client.products.filter', $view->getName());
        $this->assertArrayHasKey('products', $view->getData());
        $this->assertArrayHasKey('filterBy', $view->getData());
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
        $this->mockProductRepo->shouldReceive('findOrFail')->once();
        $this->mockCommentRepo->shouldReceive('create')->once();
        $redirect = $this->controller->comment($this->commentRequest, 1);

        $this->assertInstanceOf(RedirectResponse::class, $redirect);
        $this->assertEquals(302, $redirect->getStatusCode());
    }

    public function test_get_edit_comment_return_view()
    {
        $this->mockCommentRepo->shouldReceive('findOrFail')->once();
        $view = $this->controller->getEditComment(1);

        $this->assertEquals('client.products.comments.edit', $view->getName());
        $this->assertArrayHasKey('comment', $view->getData());
    }

    public function test_post_edit_comment_redirect()
    {
        $this->be($this->user);
        $comment = Comment::findOrFail(1);
        $this->mockCommentRepo->shouldReceive('findOrFail')->once()->andReturn($comment);
        $this->mockCommentRepo->shouldReceive('update')->once();
        $rediect = $this->controller->postEditComment($this->commentRequest);

        $this->assertInstanceOf(RedirectResponse::class, $rediect);
        $this->assertEquals(302, $rediect->getStatusCode());
    }

    public function test_rating_return_redirect_status_rated()
    {
        $this->mockRatingRepo->shouldReceive('checkOrderSuccess')->once()->andReturn(1);
        $this->mockRatingRepo->shouldReceive('checkUserRating')->once()->andReturn(1);
        $redirect = $this->controller->rating($this->ratingRequest, 1);

        $this->assertInstanceOf(RedirectResponse::class, $redirect);
        $this->assertArrayHasKey('statusRated', $redirect->getSession()->all());
    }

    public function test_can_not_rating()
    {
        $this->mockRatingRepo->shouldReceive('checkOrderSuccess')->once()->andReturn(0);
        $this->mockRatingRepo->shouldReceive('checkUserRating')->once()->andReturn(0);
        $this->be($this->user);
        $redirect = $this->controller->rating($this->ratingRequest, 1);

        $this->assertInstanceOf(RedirectResponse::class, $redirect);
        $this->assertArrayHasKey('notRating', $redirect->getSession()->all());
    }

    public function test_rating_success()
    {
        $this->mockRatingRepo->shouldReceive('checkOrderSuccess')->once()->andReturn(1);
        $this->mockRatingRepo->shouldReceive('checkUserRating')->once()->andReturn(0);
        $this->mockRatingRepo->shouldReceive('create')->once();
        $this->be($this->user);
        $redirect = $this->controller->rating($this->ratingRequest, 1);

        $this->assertInstanceOf(RedirectResponse::class, $redirect);
        $this->assertArrayHasKey('ratingSuccess', $redirect->getSession()->all());
    }
}
