<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Product') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('products.update', $product) }}">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block font-medium text-sm text-gray-700">Product Name</label>
                                <input type="text" name="name" value="{{ $product->name }}" required
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            </div>

                            <div>
                                <label class="block font-medium text-sm text-gray-700">SKU (Unique)</label>
                                <input type="text" name="sku" value="{{ $product->sku }}" required
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            </div>

                            <div>
                                <label class="block font-medium text-sm text-gray-700">Category</label>
                                <select name="category_id" required
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block font-medium text-sm text-gray-700">Brand</label>
                                <input type="text" name="brand" value="{{ $product->brand }}"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            </div>

                            <div>
                                <label class="block font-medium text-sm text-gray-700">Cost Price</label>
                                <input type="number" name="cost_price" value="{{ $product->cost_price }}" step="0.01"
                                    required min="0" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            </div>

                            <div>
                                <label class="block font-medium text-sm text-gray-700">Selling Price</label>
                                <input type="number" name="selling_price" value="{{ $product->selling_price }}"
                                    step="0.01" required min="0"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            </div>

                            <div>
                                <label class="block font-medium text-sm text-gray-700">Current Quantity</label>
                                <input type="number" name="quantity" value="{{ $product->quantity }}" required min="0"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                <p class="text-xs text-gray-500 mt-1">Note: Typically stock is updated via
                                    Purchases/Sales</p>
                            </div>

                            <div>
                                <label class="block font-medium text-sm text-gray-700">Reorder Level</label>
                                <input type="number" name="reorder_level" value="{{ $product->reorder_level }}" required
                                    min="0" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            </div>

                            <div class="col-span-2">
                                <label class="block font-medium text-sm text-gray-700">Description</label>
                                <textarea name="description" rows="3"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ $product->description }}</textarea>
                            </div>

                            <div class="col-span-2">
                                <label class="block font-medium text-sm text-gray-700">Status</label>
                                <select name="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    <option value="active" {{ $product->status == 'active' ? 'selected' : '' }}>Active
                                    </option>
                                    <option value="inactive" {{ $product->status == 'inactive' ? 'selected' : '' }}>
                                        Inactive</option>
                                </select>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <a href="{{ route('products.index') }}"
                                class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400 mr-2">Cancel</a>
                            <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Update
                                Product</button>
                        </div>
                    </form>

                    <div class="border-t mt-8 pt-6">
                        <form method="POST" action="{{ route('products.destroy', $product) }}"
                            onsubmit="return confirm('Are you sure you want to delete this product?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-semibold">Delete
                                Product</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>