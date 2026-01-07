<x-app-layout>

    {{-- ✅ HEADER --}}
    <x-slot name="header">
    <div class="flex justify-center">
        <h2 class="text-5xl font-bold text-[#004d8c]">
            My Courses
        </h2>
    </div>
</x-slot>

    {{-- ================= CONTENT ================= --}}
    <div class="bg-[#f8f9fa] py-10 px-6">

        <div class="max-w-6xl mx-auto space-y-6">

            @forelse($courses as $course)

                <div
                    class="bg-white rounded-2xl shadow-md p-6 flex flex-col md:flex-row
                           md:items-center md:justify-between gap-4">

                    {{-- Course Info --}}
                    <div>
                        <p class="text-xl font-bold text-[#1a1a1a]">
                            {{ $course->title }}
                        </p>

                        <p class="mt-1 text-sm font-semibold
                            {{ $course->pivot->status === 'approved'
                                ? 'text-green-600'
                                : 'text-[#ff8c61]' }}">
                            Status:
                            {{ ucfirst($course->pivot->status) }}
                        </p>
                    </div>

                    {{-- Actions --}}
                    <div>
                        @if($course->pivot->status === 'approved')
                            <button
                                onclick="openChatModal({{ $course->id }})"
                                class="px-6 py-2 rounded-full
                                       bg-[#004d8c] text-white
                                       font-bold text-sm
                                       hover:bg-[#003b6f] transition">
                                💬 Open Chat
                            </button>
                        @else
                            <span
                                class="px-6 py-2 rounded-full
                                       bg-gray-100 text-gray-400
                                       font-semibold text-sm">
                                🔒 Chat Locked
                            </span>
                        @endif
                    </div>
                </div>

            @empty
                <div class="bg-white rounded-xl shadow p-10 text-center text-gray-400">
                    No courses enrolled yet.
                </div>
            @endforelse

        </div>
    </div>
    {{-- ===== Chat Modal ===== --}}
<div id="chatModal"
     class="fixed inset-0 bg-black bg-opacity-40 hidden items-center justify-center z-50">

    <div class="bg-white w-full max-w-xl rounded-lg shadow-lg flex flex-col h-[500px]">

        <div class="p-4 border-b flex justify-between items-center">
            <h3 class="font-semibold" color="black">Course Chat</h3>
            <button onclick="closeChatModal()">✖</button>
        </div>

        <div id="chatMessages"
             class="flex-1 overflow-y-auto p-4 space-y-2 text-sm bg-gray-50">
        </div>

        <form onsubmit="sendChatMessage(event)"
              class="p-3 border-t flex gap-2">
            <input id="chatInput"
       class="flex-1 border rounded px-3 py-2 text-black placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500"
       placeholder="Type a message...">
            <button class="px-4 py-2 bg-indigo-600 text-black rounded">
                Send
            </button>
        </form>
    </div>
</div>

<script>
let currentCourseId = null;
const AUTH_USER_ID = {{ auth()->id() }};
let chatChannel = null;

function openChatModal(courseId) {

    
    if (chatChannel && currentCourseId) {
        window.Echo.leave(`course.${currentCourseId}`);
        chatChannel = null;
    }

    
    currentCourseId = courseId;

    document.getElementById('chatModal').classList.remove('hidden');
    document.getElementById('chatModal').classList.add('flex');

    loadChatMessages();

    // ✅ اشتراك realtime
    chatChannel = window.Echo.private(`course.${courseId}`)
        .listen('.course.message', e => {
            if (e.message.user_id !== AUTH_USER_ID) {
                appendStudentMessage(e.message);
            }
        });
}

function appendStudentMessage(msg) {
    const box = document.getElementById('chatMessages');

    box.innerHTML += `
        <div>
            <p class="text-xs text-gray-500">${msg.user.name}</p>
            <span class="inline-block px-3 py-1 rounded bg-white border">
                ${msg.message}
            </span>
        </div>
    `;

    box.scrollTop = box.scrollHeight;
}

function closeChatModal() {
    document.getElementById('chatModal').classList.add('hidden');
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
                    <div class="${isMe ? 'text-right' : ''}">
                        <p class="text-xs text-gray-500">${msg.user.name}</p>
                        <span class="inline-block px-3 py-1 rounded
                            ${isMe ? 'bg-indigo-600 text-white' : 'bg-white border'}">
                            ${msg.message}
                        </span>
                    </div>
                `;
            });

            box.scrollTop = box.scrollHeight;
        });
}

function sendChatMessage(e) {
    e.preventDefault();

    const input = document.getElementById('chatInput');
    const message = input.value.trim();
    if (!message) return;

    appendMyMessage({
    message: message
});

    fetch(`/courses/${currentCourseId}/chat`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ message })
    }).then(() => {
        input.value = '';
    });
}
function appendMyMessage(msg) {
    const box = document.getElementById('chatMessages');

    box.innerHTML += `
        <div class="text-right">
            <p class="text-xs text-gray-500">You</p>
            <span class="inline-block px-3 py-1 rounded bg-indigo-600 text-white">
                ${msg.message}
            </span>
        </div>
    `;

    box.scrollTop = box.scrollHeight;
}
</script>

</x-app-layout>