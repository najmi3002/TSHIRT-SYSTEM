<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();
        if ($request->filled('product_id')) {
            $query->where('id', $request->product_id);
        }
        if ($request->filled('product_name')) {
            $query->where('name', 'like', '%' . $request->product_name . '%');
        }
        $products = $query->get();
        return view('admin.products', [
            'products' => $products,
            'collarTypes' => $this->collarTypes(),
            'fabricTypes' => $this->fabricTypes(),
            'sleeveTypes' => $this->sleeveTypes(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'collar_type' => 'required|array|min:1',
            'collar_type.*.name' => 'required|string',
            'collar_type.*.addon_price' => 'required|numeric',
            'fabric_type' => 'required|array|min:1',
            'fabric_type.*.name' => 'required|string',
            'fabric_type.*.addon_price' => 'required|numeric',
            'sleeve_type' => 'required|array|min:1',
            'sleeve_type.*.name' => 'required|string',
            'sleeve_type.*.addon_price' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = $request->file('image')->store('products', 'public');

        Product::create([
            'name' => $validated['name'],
            'price' => $validated['price'],
            'collar_type' => $validated['collar_type'],
            'fabric_type' => $validated['fabric_type'],
            'sleeve_type' => $validated['sleeve_type'],
            'image_path' => $imagePath,
        ]);

        return redirect()->back()->with('success', 'Product added successfully!');
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
    
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'collar_type' => 'nullable|array',
            'collar_type.*.name' => 'nullable|string',
            'collar_type.*.addon_price' => 'nullable|numeric',
            'fabric_type' => 'nullable|array',
            'fabric_type.*.name' => 'nullable|string',
            'fabric_type.*.addon_price' => 'nullable|numeric',
            'sleeve_type' => 'nullable|array',
            'sleeve_type.*.name' => 'nullable|string',
            'sleeve_type.*.addon_price' => 'nullable|numeric',
        ]);
    
        $product->name = $validated['name'];
        $product->price = $validated['price'];
    
        if ($request->hasFile('image')) {
            // Delete old image
            if ($product->image_path) {
                Storage::disk('public')->delete($product->image_path);
            }
            $product->image_path = $request->file('image')->store('products', 'public');
        }
    
        // Filter out empty entries from types
        $product->collar_type = array_values(array_filter($validated['collar_type'] ?? [], fn($item) => !empty($item['name']) && isset($item['addon_price'])));
        $product->fabric_type = array_values(array_filter($validated['fabric_type'] ?? [], fn($item) => !empty($item['name']) && isset($item['addon_price'])));
        $product->sleeve_type = array_values(array_filter($validated['sleeve_type'] ?? [], fn($item) => !empty($item['name']) && isset($item['addon_price'])));
    
        $product->save();
    
        return redirect('/admin/products')->with('success', 'Product updated successfully.');
    }

    public function editCustomTypes()
    {
        $product = Product::firstOrCreate(
            ['name' => 'Default Product'],
            [
                'price' => 0,
                'image_path' => ''
            ]
        );

        return view('admin.custom-types-edit', compact('product'));
    }

    public function updateCustomTypes(Request $request)
    {
        $product = Product::where('name', 'Default Product')->firstOrFail();

        $validated = $request->validate([
            'collar_type' => 'nullable|array',
            'collar_type.*.name' => 'required_with:collar_type|string',
            'collar_type.*.addon_price' => 'required_with:collar_type|numeric',
            'fabric_type' => 'nullable|array',
            'fabric_type.*.name' => 'required_with:fabric_type|string',
            'fabric_type.*.addon_price' => 'required_with:fabric_type|numeric',
            'sleeve_type' => 'nullable|array',
            'sleeve_type.*.name' => 'required_with:sleeve_type|string',
            'sleeve_type.*.addon_price' => 'required_with:sleeve_type|numeric',
        ]);
        
        $updateData = [];
        $updateData['collar_type'] = array_values(array_filter($validated['collar_type'] ?? [], fn($item) => !empty($item['name'])));
        $updateData['fabric_type'] = array_values(array_filter($validated['fabric_type'] ?? [], fn($item) => !empty($item['name'])));
        $updateData['sleeve_type'] = array_values(array_filter($validated['sleeve_type'] ?? [], fn($item) => !empty($item['name'])));

        $product->update($updateData);

        return redirect()->route('admin.custom-types.edit')->with('success', 'Available types updated successfully!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        // Optionally delete the image file
        if ($product->image_path && \Storage::disk('public')->exists($product->image_path)) {
            \Storage::disk('public')->delete($product->image_path);
        }
        $product->delete();
        return redirect()->back()->with('success', 'Product deleted successfully!');
    }

    private function collarTypes()
    {
        return ['Round', 'V-Neck', 'Polo', 'Mandarin'];
    }
    private function fabricTypes()
    {
        return ['Cotton', 'Polyester', 'Linen', 'Wool'];
    }
    private function sleeveTypes()
    {
        return ['Short Sleeve', 'Long Sleeve', 'Sleeveless'];
    }
}
