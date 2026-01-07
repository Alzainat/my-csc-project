<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        {{-- ===== Top Navigation ===== --}}
        <div class="bg-white shadow">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center h-16">
                {{-- Left: Navigation --}}
                @include('layouts.navigation')

                {{-- Right: Notifications --}}
                @auth
                <div class="relative ml-4">
                    <button id="notifBell" class="relative text-xl">
                        🔔
                        <span id="notifBadge" class="hidden absolute -top-2 -right-2 bg-red-600 text-white text-xs rounded-full px-1.5">
                            0
                        </span>
                    </button>
                    <div id="notifDropdown" class="hidden absolute right-0 mt-2 w-80 bg-white shadow-lg rounded-lg z-50">
                        <div class="p-3 font-semibold border-b">
                            Notifications
                        </div>
                        <div id="notifList" class="max-h-64 overflow-y-auto text-sm">
                            @forelse(auth()->user()->notifications as $notification)
                            <div class="p-3 border-b">
                                {{ $notification->data['message'] }}
                            </div>
                            @empty
                            <p class="p-3 text-gray-500">
                                No notifications
                            </p>
                            @endforelse
                        </div>
                    </div>
                </div>
                @endauth
            </div>
        </div>

        <!-- Page Heading -->
        @isset($header)
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
        @endisset

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>

    <!-- Footer -->
    <footer class="bg-blue-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Left Section -->
            <div>
                <div class="flex items-center mb-4">
    <img
        src="{{ asset('images/ezy-skills-logo.png') }}"
        alt="EZY Skills Logo"
        class="h-12 object-contain"
    >
</div>
                <p class="text-sm text-gray-300 mb-6">Let Us build your career together Be the first person to transform yourself with our unique & world class corporate level trainings.</p>
                <div>
                    <h3 class="font-bold mb-3">Subscribe Our Newsletter</h3>
                    <div class="flex">
                        <input type="email" placeholder="Your Email address" class="flex-1 px-4 py-2 rounded-l-md text-gray-800 text-sm focus:outline-none">
                        <button class="bg-orange-500 px-4 py-2 rounded-r-md hover:bg-orange-600 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Middle Section -->
            <div>
                <h3 class="font-bold text-lg mb-4">Quick <span class="text-orange-500">Links</span></h3>
                <ul class="space-y-2 text-sm text-gray-300">
                    <li><a href="#" class="hover:text-orange-500">Home</a></li>
                    <li><a href="#" class="hover:text-orange-500">Our Story</a></li>
                    <li><a href="#" class="hover:text-orange-500">Best Courses</a></li>
                    <li><a href="#" class="hover:text-orange-500">Your FAQ's</a></li>
                    <li><a href="#" class="hover:text-orange-500">Cancellation & Refunds</a></li>
                    <li><a href="#" class="hover:text-orange-500">Contact US</a></li>
                </ul>
            </div>

            <!-- Right Section -->
            <div>
                <h3 class="font-bold text-lg mb-4">Contact <span class="text-orange-500">Us</span></h3>
                <div class="space-y-3 text-sm text-gray-300">
                    <div class="flex items-start gap-2">
                        <svg class="w-5 h-5 mt-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                        </svg>
                        <p>Navakethan Complex, 6th Floor, 605, 606 A&P opp, CLock Tower, SD Road, Secunderabad, Telangana 500003</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                        </svg>
                        <p>info@ezyskills.in</p>
                    </div>
                    <div class="space-y-1">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                            </svg>
                            <p>+91 8428448903</p>
                        </div>
                        <div class="flex items-center gap-2 pl-7">
                            <p>+91 9475484959</p>
                        </div>
                    </div>
                </div>

                <!-- Social Icons -->
                <div class="flex gap-3 mt-6">
                    <a href="#" class="w-8 h-8 bg-blue-800 rounded flex items-center justify-center hover:bg-blue-700 transition">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z"/></svg>
                    </a>
                    <a href="#" class="w-8 h-8 bg-blue-800 rounded flex items-center justify-center hover:bg-blue-700 transition">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                    </a>
                    <a href="#" class="w-8 h-8 bg-blue-800 rounded flex items-center justify-center hover:bg-blue-700 transition">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                    </a>
                    <a href="#" class="w-8 h-8 bg-blue-800 rounded flex items-center justify-center hover:bg-blue-700 transition">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                    </a>
                    <a href="#" class="w-8 h-8 bg-blue-800 rounded flex items-center justify-center hover:bg-blue-700 transition">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg>
                    </a>
                </div>
            </div>
        </div>

        <!-- Bottom Footer -->
        <div class="max-w-7xl mx-auto px-6 mt-8 pt-6 border-t border-blue-800 flex flex-col md:flex-row justify-between items-center text-sm text-gray-400">
            <div class="flex gap-6 mb-4 md:mb-0">
                <a href="#" class="hover:text-white">Terms & Conditions</a>
                <a href="#" class="hover:text-white">Privacy Policy</a>
            </div>
        </div>
    </footer>

    
{{-- ===== Notifications JS ===== --}}
@auth
<script>
document.addEventListener('DOMContentLoaded', function () {

    const bell     = document.getElementById('notifBell');
    const dropdown = document.getElementById('notifDropdown');
    const list     = document.getElementById('notifList');
    const badge    = document.getElementById('notifBadge');

    if (!bell || !dropdown || !list || !badge) {
        console.warn('❌ Notification elements missing');
        return;
    }

    let count = badge.innerText ? parseInt(badge.innerText) : 0;

    // Toggle dropdown
    bell.addEventListener('click', function () {
        dropdown.classList.toggle('hidden');
        badge.classList.add('hidden');
        count = 0;
        badge.innerText = '0';
    });

    // انتظري Echo يكون جاهز فعليًا
    const waitForEcho = setInterval(function () {
        if (typeof window.Echo !== 'undefined') {

            clearInterval(waitForEcho);

            const userId = {{ auth()->id() }};

            console.log('✅ Echo ready, subscribing to channel:', userId);

            window.Echo.private(`App.Models.User.${userId}`)
                .notification(function (notification) {

                    console.log('🔔 Realtime Notification received:', notification);

                    count++;
                    badge.innerText = count;
                    badge.classList.remove('hidden');

                    const item = document.createElement('div');
                    item.className = 'p-3 border-b bg-indigo-50 text-sm';
                    item.innerText = notification.message ?? 'New notification';

                    list.prepend(item);
                });
        }
    }, 100);
});
</script>
@endauth
</body>
</html>