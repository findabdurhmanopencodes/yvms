<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class StoreVolunteerRequest extends FormRequest
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
        // $date = new Carbon();
        // dump($date->format('d/m/Y'));
        // dd($this->request->get('dob'));
        // dd('ab');
        return [
            'first_name' => ['required', 'string', 'min:2', 'max:50'],
            'father_name' => ['required', 'string', 'min:2', 'max:50'],
            'grand_father_name' => ['required', 'string', 'min:2', 'max:50'],
            'disability' => ['sometimes',],
            'dob' => ['required', 'date_format:d/m/Y'],
            'gender' => ['required'],
            'phone' => ['required', 'regex:/^(\+251|0)9[0-9]{8}/', 'unique:volunteers,phone'],
            'email' => ['required', 'email', 'unique:volunteers,id'],
        ];
    }
}
