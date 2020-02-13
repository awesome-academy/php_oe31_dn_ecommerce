<?php

namespace App\Http\Controllers\Client;

use App\Repositories\Suggest\SuggestRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\SuggestRequest;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class SuggestController extends Controller
{
    protected $suggestRepo;

    public function __construct(SuggestRepositoryInterface $suggestRepo)
    {
        $this->middleware('auth');
        $this->suggestRepo = $suggestRepo;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function suggestGet()
    {
        return view('client.suggest.index');
    }

    /**
     * @param SuggestRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function suggestPost(SuggestRequest $request)
    {
        try {
            $storaPath = storage_path(config('custome.path_storage_suggest'));
            $imageName = time() . '_' . $request->image->getClientOriginalName();
            $request->image->move($storaPath, $imageName);
            $this->suggestRepo->create([
                'user_id' => auth()->user()->id,
                'image' => $imageName,
                'content' => $request->content,
            ]);

            return redirect()->back()
                ->with(['suggestSuccess' => trans('custome.suggest_success')]);
        } catch (FileException $exception) {
            throw new \Exception($exception->getMessage());
        }
    }
}
