<?php

namespace App\Http\Controllers\Admin;

use App\Models\Suggest;
use App\Repositories\Suggest\SuggestRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SuggestController extends Controller
{
    protected $suggestRepo;

    public function __construct(SuggestRepositoryInterface $suggestRepo)
    {
        $this->suggestRepo = $suggestRepo;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $paginate = config('custome.paginate_suggest');
        $suggests = $this->suggestRepo->paginate('id', 'DESC', $paginate);

        return view('admin.suggests.index', ['suggests' => $suggests]);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function delete($id)
    {
        try {
            if ($this->suggestRepo->delete($id)) {
                return redirect()->back();
            }
        } catch (ModelNotFoundException $ex) {
            throw new \Exception($ex->getMessage());
        }
    }
}
