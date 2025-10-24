<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockOut;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class POSController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('pos.index', compact('products'));
    }

    public function processSale(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|numeric|min:0.01',
            'items.*.price_per_unit' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $items = $request->items;
        $totalAmount = 0;

        foreach ($items as $item) {
            $product = Product::find($item['product_id']);
            
            // Check stock availability
            if ($product->stock < $item['quantity']) {
                return response()->json(['error' => "Insufficient stock for {$product->name}"], 422);
            }

            // Calculate total amount
            $totalAmount += $item['quantity'] * $item['price_per_unit'];

            // Create stock out record
            StockOut::create([
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price_per_unit' => $item['price_per_unit'],
                'total_price' => $item['quantity'] * $item['price_per_unit'],
                'date' => now(),
                'type' => 'sale',
                'notes' => 'POS Transaction',
            ]);

            // Update product stock
            $product->decrement('stock', $item['quantity']);
        }

        return response()->json(['success' => true, 'total' => $totalAmount]);
    }

    public function searchProducts(Request $request)
    {
        $query = $request->input('query');
        
        $products = Product::where('name', 'LIKE', "%{$query}%")
            ->orWhere('sku', 'LIKE', "%{$query}%")
            ->get(['id', 'name', 'sku', 'selling_price', 'stock', 'unit']);

        return response()->json($products);
    }
}
