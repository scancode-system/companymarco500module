<?php

namespace Modules\CompanyMarco500\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SallerClientRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'saller_id' => 'required|integer|min:1',
            'date' => 'date',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
    
}
