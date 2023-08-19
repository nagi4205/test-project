<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'content' => 'required | max:200',
            'image' => 'nullable | max:2048 | mimes:jpg,jpeg,png,gif',
            'latitude' => 'nullable | numeric',
            'longitude' => 'nullable | numeric',
            'tag' => 'required | exists:tags,id',
            'location_name' => 'nullable',
            'parent_id' => 'nullable',
        ];
    }
}
