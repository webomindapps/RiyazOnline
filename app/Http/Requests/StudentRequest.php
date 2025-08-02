<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'f_name' => 'required',
            'l_name' => 'required',
            'email' => 'required|email:rfc,dns',
            'phone' => 'required|regex:/^([1-9][0-9\s\-\+\(\)]*)$/|min:10',
            'phone_2' => 'required|different:phone',
            'course' => 'required',
            'country_id' => 'required',
            'state_id' => 'required',
            'city' => 'nullable',
            'photo' => 'mimes:jpeg,jpg,png,gif|max:10000',
            'date_joining' => 'nullable|date',
            'dob' => 'nullable|date',
            'age' => 'required',
            'gender' => 'nullable',
            'father_name' => 'nullable',
            'mother_name' => 'nullable',
            'current_address' => 'nullable',
            'permanent_address' => 'nullable',
            'emg_contact_person' => 'nullable',
            'emg_contact_no' => 'required|regex:/^([1-9][0-9\s\-\+\(\)]*)$/|min:10',
            'emg_relation' => 'nullable',
            'student_whatsapp_no' => 'nullable|regex:/^([1-9][0-9\s\-\+\(\)]*)$/|min:10',
            'payment_type' => 'required',
            'latest_paid_date' => 'required',
            'gst_no' => 'nullable',
            'reminder_date' => 'nullable',
            'reminder' => 'nullable',
            'date_joining' => 'nullable',
            'due_date' => 'nullable',
        ];
    }
}
