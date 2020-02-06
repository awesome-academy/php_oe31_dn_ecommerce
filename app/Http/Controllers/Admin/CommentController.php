<?php

namespace App\Http\Controllers\Admin;

use App\Models\Comment;
use App\Repositories\Comment\CommentRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{
    protected $commentRepo;

    public function __construct(CommentRepositoryInterface $commentRepo)
    {
        $this->commentRepo = $commentRepo;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $paginate = config('custome.paginate_suggest');
        $comments = $this->commentRepo->paginate('created_at', 'DESC', $paginate);

        return view('admin.comments.index', ['comments' => $comments]);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function active($id)
    {
        try {
            $attributes['status'] = Comment::ACTIVE;
            if ($this->commentRepo->update($id, $attributes)) {
                return redirect()->back();
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
    public function lock($id)
    {
        try {
            $attributes['status'] = Comment::BLOCK;
            if ($this->commentRepo->update($id, $attributes)) {
                return redirect()->back();
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
            if($this->commentRepo->delete($id)) {
                return redirect()->back();
            }
        } catch (ModelNotFoundException $ex) {
            throw new \Exception($ex->getMessage());
        }
    }
}
