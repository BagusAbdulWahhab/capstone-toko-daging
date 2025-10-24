<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Stock Out') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-bold mb-6">Add Stock Out</h1>

                    <form method="POST" action="{{ route('stock-out.store') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="product_id" class="block text-sm font-medium text-gray-700">Product</label>
                            <select name="product_id" id="product_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="">Select Product</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }} data-stock="{{ $product->stock }}">
                                        {{ $product->name }} ({{ $product->stock }} {{ $product->unit }} in stock)
                                    </option>
                                @endforeach
                            </select>
                            @error('product_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity</label>
                            <input type="number" name="quantity" id="quantity" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="{{ old('quantity') }}" step="0.01" min="0.01" required>
                            <p id="stock-info" class="text-sm text-gray-500 mt-1"></p>
                            @error('quantity')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="price_per_unit" class="block text-sm font-medium text-gray-700">Price Per Unit</label>
                            <input type="number" name="price_per_unit" id="price_per_unit" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="{{ old('price_per_unit') }}" step="0.01" min="0" required>
                            @error('price_per_unit')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="date" class="block text-sm font-medium text-gray-700">Date</label>
                            <input type="date" name="date" id="date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="{{ old('date', date('Y-m-d')) }}" required>
                            @error('date')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="type" class="block text-sm font-medium text-gray-700">Type</label>
                            <select name="type" id="type" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="sale" {{ old('type') == 'sale' ? 'selected' : '' }}>Sale</option>
                                <option value="damage" {{ old('type') == 'damage' ? 'selected' : '' }}>Damage</option>
                                <option value="lost" {{ old('type') == 'lost' ? 'selected' : '' }}>Lost</option>
                            </select>
                            @error('type')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
                            <textarea name="notes" id="notes" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('notes') }}</textarea>
                            @error('notes')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('stock-out.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">Cancel</a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Add Stock Out</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const productSelect = document.getElementById('product_id');
            const quantityInput = document.getElementById('quantity');
            const stockInfo = document.getElementById('stock-info');
            
            productSelect.addEventListener('change', function() {
                const selectedOption = productSelect.options[productSelect.selectedIndex];
                const stock = selectedOption.dataset.stock;
                
                if (stock) {
                    stockInfo.textContent = `Available stock: ${stock}`;
                } else {
                    stockInfo.textContent = '';
                }
            });
            
            quantityInput.addEventListener('input', function() {
                const selectedOption = productSelect.options[productSelect.selectedIndex];
                const stock = selectedOption.dataset.stock;
                const quantity = parseFloat(quantityInput.value);
                
                if (stock && quantity > parseFloat(stock)) {
                    quantityInput.setCustomValidity('Quantity exceeds available stock');
                    quantityInput.style.borderColor = '#ef4444';
                } else {
                    quantityInput.setCustomValidity('');
                    quantityInput.style.borderColor = '#d1d5db';
                }
            });
        });
    </script>
</x-app-layout>