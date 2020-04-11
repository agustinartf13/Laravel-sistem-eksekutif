<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServisRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name_mekanik' => 'required',
            'motor' => 'required',
            'name_customer' => 'required',
            'no_polis' => 'required',
            'motor' => 'required',
            'keluhan' => 'required',
            'km_datang' => 'required',
            'tipe_servis' => 'required',
            'waktu_servis' => 'required',
            'harga_jasa' => 'required',
            'status' => 'required',
            // 'barang' => 'required',
            // 'quantitiy' => 'required',
        ];
    }
}