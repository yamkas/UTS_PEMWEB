<?php

namespace App\Http\Requests;

use App\Models\data_pembayaran;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroydata_pembayaranRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('pembayaran_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:pembayarans,id',
        ];
    }
}
