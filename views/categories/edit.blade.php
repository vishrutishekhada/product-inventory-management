<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Category') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('categories.update', $category) }}">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 gap-6 max-w-2xl">
                            <div>
                                <label class="block font-medium text-sm text-gray-700">Category Name</label>
                                <input type="text" name="name" value="{{ $category->name }}" required
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            </div>

                            <div>
                                <label class="block font-medium text-sm text-gray-700">Description</label>
                                <textarea name="description" rows="3"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ $category->description }}</textarea>
                            </div>

                            <div>
                                <label class="block font-medium text-sm text-gray-700">Status</label>
                                <select name="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    <option value="active" {{ $category->status == 'active' ? 'selected' : '' }}>Active
                                    </option>
                                    <option value="inactive" {{ $category->status == 'inactive' ? 'selected' : '' }}>
                                        Inactive</option>
                                </select>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end max-w-2xl">
                            <a href="{{ route('categories.index') }}"
                                class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400 mr-2">Cancel</a>
                            <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Update
                                Category</button>
                        </div>
                    </form>

                    <div class="border-t mt-8 pt-6 max-w-2xl">
                        <form method="POST" action="{{ route('categories.destroy', $category) }}"
                            onsubmit="return confirm('Are you sure you want to delete this category?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-semibold">Delete
                                Category</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>