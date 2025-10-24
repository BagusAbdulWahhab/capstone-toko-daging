<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockIn;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StockInController extends Controller
{
    public function index()
    {
        $stockIns = StockIn::with(['product', 'supplier'])->get();
        return view('stock-in.index', compact('stockIns'));
    }

    public function create()
    {
        $products = Product::all();
        $suppliers = Supplier::all();
        return view('stock-in.create', compact('products', 'suppliers'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'quantity' => 'required|numeric|min:0.01',
            'price_per_unit' => 'required|numeric|min:0',
            'date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validated();
        $validated['total_price'] = $validated['quantity'] * $validated['price_per_unit'];

        $stockIn = StockIn::create($validated);

        // Update product stock
        $product = $stockIn->product;
        $product->increment('stock', $validated['quantity']);

        return redirect()->route('stock-in.index')->with('success', 'Stock In recorded successfully.');
    }

    public function show(StockIn $stockIn)
    {
        return view('stock-in.show', compact('stockIn'));
    }

    public function edit(StockIn $stockIn)
    {
        $products = Product::all();
        $suppliers = Supplier::all();
        return view('stock-in.edit', compact('stockIn', 'products', 'suppliers'));
    }

    public function update(Request $request, StockIn $stockIn)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'quantity' => 'required|numeric|min:0.01',
            'price_per_unit' => 'required|numeric|min:0',
            'date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validated();
        $validated['total_price'] = $validated['quantity'] * $validated['price_per_unit'];

        // Update product stock: subtract old quantity and add new quantity
        $oldQuantity = $stockIn->quantity;
        $newQuantity = $validated['quantity'];
        $product = $stockIn->product;
        
        $product->decrement('stock', $oldQuantity);
        $product->increment('stock', $newQuantity);

        $stockIn->update($validated);

        return redirect()->route('stock-in.index')->with('success', 'Stock In updated successfully.');
    }

    public function destroy(StockIn $stockIn)
    {
        // Subtract the stock from the product
        $product = $stockIn->product;
        $product->decrement('stock', $stockIn->quantity);

        $stockIn->delete();

        return redirect()->route('stock-in.index')->with('success', 'Stock In deleted successfully.');
    }
}
