<?php

namespace App\Http\Requests;

use Andegna\DateTimeFactory;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

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
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'msc_document.required_if' => 'The MSC document field is required when educational level is MSC & PHD.',
            'phd_document.required_if' => 'The PHD document field is required when educational level is PHD.',
            'non_pregnant_validation_document.required_if' => 'The Non Pregnant Validation document field is required when gender is Female.',

        ];
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $maxGraduationYear = Carbon::now()->subYear(0);
        $minGraduationYear = Carbon::now()->subYear(35);
        $maxGraduationYear = DateTimeFactory::fromDateTime($maxGraduationYear)->format('Y');
        $minGraduationYear = DateTimeFactory::fromDateTime($minGraduationYear)->format('Y');
        return [
            'agree_check' => ['required', 'accepted'],
            //first wizard validation
            'photo' => ['required', 'image', 'max:4096', 'mimes:png,jpg,jpeg,bmp,tiff'],
            'first_name' => ['required', 'string', 'min:2', 'max:50','regex:/^[a-z A-Z ]+$/'],
            'first_name' => ['required', 'string', 'min:2', 'max:50','regex:/^[a-z A-Z ]+$/'],
            'father_name' => ['required', 'string', 'min:2', 'max:50','regex:/^[a-z A-Z ]+$/'],
            'grand_father_name' => ['required', 'string', 'min:2', 'max:50','regex:/^[a-z A-Z ]+$/'],
            // 'disability' => ['sometimes',],
            'dob' => ['required', 'date_format:d/m/Y'],
            'gender' => ['required'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'phone' => ['required', 'regex:/^(\+251|0)9[0-9]{8}/', 'unique:volunteers,phone'],
            'email' => ['required', 'email', 'unique:volunteers,email'],
            //second wizard validation
            'region' => ['required'],
            'zone' => ['required'],
            'woreda' => ['required'],
            //Eductional Documents
            'educational_level' => ['required', 'numeric', 'min:0', 'max:3'],
            'field_of_study' => ['required'],
            'gpa' => ['required', 'numeric', 'between:2.0,4.0'],
            'graduation_date' => ['required', 'numeric','min:'.$minGraduationYear,'max:'.$maxGraduationYear],
            'ministry_document' => ['required', 'file', 'max:4096', 'mimes:pdf,png,jpg,jpeg,bmp,tiff',],
            'bsc_document' => ['required', 'file', 'max:4096', 'mimes:pdf,png,jpg,jpeg,bmp,tiff', 'max:4096',],
            'msc_document' => ['required_if:educational_level,==,1', 'required_if:educational_level,==,2', 'file', 'max:4096', 'mimes:pdf,png,jpg,jpeg,bmp,tiff',],
            'phd_document' => ['required_if:educational_level,==,2', 'file', 'max:4096', 'mimes:pdf,png,jpg,jpeg,bmp,tiff',],
            //Other Mandatory Documents
            'contact_name' => ['required','regex:/^[a-z A-Z ]+$/'],
            'contact_phone' => ['required', 'regex:/^(\+251|0)9[0-9]{8}/', 'unique:volunteers,phone'],
            'kebele_id' => ['required', 'file', 'max:4096', 'mimes:pdf,png,jpg,jpeg,bmp,tiff',],
            'ethical_license' => ['required', 'file', 'max:4096', 'mimes:pdf,png,jpg,jpeg,bmp,tiff',],
            'non_pregnant_validation_document' => ['required_if:gender,==,F', 'file', 'max:4096', 'mimes:pdf,png,jpg,jpeg,bmp,tiff',],

        ];
    }
}
