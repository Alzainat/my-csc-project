<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            My Courses
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded shadow">

                <a href="{{ route('teacher.courses.create') }}"
                   class="text-blue-600 font-semibold">
                    + Add New Course
                </a>

                <hr class="my-4">

                @forelse($courses as $course)
                    <div class="border-b pb-3 mb-3">
                        <h3 class="font-bold">{{ $course->title }}</h3>
                        <p>{{ $course->description }}</p>
                        <p class="text-sm text-gray-600">
                            Price: {{ $course->price }}
                        </p>
                    </div>
                @empty
                    <p>No courses yet</p>
                @endforelse

            </div>
        </div>
    </div>
</x-app-layout>