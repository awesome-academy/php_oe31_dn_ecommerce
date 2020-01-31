<?php

namespace App\Http\Controllers\Admin;

use App\Models\Suggest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SuggestController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $paginate = config('custome.paginate_suggest');
        $suggests = Suggest::orderBy('created_at', 'DESC')->paginate($paginate);

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
            $suggest = Suggest::findOrFail($id);
            $suggest->delete();

            return redirect()->back();
        } catch (ModelNotFoundException $ex) {
            throw new \Exception($ex->getMessage());
        }
    }
}
