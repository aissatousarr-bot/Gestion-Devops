<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->role === 'admin';
    }

    public function rules(): array
    {
        $userId = $this->route('user');

        $rules = [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($userId)
            ],
            'phone_number' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:500'],
            'role' => ['required', 'in:admin,teacher,student,parent'],
            'status' => ['required', 'in:active,inactive'],
        ];

        // Règles spécifiques selon le rôle
        if ($this->input('role') === 'teacher') {
            $rules['specialty'] = ['required', 'string', 'max:255'];
            $rules['hire_date'] = ['required', 'date'];
        }

        if ($this->input('role') === 'student') {
            $rules['registration_number'] = [
                'required',
                'string',
                Rule::unique('students')->ignore($userId, 'user_id')
            ];
            $rules['birth_date'] = ['required', 'date'];
            $rules['gender'] = ['required', 'in:M,F'];
            $rules['classroom_id'] = ['required', 'exists:classrooms,id'];
        }

        if ($this->input('role') === 'parent') {
            $rules['occupation'] = ['nullable', 'string', 'max:255'];
            $rules['relationship_type'] = ['required', 'in:father,mother,guardian'];
            $rules['emergency_contact'] = ['required', 'string', 'max:20'];
        }

        if (!$userId) {
            $rules['password'] = ['required', Password::defaults()];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'first_name.required' => 'Le prénom est requis',
            'last_name.required' => 'Le nom est requis',
            'email.required' => 'L\'email est requis',
            'email.email' => 'L\'email doit être une adresse email valide',
            'email.unique' => 'Cet email est déjà utilisé',
            'role.required' => 'Le rôle est requis',
            'role.in' => 'Le rôle sélectionné n\'est pas valide',
            'status.required' => 'Le statut est requis',
            'status.in' => 'Le statut sélectionné n\'est pas valide',
            'password.required' => 'Le mot de passe est requis',
            'specialty.required' => 'La spécialité est requise',
            'hire_date.required' => 'La date d\'embauche est requise',
            'registration_number.required' => 'Le numéro de matricule est requis',
            'registration_number.unique' => 'Ce numéro de matricule est déjà utilisé',
            'birth_date.required' => 'La date de naissance est requise',
            'gender.required' => 'Le genre est requis',
            'gender.in' => 'Le genre sélectionné n\'est pas valide',
            'classroom_id.required' => 'La classe est requise',
            'classroom_id.exists' => 'La classe sélectionnée n\'est pas valide',
            'occupation.required' => 'L\'occupation est requise',
            'relationship_type.required' => 'Le type de relation est requis',
            'relationship_type.in' => 'Le type de relation sélectionné n\'est pas valide',
            'emergency_contact.required' => 'Le contact d\'urgence est requis',
        ];
    }
}
