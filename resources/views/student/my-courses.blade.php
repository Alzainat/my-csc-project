<x-app-layout>

    {{-- ✅ HEADER لازم يكون أول شيء --}}
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            My Courses
        </h2>
    </x-slot>

    

    {{-- ✅ العرض الحقيقي --}}
    <div class="p-6">
        @forelse($courses as $course)
            <div class="border p-4 mb-4 rounded flex justify-between items-center">
            <div>
                <p class="font-semibold">{{ $course->title }}</p>
                <p class="text-sm text-gray-600">
                    Status: {{ ucfirst($course->pivot->status) }}
                </p>
            </div>

            {{-- ✅ الشات فقط إذا approved --}}
            @if($course->pivot->status === 'approved')
                <button
                    onclick="openChatModal({{ $course->id }})"
                    class="px-4 py-2 bg-indigo-600 text-white rounded text-sm">
                    💬 Open Chat
                </button>
            @else
                <span class="text-sm text-gray-400">
                    Chat locked
                </span>
            @endif
        </div>
        @empty
            <p>No courses</p>
        @endforelse
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

function openChatModal(courseId) {
    currentCourseId = courseId;

    document.getElementById('chatModal').classList.remove('hidden');
    document.getElementById('chatModal').classList.add('flex');

    loadChatMessages();
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

    fetch(`/courses/${currentCourseId}/chat`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ message })
    }).then(() => {
        input.value = '';
        loadChatMessages();
    });
}
</script>

</x-app-layout>