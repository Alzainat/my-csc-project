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

        {{-- Typing Indicator --}}
        <div id="typingIndicator"
             class="px-4 pb-2 text-xs text-gray-500 hidden">
        </div>

        {{-- Input --}}
        <form onsubmit="sendChatMessage(event)"
              class="p-3 border-t flex gap-2">
            <input id="chatInput"
                   oninput="typing()"
                   class="flex-1 border rounded px-3 py-2 text-sm text-black"
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
    console.log('Echo:', window.Echo);
    const AUTH_USER_ID = {{ auth()->id() }};
    const AUTH_USER_NAME = "{{ auth()->user()->name }}";
    let currentCourseId = null;
    let chatChannel = null;
    let typingTimer = null;

    function openChatModal(courseId) {
        
        if (chatChannel) {
    window.Echo.leave(`course.${currentCourseId}`);
    chatChannel = null;
}
currentCourseId = courseId;

        const modal = document.getElementById('chatModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');

        // 1️⃣ تحميل الرسائل القديمة
        fetch(`/courses/${courseId}/chat`)
            .then(res => res.json())
            .then(messages => {
                const box = document.getElementById('chatMessages');
                box.innerHTML = '';

                messages.forEach(msg => {
                    appendMessage(msg, msg.user_id === AUTH_USER_ID);
                });

                box.scrollTop = box.scrollHeight;
            })
            .catch(err => console.error('Failed to load messages:', err));

        // 2️⃣ الاشتراك بالقناة - هنا التعديل المهم
        chatChannel = window.Echo.private(`course.${courseId}`)
    .listen('.course.message', e => {
        appendMessage(e.message, e.message.user_id === AUTH_USER_ID);
        hideTyping();
    })
    .listenForWhisper('typing', e => {
        if (e.user_id !== AUTH_USER_ID) {
            showTyping(e.name);
        }
    });

        console.log('Subscribed to channel:', `course.${courseId}`);
    }

    function closeChatModal() {
        const modal = document.getElementById('chatModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');

        if (chatChannel) {
            window.Echo.leave(`course.${currentCourseId}`);
            chatChannel = null;
            console.log('Left channel');
        }

        currentCourseId = null;
        hideTyping();
        document.getElementById('chatInput').value = '';
    }

    function sendChatMessage(event) {
        event.preventDefault();

        const input = document.getElementById('chatInput');
        const message = input.value.trim();
        
        if (!message || !currentCourseId) return;

        

        fetch(`/courses/${currentCourseId}/chat`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ message })
        })
        .then(res => {
            if (!res.ok) throw new Error('Failed to send message');
            return res.json();
        })
        .then(msg => {
            console.log('Message sent successfully:', msg);
            input.value = '';
            hideTyping();
        })
        .catch(err => {
            console.error('Send message error:', err);
            alert('Failed to send message');
        });
    }

    function appendMessage(msg, mine) {
        const box = document.getElementById('chatMessages');
        
        // تأكد إنه الرسالة مش موجودة مسبقاً
        const existingMsg = box.querySelector(`[data-msg-id="${msg.id}"]`);
        if (existingMsg) return;

        const div = document.createElement('div');
        div.setAttribute('data-msg-id', msg.id);
        div.className = mine ? 'text-right' : 'text-left';
        
        const userName = mine ? 'You' : (msg.user?.name || 'Unknown');
        
        div.innerHTML = `
            <p class="text-xs text-gray-500 mb-1">
                ${userName}
            </p>
            <span class="inline-block px-3 py-2 rounded text-sm
                ${mine ? 'bg-indigo-600 text-white' : 'bg-white border border-gray-200'}">
                ${escapeHtml(msg.message)}
            </span>
        `;

        box.appendChild(div);
        box.scrollTop = box.scrollHeight;
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // ===== Typing Indicator =====
    function typing() {
    if (!chatChannel) return;

    chatChannel.whisper('typing', {
        user_id: AUTH_USER_ID,
        name: AUTH_USER_NAME
    });

    clearTimeout(typingTimer);
    typingTimer = setTimeout(hideTyping, 2500);
}

    function showTyping(name) {
    const el = document.getElementById('typingIndicator');
    el.textContent = `${name} is typing...`;
    el.classList.remove('hidden');
}

    function hideTyping() {
        const el = document.getElementById('typingIndicator');
        el.classList.add('hidden');
        el.textContent = '';
    }

    // عند تحميل الصفحة - تأكد من وجود Echo
    document.addEventListener('DOMContentLoaded', () => {
        if (typeof Echo === 'undefined') {
            console.error('Laravel Echo is not loaded!');
        } else {
            console.log('Laravel Echo is ready');
        }
    });
</script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const userId = {{ auth()->id() }};

    Echo.private(`App.Models.User.${userId}`)
        .notification((notification) => {
            console.log('🔔 Notification received:', notification);

            // مثال عرض
            alert(notification.message);

            // أو badge / toast لاحقًا
        });
});
</script>
</x-app-layout>