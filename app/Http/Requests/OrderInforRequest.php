<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderInforRequest extends FormRequest
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
            'name' => 'required|min:10|max:50',
            'phone' => 'required|regex:/^([0-9]*)$/|min:10|max:11',
            'email' => 'required|email',
            'address' => 'required|min:20|max:100',
            'city' => 'required',
        ];
    }
}
