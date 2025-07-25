<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductDashboardController extends Controller
{
    public function __invoke()
    {
        $products = Product::where('name', '!=', 'Default Product')->latest()->get();
        // Ambil pilihan untuk setiap produk
        foreach ($products as $product) {
            $product->collar_type_options = $product->collar_type ?? [];
            $product->fabric_type_options = $product->fabric_type ?? [];
            $product->sleeve_type_options = $product->sleeve_type ?? [];
        }
        return view('customer.dashboard', compact('products'));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('customer.product', compact('product'));
    }
} 