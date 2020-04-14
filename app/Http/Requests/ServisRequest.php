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
            'no_polis' => 'required|max:9',
            'keluhan' => 'required',
            'km_datang' => 'required|numeric',
            'tipe_servis' => 'required',
            'waktu_servis' => 'required',
            'harga_jasa' => 'required|numeric',
            'status' => 'required',
            'alamat' => 'required',
            'no_telphone' => 'required|numeric',
            'barang.*' => 'required',
            'qty.*' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name_mekanik.required' => 'field name mekanik tidak boleh kosong!',
            'motor.required' => 'field motor tidak boleh kosong!',
            'name_customer.required' => 'field name customer tidak boleh kosong!',
            'no_polis.required' => 'field no polis tidak boleh kosong!',
            'no_polis.max' => 'no polis tidak boleh lebih dari 9 digit!',
            'keluhan.required' => 'field keluhan tidak boleh kosong!',
            'km_datang.required' => 'field KM Datang tidak boleh kosong!',
            'km_datang.numeric' => 'field ini berupa tipe angka!',
            'tipe_service.required' => 'field tipe service tidak boleh kosong!',
            'waktu_servis.required' => 'field waktu service tidak boleh kosong!',
            'harga_jasa.required' => 'field harga jasa tidak boleh kosong!',
            'harga_jasa.numeric' => 'field ini berupa tipe angka!',
            'status.required' => 'field status tidak boleh kosong',
            'alamat.required' => 'field alamat tidak boleh kosong',
            'no_telphone.required' => 'field no telphone tidak boleh kosong',
            'no_telphone.numeric' => 'field ini berupa tipe angka',
            // 'no_telphone.max' => 'field ini tidak boleh lebih dari 12 digit',
            'barang.*.required' => 'field barang tidak boleh kosong!',
            'qty.*.required' => 'field quantity tidak boleh kosong!',
        ];
    }
}