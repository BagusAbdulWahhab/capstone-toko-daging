<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Sales Report') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-bold mb-6">Sales Report</h1>

                    <!-- Filter Form -->
                    <form method="GET" action="{{ route('reports.sales') }}" class="mb-6 p-4 bg-gray-50 rounded-lg">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div>
                                <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                                <input type="date" name="start_date" id="start_date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="{{ request('start_date', $startDate) }}">
                            </div>
                            <div>
                                <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
                                <input type="date" name="end_date" id="end_date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="{{ request('end_date', $endDate) }}">
                            </div>
                            <div class="flex items-end">
                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Filter</button>
                            </div>
                            <div class="flex items-end">
                                <a href="{{ route('reports.sales') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Clear</a>
                            </div>
                        </div>
                    </form>

                    <!-- Summary Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <h3 class="text-lg font-semibold">Total Sales</h3>
                            <p class="text-2xl font-bold">Rp {{ number_format($totalSales, 2) }}</p>
                        </div>
                        <div class="bg-green-50 p-4 rounded-lg">
                            <h3 class="text-lg font-semibold">Total Quantity Sold</h3>
                            <p class="text-2xl font-bold">{{ $totalQuantity }}</p>
                        </div>
                        <div class="bg-purple-50 p-4 rounded-lg">
                            <h3 class="text-lg font-semibold">Total Transactions</h3>
                            <p class="text-2xl font-bold">{{ $sales->count() }}</p>
                        </div>
                    </div>

                    <!-- Sales by Product -->
                    <div class="mb-8">
                        <h2 class="text-xl font-semibold mb-4">Sales by Product</h2>
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
                                    @forelse($salesByProduct as $item)
                                        <tr class="border-b">
                                            <td class="px-4 py-2">{{ $item['product_name'] }}</td>
                                            <td class="px-4 py-2">{{ $item['quantity'] }}</td>
                                            <td class="px-4 py-2">Rp {{ number_format($item['total_price'], 2) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="px-4 py-2 text-center">No sales data found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Detailed Sales -->
                    <div>
                        <h2 class="text-xl font-semibold mb-4">Detailed Sales</h2>
                        <div class="overflow-x-auto">
                            <table class="min-w-full table-auto">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th class="px-4 py-2">Date</th>
                                        <th class="px-4 py-2">Product</th>
                                        <th class="px-4 py-2">Quantity</th>
                                        <th class="px-4 py-2">Price per Unit</th>
                                        <th class="px-4 py-2">Total Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($sales as $sale)
                                        <tr class="border-b">
                                            <td class="px-4 py-2">{{ $sale->date->format('Y-m-d') }}</td>
                                            <td class="px-4 py-2">{{ $sale->product->name }}</td>
                                            <td class="px-4 py-2">{{ $sale->quantity }}</td>
                                            <td class="px-4 py-2">Rp {{ number_format($sale->price_per_unit, 2) }}</td>
                                            <td class="px-4 py-2">Rp {{ number_format($sale->total_price, 2) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-4 py-2 text-center">No sales data found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>