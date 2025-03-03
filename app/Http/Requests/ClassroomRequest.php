<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClassroomRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->user()->role === 'admin';
    }

    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'section' => ['required', 'string', 'max:255'],
            'level' => ['required', 'integer', 'min:1', 'max:12'],
            'capacity' => ['required', 'integer', 'min:1'],
            'academic_year' => ['required', 'string', 'regex:/^\d{4}-\d{4}$/'],
            'status' => ['required', 'in:active,inactive'],
            'teacher_ids' => ['nullable', 'array'],
            'teacher_ids.*' => ['exists:teachers,id']
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Le nom de la classe est requis',
            'section.required' => 'La section est requise',
            'level.required' => 'Le niveau est requis',
            'capacity.required' => 'La capacité est requise',
            'academic_year.required' => 'L\'année académique est requise',
            'academic_year.regex' => 'L\'année académique doit être au format YYYY-YYYY',
        ];
    }
}
