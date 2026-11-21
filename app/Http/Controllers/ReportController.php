<?php

namespace App\Http\Controllers;

use App\Models\LaundryStorage;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    private function filteredQuery(Request $request)
    {
        $startDate = $request->query('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->query('end_date', now()->toDateString());

        $query = LaundryStorage::with(['rack', 'serviceCategory', 'staff'])
            ->whereDate('stored_at', '>=', $startDate)
            ->whereDate('stored_at', '<=', $endDate)
            ->orderByDesc('stored_at');

        return [$query, $startDate, $endDate];
    }

    public function index(Request $request): View
    {
        [$query, $startDate, $endDate] = $this->filteredQuery($request);
        $records = $query->get();
        $totalRevenue = (float) $records->sum('total_price');
        $totalWeight = (float) $records->sum('laundry_weight');

        return view('reports.index', compact('records', 'startDate', 'endDate', 'totalRevenue', 'totalWeight'));
    }

    public function exportCsv(Request $request): StreamedResponse
    {
        [$query, $startDate, $endDate] = $this->filteredQuery($request);
        $records = $query->get();
        $filename = "laporan-rak-boim-{$startDate}-sd-{$endDate}.csv";

        return response()->streamDownload(function () use ($records) {
            $handle = fopen('php://output', 'w');
            // UTF-8 BOM agar rapi saat dibuka di Microsoft Excel
            fwrite($handle, "\xEF\xBB\xBF");
            fputcsv($handle, [
                'No. Nota',
                'Tanggal Masuk',
                'Nama Pelanggan',
                'No. Telepon',
                'Layanan',
                'Berat / Qty',
                'ID Rak',
                'Jemput-Antar PP',
                'Total Biaya (Rp)',
                'Status Bayar',
                'Status Rak',
            ]);

            foreach ($records as $row) {
                fputcsv($handle, [
                    $row->storage_code,
                    $row->stored_at?->format('Y-m-d H:i'),
                    $row->customer_name,
                    $row->customer_phone,
                    $row->serviceCategory->service_name ?? '-',
                    $row->laundry_weight,
                    $row->rack->rack_code ?? '-',
                    $row->include_delivery ? 'Ya (+10000)' : 'Tidak',
                    $row->total_price,
                    $row->payment_status,
                    $row->storage_status,
                ]);
            }
            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    public function exportPdf(Request $request)
    {
        [$query, $startDate, $endDate] = $this->filteredQuery($request);
        $records = $query->get();
        $totalRevenue = (float) $records->sum('total_price');
        $totalWeight = (float) $records->sum('laundry_weight');

        // Jika barryvdh/laravel-dompdf terpasang, unduh PDF langsung.
        // Jika belum terpasang, tampilkan halaman cetak PDF siap Save as PDF di browser.
        if (class_exists(\Barryvdh\DomPDF\Facade\Pdf::class)) {
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('reports.pdf', compact(
                'records', 'startDate', 'endDate', 'totalRevenue', 'totalWeight'
            ));
            return $pdf->download("laporan-rak-boim-{$startDate}-sd-{$endDate}.pdf");
        }

        return view('reports.pdf', compact('records', 'startDate', 'endDate', 'totalRevenue', 'totalWeight'));
    }
}
