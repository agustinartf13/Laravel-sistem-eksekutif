<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PembelianRequest extends FormRequest
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
            'supplier' => 'required',
            'status' => 'required',
            'categories.*' => 'required',
            'barang.*' => 'required',
            'qty.*' => 'required|numeric|max:100'
        ];
    }

    public function messages()
    {
        return [
          'supplier.required' => 'field name supplier tidak boleh kosong!',
          'status.required' => 'kolom status harus diisi!',
          'categories.*.required' => 'field category tidak boleh kosong!',
          'barang.*.required' => 'field barang tidak boleh kosong!',
          'qty.*.required' => 'field jumlah barang harus diisi!'
        ];
    }
}