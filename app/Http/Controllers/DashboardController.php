<?php

namespace App\Http\Controllers;

use App\Models\LaundryStorage;
use App\Models\Rack;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $totalStoredBundles = LaundryStorage::whereIn('storage_status', ['tersimpan', 'siap_diambil'])->count();
        $totalActiveWeight = (float) LaundryStorage::whereIn('storage_status', ['tersimpan', 'siap_diambil'])->sum('laundry_weight');
        $readyForPickup = LaundryStorage::where('storage_status', 'siap_diambil')->count();
        $totalRevenue = (float) LaundryStorage::sum('total_price');

        $racks = Rack::orderBy('rack_code')->get();
        $recentStorages = LaundryStorage::with(['rack', 'serviceCategory'])
            ->latest('stored_at')
            ->limit(6)
            ->get();

        return view('dashboard.index', compact(
            'totalStoredBundles',
            'totalActiveWeight',
            'readyForPickup',
            'totalRevenue',
            'racks',
            'recentStorages'
        ));
    }
}
