<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'username' => 'sometimes|string|min:3|max:15|lowercase|unique:users,username',
            'password' => 'sometimes|string|min:8|max:15|lowercase|confirmed:password_confirmation',
            'avatar' => 'sometimes|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }
}
