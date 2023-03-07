<?php

namespace App\Http\Requests;

use App\Enums\TaskStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Enum;

class TaskRequest extends FormRequest
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
            'id' => ['sometimes', 'required', 'exists:tasks'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'due_date' => ['required', 'date'],
            'status' => ['sometimes', 'required', new Enum(TaskStatus::class)]
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
            'id.exists' => 'This task does not exists in our records.',
            'title.required' => 'Task title is required.',
            'description.required' => 'Task description is required.',
            'due_date.required' => 'Due date for the task is required.',
            'status.required' => 'Current status of the task is required.',
            'status.enum' => 'Staus can only be either: To-do, Ongoing, Closed, Removed',
        ];
    }
}
