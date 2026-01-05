<x-app-layout>
    <div class="flex min-h-screen bg-gray-100">

        {{-- ================= Sidebar ================= --}}
        <aside class="w-52 bg-white shadow">
            <div class="p-6 border-b">
                <h2 class="text-xl font-bold text-gray-800">Teacher Panel</h2>
                <p class="text-sm text-gray-500">{{ auth()->user()->name }}</p>
            </div>

            <nav class="p-4 space-y-2">
                <button onclick="showSection('overview')"
                        class="sidebar-btn">
                    📊 Dashboard
                </button>

                <button onclick="showSection('courses')"
                        class="sidebar-btn">
                    📚 My Courses
                </button>

                <button onclick="showSection('pending')"
                        class="sidebar-btn">
                    ⏳ Pending Requests
                </button>

                <button onclick="showSection('approved')"
                        class="sidebar-btn">
                    ✅ Approved Students
                </button>
            </nav>
        </aside>

        {{-- ================= Main Content ================= --}}
        <main class="flex-1 p-6 space-y-8 bg-gray-50">

            {{-- ===== Dashboard Overview ===== --}}
            <section id="overview" class="dashboard-section">
                <h2 class="text-2xl font-bold mb-6">Overview</h2>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white p-6 rounded shadow">
                        <p class="text-gray-500 text-sm">My Courses</p>
                        <p class="text-3xl font-bold">
                            {{ $courses->count() }}
                        </p>
                    </div>

                    <div class="bg-white p-6 rounded shadow">
                        <p class="text-gray-500 text-sm">Pending Requests</p>
                        <p class="text-3xl font-bold text-yellow-500">
                            {{ $courses->sum(fn($c) => $c->students->where('pivot.status','pending')->count()) }}
                        </p>
                    </div>

                    <div class="bg-white p-6 rounded shadow">
                        <p class="text-gray-500 text-sm">Approved Students</p>
                        <p class="text-3xl font-bold text-green-600">
                            {{ $courses->sum(fn($c) => $c->students->where('pivot.status','approved')->count()) }}
                        </p>
                    </div>
                </div>
            </section>

            {{-- ===== My Courses ===== --}}
<section id="courses" class="dashboard-section hidden">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold text-gray-800">
            My Courses
        </h2>

        <button onclick="openAddCourseModal()"
                class="px-4 py-2 bg-indigo-600 text-white rounded text-sm">
            ➕ Add Course
        </button>
    </div>

    <div class="bg-white rounded-lg shadow-sm border overflow-hidden">
        <table class="w-full text-sm text-gray-700">
            <thead class="bg-gray-50 text-gray-600">
                <tr>
                    <th class="px-4 py-3 text-left">Title</th>
                    <th class="px-4 py-3 text-center">Students</th>
                    <th class="px-4 py-3 text-center">Status</th>
                    <th class="px-4 py-3 text-center">Actions</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @foreach($courses as $course)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 font-medium">
                            {{ $course->title }}
                        </td>

                        <td class="px-4 py-3 text-center">
                            {{ $course->students->count() }}
                        </td>

                        <td class="px-4 py-3 text-center">
                            <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-700">
                                Active
                            </span>
                        </td>

                        <td class="px-4 py-3 text-center space-x-2">
    <button
        onclick="openStudentsModal({{ $course->id }})"
        class="text-indigo-600 hover:underline text-sm">
        👀 Students
    </button>

    <button
        onclick="openChatModal({{ $course->id }})"
        class="text-green-600 hover:underline text-sm">
        💬 Chat
    </button>
</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>

            {{-- ===== Pending Requests ===== --}}
            <section id="pending" class="dashboard-section hidden">
                <h2 class="text-2xl font-bold mb-4">Pending Requests</h2>

                <div class="bg-white rounded shadow p-4 space-y-3">
                    @foreach($courses as $course)
                        @foreach($course->students->where('pivot.status','pending') as $student)
                            <div class="flex justify-between items-center border p-3 rounded">
                                <div>
                                    <p class="font-semibold">{{ $student->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $course->title }}</p>
                                </div>

                                <div class="space-x-2">
                                    <form method="POST"
                                          action="{{ route('teacher.requests.approve', [$course->id, $student->id]) }}"
                                          class="inline">
                                        @csrf
                                        <button class="px-3 py-1 bg-green-600 text-white rounded">
                                            Approve
                                        </button>
                                    </form>

                                    <form method="POST"
                                          action="{{ route('teacher.requests.reject', [$course->id, $student->id]) }}"
                                          class="inline">
                                        @csrf
                                        <button class="px-3 py-1 bg-red-600 text-white rounded">
                                            Reject
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    @endforeach
                </div>
            </section>

            {{-- ===== Approved Students ===== --}}
            <section id="approved" class="dashboard-section hidden">
                <h2 class="text-2xl font-bold mb-4">Approved Students</h2>

                <div class="bg-white rounded shadow p-4">
                    @foreach($courses as $course)
                        @foreach($course->students->where('pivot.status','approved') as $student)
                            <p class="border-b py-2">
                                {{ $student->name }} – 
                                <span class="text-gray-500">{{ $course->title }}</span>
                            </p>
                        @endforeach
                    @endforeach
                </div>
            </section>

        </main>
    </div>



    {{-- ================= JS ================= --}}
    <script>
        function showSection(id) {
            document.querySelectorAll('.dashboard-section')
                .forEach(sec => sec.classList.add('hidden'));

            document.getElementById(id).classList.remove('hidden');
        }
    </script>

    {{-- ================= Styles ================= --}}
    <style>
        .sidebar-btn {
            width: 100%;
            text-align: left;
            padding: 0.75rem;
            border-radius: 0.5rem;
            color: #374151;
            font-weight: 500;
        }
        .sidebar-btn:hover {
            background-color: #f3f4f6;
        }
    </style>
    {{-- ===== Students Modal ===== --}}
<div id="studentsModal"
     class="fixed inset-0 bg-black bg-opacity-40 hidden items-center justify-center z-50">

    <div class="bg-white w-full max-w-lg rounded-lg shadow-lg p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold">Course Students</h3>
            <button onclick="closeStudentsModal()">✖</button>
        </div>

        <div id="studentsContent" class="space-y-2">
            {{-- Filled by JS --}}
        </div>
    </div>
</div>

{{-- ===== Add Course Modal ===== --}}
<div id="addCourseModal"
     class="fixed inset-0 bg-black bg-opacity-40 hidden items-center justify-center z-50">

    <div class="bg-white w-full max-w-lg rounded-lg shadow-lg p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold">Add New Course</h3>
            <button type="button" onclick="closeAddCourseModal()">✖</button>
        </div>

        <form method="POST" action="{{ route('teacher.courses.store') }}">
            @csrf

            <div class="mb-4">
                <label class="text-sm text-gray-600">Title</label>
                <input name="title" required
                       class="w-full border rounded px-3 py-2">
            </div>

            <div class="mb-4">
                <label class="text-sm text-gray-600">Description</label>
                <textarea name="description" required
                          class="w-full border rounded px-3 py-2"></textarea>
            </div>

            <div class="mb-4">
                <label class="text-sm text-gray-600">Price</label>
                <input type="number" name="price"
                       class="w-full border rounded px-3 py-2">
            </div>

            <div class="flex justify-end gap-2">
                <button type="button"
                        onclick="closeAddCourseModal()"
                        class="px-4 py-2 border rounded text-sm">
                    Cancel
                </button>

                <button type="submit"
                        class="px-4 py-2 bg-indigo-600 text-white rounded text-sm">
                    Save
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ===== Chat Modal ===== --}}
<div id="chatModal"
     class="fixed inset-0 bg-black bg-opacity-40 hidden items-center justify-center z-50">

    <div class="bg-white w-full max-w-xl rounded-lg shadow-lg flex flex-col h-[500px]">

        {{-- Header --}}
        <div class="p-4 border-b flex justify-between items-center">
            <h3 class="font-semibold text-gray-800">
                Course Chat
            </h3>
            <button onclick="closeChatModal()">✖</button>
        </div>

        {{-- Messages --}}
        <div id="chatMessages"
             class="flex-1 overflow-y-auto p-4 space-y-3 text-sm bg-gray-50">
        </div>

        {{-- Input --}}
        <form onsubmit="sendChatMessage(event)"
              class="p-3 border-t flex gap-2">
            <input id="chatInput"
                   class="flex-1 border rounded px-3 py-2 text-sm"
                   placeholder="Type a message...">
            <button
                class="px-4 py-2 bg-indigo-600 text-white rounded text-sm">
                Send
            </button>
        </form>
    </div>
</div>

<script>
    const coursesData = @json($courses);

    function openStudentsModal(courseId) {
        const modal = document.getElementById('studentsModal');
        const content = document.getElementById('studentsContent');

        const course = coursesData.find(c => c.id === courseId);

        content.innerHTML = '';

        if (course.students.length === 0) {
            content.innerHTML = '<p class="text-gray-500">No students yet</p>';
        } else {
            course.students.forEach(student => {
                const status = student.pivot.status;
                const color = status === 'approved'
                    ? 'text-green-600'
                    : status === 'pending'
                        ? 'text-yellow-600'
                        : 'text-red-600';

                content.innerHTML += `
                    <div class="flex justify-between border-b pb-2">
                        <span>${student.name}</span>
                        <span class="${color} text-sm capitalize">${status}</span>
                    </div>
                `;
            });
        }

        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }


    function closeStudentsModal() {
        document.getElementById('studentsModal').classList.add('hidden');
    }
    function openAddCourseModal() {
    const modal = document.getElementById('addCourseModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeAddCourseModal() {
    const modal = document.getElementById('addCourseModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}
</script>
<script>
    let currentCourseId = null;

    function openChatModal(courseId) {
        currentCourseId = courseId;

        document.getElementById('chatModal').classList.remove('hidden');
        document.getElementById('chatModal').classList.add('flex');

        loadChatMessages();
    }

    function closeChatModal() {
        document.getElementById('chatModal').classList.add('hidden');
        currentCourseId = null;
    }

    function loadChatMessages() {
        fetch(`/courses/${currentCourseId}/chat`)
            .then(res => res.json())
            .then(messages => {
                const box = document.getElementById('chatMessages');
                box.innerHTML = '';

                messages.forEach(msg => {
                    const isMe = msg.user_id === {{ auth()->id() }};

                    box.innerHTML += `
                        <div class="${isMe ? 'text-right' : 'text-left'}">
                            <p class="text-xs text-gray-500">
                                ${msg.user.name}
                            </p>
                            <span class="inline-block px-3 py-2 rounded 
                                ${isMe ? 'bg-indigo-600 text-black' : 'bg-white border'}">
                                ${msg.message}
                            </span>
                        </div>
                    `;
                });

                box.scrollTop = box.scrollHeight;
            });
    }

    function sendChatMessage(event) {
        event.preventDefault();

        const input = document.getElementById('chatInput');
        const message = input.value.trim();

        if (!message) return;

        fetch(`/courses/${currentCourseId}/chat`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ message })
        })
        .then(() => {
            input.value = '';
            loadChatMessages();
        });
    }
</script>
</x-app-layout>