<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubjectRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->user()->role === 'admin';
    }

    public function rules()
    {
        $subjectId = $this->route('subject');

        return [
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:20', 'unique:subjects,code' . ($subjectId ? ",$subjectId" : '')],
            'description' => ['nullable', 'string'],
            'coefficient' => ['required', 'numeric', 'min:0.1', 'max:10'],
            'hours_per_week' => ['required', 'integer', 'min:1', 'max:20'],
            'status' => ['required', 'in:active,inactive'],
            'teacher_ids' => ['nullable', 'array'],
            'teacher_ids.*' => ['exists:teachers,id']
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Le nom de la matière est requis',
            'code.required' => 'Le code de la matière est requis',
            'code.unique' => 'Ce code est déjà utilisé',
            'coefficient.required' => 'Le coefficient est requis',
            'hours_per_week.required' => 'Le nombre d\'heures par semaine est requis'
        ];
    }
}
