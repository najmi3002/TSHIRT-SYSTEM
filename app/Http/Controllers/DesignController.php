<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Design;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class DesignController extends Controller
{
    public function index()
    {
        $designs = Design::where('user_id', Auth::id())->with('product')->latest()->get();
        
        // Fetch the default product for type options
        $defaultProduct = Product::where('name', 'Default Product')->first();

        $collarOptions = $defaultProduct && is_array($defaultProduct->collar_type) ? $defaultProduct->collar_type : [];
        $fabricOptions = $defaultProduct && is_array($defaultProduct->fabric_type) ? $defaultProduct->fabric_type : [];
        $sleeveOptions = $defaultProduct && is_array($defaultProduct->sleeve_type) ? $defaultProduct->sleeve_type : [];

        return view('designs.index', [
            'designs' => $designs,
            'collarOptions' => $collarOptions,
            'fabricOptions' => $fabricOptions,
            'sleeveOptions' => $sleeveOptions,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'collar_type' => 'required',
            'fabric_type' => 'required',
            'sleeve_type' => 'required',
            'total_qty' => 'required|integer|min:1',
            'total_price' => 'required|numeric|min:0',
        ]);

        Design::create([
            'user_id' => Auth::id(),
            'product_id' => $request->product_id,
            'collar_type' => json_decode($request->collar_type, true),
            'fabric_type' => json_decode($request->fabric_type, true),
            'sleeve_type' => json_decode($request->sleeve_type, true),
            'total_qty' => $request->total_qty,
            'total_price' => $request->total_price,
        ]);
        return redirect('/designs')->with('success', 'Design saved!');
    }

    public function storeCustom(Request $request)
    {
        \Log::info('STORE CUSTOM DIPANGGIL', $request->all());
        try {
            $request->validate([
                'product_name' => 'required|string|max:255',
                'design_image' => 'required|file|mimes:jpeg,png,jpg,gif,pdf|max:2048',
                'collar_type' => 'nullable|string',
                'fabric_type' => 'nullable|string',
                'sleeve_type' => 'nullable|string',
                'total_qty' => 'required|integer|min:1',
                'total_price' => 'required|numeric|min:0',
            ]);
            \Log::info('VALIDATION LULUS');
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('VALIDATION ERROR', $e->errors());
            throw $e;
        }

        $imagePath = $request->file('design_image')->store('designs', 'public');

        Design::create([
            'user_id' => Auth::id(),
            'product_id' => null, // No product for custom designs
            'product_name' => $request->product_name,
            'design_path' => $imagePath,
            'collar_type' => json_decode($request->collar_type, true) ?? [],
            'fabric_type' => json_decode($request->fabric_type, true) ?? [],
            'sleeve_type' => json_decode($request->sleeve_type, true) ?? [],
            'total_qty' => $request->total_qty,
            'total_price' => $request->total_price,
            'status' => 'Pending',
        ]);
        \Log::info('ORDER BERJAYA DISIMPAN');

        return redirect()->route('designs.index')->with('success', 'Your custom design has been submitted successfully!');
    }

    public function uploadPaymentProof(Request $request)
    {
        $request->validate([
            'design_id' => 'required|exists:designs,id',
            'payment_type' => 'required|in:deposit,fullpayment',
            'payment_proof' => 'required|file|mimes:jpeg,png,jpg,gif,pdf|max:2048',
        ]);

        $design = Design::findOrFail($request->input('design_id'));
        $paymentType = $request->input('payment_type');
        $file = $request->file('payment_proof');
        $path = $file->store('payment_proofs', 'public');

        if ($paymentType === 'deposit') {
            $design->deposit = $design->total_price / 2;
            $design->deposit_proof_path = $path;
            $design->status = 'Deposit Paid';
        } elseif ($paymentType === 'fullpayment') {
            $fullPaymentAmount = $design->total_price - ($design->deposit ?? 0);
            $design->fullpayment = $fullPaymentAmount;
            $design->fullpayment_proof_path = $path;
            $design->status = 'Fully Paid';
        }

        $design->save();

        return redirect()->route('designs.index')->with('success', 'Payment proof uploaded successfully!');
    }

    public function destroy(Design $design)
    {
        // Make sure the user owns the design
        if (Auth::id() !== $design->user_id) {
            abort(403);
        }

        // Delete the design image from storage if it exists
        if ($design->design_path) {
            Storage::disk('public')->delete($design->design_path);
        }

        $design->delete();

        return redirect()->route('designs.index')->with('success', 'Design has been cancelled successfully!');
    }
} 