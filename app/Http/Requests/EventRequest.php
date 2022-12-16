<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
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
            'event_type_id' => 'required',
            'invited_name' => 'required',
            'invited_email' => 'required|email',
            'day' => 'required|date',
            'time' => 'required|date_format:H:i',
            'link' => 'nullable',
        ];
    }
}
