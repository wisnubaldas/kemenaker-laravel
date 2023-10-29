<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewDraftUsulanRequest extends FormRequest
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
        //dd(request()->all());
        return [
            "no_surat_usulan"=>"required|max:100",
            'file_surat_usulan' => 'nullable|file|mimes:pdf|max:25000',
           // 'usulanTenderDetails.*.nama_tender' => 'required',
        ];
    }

    public function messages():array
    {
        return[
            "no_surat_usulan.required"=>"No surat usulan tidak boleh kosong",
            "no_surat_usulan.max"=>"No surat usulan tidak boleh lebih dari 100 karakter",
            "file_surat_usulan.file"=>"Surat harus berupa file",
            "file_surat_usulan.mimes"=>"File harus berupa PDF",
            "file_surat_usulan.max"=>"File tidak boleh lebih dari 25Mb",
            //"usulanTenderDetails.*.nama_tender.required" => 'Nama Tender tidak boleh kosong',
        ];
    }
}
