<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create Course
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded shadow">

                <form method="POST" action="{{ route('teacher.courses.store') }}">
                    @csrf

                    <div class="mb-4">
                        <label>Title</label>
                        <input type="text" name="title" class="w-full border rounded p-2">
                    </div>

                    <div class="mb-4">
                        <label>Description</label>
                        <textarea name="description" class="w-full border rounded p-2"></textarea>
                    </div>

                    <div class="mb-4">
                        <label>Price</label>
                        <input type="number" name="price" class="w-full border rounded p-2">
                    </div>

                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
                        Create
                    </button>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>