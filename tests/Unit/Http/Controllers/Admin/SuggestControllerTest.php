<?php

namespace Tests\Unit\Http\Controllers\Admin;

use App\Http\Controllers\Admin\SuggestController;
use App\Repositories\Suggest\SuggestRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Tests\TestCase;
use Mockery as m;

class SuggestControllerTest extends TestCase
{
    protected $mockSuggestRepo;
    protected $controller;

    protected function setUp()
    {
        parent::setUp();
        $this->afterApplicationCreated(function () {
            $this->mockSuggestRepo = m::mock($this->app->make(SuggestRepositoryInterface::class));
        });
        $this->controller = new SuggestController($this->mockSuggestRepo);
    }

    public function test_index_return_view()
    {
        $this->mockSuggestRepo->shouldReceive('paginate')->once();
        $view = $this->controller->index();

        $this->assertEquals('admin.suggests.index', $view->getName());
        $this->assertArrayHasKey('suggests', $view->getData());
    }

    public function test_delete_success_redirect()
    {
        $this->mockSuggestRepo->shouldReceive('delete')
            ->once()->andReturn(true);
        $redirect = $this->controller->delete(1);

        $this->assertInstanceOf(RedirectResponse::class, $redirect);
    }
}
