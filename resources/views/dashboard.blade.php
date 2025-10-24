<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Summary Cards & Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-blue-50 p-6 rounded-lg shadow">
                    <h3 class="text-lg font-semibold text-gray-700">Total Products</h3>
                    <p class="text-3xl font-bold">{{ $totalProducts }}</p>
                </div>
                <div class="bg-green-50 p-6 rounded-lg shadow">
                    <h3 class="text-lg font-semibold text-gray-700">Total Stock</h3>
                    <p class="text-3xl font-bold">{{ $totalStock }}</p>
                </div>
                <div class="bg-yellow-50 p-6 rounded-lg shadow">
                    <h3 class="text-lg font-semibold text-gray-700">Low Stock Items</h3>
                    <p class="text-3xl font-bold">{{ $lowStockProducts->count() }}</p>
                </div>
                <div class="bg-purple-50 p-6 rounded-lg shadow">
                    <h3 class="text-lg font-semibold text-gray-700">Today's Sales</h3>
                    <p class="text-3xl font-bold">Rp {{ number_format($todaySales, 2) }}</p>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <a href="{{ route('products.create') }}" class="bg-white p-6 rounded-lg shadow border border-gray-200 hover:shadow-md transition-shadow duration-300 flex flex-col items-center text-center">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Add Product</h3>
                    <p class="text-gray-600 text-sm">Create new product entries</p>
                </a>
                
                <a href="{{ route('suppliers.create') }}" class="bg-white p-6 rounded-lg shadow border border-gray-200 hover:shadow-md transition-shadow duration-300 flex flex-col items-center text-center">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Add Supplier</h3>
                    <p class="text-gray-600 text-sm">Register new suppliers</p>
                </a>
                
                <a href="{{ route('stock-in.create') }}" class="bg-white p-6 rounded-lg shadow border border-gray-200 hover:shadow-md transition-shadow duration-300 flex flex-col items-center text-center">
                    <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Stock In</h3>
                    <p class="text-gray-600 text-sm">Record new stock entries</p>
                </a>
                
                <a href="{{ route('stock-out.create') }}" class="bg-white p-6 rounded-lg shadow border border-gray-200 hover:shadow-md transition-shadow duration-300 flex flex-col items-center text-center">
                    <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Stock Out</h3>
                    <p class="text-gray-600 text-sm">Record stock removals</p>
                </a>
            </div>

            <!-- Low Stock Products Alert -->
            @if($lowStockProducts->count() > 0)
                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-8">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-700">
                                <strong>Warning:</strong> The following products have low stock:
                                @foreach($lowStockProducts as $product)
                                    <span class="font-medium">{{ $product->name }}</span>{{ !$loop->last ? ',' : '' }}
                                @endforeach
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Recent Stock In -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold">Recent Stock In</h3>
                            <a href="{{ route('stock-in.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">View All</a>
                        </div>
                        @if($recentStockIn->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full table-auto">
                                    <thead>
                                        <tr class="bg-gray-100">
                                            <th class="px-4 py-2">Product</th>
                                            <th class="px-4 py-2">Quantity</th>
                                            <th class="px-4 py-2">Supplier</th>
                                            <th class="px-4 py-2">Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($recentStockIn as $stockIn)
                                            <tr class="border-b">
                                                <td class="px-4 py-2">{{ $stockIn->product->name }}</td>
                                                <td class="px-4 py-2">{{ $stockIn->quantity }} {{ $stockIn->product->unit }}</td>
                                                <td class="px-4 py-2">{{ $stockIn->supplier->name }}</td>
                                                <td class="px-4 py-2">{{ $stockIn->date->format('Y-m-d') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p>No recent stock in records.</p>
                        @endif
                    </div>
                </div>

                <!-- Recent Stock Out -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold">Recent Stock Out</h3>
                            <a href="{{ route('stock-out.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">View All</a>
                        </div>
                        @if($recentStockOut->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full table-auto">
                                    <thead>
                                        <tr class="bg-gray-100">
                                            <th class="px-4 py-2">Product</th>
                                            <th class="px-4 py-2">Quantity</th>
                                            <th class="px-4 py-2">Type</th>
                                            <th class="px-4 py-2">Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($recentStockOut as $stockOut)
                                            <tr class="border-b">
                                                <td class="px-4 py-2">{{ $stockOut->product->name }}</td>
                                                <td class="px-4 py-2">{{ $stockOut->quantity }} {{ $stockOut->product->unit }}</td>
                                                <td class="px-4 py-2">
                                                    @if($stockOut->type === 'sale')
                                                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded">Sale</span>
                                                    @elseif($stockOut->type === 'damage')
                                                        <span class="bg-red-100 text-red-800 px-2 py-1 rounded">Damage</span>
                                                    @else
                                                        <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded">Lost</span>
                                                    @endif
                                                </td>
                                                <td class="px-4 py-2">{{ $stockOut->date->format('Y-m-d') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p>No recent stock out records.</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Top Selling Products -->
            <div class="mt-8 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Top Selling Products</h3>
                        <a href="{{ route('reports.sales') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">View Sales Report</a>
                    </div>
                    @if($topSellingProducts->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full table-auto">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th class="px-4 py-2">Product</th>
                                        <th class="px-4 py-2">Quantity Sold</th>
                                        <th class="px-4 py-2">Total Revenue</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($topSellingProducts as $product)
                                        <tr class="border-b">
                                            <td class="px-4 py-2">{{ $product->product->name }}</td>
                                            <td class="px-4 py-2">{{ $product->total_quantity_sold }} {{ $product->product->unit }}</td>
                                            <td class="px-4 py-2">Rp {{ number_format($product->total_revenue, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p>No sales data available.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
