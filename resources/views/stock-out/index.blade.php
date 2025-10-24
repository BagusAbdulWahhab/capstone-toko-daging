<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Stock Out') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-bold">Stock Out Records</h1>
                        @can('create', \App\Models\StockOut::class)
                            <a href="{{ route('stock-out.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Add Stock Out</a>
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
                                    <th class="px-4 py-2">Quantity</th>
                                    <th class="px-4 py-2">Price Per Unit</th>
                                    <th class="px-4 py-2">Total Price</th>
                                    <th class="px-4 py-2">Date</th>
                                    <th class="px-4 py-2">Type</th>
                                    <th class="px-4 py-2">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($stockOuts as $stockOut)
                                    <tr class="border-b">
                                        <td class="px-4 py-2">{{ $stockOut->id }}</td>
                                        <td class="px-4 py-2">{{ $stockOut->product->name }}</td>
                                        <td class="px-4 py-2">{{ $stockOut->quantity }} {{ $stockOut->product->unit }}</td>
                                        <td class="px-4 py-2">Rp {{ number_format($stockOut->price_per_unit, 2) }}</td>
                                        <td class="px-4 py-2">Rp {{ number_format($stockOut->total_price, 2) }}</td>
                                        <td class="px-4 py-2">{{ $stockOut->date->format('Y-m-d') }}</td>
                                        <td class="px-4 py-2">
                                            @if($stockOut->type === 'sale')
                                                <span class="bg-green-100 text-green-800 px-2 py-1 rounded">Sale</span>
                                            @elseif($stockOut->type === 'damage')
                                                <span class="bg-red-100 text-red-800 px-2 py-1 rounded">Damage</span>
                                            @else
                                                <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded">Lost</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-2">
                                            @can('update', $stockOut)
                                                <a href="{{ route('stock-out.edit', $stockOut) }}" class="text-blue-500 hover:text-blue-700 mr-2">Edit</a>
                                            @endcan
                                            @can('delete', $stockOut)
                                                <form action="{{ route('stock-out.destroy', $stockOut) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-500 hover:text-red-700" onclick="return confirm('Are you sure?')">Delete</button>
                                                </form>
                                            @endcan
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="px-4 py-2 text-center">No stock out records found</td>
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