<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Repositories\Category\CategoryRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    protected $categoryRepo;

    public function __construct(CategoryRepositoryInterface $categoryRepo)
    {
        $this->categoryRepo = $categoryRepo;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $paginate = config('custome.paginate_pro');
        $categories = $this->categoryRepo->paginate(null, null, $paginate);

        return view('admin.categories.index', ['categories' => $categories]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * @param CategoryRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CategoryRequest $request)
    {
        $data = [
            'name' => $request->name,
            'description' => $request->description,
        ];
        if ($request->has('parent')) {
            $data['parent_id'] = $request->parent;
        }
        $this->categoryRepo->create($data);

        return redirect()->back()->with('createSuccess', trans('custome.create_success'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function show($id)
    {
        try {
            $category = $this->categoryRepo->findOrFail($id);

            return view('admin.categories.detail', ['category' => $category]);
        } catch (ModelNotFoundException $ex) {
            throw new \Exception($ex->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * @param CategoryRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function update(CategoryRequest $request, $id)
    {
        try {
            $category = $this->categoryRepo->findOrFail($id);
            $attributes['name'] = $request->name;
            if ($request->has('parent') && $request->parent == $category->id) {
                return redirect()->back()->with('status', trans('custome.not_add_category_parent'));
            } else {
                $attributes['parent_id'] = $request->parent;
            }
            if ($request->has('description')) {
                $attributes['description'] = $request->description;
            }
            if ($this->categoryRepo->update($id, $attributes)) {
                return redirect()->back()->with('updateSuccess', trans('custome.update_success'));
            }
        } catch (ModelNotFoundException $ex) {
            throw new \Exception($ex->getMessage());
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function delete($id)
    {
        try {
            if ($this->categoryRepo->delete($id)) {
                return redirect()->back();
            }
        } catch (ModelNotFoundException $ex) {
            throw new \Exception($ex->getMessage());
        }
    }
}
