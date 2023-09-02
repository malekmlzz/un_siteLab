<?php

namespace App\Http\Requests\Docter;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'full_name' => 'required|string|max:255',
            'national_code' => 'required|numeric',
            'doc_code' => 'required',
            'role' => 'required',
            'phon_number' => 'required|numeric',
            'password' => 'required|min:8',
        ];
    }
}
