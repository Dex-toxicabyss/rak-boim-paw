<?php

namespace App\Http\Controllers;

use App\Http\Requests\LaundryStorageRequest;
use App\Models\LaundryStorage;
use App\Models\Rack;
use App\Models\ServiceCategory;
use App\Models\StorageLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class LaundryStorageController extends Controller
{
    public function index(Request $request): View
    {
        $filters = $request->only(['q', 'rack_id', 'status', 'sort']);

        $storages = LaundryStorage::with(['rack', 'serviceCategory', 'staff'])
            ->filter($filters)
            ->paginate(10)
            ->withQueryString();

        $racks = Rack::orderBy('rack_code')->get();

        return view('storages.index', compact('storages', 'racks', 'filters'));
    }

    public function create(): View
    {
        $racks = Rack::where('status', '!=', 'perbaikan')->orderBy('rack_code')->get();
        $categories = ServiceCategory::where('service_type', '!=', 'tambahan')
            ->orderBy('service_type')
            ->orderBy('service_name')
            ->get();

        return view('storages.create', compact('racks', 'categories'));
    }

    public function store(LaundryStorageRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $service = ServiceCategory::findOrFail($data['service_category_id']);
        $includeDelivery = $request->boolean('include_delivery');
        $totalPrice = $service->calculateTotal((float) $data['laundry_weight'], $includeDelivery);

        DB::transaction(function () use ($data, $includeDelivery, $totalPrice) {
            $storage = LaundryStorage::create([
                'storage_code' => LaundryStorage::generateCode(),
                'rack_id' => $data['rack_id'],
                'service_category_id' => $data['service_category_id'],
                'staff_id' => auth()->id(),
                'customer_name' => $data['customer_name'],
                'customer_phone' => $data['customer_phone'],
                'laundry_weight' => $data['laundry_weight'],
                'include_delivery' => $includeDelivery,
                'total_price' => $totalPrice,
                'payment_status' => $data['payment_status'],
                'storage_status' => $data['storage_status'],
                'stored_at' => now(),
            ]);

            $storage->rack->recalculateLoad();

            StorageLog::create([
                'log_code' => StorageLog::generateCode(),
                'laundry_storage_id' => $storage->id,
                'handled_by' => auth()->id(),
                'ironer_name' => $data['ironer_name'] ?? null,
                'verified_weight' => $storage->laundry_weight,
                'action_type' => 'masuk_rak',
                'logged_at' => now(),
                'notes' => $data['notes'] ?? "Masuk ke rak {$storage->rack->rack_code}",
            ]);
        });

        return redirect()->route('storages.index')
            ->with('success', 'Data penataan rak cucian berhasil disimpan dan beban rak diperbarui.');
    }

    public function edit(LaundryStorage $laundryStorage): View
    {
        $racks = Rack::where('status', '!=', 'perbaikan')
            ->orWhere('id', $laundryStorage->rack_id)
            ->orderBy('rack_code')
            ->get();
        $categories = ServiceCategory::where('service_type', '!=', 'tambahan')
            ->orderBy('service_type')
            ->orderBy('service_name')
            ->get();

        return view('storages.edit', compact('laundryStorage', 'racks', 'categories'));
    }

    public function update(LaundryStorageRequest $request, LaundryStorage $laundryStorage): RedirectResponse
    {
        $data = $request->validated();
        $oldRackId = $laundryStorage->rack_id;
        $service = ServiceCategory::findOrFail($data['service_category_id']);
        $includeDelivery = $request->boolean('include_delivery');
        $totalPrice = $service->calculateTotal((float) $data['laundry_weight'], $includeDelivery);

        DB::transaction(function () use ($laundryStorage, $data, $oldRackId, $includeDelivery, $totalPrice) {
            $laundryStorage->update([
                'rack_id' => $data['rack_id'],
                'service_category_id' => $data['service_category_id'],
                'customer_name' => $data['customer_name'],
                'customer_phone' => $data['customer_phone'],
                'laundry_weight' => $data['laundry_weight'],
                'include_delivery' => $includeDelivery,
                'total_price' => $totalPrice,
                'payment_status' => $data['payment_status'],
                'storage_status' => $data['storage_status'],
            ]);

            $laundryStorage->refresh();
            $laundryStorage->rack->recalculateLoad();

            if ($oldRackId !== (int) $data['rack_id']) {
                Rack::find($oldRackId)?->recalculateLoad();
            }

            $action = match (true) {
                $data['storage_status'] === 'selesai' => 'serah_terima_ambil',
                $oldRackId !== (int) $data['rack_id'] => 'pindah_rak',
                default => 'masuk_rak',
            };

            StorageLog::create([
                'log_code' => StorageLog::generateCode(),
                'laundry_storage_id' => $laundryStorage->id,
                'handled_by' => auth()->id(),
                'ironer_name' => $data['ironer_name'] ?? null,
                'verified_weight' => $laundryStorage->laundry_weight,
                'action_type' => $action,
                'logged_at' => now(),
                'notes' => $data['notes'] ?? "Status diperbarui menjadi {$data['storage_status']} di rak {$laundryStorage->rack->rack_code}",
            ]);
        });

        return redirect()->route('storages.index')
            ->with('success', 'Data penyimpanan cucian dan kapasitas rak berhasil diperbarui.');
    }

    public function destroy(LaundryStorage $laundryStorage): RedirectResponse
    {
        $rack = $laundryStorage->rack;
        $laundryStorage->delete();
        $rack->recalculateLoad();

        return redirect()->route('storages.index')
            ->with('success', 'Arsip cucian selesai telah dihapus dan kapasitas rak dibebaskan.');
    }
}
