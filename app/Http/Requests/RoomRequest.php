<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoomRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->user()->role === 'admin';
    }

    public function rules()
    {
        $roomId = $this->route('room');

        return [
            'name' => ['required', 'string', 'max:255'],
            'number' => ['required', 'string', 'max:50', 'unique:rooms,number' . ($roomId ? ",$roomId" : '')],
            'type' => ['required', 'in:classroom,lab,conference,other'],
            'capacity' => ['required', 'integer', 'min:1'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'in:available,maintenance,occupied'],
            'floor' => ['nullable', 'string', 'max:50'],
            'building' => ['nullable', 'string', 'max:100']
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Le nom de la salle est requis',
            'number.required' => 'Le numéro de la salle est requis',
            'number.unique' => 'Ce numéro de salle est déjà utilisé',
            'capacity.required' => 'La capacité est requise',
            'capacity.min' => 'La capacité doit être supérieure à 0'
        ];
    }
}
