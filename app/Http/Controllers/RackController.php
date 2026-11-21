<?php

namespace App\Http\Controllers;

use App\Http\Requests\RackRequest;
use App\Models\Rack;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RackController extends Controller
{
    public function index(): View
    {
        $racks = Rack::withCount(['storages as active_bundles_count' => function ($q) {
            $q->whereIn('storage_status', ['tersimpan', 'siap_diambil']);
        }])->orderBy('rack_code')->get();

        return view('racks.index', compact('racks'));
    }

    public function create(): View
    {
        return view('racks.form', ['rack' => new Rack()]);
    }

    public function store(RackRequest $request): RedirectResponse
    {
        Rack::create($request->validated());

        return redirect()->route('racks.index')
            ->with('success', 'Master ID Rak baru berhasil ditambahkan.');
    }

    public function edit(Rack $rack): View
    {
        return view('racks.form', compact('rack'));
    }

    public function update(RackRequest $request, Rack $rack): RedirectResponse
    {
        $rack->update($request->validated());
        $rack->recalculateLoad();

        return redirect()->route('racks.index')
            ->with('success', 'Data Master ID Rak berhasil diperbarui.');
    }

    public function destroy(Rack $rack): RedirectResponse
    {
        if ($rack->storages()->exists()) {
            return back()->withErrors([
                'rack' => "Rak {$rack->rack_code} tidak dapat dihapus karena masih memiliki riwayat cucian terkait.",
            ]);
        }

        $rack->delete();
        return redirect()->route('racks.index')
            ->with('success', 'Master ID Rak berhasil dihapus.');
    }
}
