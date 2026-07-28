<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;

class CertificateController extends Controller
{
    public function generate(Transaction $transaction)
    {
        // Hanya transaksi sukses yang boleh download certificate
        if (!in_array(strtolower($transaction->status), ['success', 'settlement'])) {
            abort(403, 'Certificate hanya tersedia untuk transaksi yang berhasil.');
        }

        // Buat certificate jika belum ada
        $certificate = Certificate::firstOrCreate(
            [
                'transaction_id' => $transaction->id,
            ],
            [
                'event_id' => $transaction->event_id,
                'participant_name' => $transaction->customer_name,
                'participant_email' => $transaction->customer_email,
                'certificate_number' => 'CERT-' . date('Y') . '-' . strtoupper(Str::random(6)),
                'generated_at' => now(),
            ]
        );

        // Generate PDF
        $pdf = Pdf::loadView('certificate.pdf', [
            'certificate' => $certificate,
            'transaction' => $transaction,
        ])->setPaper('a4', 'landscape');

        // Simpan lokasi file (opsional)
        // $fileName = $certificate->certificate_number . '.pdf';
        // Storage::disk('public')->put(
        //     'certificates/' . $fileName,
        //     $pdf->output()
        // );
        //
        // $certificate->update([
        //     'pdf_path' => 'certificates/' . $fileName,
        //     'generated_at' => now(),
        // ]);

        return $pdf->download(
            $certificate->certificate_number . '.pdf'
        );
    }
}