<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LaundryStorage;
use App\Models\ServiceCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PublicStatusController extends Controller
{
    public function services(Request $request): JsonResponse
    {
        $perPage = min((int) $request->query('limit', 20), 100);
        $services = ServiceCategory::orderBy('service_type')
            ->orderBy('service_name')
            ->paginate($perPage);

        return response()->json([
            'data' => $services->items(),
            'pagination' => [
                'current_page' => $services->currentPage(),
                'per_page' => $services->perPage(),
                'total' => $services->total(),
                'has_more' => $services->hasMorePages(),
            ],
        ]);
    }

    public function track(Request $request): JsonResponse
    {
        $last4 = $request->query('phone_last4');

        if (!$last4 || !preg_match('/^[0-9]{4}$/', $last4)) {
            return response()->json([
                'type' => 'https://rakboim.local/errors/validation-error',
                'title' => 'Validation Error',
                'status' => 422,
                'detail' => 'Parameter phone_last4 wajib berupa tepat 4 digit terakhir nomor telepon.',
                'instance' => $request->getRequestUri(),
            ], 422, ['Content-Type' => 'application/problem+json']);
        }

        $items = LaundryStorage::with(['rack:id,rack_code', 'serviceCategory:id,service_name,unit_label'])
            ->where('customer_phone', 'like', "%{$last4}")
            ->latest('stored_at')
            ->limit(10)
            ->get(['id', 'storage_code', 'rack_id', 'service_category_id', 'customer_name', 'laundry_weight', 'total_price', 'storage_status', 'stored_at']);

        return response()->json([
            'data' => $items,
        ]);
    }
}
