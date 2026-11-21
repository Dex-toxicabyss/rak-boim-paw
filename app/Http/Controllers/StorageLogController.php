<?php

namespace App\Http\Controllers;

use App\Models\LaundryStorage;
use App\Models\StorageLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StorageLogController extends Controller
{
    public function index(): View
    {
        $logs = StorageLog::with(['storage.rack', 'handler'])
            ->latest('logged_at')
            ->paginate(15);

        $activeStorages = LaundryStorage::with('rack')
            ->whereIn('storage_status', ['tersimpan', 'siap_diambil'])
            ->orderByDesc('stored_at')
            ->get();

        return view('logs.index', compact('logs', 'activeStorages'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'laundry_storage_id' => ['required', 'exists:laundry_storages,id'],
            'ironer_name' => ['required', 'string', 'max:100'],
            'verified_weight' => ['required', 'numeric', 'gt:0'],
            'action_type' => ['required', 'in:masuk_rak,pindah_rak,serah_terima_ambil'],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        StorageLog::create([
            'log_code' => StorageLog::generateCode(),
            'laundry_storage_id' => $data['laundry_storage_id'],
            'handled_by' => auth()->id(),
            'ironer_name' => $data['ironer_name'],
            'verified_weight' => $data['verified_weight'],
            'action_type' => $data['action_type'],
            'logged_at' => now(),
            'notes' => $data['notes'] ?? null,
        ]);

        return redirect()->route('logs.index')
            ->with('success', 'Log verifikasi setrika / serah terima rak berhasil dicatat.');
    }
}
