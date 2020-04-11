<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PenjualanRequest extends FormRequest
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
            'name_pembeli' => 'required',
            'barang.*' => 'required',
            'qty.*' => 'required|numeric|max:100'
        ];
    }

    public function messages()
    {
        return [
            'name_pembeli.required' => 'field name tidak boleh kosong!',
            'barang.*.required' => 'field barang tidak boleh kosong!',
            'qty.*.required' => 'field quantity tidak boleh kosong!',
            'qty.*.numeric' => 'field yang di masukan berupa angka!'
        ];

    }
}