<?php

namespace Tests\Unit\Http\Controllers\Client;

use App\Http\Controllers\Client\SuggestController;
use App\Http\Requests\SuggestRequest;
use App\Models\User;
use App\Repositories\Suggest\SuggestRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use Mockery as m;

class SuggestControllerTest extends TestCase
{
    protected $user;
    protected $mockSuggestRepo;
    protected $suggestRequest;
    protected $controller;

    protected function setUp()
    {
        parent::setUp();
        $this->user = factory(User::class)->make();
        $this->afterApplicationCreated(function () {
            $this->mockSuggestRepo = m::mock($this->app->make(SuggestRepositoryInterface::class));
        });
        $this->controller = new SuggestController($this->mockSuggestRepo);
        $this->suggestRequest = new SuggestRequest();
    }

    public function test_index_return_view()
    {
        $view = $this->controller->suggestGet();
        $this->assertEquals('client.suggest.index', $view->getName());
    }

    public function test_suggest_success_redirect()
    {
        $this->be($this->user);
        $this->mockSuggestRepo->shouldReceive('create')->once();
        $data = [
            'image' => UploadedFile::fake()->image('testing.jpg'),
            'content' => 'Do you have this item?',
        ];
        $request = new SuggestRequest();
        $request->request->add($data);
        $request->setMethod('POST');
        $redirect = $this->controller->suggestPost($request);

        $this->assertInstanceOf(RedirectResponse::class, $redirect);
        $this->assertEquals(302, $redirect->status());
        $this->assertArrayHasKey('suggestSuccess', $redirect->getSession()->all());
    }
}
