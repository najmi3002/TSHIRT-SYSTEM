<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Design;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Design::with('user', 'product')->latest();

        // Filter by Order ID
        if ($request->filled('order_id')) {
            $query->where('id', $request->order_id);
        }
        // Filter by Customer Name
        if ($request->filled('customer_name')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->customer_name . '%');
            });
        }
        // Filter by Date
        if ($request->filled('order_date')) {
            $query->whereDate('created_at', $request->order_date);
        }

        $designs = $query->get();
        $customDesigns = $designs->whereNull('product_id');
        $standardOrders = $designs->whereNotNull('product_id');

        return view('admin.orders', compact('customDesigns', 'standardOrders'));
    }

    public function show(Design $design)
    {
        return view('admin.order-details', compact('design'));
    }

    public function updateStatus(Request $request, Design $design)
    {
        $request->validate([
            'status' => 'required|string|in:Deposit Paid,Fully Paid,Pending,Deposit Pending,Full Payment Pending,In Progress,Complete',
        ]);

        $design->status = $request->status;
        $design->save();

        return redirect()->route('admin.orders.index')->with('success', 'Order status updated successfully.');
    }

    public function destroy(Design $design)
    {
        // Delete associated files from storage to keep the system clean
        if ($design->design_path) {
            Storage::disk('public')->delete($design->design_path);
        }
        if ($design->deposit_proof_path) {
            Storage::disk('public')->delete($design->deposit_proof_path);
        }
        if ($design->fullpayment_proof_path) {
            Storage::disk('public')->delete($design->fullpayment_proof_path);
        }
        
        // Delete the design record from the database
        $design->delete();

        return redirect()->route('admin.orders.index')->with('success', 'Order deleted successfully.');
    }
}
