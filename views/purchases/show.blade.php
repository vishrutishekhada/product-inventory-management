<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Purchase Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="md:flex md:justify-between mb-6">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Invoice: {{ $purchase->invoice_number }}</h3>
                            <p class="text-sm text-gray-500">Date: {{ $purchase->purchase_date->format('d M Y') }}</p>
                        </div>
                        <div class="mt-4 md:mt-0">
                            <h4 class="text-md font-semibold text-gray-700">Supplier Info</h4>
                            <p class="text-gray-600">{{ $purchase->supplier->name }}</p>
                            <p class="text-sm text-gray-500">{{ $purchase->supplier->email }}</p>
                        </div>
                    </div>

                    <div class="overflow-x-auto mb-6">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Product</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        SKU</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Cost Price</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Quantity</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Total</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($purchase->purchaseItems as $item)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $item->product->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $item->product->sku }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            ₹{{ number_format($item->cost_price, 2) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item->quantity }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                            ₹{{ number_format($item->subtotal, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="flex justify-end border-t pt-4">
                        <div class="text-right">
                            <p class="text-lg font-bold">Grand Total: ₹{{ number_format($purchase->total_amount, 2) }}
                            </p>
                            <p class="text-sm text-gray-500 mt-1">Created By: {{ $purchase->creator->name }}</p>
                        </div>
                    </div>

                    <div class="mt-6">
                        <a href="{{ route('purchases.index') }}" class="text-indigo-600 hover:text-indigo-900">Back to
                            Purchase History</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>