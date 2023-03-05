<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class PasswordUpdateRequest extends FormRequest
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
            'current_password' => 'required|current-password',
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
            'current_password.required' => 'Your current password is required to initiate this request.',
            'current_password.current-password' => 'Password given is incorrect.',
            'password.required' => 'Password field is required.',
            'password.confirmed' => 'This doesn\'t match with the confirmed password.',
        ];
    }
}
