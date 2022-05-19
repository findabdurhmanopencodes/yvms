<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTrainingMasterRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'first_name' => ['required', 'string', 'max:255', 'min:3'],
            'father_name' => ['required', 'string', 'max:255', 'min:3'],
            'grand_father_name' => ['required', 'string', 'max:255', 'min:3'],
            'dob' => ['required', 'date_format:d/m/Y'],
            'gender' => ['required', 'string', 'in:M,F'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,id,' . request()->get('user')],
            'bank_account' => ['required', 'string', 'min:13'],
        ];
    }
}
