<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Stock In') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-bold mb-6">Edit Stock In</h1>

                    <form method="POST" action="{{ route('stock-in.update', $stockIn) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="product_id" class="block text-sm font-medium text-gray-700">Product</label>
                            <select name="product_id" id="product_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" {{ old('product_id', $stockIn->product_id) == $product->id ? 'selected' : '' }}>
                                        {{ $product->name }} ({{ $product->stock }} {{ $product->unit }} in stock)
                                    </option>
                                @endforeach
                            </select>
                            @error('product_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="supplier_id" class="block text-sm font-medium text-gray-700">Supplier</label>
                            <select name="supplier_id" id="supplier_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}" {{ old('supplier_id', $stockIn->supplier_id) == $supplier->id ? 'selected' : '' }}>
                                        {{ $supplier->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('supplier_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity</label>
                            <input type="number" name="quantity" id="quantity" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="{{ old('quantity', $stockIn->quantity) }}" step="0.01" min="0.01" required>
                            @error('quantity')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="price_per_unit" class="block text-sm font-medium text-gray-700">Price Per Unit</label>
                            <input type="number" name="price_per_unit" id="price_per_unit" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="{{ old('price_per_unit', $stockIn->price_per_unit) }}" step="0.01" min="0" required>
                            @error('price_per_unit')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="date" class="block text-sm font-medium text-gray-700">Date</label>
                            <input type="date" name="date" id="date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="{{ old('date', $stockIn->date->format('Y-m-d')) }}" required>
                            @error('date')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
                            <textarea name="notes" id="notes" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('notes', $stockIn->notes) }}</textarea>
                            @error('notes')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('stock-in.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">Cancel</a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Update Stock In</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>