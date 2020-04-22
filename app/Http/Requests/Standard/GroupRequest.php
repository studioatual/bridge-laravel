<?php

namespace App\Http\Requests\Standard;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GroupRequest extends FormRequest
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

    public function validationData()
    {
        $data = array_filter($this->all());

        if (isset($data['cnpj'])) {
            $data['cnpj'] = preg_replace('/\D/', '', $data['cnpj']);
        }

        return $data;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:50',
            'cnpj' => ['required', 'cnpj', Rule::unique('standard_groups')->ignore($this->group)],
        ];
    }

    public function messages()
    {
        return [
            'required' => 'Campo é obrigatório',
            'max' => 'Tamanho máximo permitido :max caracteres',
            'unique' => 'Valor já existe',
            'cnpj' => 'Cnpj inválido',
        ];
    }
}
