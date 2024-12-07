<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PatientRequest extends FormRequest
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
        // ambil id yang sedang di update request atau route
        $id = $this->route('id');

        return [
            'national_id' => 'required|string|max:16|unique:patients,national_id,' . $id,
            'name' => 'required|string|max:50',
            'gender' => 'required|in:Male,Female',
            'date_of_birth' => 'required|date',
            'phone_number' => 'required|string|max:15',
            'address' => 'required|string'

        ];
    }
}
