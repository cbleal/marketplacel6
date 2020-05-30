<?php

namespace App\Http\Requests;

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
            // regras de validação para os campos de store
            'name'         => 'required',
            'description'  => 'required|min:15',
            'phone'        => 'required',
            'mobile_phone' => 'required',
            'logo'         => 'image',
        ];
    }

    /**
     * Retorna as mensagens de validação do FormRequest
     */
    public function messages()
    {
        return [
            'required' => 'O campo :attribute é obrigatório.',
            'min'      => 'O campo :attribute deve ter no mínimo :min caracteres.',
            'image'    => 'O arquivo não é uma imagem válida.',
        ];
    }
}
