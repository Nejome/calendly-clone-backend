<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required']
        ] + ($this->isMethod('posts')? $this->store() : $this->update());
    }

    public function store()
    {
        return [
          'email' => ['required', Rule::unique('users', 'email')],
          'password' => ['required']
        ];
    }

    public function update()
    {
        return [
            'email' => ['required', Rule::unique('users', 'email')->ignore(auth()->user())],
            'password' => ['nullable']
        ];
    }
}
