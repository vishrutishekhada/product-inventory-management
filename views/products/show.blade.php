<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Product Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ $product->name }}</h3>
                            <p class="text-gray-500 mb-4">SKU: {{ $product->sku }} | Category:
                                {{ $product->category->name }}</p>
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $product->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ ucfirst($product->status) }}
                            </span>
                        </div>
                        <div class="text-right">
                            <div class="text-3xl font-bold text-gray-900 mb-1">{{ $product->quantity }}</div>
                            <p class="text-sm text-gray-500 mb-2">In Stock</p>
                            @if($product->quantity <= $product->reorder_level)
                                <span class="bg-red-500 text-white px-3 py-1 rounded-full text-xs animate-pulse">Low
                                    Stock</span>
                            @endif
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-8 border-t pt-8">
                        <div>
                            <h4 class="text-lg font-semibold mb-4">Pricing Info</h4>
                            <div class="bg-gray-50 p-4 rounded-md">
                                <div class="flex justify-between mb-2">
                                    <span class="text-gray-600">Cost Price:</span>
                                    <span class="font-medium">₹{{ number_format($product->cost_price, 2) }}</span>
                                </div>
                                <div class="flex justify-between mb-2">
                                    <span class="text-gray-600">Selling Price:</span>
                                    <span
                                        class="font-medium text-green-600">₹{{ number_format($product->selling_price, 2) }}</span>
                                </div>
                                <div class="flex justify-between border-t border-gray-200 pt-2 mt-2">
                                    <span class="text-gray-600">Profit Margin:</span>
                                    <span class="font-medium">{{ number_format($product->profit_margin, 1) }}%</span>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h4 class="text-lg font-semibold mb-4">Stock Value</h4>
                            <div class="bg-gray-50 p-4 rounded-md">
                                <div class="flex justify-between mb-2">
                                    <span class="text-gray-600">Total Stock Value:</span>
                                    <span
                                        class="font-bold text-indigo-600">₹{{ number_format($product->stock_value, 2) }}</span>
                                </div>
                                <div class="flex justify-between mb-2">
                                    <span class="text-gray-600">Reorder Level:</span>
                                    <span class="font-medium">{{ $product->reorder_level }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($product->description)
                        <div class="mt-8">
                            <h4 class="text-lg font-semibold mb-2">Description</h4>
                            <p class="text-gray-600 bg-gray-50 p-4 rounded-md">{{ $product->description }}</p>
                        </div>
                    @endif

                    <div class="mt-8 flex gap-4">
                        <a href="{{ route('products.edit', $product) }}"
                            class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Edit Product</a>
                        <a href="{{ route('products.index') }}"
                            class="px-4 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50">Back to
                            List</a>
                    </div>
                </div>
            </div>

            <!-- Stock Logs History -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">Recent Stock Movements</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Date</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Type</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Quantity</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Reason</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        User</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($product->stockLogs()->latest()->limit(10)->get() as $log)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $log->created_at->format('d M Y H:i') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $log->type == 'in' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ strtoupper($log->type) }}
                                            </span>
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm font-medium {{ $log->type == 'in' ? 'text-green-600' : 'text-red-600' }}">
                                            {{ $log->type == 'in' ? '+' : '-' }}{{ $log->quantity }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ ucfirst($log->reference_type) }} #{{ $log->reference_id }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $log->creator->name }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">No logs found.</td>
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