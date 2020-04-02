<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MachineRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'cpu_utilizavel' => ['required', 'numeric', 'min:25',],
            'ram_utilizavel' => ['required', 'numeric', 'min:128',],
        ];
    }

    public function messages()
    {
        return [
            'required' => 'O campo :attribute é obrigatório',
            'numeric'  => 'O campor :attribute é numérico',
            'min'      => 'Quantidade de :attribute informada está abaixo do permitido.'
        ];
    }
}
