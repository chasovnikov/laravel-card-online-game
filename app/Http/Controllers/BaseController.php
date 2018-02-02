<?php

namespace App\Http\Controllers;

use App\Http\Requests\BaseRequest;
use Illuminate\Http\Request;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;

class BaseController extends Controller
{
    /**
     * @var BaseRepository
     */
    protected $repository;

    /**
     * @param BaseRepository $repository
     */
    public function __construct(BaseRepository $repository = null)
    {
        $this->repository = $repository;
    }

    /**
     * @param BaseRequest $request
     *
     * @return RedirectResponse
     */
    public function store(BaseRequest $request)
    {
        $this->repository->create($request);

        return redirect()->back();
    }

    /**
     * @param $id
     *
     * @return Model | null | static
     */
    public function edit($id)
    {
        return $this->repository->withTrashedWhere('id', $id)
            ->first();
    }

    /**
     * @param BaseRequest $request
     *
     * @return RedirectResponse
     */
    public function update(BaseRequest $request)
    {
        $this->repository->update($request);

        return redirect()->back();
    }

//    /**
//     * @param BaseRequest $request
//     * @param string      $column
//     *
//     * @return RedirectResponse
//     */
//    public function updateOnceColumn(BaseRequest $request, string $column)
//    {
//        $model = $this->repository->withTrashedWhere('id', $request->id)
//            ->first();
//
//        $input = $request->input($column);
//        dd($input);
//
//        $model->$column = $input;
//
//        $model->save();
//
//        return redirect()->back();
//    }

    /**
     * @param $id
     *
     * @return RedirectResponse | HttpException
     */
    public function destroy($id)
    {
        $this->repository->getById($id)
            ->delete();

        return redirect()->back();
    }

    /**
     * @param $id
     *
     * @return RedirectResponse | HttpException
     */
    public function forceDestroy($id)
    {
        $this->repository->withTrashedWhere('id', $id)
            ->forceDelete();

        return redirect()->back();
    }

    /**
     * @param $id
     *
     * @return RedirectResponse | HttpException
     */
    public function restore($id)
    {
        $this->repository->withTrashedWhere('id', $id)
            ->restore();

        return redirect()->back();
    }
}
