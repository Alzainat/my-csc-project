<!-- Navbar -->
<nav class="w-full bg-white border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">

        {{-- Logo --}}
<div class="flex items-center">
    <img
        src="{{ asset('images/ezy-skills-logo.png') }}"
        alt="EZY Skills Logo"
        class="h-14 object-contain"
    >
</div>

        {{-- Links --}}
        <div class="hidden md:flex items-center gap-8 text-sm font-medium">

            {{-- Student Links --}}
            @auth
                @if(auth()->user()->role === 'student')
                    <a href="{{ route('student.courses.index') }}"
                       class="text-gray-600 hover:text-orange-500 transition">
                        Courses
                    </a>

                    <a href="{{ route('student.my-courses') }}"
                       class="text-gray-600 hover:text-orange-500 transition">
                        My Courses
                    </a>
                @endif
            @endauth

            {{-- Teacher Link --}}
            @auth
                @if(auth()->user()->role === 'teacher')
                    <a href="{{ route('teacher.dashboard') }}"
                       class="text-gray-600 hover:text-orange-500 transition">
                        Teacher Dashboard
                    </a>
                @endif
            @endauth

        </div>

        {{-- Auth Actions --}}
        <div class="flex items-center gap-3">

            {{-- Guest --}}
            @guest
                <a href="{{ route('login') }}"
                   class="px-6 py-2 border border-orange-500 text-orange-500 rounded-md text-sm hover:bg-orange-50 transition">
                    Log In
                </a>

                <a href="{{ route('register') }}"
                   class="px-6 py-2 bg-orange-500 text-white rounded-md text-sm hover:bg-orange-600 transition">
                    Create Account
                </a>
            @endguest

            {{-- Authenticated --}}
            @auth
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="px-6 py-2 bg-red-500 text-white rounded-md text-sm hover:bg-red-600 transition">
                        Logout
                    </button>
                </form>
            @endauth

        </div>

    </div>
</nav>