<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Point of Sale') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-bold">Point of Sale (POS)</h1>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Product Search and Selection -->
                        <div class="lg:col-span-2 bg-gray-50 p-6 rounded-lg">
                            <h2 class="text-xl font-semibold mb-4">Add Item</h2>
                            
                            <div class="mb-4">
                                <label for="search_products" class="block text-sm font-medium text-gray-700 mb-1">Search Products</label>
                                <div class="relative">
                                    <input type="text" id="search_products" class="w-full p-2 border border-gray-300 rounded-md" placeholder="Search product by name or SKU...">
                                    <div id="search_results" class="absolute z-10 w-full bg-white border border-gray-300 rounded-md shadow-lg mt-1 hidden"></div>
                                </div>
                            </div>

                            <div id="selected_items">
                                <h3 class="text-lg font-semibold mb-3">Selected Items</h3>
                                <div id="items_list" class="mb-4">
                                    <p class="text-gray-500" id="no_items">No items added yet</p>
                                    <ul id="items_ul" class="hidden"></ul>
                                </div>
                                
                                <div class="flex justify-between items-center mt-4">
                                    <span class="text-lg font-semibold">Total: <span id="total_amount">Rp 0.00</span></span>
                                    <button id="process_sale" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded" disabled>Process Sale</button>
                                </div>
                            </div>
                        </div>

                        <!-- Products List -->
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h2 class="text-xl font-semibold mb-4">Products List</h2>
                            <div class="overflow-y-auto" style="max-height: 500px;">
                                <table class="min-w-full table-auto">
                                    <thead>
                                        <tr class="bg-gray-100">
                                            <th class="px-4 py-2">Name</th>
                                            <th class="px-4 py-2">Price</th>
                                            <th class="px-4 py-2">Stock</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($products as $product)
                                            <tr class="border-b" data-product-id="{{ $product->id }}" data-product-name="{{ $product->name }}" data-product-price="{{ $product->selling_price }}" data-product-stock="{{ $product->stock }}" data-product-unit="{{ $product->unit }}">
                                                <td class="px-4 py-2">{{ $product->name }}</td>
                                                <td class="px-4 py-2">Rp {{ number_format($product->selling_price, 2) }}</td>
                                                <td class="px-4 py-2">{{ $product->stock }} {{ $product->unit }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quantity Modal -->
    <div id="quantity_modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex justify-between items-center pb-3">
                    <h3 class="text-lg font-semibold">Enter Quantity</h3>
                    <button id="close_modal" class="text-gray-500 hover:text-gray-700">&times;</button>
                </div>
                <div class="p-4">
                    <p id="modal_product_name" class="font-medium mb-3"></p>
                    <div class="mb-4">
                        <label for="quantity_input" class="block text-sm font-medium text-gray-700 mb-1">Quantity</label>
                        <input type="number" id="quantity_input" class="w-full p-2 border border-gray-300 rounded-md" min="0.01" step="0.01" value="1">
                        <p id="stock_availability" class="text-sm text-gray-500 mt-1"></p>
                    </div>
                    <div class="flex justify-end space-x-2">
                        <button id="cancel_modal" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-700">Cancel</button>
                        <button id="add_to_cart" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-700">Add to Cart</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let cart = [];
        let currentProduct = null;

        document.addEventListener('DOMContentLoaded', function() {
            // Product selection from the table
            const productRows = document.querySelectorAll('tbody tr');
            productRows.forEach(row => {
                row.addEventListener('click', function() {
                    const product = {
                        id: this.dataset.productId,
                        name: this.dataset.productName,
                        price: parseFloat(this.dataset.productPrice),
                        stock: parseFloat(this.dataset.productStock),
                        unit: this.dataset.productUnit
                    };
                    
                    showQuantityModal(product);
                });
            });

            // Search functionality
            const searchInput = document.getElementById('search_products');
            const searchResults = document.getElementById('search_results');
            
            searchInput.addEventListener('input', function() {
                const query = this.value.trim();
                
                if (query.length > 1) {
                    fetch(`/pos/search?q=${query}`)
                        .then(response => response.json())
                        .then(products => {
                            searchResults.innerHTML = '';
                            
                            if (products.length > 0) {
                                products.forEach(product => {
                                    const div = document.createElement('div');
                                    div.className = 'p-2 hover:bg-gray-100 cursor-pointer border-b';
                                    div.textContent = `${product.name} - Rp ${product.selling_price}`;
                                    div.dataset.productId = product.id;
                                    div.dataset.productName = product.name;
                                    div.dataset.productPrice = product.selling_price;
                                    div.dataset.productStock = product.stock;
                                    div.dataset.productUnit = product.unit;
                                    
                                    div.addEventListener('click', function() {
                                        const product = {
                                            id: this.dataset.productId,
                                            name: this.dataset.productName,
                                            price: parseFloat(this.dataset.productPrice),
                                            stock: parseFloat(this.dataset.productStock),
                                            unit: this.dataset.productUnit
                                        };
                                        
                                        showQuantityModal(product);
                                        searchResults.classList.add('hidden');
                                        searchInput.value = '';
                                    });
                                    
                                    searchResults.appendChild(div);
                                });
                                
                                searchResults.classList.remove('hidden');
                            } else {
                                searchResults.classList.add('hidden');
                            }
                        })
                        .catch(error => console.error('Error:', error));
                } else {
                    searchResults.classList.add('hidden');
                }
            });

            // Quantity modal functionality
            const quantityModal = document.getElementById('quantity_modal');
            const closeModalBtn = document.getElementById('close_modal');
            const cancelModalBtn = document.getElementById('cancel_modal');
            const addToCartBtn = document.getElementById('add_to_cart');
            
            closeModalBtn.addEventListener('click', hideQuantityModal);
            cancelModalBtn.addEventListener('click', hideQuantityModal);
            
            addToCartBtn.addEventListener('click', function() {
                const quantityInput = document.getElementById('quantity_input');
                const quantity = parseFloat(quantityInput.value);
                
                if (quantity <= 0) {
                    alert('Quantity must be greater than 0');
                    return;
                }
                
                if (quantity > currentProduct.stock) {
                    alert('Quantity exceeds available stock');
                    return;
                }
                
                // Check if product is already in cart
                const existingItem = cart.find(item => item.id === currentProduct.id);
                
                if (existingItem) {
                    // Update quantity if it doesn't exceed stock
                    const newQuantity = existingItem.quantity + quantity;
                    if (newQuantity > currentProduct.stock) {
                        alert('Total quantity exceeds available stock');
                        return;
                    }
                    existingItem.quantity = newQuantity;
                } else {
                    // Add new item to cart
                    cart.push({
                        id: currentProduct.id,
                        name: currentProduct.name,
                        price: currentProduct.price,
                        quantity: quantity,
                        unit: currentProduct.unit
                    });
                }
                
                updateCartDisplay();
                hideQuantityModal();
            });

            // Process sale button
            document.getElementById('process_sale').addEventListener('click', processSale);
        });

        function showQuantityModal(product) {
            currentProduct = product;
            
            document.getElementById('modal_product_name').textContent = `${product.name} - Rp ${product.price}`;
            document.getElementById('quantity_input').value = '1';
            document.getElementById('stock_availability').textContent = `Available: ${product.stock} ${product.unit}`;
            
            document.getElementById('quantity_modal').classList.remove('hidden');
        }

        function hideQuantityModal() {
            document.getElementById('quantity_modal').classList.add('hidden');
        }

        function updateCartDisplay() {
            const itemsList = document.getElementById('items_list');
            const itemsUl = document.getElementById('items_ul');
            const noItems = document.getElementById('no_items');
            const totalAmount = document.getElementById('total_amount');
            const processSaleBtn = document.getElementById('process_sale');
            
            if (cart.length > 0) {
                noItems.classList.add('hidden');
                itemsUl.classList.remove('hidden');
                
                itemsUl.innerHTML = '';
                
                let total = 0;
                
                cart.forEach((item, index) => {
                    const totalItemPrice = item.quantity * item.price;
                    total += totalItemPrice;
                    
                    const li = document.createElement('li');
                    li.className = 'flex justify-between items-center py-2 border-b';
                    li.innerHTML = `
                        <div>
                            <span class="font-medium">${item.name}</span>
                            <span class="text-gray-600 ml-2">${item.quantity} ${item.unit}</span>
                        </div>
                        <div class="flex items-center">
                            <span class="mr-4">Rp ${totalItemPrice.toFixed(2)}</span>
                            <button class="text-red-500 hover:text-red-700 remove-item" data-index="${index}">Remove</button>
                        </div>
                    `;
                    
                    itemsUl.appendChild(li);
                });
                
                // Add event listeners to remove buttons
                document.querySelectorAll('.remove-item').forEach(button => {
                    button.addEventListener('click', function() {
                        const index = parseInt(this.dataset.index);
                        cart.splice(index, 1);
                        updateCartDisplay();
                    });
                });
                
                totalAmount.textContent = `Rp ${total.toFixed(2)}`;
                processSaleBtn.disabled = false;
            } else {
                noItems.classList.remove('hidden');
                itemsUl.classList.add('hidden');
                totalAmount.textContent = 'Rp 0.00';
                processSaleBtn.disabled = true;
            }
        }

        function processSale() {
            if (cart.length === 0) {
                alert('Cart is empty');
                return;
            }
            
            // Send the sale to the server
            fetch('/pos/process', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    items: cart.map(item => ({
                        product_id: item.id,
                        quantity: item.quantity,
                        price_per_unit: item.price
                    }))
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Sale processed successfully!');
                    cart = [];
                    updateCartDisplay();
                } else if (data.error) {
                    alert(data.error);
                } else if (data.errors) {
                    let errorMsg = '';
                    for (const field in data.errors) {
                        errorMsg += data.errors[field][0] + '\n';
                    }
                    alert(errorMsg);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while processing the sale');
            });
        }
    </script>
</x-app-layout>