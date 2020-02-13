<?php

namespace Tests\Unit\Http\Controllers\Admin;

use App\Http\Controllers\Admin\CommentController;
use App\Repositories\Comment\CommentRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Tests\TestCase;
use Mockery as m;

class CommentControllerTest extends TestCase
{
    protected $mockCommentRepo;
    protected $controller;

    protected function setUp()
    {
        parent::setUp();
        $this->afterApplicationCreated(function () {
            $this->mockCommentRepo = m::mock($this->app->make(CommentRepositoryInterface::class));
        });
        $this->controller = new CommentController($this->mockCommentRepo);
    }

    public function test_index_return_view()
    {
        $this->mockCommentRepo->shouldReceive('paginate')->once();
        $view = $this->controller->index();

        $this->assertEquals('admin.comments.index', $view->getName());
        $this->assertArrayHasKey('comments', $view->getData());
    }

    public function test_active_success_redirect()
    {
        $this->mockCommentRepo->shouldReceive('update')
            ->once()->andReturn(true);
        $redirect = $this->controller->active(1);

        $this->assertInstanceOf(RedirectResponse::class, $redirect);
    }

    public function test_lock_success_redirect()
    {
        $this->mockCommentRepo->shouldReceive('update')
            ->once()->andReturn(true);
        $redirect = $this->controller->lock(1);

        $this->assertInstanceOf(RedirectResponse::class, $redirect);
    }

    public function test_delete_success_redirect()
    {
        $this->mockCommentRepo->shouldReceive('delete')
            ->once()->andReturn(true);
        $redirect = $this->controller->delete(1);

        $this->assertInstanceOf(RedirectResponse::class, $redirect);
    }
}
