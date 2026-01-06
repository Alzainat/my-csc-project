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
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8
                    flex justify-between items-center h-16">

            {{-- Left: Navigation --}}
            @include('layouts.navigation')

            {{-- Right: Notifications --}}
            @auth
            <div class="relative ml-4">
                <button id="notifBell" class="relative text-xl">
                    🔔
                    <span id="notifBadge"
                          class="hidden absolute -top-2 -right-2 bg-red-600
                                 text-white text-xs rounded-full px-1.5">
                        0
                    </span>
                </button>

                <div id="notifDropdown"
                     class="hidden absolute right-0 mt-2 w-80
                            bg-white shadow-lg rounded-lg z-50">

                    <div class="p-3 font-semibold border-b">
                        Notifications
                    </div>

                    <div id="notifList"
                         class="max-h-64 overflow-y-auto text-sm">
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

    {{-- ===== Page Header ===== --}}
    @isset($header)
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
    @endisset

    {{-- ===== Page Content ===== --}}
    <main>
        {{ $slot }}
    </main>

</div>

{{-- ===== Notifications JS ===== --}}
@auth
<script>
document.addEventListener('DOMContentLoaded', () => {
    const bell = document.getElementById('notifBell');
    const dropdown = document.getElementById('notifDropdown');
    const list = document.getElementById('notifList');
    const badge = document.getElementById('notifBadge');
    let count = 0;

    bell.addEventListener('click', () => {
        dropdown.classList.toggle('hidden');
        badge.classList.add('hidden');
        count = 0;
    });

    const userId = {{ auth()->id() }};

    Echo.private(`App.Models.User.${userId}`)
        .notification((notification) => {
            count++;
            badge.innerText = count;
            badge.classList.remove('hidden');

            const item = document.createElement('div');
            item.className = 'p-3 border-b bg-indigo-50';
            item.innerText = notification.message;

            list.prepend(item);
        });
});
</script>
@endauth

</body>
</html>