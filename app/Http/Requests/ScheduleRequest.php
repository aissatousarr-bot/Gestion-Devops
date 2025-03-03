<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScheduleRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->user()->role === 'admin';
    }

    public function rules()
    {
        return [
            'classroom_id' => ['required', 'exists:classrooms,id'],
            'subject_id' => ['required', 'exists:subjects,id'],
            'teacher_id' => ['required', 'exists:teachers,id'],
            'room_id' => ['required', 'exists:rooms,id'],
            'day' => ['required', 'in:monday,tuesday,wednesday,thursday,friday,saturday'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => [
                'required',
                'date_format:H:i',
                'after:start_time'
            ],
            'semester' => ['required', 'in:S1,S2'],
            'academic_year' => ['required', 'regex:/^\d{4}-\d{4}$/'],
            'status' => ['required', 'in:active,cancelled'],
            'notes' => ['nullable', 'string', 'max:500']
        ];
    }

    public function messages()
    {
        return [
            'classroom_id.required' => 'La classe est requise',
            'subject_id.required' => 'La matière est requise',
            'teacher_id.required' => 'L\'enseignant est requis',
            'room_id.required' => 'La salle est requise',
            'day.required' => 'Le jour est requis',
            'start_time.required' => 'L\'heure de début est requise',
            'start_time.date_format' => 'Le format de l\'heure de début est invalide',
            'end_time.required' => 'L\'heure de fin est requise',
            'end_time.date_format' => 'Le format de l\'heure de fin est invalide',
            'end_time.after' => 'L\'heure de fin doit être après l\'heure de début',
            'semester.required' => 'Le semestre est requis',
            'academic_year.required' => 'L\'année académique est requise',
            'academic_year.regex' => 'Le format de l\'année académique est invalide (YYYY-YYYY)'
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'start_time' => $this->start_time ? date('H:i', strtotime($this->start_time)) : null,
            'end_time' => $this->end_time ? date('H:i', strtotime($this->end_time)) : null,
        ]);
    }
}
