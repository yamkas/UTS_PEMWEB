<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Http\Resources\Admin\BookResource;
use App\Models\data_pembayaran;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class data_pembayaranApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('book_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new data_pembayaranResource(data_pembayaran::all());
    }

    public function store(StoreBookRequest $request)
    {
        $pembayaran = data_pembayaran::create($request->all());

        return (new data_pembayaranResource($pembayaran))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(data_pembayaran $pembayaran)
    {
        abort_if(Gate::denies('book_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new BookResource($pembayaran);
    }

    public function update(UpdateBookRequest $request, Book $book)
    {
        $book->update($request->all());

        return (new BookResource($book))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Book $book)
    {
        abort_if(Gate::denies('book_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $book->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
