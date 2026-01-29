<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('New Purchase') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('purchases.store') }}">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                            <div>
                                <label class="block font-medium text-sm text-gray-700">Invoice Number</label>
                                <input type="text" name="invoice_number" value="{{ $invoiceNumber }}" readonly
                                    class="mt-1 block w-full bg-gray-100 border-gray-300 rounded-md shadow-sm">
                            </div>
                            <div>
                                <label class="block font-medium text-sm text-gray-700">Purchase Date</label>
                                <input type="date" name="purchase_date" value="{{ date('Y-m-d') }}"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            </div>
                            <div>
                                <label class="block font-medium text-sm text-gray-700">Supplier</label>
                                <select name="supplier_id" required
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    <option value="">Select Supplier</option>
                                    @foreach($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <h3 class="text-lg font-medium text-gray-900 mb-4">Items</h3>

                        <div id="items-container">
                            <div class="item-row grid grid-cols-12 gap-4 mb-4 items-end">
                                <div class="col-span-4">
                                    <label class="block font-medium text-sm text-gray-700">Product</label>
                                    <select name="items[0][product_id]" required
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm product-select">
                                        <option value="">Select Product</option>
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}" data-price="{{ $product->cost_price }}">
                                                {{ $product->name }} (Current Cost: ₹{{ $product->cost_price }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-span-3">
                                    <label class="block font-medium text-sm text-gray-700">Cost Price</label>
                                    <input type="number" name="items[0][cost_price]" step="0.01"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm price-input"
                                        oninput="calculateTotal()">
                                </div>
                                <div class="col-span-2">
                                    <label class="block font-medium text-sm text-gray-700">Quantity</label>
                                    <input type="number" name="items[0][quantity]" min="1" value="1" required
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm qty-input"
                                        oninput="calculateTotal()">
                                </div>
                                <div class="col-span-2">
                                    <label class="block font-medium text-sm text-gray-700">Subtotal</label>
                                    <input type="number" step="0.01"
                                        class="mt-1 block w-full bg-gray-50 border-gray-300 rounded-md shadow-sm subtotal-input"
                                        readonly>
                                </div>
                                <div class="col-span-1">
                                    <button type="button" class="mt-6 text-red-600 hover:text-red-900"
                                        onclick="removeRow(this)">X</button>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 mb-6">
                            <button type="button" onclick="addItem()"
                                class="text-sm text-green-600 hover:text-green-900">+ Add Another Item</button>
                        </div>

                        <div class="border-t pt-4 flex justify-end">
                            <div class="text-xl font-bold">Total: ₹<span id="grand-total">0.00</span></div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <button type="submit"
                                class="px-6 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 font-semibold">Complete
                                Purchase</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        let itemCount = 1;

        // Auto-fill cost price when product selected
        document.addEventListener('change', function (e) {
            if (e.target.classList.contains('product-select')) {
                const row = e.target.closest('.item-row');
                const option = e.target.options[e.target.selectedIndex];
                const price = option.getAttribute('data-price') || 0;

                // Only set price if input is empty
                if (!row.querySelector('.price-input').value) {
                    row.querySelector('.price-input').value = price;
                    calculateTotal();
                }
            }
        });

        function calculateTotal() {
            let grandTotal = 0;
            document.querySelectorAll('.item-row').forEach(row => {
                const price = parseFloat(row.querySelector('.price-input').value) || 0;
                const qty = parseFloat(row.querySelector('.qty-input').value) || 0;
                const subtotal = price * qty;

                row.querySelector('.subtotal-input').value = subtotal.toFixed(2);
                grandTotal += subtotal;
            });
            document.getElementById('grand-total').textContent = grandTotal.toFixed(2);
        }

        function addItem() {
            const container = document.getElementById('items-container');
            const newRow = container.querySelector('.item-row').cloneNode(true);

            // Clear values
            newRow.querySelector('select').value = '';
            newRow.querySelector('.price-input').value = '';
            newRow.querySelector('.qty-input').value = '1';
            newRow.querySelector('.subtotal-input').value = '';

            // Update names
            newRow.querySelector('select').name = `items[${itemCount}][product_id]`;
            newRow.querySelector('.price-input').name = `items[${itemCount}][cost_price]`;
            newRow.querySelector('.qty-input').name = `items[${itemCount}][quantity]`;

            container.appendChild(newRow);
            itemCount++;
        }

        function removeRow(btn) {
            if (document.querySelectorAll('.item-row').length > 1) {
                btn.closest('.item-row').remove();
                calculateTotal();
            }
        }
    </script>
</x-app-layout>