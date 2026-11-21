<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ServiceCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isPemilik();
    }

    public function rules(): array
    {
        $id = $this->route('serviceCategory')?->id;

        return [
            'category_code' => ['required', 'string', 'max:20', Rule::unique('service_categories', 'category_code')->ignore($id)],
            'service_type' => ['required', 'in:kiloan_reguler,kiloan_express,satuan,tambahan'],
            'service_name' => ['required', 'string', 'max:100'],
            'unit_label' => ['required', 'string', 'max:20'],
            'price' => ['required', 'numeric', 'min:1000'],
            'min_weight_kg' => ['required', 'numeric', 'min:0'],
            'estimated_hours' => ['required', 'integer', 'min:1'],
        ];
    }
}
