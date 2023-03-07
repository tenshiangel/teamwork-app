<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'birthdate' => ['required', 'date'],
            'email' => ['required', 'email', Rule::unique('users')->ignore(Auth::user()->id)],
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
        ];
    }
}
