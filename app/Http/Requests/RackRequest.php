<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RackRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isPemilik();
    }

    public function rules(): array
    {
        $rackId = $this->route('rack')?->id;

        return [
            'rack_code' => ['required', 'string', 'max:20', Rule::unique('racks', 'rack_code')->ignore($rackId)],
            'cabinet_number' => ['required', 'string', 'max:20'],
            'column_number' => ['required', 'string', 'max:20'],
            'max_capacity_kg' => ['required', 'numeric', 'min:5', 'max:500'],
            'status' => ['required', 'in:tersedia,penuh,perbaikan'],
        ];
    }

    public function messages(): array
    {
        return [
            'rack_code.required' => 'Kode ID Rak wajib diisi (contoh: RAK-04-K1).',
            'rack_code.unique' => 'Kode ID Rak tersebut sudah terdaftar.',
            'max_capacity_kg.min' => 'Kapasitas maksimal rak minimal 5 kg.',
        ];
    }
}
