<?php

namespace Tests\Unit\Http\Controllers\Admin;

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Models\Role;
use App\Models\User;
use App\Repositories\Category\CategoryRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Tests\TestCase;
use Mockery as m;

class CategoryControllerTest extends TestCase
{
    protected $userAdmin;
    protected $mockCategoryRepo;
    protected $controller;
    protected $categoryRequest;

    protected function setUp()
    {
        parent::setUp();
        $this->afterApplicationCreated(function () {
            $this->mockCategoryRepo = m::mock($this->app->make(CategoryRepositoryInterface::class));
        });
        $this->controller = new CategoryController($this->mockCategoryRepo);
        $this->categoryRequest = new CategoryRequest();
        $this->userAdmin = factory(User::class)->make();
        $this->userAdmin->role_id = Role::SUPER_ADMIN;
    }

    public function test_index_return_view()
    {
        $this->mockCategoryRepo->shouldReceive('paginate')->once();
        $view = $this->controller->index();

        $this->assertEquals('admin.categories.index', $view->getName());
        $this->assertArrayHasKey('categories', $view->getData());
    }

    public function test_create_return_view()
    {
        $view = $this->controller->create();

        $this->assertEquals('admin.categories.create', $view->getName());
    }

    public function test_store_error_validation()
    {
        $this->withoutMiddleware();
        $response = $this->post(route('categories.store', ['id' => 1]), []);

        $response->assertSessionHasErrors('name');
    }

    public function test_store_success_redirect()
    {
        $this->withoutMiddleware();
        $this->mockCategoryRepo->shouldReceive('create')->once();
        $redirect = $this->controller->store($this->categoryRequest);

        $this->assertInstanceOf(RedirectResponse::class, $redirect);
        $this->assertArrayHasKey('createSuccess', $redirect->getSession()->all());
    }

    public function test_show_return_view()
    {
        $this->mockCategoryRepo->shouldReceive('findOrFail')->once();
        $view = $this->controller->show(1);

        $this->assertEquals('admin.categories.detail', $view->getName());
        $this->assertArrayHasKey('category', $view->getData());
    }

    public function test_can_not_update_parent()
    {
        $category = new Category(['name' => 'Category test']);
        $category->id = 1;
        $this->mockCategoryRepo->shouldReceive('findOrFail')->with(1)
            ->once()->andReturn($category);
        $request = $this->categoryRequest;
        $request->request->add(['parent' => 1]);
        $request->setMethod('PUT');
        $redirect = $this->controller->update($request, 1);

        $this->assertInstanceOf(RedirectResponse::class, $redirect);
        $this->assertArrayHasKey('status', $redirect->getSession()->all());
    }

    public function test_update_success_redirect()
    {
        $this->mockCategoryRepo->shouldReceive('update')
            ->once()->andReturn(true);
        $request = $this->categoryRequest;
        $redirect = $this->controller->update($this->categoryRequest, 1);

        $this->assertInstanceOf(RedirectResponse::class, $redirect);
        $this->assertArrayHasKey('updateSuccess', $redirect->getSession()->all());
    }

    public function test_delete_throw_exception()
    {
        $redirect = $this->actingAs($this->userAdmin)
            ->get(route('admin.category.delete', ['id' => 0]));

        $this->assertNotNull($redirect->exception->getMessage());
    }

    public function test_delete_success_redirect()
    {
        $this->mockCategoryRepo->shouldReceive('delete')
            ->once()->andReturn(true);
        $redirect = $this->controller->delete(1);

        $this->assertInstanceOf(RedirectResponse::class, $redirect);
    }
}
