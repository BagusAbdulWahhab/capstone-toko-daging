<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockOut;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StockOutController extends Controller
{
    public function index()
    {
        $stockOuts = StockOut::with('product')->get();
        return view('stock-out.index', compact('stockOuts'));
    }

    public function create()
    {
        $products = Product::all();
        return view('stock-out.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|numeric|min:0.01',
            'price_per_unit' => 'required|numeric|min:0',
            'date' => 'required|date',
            'type' => 'required|in:sale,damage,lost',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validated();
        $validated['total_price'] = $validated['quantity'] * $validated['price_per_unit'];

        // Check if there's enough stock
        $product = Product::find($validated['product_id']);
        if ($product->stock < $validated['quantity']) {
            return redirect()->back()->withErrors(['quantity' => 'Insufficient stock available.'])->withInput();
        }

        $stockOut = StockOut::create($validated);

        // Update product stock
        $product->decrement('stock', $validated['quantity']);

        return redirect()->route('stock-out.index')->with('success', 'Stock Out recorded successfully.');
    }

    public function show(StockOut $stockOut)
    {
        return view('stock-out.show', compact('stockOut'));
    }

    public function edit(StockOut $stockOut)
    {
        $products = Product::all();
        return view('stock-out.edit', compact('stockOut', 'products'));
    }

    public function update(Request $request, StockOut $stockOut)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|numeric|min:0.01',
            'price_per_unit' => 'required|numeric|min:0',
            'date' => 'required|date',
            'type' => 'required|in:sale,damage,lost',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validated();
        $validated['total_price'] = $validated['quantity'] * $validated['price_per_unit'];

        // Update product stock: add back old quantity and subtract new quantity
        $oldQuantity = $stockOut->quantity;
        $newQuantity = $validated['quantity'];
        $product = $stockOut->product;
        
        $product->increment('stock', $oldQuantity);
        
        // Check if there's enough stock for the new quantity
        if ($product->stock < $newQuantity) {
            return redirect()->back()->withErrors(['quantity' => 'Insufficient stock available.'])->withInput();
        }

        $product->decrement('stock', $newQuantity);

        $stockOut->update($validated);

        return redirect()->route('stock-out.index')->with('success', 'Stock Out updated successfully.');
    }

    public function destroy(StockOut $stockOut)
    {
        // Add the stock back to the product
        $product = $stockOut->product;
        $product->increment('stock', $stockOut->quantity);

        $stockOut->delete();

        return redirect()->route('stock-out.index')->with('success', 'Stock Out deleted successfully.');
    }
}
