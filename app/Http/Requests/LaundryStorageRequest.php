<?php

namespace App\Http\Requests;

use App\Models\ServiceCategory;
use Illuminate\Foundation\Http\FormRequest;

class LaundryStorageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'customer_name' => ['required', 'string', 'max:100'],
            'customer_phone' => ['required', 'regex:/^[0-9]{10,15}$/'],
            'rack_id' => ['required', 'exists:racks,id'],
            'service_category_id' => ['required', 'exists:service_categories,id'],
            'laundry_weight' => [
                'required',
                'numeric',
                'gt:0',
                function (string $attribute, mixed $value, \Closure $fail) {
                    $service = ServiceCategory::find($this->input('service_category_id'));
                    if ($service && $service->isKiloan() && (float) $value < (float) $service->min_weight_kg) {
                        $fail("Berat cucian untuk paket {$service->service_name} minimal {$service->min_weight_kg} kg.");
                    }
                },
            ],
            'include_delivery' => ['nullable', 'boolean'],
            'payment_status' => ['required', 'in:lunas,belum_lunas'],
            'storage_status' => ['required', 'in:tersimpan,siap_diambil,selesai'],
            'ironer_name' => ['nullable', 'string', 'max:100'],
            'notes' => ['nullable', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'customer_name.required' => 'Nama pelanggan wajib diisi.',
            'customer_phone.required' => 'Nomor telepon pelanggan wajib diisi.',
            'customer_phone.regex' => 'Nomor telepon harus berupa 10 hingga 15 digit angka tanpa spasi.',
            'rack_id.required' => 'Kode ID Rak penyimpanan wajib dipilih.',
            'service_category_id.required' => 'Paket layanan Boim Laundry wajib dipilih.',
            'laundry_weight.required' => 'Berat atau jumlah cucian wajib diisi.',
            'laundry_weight.gt' => 'Berat atau jumlah cucian harus lebih dari 0.',
        ];
    }
}
