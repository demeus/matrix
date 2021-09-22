<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'service.title' => ['required'],
            'service.slug' => 'nullable|unique:services,slug,' . $this->service['id'] ?? 'NULL',
            'service.content' => ['required'],
            'service.active' => ['boolean'],
        ];
    }
}
