<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Products') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-bold">Products</h1>
                        @can('create', \App\Models\Product::class)
                            <a href="{{ route('products.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Add New Product</a>
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
                                    <th class="px-4 py-2">Name</th>
                                    <th class="px-4 py-2">SKU</th>
                                    <th class="px-4 py-2">Unit</th>
                                    <th class="px-4 py-2">Purchase Price</th>
                                    <th class="px-4 py-2">Selling Price</th>
                                    <th class="px-4 py-2">Stock</th>
                                    <th class="px-4 py-2">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($products as $product)
                                    <tr class="border-b">
                                        <td class="px-4 py-2">{{ $product->id }}</td>
                                        <td class="px-4 py-2">{{ $product->name }}</td>
                                        <td class="px-4 py-2">{{ $product->sku }}</td>
                                        <td class="px-4 py-2">{{ $product->unit }}</td>
                                        <td class="px-4 py-2">Rp {{ number_format($product->purchase_price, 2) }}</td>
                                        <td class="px-4 py-2">Rp {{ number_format($product->selling_price, 2) }}</td>
                                        <td class="px-4 py-2">{{ $product->stock }} {{ $product->unit }}</td>
                                        <td class="px-4 py-2">
                                            @can('update', $product)
                                                <a href="{{ route('products.edit', $product) }}" class="text-blue-500 hover:text-blue-700 mr-2">Edit</a>
                                            @endcan
                                            @can('delete', $product)
                                                <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-500 hover:text-red-700" onclick="return confirm('Are you sure?')">Delete</button>
                                                </form>
                                            @endcan
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="px-4 py-2 text-center">No products found</td>
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