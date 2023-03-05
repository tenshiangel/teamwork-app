<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::guest();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'birthdate' => 'required|date',
            'email' => 'required|email|unique:'.User::class,
            'password' => ['required', 'confirmed', Password::defaults()],
        ];
    }

    /**
     * Messages returned when the request fails.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function messages()
    {
        return [
            'first_name.required' => 'First name field is required.',
            'last_name.required' => 'Last name field is required.',
            'birthdate.required' => 'Birthdate field is required.',
            'email.required' => 'Email field is required.',
            'email.unique' => 'This email is already taken.',
            'password.required' => 'Password field is required.',
            'password.confirmed' => 'This doesn\'t match with the confirmed password.',
        ];
    }
}
