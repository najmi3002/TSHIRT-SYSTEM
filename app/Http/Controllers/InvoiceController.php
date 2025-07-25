<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class InvoiceController extends Controller
{
    /**
     * Display the specified invoice to the customer.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\View\View
     */
    public function show(Invoice $invoice)
    {
        // Ensure the authenticated user owns this invoice
        if (auth()->user()->id !== $invoice->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $invoice->load(['user', 'design']);

        return view('invoices.show', compact('invoice'));
    }
}
