<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            // regras de validação para os campos do product
            'name'        => 'required',
            'description' => 'required|min:20',           
            'price'       => 'required',
            'photos.*'    => 'image',
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
            'regex'    => 'O formato do :attribute não é válido.',
            'image'    => 'O arquivo não é uma imagem válida.',
        ];
    }
}
