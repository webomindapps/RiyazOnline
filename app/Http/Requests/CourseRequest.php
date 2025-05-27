<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseRequest extends FormRequest
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
            'course_name' => 'required',
            'description' => 'required',
            'new_student_fees' => 'required|numeric',
            'old_student_fees' => 'required|numeric',
            'priority' => 'required|numeric',
            'status' => 'nullable'
        ];
    }
}
