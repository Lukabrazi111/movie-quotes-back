<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name' => 'required|string|min:3|max:15|lowercase|unique:users,name',
            'email' => 'required|email|string|unique:users,email',
            'password' => 'required|string|min:8|max:15|lowercase|confirmed:password_confirmation',
            'password_confirmation' => 'required',
        ];
    }
}
