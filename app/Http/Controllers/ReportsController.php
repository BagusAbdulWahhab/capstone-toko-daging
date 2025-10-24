<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockIn;
use App\Models\StockOut;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function index()
    {
        return view('reports.index');
    }

    public function salesReport(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth());
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth());
        
        $sales = StockOut::where('type', 'sale')
            ->whereBetween('date', [$startDate, $endDate])
            ->with('product')
            ->get();

        $totalSales = $sales->sum('total_price');
        $totalQuantity = $sales->sum('quantity');
        
        // Sales by product
        $salesByProduct = $sales->groupBy('product_id')->map(function ($items) {
            $firstItem = $items->first();
            return [
                'product_name' => $firstItem->product->name,
                'quantity' => $items->sum('quantity'),
                'total_price' => $items->sum('total_price'),
            ];
        })->sortByDesc('total_price');

        return view('reports.sales', compact('sales', 'totalSales', 'totalQuantity', 'salesByProduct', 'startDate', 'endDate'));
    }

    public function stockReport()
    {
        $products = Product::all();
        $stockIns = StockIn::with('product', 'supplier')->get();
        $stockOuts = StockOut::with('product')->get();

        return view('reports.stock', compact('products', 'stockIns', 'stockOuts'));
    }

    public function profitReport(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth());
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth());
        
        $sales = StockOut::where('type', 'sale')
            ->whereBetween('date', [$startDate, $endDate])
            ->with('product')
            ->get();

        $totalRevenue = $sales->sum('total_price');
        
        // Calculate cost of goods sold (COGS)
        $totalCost = 0;
        foreach ($sales as $sale) {
            $product = $sale->product;
            $totalCost += $sale->quantity * $product->purchase_price; // Using purchase price as cost
        }

        $totalProfit = $totalRevenue - $totalCost;
        $profitMargin = $totalRevenue > 0 ? ($totalProfit / $totalRevenue) * 100 : 0;

        // Profit by product
        $profitByProduct = $sales->groupBy('product_id')->map(function ($items) {
            $firstItem = $items->first();
            $product = $firstItem->product;
            
            $totalRevenue = $items->sum(function($item) {
                return $item->quantity * $item->price_per_unit;
            });
            
            $totalCost = $items->sum(function($item) use ($product) {
                return $item->quantity * $product->purchase_price;
            });
            
            $profit = $totalRevenue - $totalCost;
            $margin = $totalRevenue > 0 ? ($profit / $totalRevenue) * 100 : 0;
            
            return [
                'product_name' => $product->name,
                'revenue' => $totalRevenue,
                'cost' => $totalCost,
                'profit' => $profit,
                'margin' => $margin,
            ];
        })->sortByDesc('profit');

        return view('reports.profit', compact('totalRevenue', 'totalCost', 'totalProfit', 'profitMargin', 'profitByProduct', 'startDate', 'endDate'));
    }
}
