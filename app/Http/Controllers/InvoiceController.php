<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;


class InvoiceController extends Controller
{
    public function store(Request $request, $reportId)
    {
        $request->validate([
            'description' => 'nullable|string',
            'total_price' => 'required|numeric|min:0',
            'total_paid' => 'required|numeric|min:0',
        ]);

        try {
            $invoice = new Invoice();
            $transactionCount = Invoice::count() + 1;
            $invoice->fine_id = $reportId;
            $invoice->description = $request->input('description');
            $invoice->total_price = $request->input('total_price');
            $invoice->total_paid = $request->input('total_paid');

            $invoice->return = $invoice->total_paid - $invoice->total_price;

            $invoice->paymentId = 'INV' . strtoupper(uniqid() . $transactionCount);

            $invoice->save();

            return redirect()->back()->with('success', 'Invoice berhasil dibuat!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat membuat invoice: ' . $e->getMessage());
        }
    }

    public function generateInvoicePDF($id)
    {
        $invoice =  Invoice::with(['fine.loan'])->findOrFail($id);

        $data = [
            'invoice' => $invoice,
        ];

        $pdf = Pdf::loadView('invoicePDF', $data);
        return $pdf->download('invoice.pdf');
    }
}
