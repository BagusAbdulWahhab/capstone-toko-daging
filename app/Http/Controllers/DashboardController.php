<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockIn;
use App\Models\StockOut;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Get key metrics for the dashboard
        $totalProducts = Product::count();
        $totalStock = Product::sum('stock');
        $lowStockProducts = Product::where('stock', '<', 5)->get();
        
        // Calculate today's sales
        $todaySales = StockOut::whereDate('created_at', Carbon::today())
            ->where('type', 'sale')
            ->sum('total_price');
        
        // Calculate today's total quantity sold
        $todayQuantitySold = StockOut::whereDate('created_at', Carbon::today())
            ->where('type', 'sale')
            ->sum('quantity');
        
        // Get recent stock in/out activities
        $recentStockIn = StockIn::with('product', 'supplier')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
            
        $recentStockOut = StockOut::with('product')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Get top selling products (by quantity sold)
        $topSellingProducts = StockOut::where('type', 'sale')
            ->selectRaw('product_id, SUM(quantity) as total_quantity_sold, SUM(total_price) as total_revenue')
            ->groupBy('product_id')
            ->orderBy('total_quantity_sold', 'desc')
            ->limit(5)
            ->with('product')
            ->get();

        return view('dashboard', compact(
            'totalProducts',
            'totalStock',
            'lowStockProducts',
            'todaySales',
            'todayQuantitySold',
            'recentStockIn',
            'recentStockOut',
            'topSellingProducts'
        ));
    }
}
