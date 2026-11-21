<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServiceCategoryRequest;
use App\Models\ServiceCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ServiceCategoryController extends Controller
{
    public function index(Request $request): View
    {
        $type = $request->query('type');
        $categories = ServiceCategory::when($type, fn ($q) => $q->where('service_type', $type))
            ->orderBy('service_type')
            ->orderBy('service_name')
            ->get();

        return view('categories.index', compact('categories', 'type'));
    }

    public function create(): View
    {
        return view('categories.form', ['category' => new ServiceCategory()]);
    }

    public function store(ServiceCategoryRequest $request): RedirectResponse
    {
        ServiceCategory::create($request->validated());

        return redirect()->route('categories.index')
            ->with('success', 'Tarif layanan baru berhasil ditambahkan.');
    }

    public function edit(ServiceCategory $serviceCategory): View
    {
        return view('categories.form', ['category' => $serviceCategory]);
    }

    public function update(ServiceCategoryRequest $request, ServiceCategory $serviceCategory): RedirectResponse
    {
        $serviceCategory->update($request->validated());

        return redirect()->route('categories.index')
            ->with('success', 'Tarif layanan berhasil diperbarui.');
    }

    public function destroy(ServiceCategory $serviceCategory): RedirectResponse
    {
        if ($serviceCategory->storages()->exists()) {
            return back()->withErrors([
                'category' => 'Tarif layanan tidak dapat dihapus karena sudah dipakai pada transaksi penyimpanan.',
            ]);
        }

        $serviceCategory->delete();
        return redirect()->route('categories.index')
            ->with('success', 'Tarif layanan berhasil dihapus.');
    }
}
