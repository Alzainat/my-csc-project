<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Courses
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded p-6">

                @forelse($courses as $course)
                    <div class="border-b pb-4 mb-4">
                        <h3 class="text-lg font-bold">{{ $course->title }}</h3>

                        <p class="mb-1">{{ $course->description }}</p>

                        <p class="text-sm text-gray-600 mb-2">
                            Teacher: {{ $course->teacher->name }}
                        </p>

                        <form method="POST"
                              action="{{ route('student.courses.register', $course->id) }}">
                            @csrf
                            <button type="submit"
                                    class="mt-2 text-blue-600 font-semibold hover:underline">
                                Register
                            </button>
                        </form>
                    </div>
                @empty
                    <p>No courses available</p>
                @endforelse

            </div>
        </div>
    </div>

    {{-- SweetAlert CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- Sweet Pop-up Message --}}
    @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Request Sent 💖',
                text: "{{ session('success') }}",
                confirmButtonColor: '#9333ea',
                confirmButtonText: 'Okay ✨'
            });
        </script>
    @endif

</x-app-layout>