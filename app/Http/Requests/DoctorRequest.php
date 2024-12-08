<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DoctorRequest extends FormRequest
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
            'practice_license' => 'required|string|max:20|unique:doctors,practice_license,' . $id,
            'name' => 'required|string|max:50',
            'phone_number' => 'required|string|max:15',
            'address' => 'required|string',
            'specialty_id' => 'required|numeric',
        ];
    }
}
