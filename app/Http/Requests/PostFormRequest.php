<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostFormRequest extends FormRequest
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
            'title' => 'required|min:5|max:20',
            'content' => 'required|min:5|max:200'
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'El titulo es requerido',
            'title.min' => 'El titulo debe contener de al menos 5 caracteres',
            'title.max' => 'El titulo no debe sobrepasar los 20 caracteres',
            'content.required' => 'El contenido es requerido',
            'content.min' => 'El contenido debe contener de al menos 5 caracteres',
            'content.max' => 'El contenido no debe sobrepasar los 200 caracteres'
        ];
    }
}
