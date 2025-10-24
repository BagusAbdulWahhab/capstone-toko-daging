<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Product') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-bold mb-6">Create New Product</h1>

                    <form method="POST" action="{{ route('products.store') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                            <input type="text" name="name" id="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="{{ old('name') }}" required>
                            @error('name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="sku" class="block text-sm font-medium text-gray-700">SKU (Optional)</label>
                            <input type="text" name="sku" id="sku" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="{{ old('sku') }}">
                            @error('sku')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="unit" class="block text-sm font-medium text-gray-700">Unit</label>
                            <select name="unit" id="unit" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="Kg" {{ old('unit') == 'Kg' ? 'selected' : '' }}>Kg</option>
                                <option value="Gram" {{ old('unit') == 'Gram' ? 'selected' : '' }}>Gram</option>
                                <option value="Pcs" {{ old('unit') == 'Pcs' ? 'selected' : '' }}>Pcs</option>
                            </select>
                            @error('unit')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="purchase_price" class="block text-sm font-medium text-gray-700">Purchase Price</label>
                            <input type="number" name="purchase_price" id="purchase_price" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="{{ old('purchase_price') }}" step="0.01" min="0" required>
                            @error('purchase_price')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="selling_price" class="block text-sm font-medium text-gray-700">Selling Price</label>
                            <input type="number" name="selling_price" id="selling_price" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="{{ old('selling_price') }}" step="0.01" min="0" required>
                            @error('selling_price')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('products.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">Cancel</a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Create Product</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>