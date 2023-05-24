<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroydata_pembayaranRequest;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Models\data_pembayaran;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class BookController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('book_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = data_pembayaran::query()->select(sprintf('%s.*', (new data_pembayaran)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'pembayaran_show';
                $editGate      = 'pembayaran_edit';
                $deleteGate    = 'pembayaran_delete';
                $crudRoutePart = 'pembayarans';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('No', function ($row) {
                return $row->No ? $row->No : '';
            });
            $table->editColumn('Kode Pembayaran', function ($row) {
                return $row->KodePembayaran ? $row->KodePembayaran : '';
            });
            $table->editColumn('Jenis Pembayaran', function ($row) {
                return $row->Jenis ? $row->Jenis : '';
            });
            $table->editColumn('Metode Pembayaran', function ($row) {
                return $row->Metode ? $row->Metode : '';
            });
            $table->editColumn('Jumlah Bayar', function ($row) {
                return $row->Jumlah ? $row->Jumlah : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.pembayarans.index');
    }

    public function create()
    {
        abort_if(Gate::denies('pembayaran_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.pembayarans.create');
    }

    public function store(StoreBookRequest $request)
    {
        $book = data_pembayaran ::create($request->all());

        return redirect()->route('admin.pembayarans.index');
    }

    public function edit(data_pembayaran $book)
    {
        abort_if(Gate::denies('pembayaran_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.pembayarans.edit', compact('pembayaran'));
    }

    public function update(Updatedata_pembayaranRequest $request, data_pembayaran $pembayaran)
    {
        $pembayaran->update($request->all());

        return redirect()->route('admin.pembayarans.index');
    }

    public function show(data_pembayaran $pembayaran)
    {
        abort_if(Gate::denies('pembayaran_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.pembayarans.show', compact('pembayaran'));
    }

    public function destroy(data_pembayaran $pembayaran)
    {
        abort_if(Gate::denies('pembayaran_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $pembayaran->delete();

        return back();
    }

    public function massDestroy(MassDestroyBookRequest $request)
    {
        $pembayarans = data_pembayaran::find(request('ids'));

        foreach ($pembayarans as $pembayaran) {
            $pembayaran->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
