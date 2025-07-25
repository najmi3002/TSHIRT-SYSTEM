<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Design;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with(['user', 'design'])
            ->latest()
            ->paginate(15);

        $stats = [
            'total' => Invoice::count(),
            'pending' => Invoice::pending()->count(),
            'partial' => Invoice::partial()->count(),
            'paid' => Invoice::paid()->count(),
            'overdue' => Invoice::overdue()->count(),
        ];

        return view('admin.invoices.index', compact('invoices', 'stats'));
    }

    public function create()
    {
        $designs = Design::with('user')->whereDoesntHave('invoice')->get();
        $selectedDesignId = request('design_id');
        return view('admin.invoices.create', compact('designs', 'selectedDesignId'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'design_id' => 'required|exists:designs,id',
            'invoice_date' => 'required|date',
            'due_date' => 'required|date|after:invoice_date',
            'deposit_amount' => 'nullable|numeric|min:0',
            'tax_amount' => 'nullable|numeric|min:0',
            'discount_amount' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            'terms_conditions' => 'nullable|string',
        ]);

        $design = Design::with('user')->findOrFail($request->design_id);
        
        // Calculate amounts
        $subtotal = $design->total_price;
        $taxAmount = $request->tax_amount ?? 0;
        $discountAmount = $request->discount_amount ?? 0;
        $totalAmount = $subtotal + $taxAmount - $discountAmount;
        $depositAmount = $request->deposit_amount ?? 0;
        $balanceAmount = $totalAmount - $depositAmount;

        // Determine payment status
        $paymentStatus = 'pending';
        if ($depositAmount > 0 && $depositAmount < $totalAmount) {
            $paymentStatus = 'partial';
        } elseif ($depositAmount >= $totalAmount) {
            $paymentStatus = 'paid';
        }

        $invoice = Invoice::create([
            'invoice_number' => $this->generateInvoiceNumber(),
            'design_id' => $design->id,
            'user_id' => $design->user_id,
            'customer_name' => $design->user->name,
            'customer_email' => $design->user->email,
            'customer_phone' => $design->user->phone,
            'customer_address' => $design->user->address,
            'product_name' => $design->product_name ?? 'Custom Design',
            'quantity' => $design->total_qty,
            'unit_price' => $design->total_price / $design->total_qty,
            'subtotal' => $subtotal,
            'tax_amount' => $taxAmount,
            'discount_amount' => $discountAmount,
            'total_amount' => $totalAmount,
            'deposit_amount' => $depositAmount,
            'balance_amount' => $balanceAmount,
            'payment_status' => $paymentStatus,
            'invoice_status' => 'draft',
            'invoice_date' => $request->invoice_date,
            'due_date' => $request->due_date,
            'notes' => $request->notes,
            'terms_conditions' => $request->terms_conditions,
        ]);

        return redirect()->route('admin.invoices.show', $invoice)
            ->with('success', 'Invoice created successfully!');
    }

    public function show(Invoice $invoice)
    {
        $invoice->load(['user', 'design']);
        return view('admin.invoices.show', compact('invoice'));
    }

    public function edit(Invoice $invoice)
    {
        $invoice->load(['user', 'design']);
        return view('admin.invoices.edit', compact('invoice'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        $request->validate([
            'invoice_date' => 'required|date',
            'due_date' => 'required|date|after:invoice_date',
            'deposit_amount' => 'nullable|numeric|min:0',
            'tax_amount' => 'nullable|numeric|min:0',
            'discount_amount' => 'nullable|numeric|min:0',
            'payment_status' => 'required|in:pending,partial,paid',
            'invoice_status' => 'required|in:draft,sent,paid,overdue,cancelled',
            'notes' => 'nullable|string',
            'terms_conditions' => 'nullable|string',
        ]);

        // Recalculate amounts
        $subtotal = $invoice->subtotal;
        $taxAmount = $request->tax_amount ?? 0;
        $discountAmount = $request->discount_amount ?? 0;
        $totalAmount = $subtotal + $taxAmount - $discountAmount;
        $depositAmount = $request->deposit_amount ?? 0;
        $balanceAmount = $totalAmount - $depositAmount;

        $invoice->update([
            'tax_amount' => $taxAmount,
            'discount_amount' => $discountAmount,
            'total_amount' => $totalAmount,
            'deposit_amount' => $depositAmount,
            'balance_amount' => $balanceAmount,
            'payment_status' => $request->payment_status,
            'invoice_status' => $request->invoice_status,
            'invoice_date' => $request->invoice_date,
            'due_date' => $request->due_date,
            'notes' => $request->notes,
            'terms_conditions' => $request->terms_conditions,
        ]);

        return redirect()->route('admin.invoices.show', $invoice)
            ->with('success', 'Invoice updated successfully!');
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return redirect()->route('admin.invoices.index')
            ->with('success', 'Invoice deleted successfully!');
    }

    public function generatePdf(Invoice $invoice)
    {
        // Allow admin access OR customer access to their own invoice
        if (auth()->user()->role !== 'admin' && auth()->user()->id !== $invoice->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $invoice->load(['user', 'design']);
        
        $pdf = PDF::loadView('admin.invoices.pdf', compact('invoice'));
        
        return $pdf->download('invoice-' . $invoice->invoice_number . '.pdf');
    }

    public function sendInvoice(Invoice $invoice)
    {
        $invoice->update(['invoice_status' => 'sent']);
        
        // Here you can add email functionality to send invoice to customer
        // Mail::to($invoice->customer_email)->send(new InvoiceMail($invoice));
        
        return redirect()->route('admin.invoices.show', $invoice)
            ->with('success', 'Invoice sent successfully!');
    }

    public function markAsPaid(Invoice $invoice)
    {
        $invoice->update([
            'payment_status' => 'paid',
            'invoice_status' => 'paid',
            'paid_date' => now(),
        ]);

        return redirect()->route('admin.invoices.show', $invoice)
            ->with('success', 'Invoice marked as paid!');
    }

    private function generateInvoiceNumber()
    {
        $lastInvoice = Invoice::latest()->first();
        $lastNumber = $lastInvoice ? intval(substr($lastInvoice->invoice_number, 4)) : 0;
        $newNumber = $lastNumber + 1;
        
        return 'INV-' . str_pad($newNumber, 6, '0', STR_PAD_LEFT);
    }
}
