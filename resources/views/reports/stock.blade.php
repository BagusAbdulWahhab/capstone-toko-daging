<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Stock Report') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-bold mb-6">Stock Report</h1>

                    <!-- Current Stock -->
                    <div class="mb-8">
                        <h2 class="text-xl font-semibold mb-4">Current Stock</h2>
                        <div class="overflow-x-auto">
                            <table class="min-w-full table-auto">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th class="px-4 py-2">Product</th>
                                        <th class="px-4 py-2">SKU</th>
                                        <th class="px-4 py-2">Unit</th>
                                        <th class="px-4 py-2">Current Stock</th>
                                        <th class="px-4 py-2">Purchase Price</th>
                                        <th class="px-4 py-2">Selling Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($products as $product)
                                        <tr class="border-b">
                                            <td class="px-4 py-2">{{ $product->name }}</td>
                                            <td class="px-4 py-2">{{ $product->sku }}</td>
                                            <td class="px-4 py-2">{{ $product->unit }}</td>
                                            <td class="px-4 py-2 {{ $product->stock < 5 ? 'text-red-500 font-bold' : '' }}">{{ $product->stock }}</td>
                                            <td class="px-4 py-2">Rp {{ number_format($product->purchase_price, 2) }}</td>
                                            <td class="px-4 py-2">Rp {{ number_format($product->selling_price, 2) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="px-4 py-2 text-center">No products found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Stock In Report -->
                    <div class="mb-8">
                        <h2 class="text-xl font-semibold mb-4">Stock In</h2>
                        <div class="overflow-x-auto">
                            <table class="min-w-full table-auto">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th class="px-4 py-2">Date</th>
                                        <th class="px-4 py-2">Product</th>
                                        <th class="px-4 py-2">Supplier</th>
                                        <th class="px-4 py-2">Quantity</th>
                                        <th class="px-4 py-2">Price per Unit</th>
                                        <th class="px-4 py-2">Total Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($stockIns as $stockIn)
                                        <tr class="border-b">
                                            <td class="px-4 py-2">{{ $stockIn->date->format('Y-m-d') }}</td>
                                            <td class="px-4 py-2">{{ $stockIn->product->name }}</td>
                                            <td class="px-4 py-2">{{ $stockIn->supplier->name }}</td>
                                            <td class="px-4 py-2">{{ $stockIn->quantity }}</td>
                                            <td class="px-4 py-2">Rp {{ number_format($stockIn->price_per_unit, 2) }}</td>
                                            <td class="px-4 py-2">Rp {{ number_format($stockIn->total_price, 2) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="px-4 py-2 text-center">No stock in records found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Stock Out Report -->
                    <div>
                        <h2 class="text-xl font-semibold mb-4">Stock Out</h2>
                        <div class="overflow-x-auto">
                            <table class="min-w-full table-auto">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th class="px-4 py-2">Date</th>
                                        <th class="px-4 py-2">Product</th>
                                        <th class="px-4 py-2">Quantity</th>
                                        <th class="px-4 py-2">Price per Unit</th>
                                        <th class="px-4 py-2">Total Price</th>
                                        <th class="px-4 py-2">Type</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($stockOuts as $stockOut)
                                        <tr class="border-b">
                                            <td class="px-4 py-2">{{ $stockOut->date->format('Y-m-d') }}</td>
                                            <td class="px-4 py-2">{{ $stockOut->product->name }}</td>
                                            <td class="px-4 py-2">{{ $stockOut->quantity }}</td>
                                            <td class="px-4 py-2">Rp {{ number_format($stockOut->price_per_unit, 2) }}</td>
                                            <td class="px-4 py-2">Rp {{ number_format($stockOut->total_price, 2) }}</td>
                                            <td class="px-4 py-2">
                                                @if($stockOut->type === 'sale')
                                                    <span class="bg-green-100 text-green-800 px-2 py-1 rounded">Sale</span>
                                                @elseif($stockOut->type === 'damage')
                                                    <span class="bg-red-100 text-red-800 px-2 py-1 rounded">Damage</span>
                                                @else
                                                    <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded">Lost</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="px-4 py-2 text-center">No stock out records found</td>
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