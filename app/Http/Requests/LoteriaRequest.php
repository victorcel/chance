<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoteriaRequest extends FormRequest
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
            'numero'=>'required|min:4|max:4'
        ];
    }
    public function messages()
    {
        return [
            'numero.required' => 'DIGITE NUMERO LOTERIA',
            'numero.max'  => 'NUMERO MAXIMO DE LA LOTERIA ES DE 4 DIGITOS',
            'numero.min'  => 'NUMERO MINIMO DE LA LOTERIA ES DE 4 DIGITOS',
        ];
    }
}
