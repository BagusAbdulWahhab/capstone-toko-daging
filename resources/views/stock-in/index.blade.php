<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Stock In') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-bold">Stock In Records</h1>
                        @can('create', \App\Models\StockIn::class)
                            <a href="{{ route('stock-in.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Add Stock In</a>
                        @endcan
                    </div>

                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-4 py-2">ID</th>
                                    <th class="px-4 py-2">Product</th>
                                    <th class="px-4 py-2">Supplier</th>
                                    <th class="px-4 py-2">Quantity</th>
                                    <th class="px-4 py-2">Price Per Unit</th>
                                    <th class="px-4 py-2">Total Price</th>
                                    <th class="px-4 py-2">Date</th>
                                    <th class="px-4 py-2">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($stockIns as $stockIn)
                                    <tr class="border-b">
                                        <td class="px-4 py-2">{{ $stockIn->id }}</td>
                                        <td class="px-4 py-2">{{ $stockIn->product->name }}</td>
                                        <td class="px-4 py-2">{{ $stockIn->supplier->name }}</td>
                                        <td class="px-4 py-2">{{ $stockIn->quantity }} {{ $stockIn->product->unit }}</td>
                                        <td class="px-4 py-2">Rp {{ number_format($stockIn->price_per_unit, 2) }}</td>
                                        <td class="px-4 py-2">Rp {{ number_format($stockIn->total_price, 2) }}</td>
                                        <td class="px-4 py-2">{{ $stockIn->date->format('Y-m-d') }}</td>
                                        <td class="px-4 py-2">
                                            @can('update', $stockIn)
                                                <a href="{{ route('stock-in.edit', $stockIn) }}" class="text-blue-500 hover:text-blue-700 mr-2">Edit</a>
                                            @endcan
                                            @can('delete', $stockIn)
                                                <form action="{{ route('stock-in.destroy', $stockIn) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-500 hover:text-red-700" onclick="return confirm('Are you sure?')">Delete</button>
                                                </form>
                                            @endcan
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="px-4 py-2 text-center">No stock in records found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>