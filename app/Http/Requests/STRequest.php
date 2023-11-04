<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class STRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "nomor_st"=>"required|max:100",
            "tgl_st" => 'required',
            "anggota"=>'required|array'
        ];
    }
    public function messages():array
    {
        return[
            "nomor_st.required"=>"No Surat Tugas tidak boleh kosong",
            "tgl_st.required"=>"Tanggal ST tidak boleh kosong",
            "anggota.required"=>"Harus pilih minimal 1 anggota pokja",
        ];
    }
}
