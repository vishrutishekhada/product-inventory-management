<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Supplier') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('suppliers.update', $supplier) }}">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block font-medium text-sm text-gray-700">Supplier Name</label>
                                <input type="text" name="name" value="{{ $supplier->name }}" required
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            </div>

                            <div>
                                <label class="block font-medium text-sm text-gray-700">Email</label>
                                <input type="email" name="email" value="{{ $supplier->email }}" required
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            </div>

                            <div>
                                <label class="block font-medium text-sm text-gray-700">Phone</label>
                                <input type="text" name="phone" value="{{ $supplier->phone }}" required
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            </div>

                            <div>
                                <label class="block font-medium text-sm text-gray-700">Status</label>
                                <select name="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    <option value="active" {{ $supplier->status == 'active' ? 'selected' : '' }}>Active
                                    </option>
                                    <option value="inactive" {{ $supplier->status == 'inactive' ? 'selected' : '' }}>
                                        Inactive</option>
                                </select>
                            </div>

                            <div class="col-span-2">
                                <label class="block font-medium text-sm text-gray-700">Address</label>
                                <textarea name="address" rows="3"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ $supplier->address }}</textarea>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <a href="{{ route('suppliers.index') }}"
                                class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400 mr-2">Cancel</a>
                            <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Update
                                Supplier</button>
                        </div>
                    </form>

                    <div class="border-t mt-8 pt-6">
                        <form method="POST" action="{{ route('suppliers.destroy', $supplier) }}"
                            onsubmit="return confirm('Are you sure you want to delete this supplier?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-semibold">Delete
                                Supplier</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>