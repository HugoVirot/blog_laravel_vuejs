<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;  // tous les utilisateurs peuvent s'inscrire
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'pseudo' => 'required|string|min:4|max:25|unique:users',
            'email' => 'required|email|min:7|max:50|unique:users',
            'password' => [
                'required', 'confirmed', 'string',
                Password::min(8) // minimum 8 caractères   
                    ->mixedCase() // au moins 1 minuscule et une majuscule
                    ->letters()  // au moins une lettre
                    ->numbers() // au moins un chiffre
                    ->symbols() // au moins un caractère spécial parmi ! @ # $ % ^ & * ?  
            ],
            'image' => 'nullable|image|mimes:jpg,jpeg,png,svg|max:2048'
        ];
    }

    public function messages()
    {
        return [
            'pseudo.required' => 'Le pseudo est requis.',
            'pseudo.string' => 'Le pseudo doit être une chaîne de caractères.',
            'pseudo.min' => 'Le pseudo doit faire au moins 4 caractères.',
            'pseudo.max' => 'Le pseudo ne doit pas dépasser 25 caractères.',
            'email.unique' => 'Pseudo déjà utilisé.',
            'email.required' => 'L\'email est requis.',
            'email.email' => 'Email invalide.',
            'pseudo.min' => 'L\'email doit faire au moins 7 caractères.',
            'pseudo.max' => 'L\'email ne doit pas dépasser 50 caractères.',
            'email.unique' => 'Email déjà utilisé.',
            'password.required' => 'Le mot de passe est requis.',
            'password.string' => 'Le mot de passe doit être une chaîne de caractères.',
            'password.min' => 'Le mot de passe doit faire au moins 8 caractères.',
            'password.confirmed' => 'Confirmation du mot de passe incorrecte.',
        ];
    }
}
