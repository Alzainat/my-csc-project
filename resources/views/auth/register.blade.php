<x-guest-layout>
    <h2 class="text-3xl font-bold mb-6">
        <span class="text-blue-900">Create</span> 
        <span class="text-orange-500">Account</span>
    </h2>
    
    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf
        
        <!-- Name -->
        <div>
            <x-text-input
                id="name"
                class="w-full px-0 py-2 border-0 border-b-2 border-gray-200 focus:border-orange-500 focus:ring-0 rounded-none bg-transparent placeholder-gray-400 text-gray-700"
                type="text"
                name="name"
                placeholder="Full Name"
                :value="old('name')"
                required
                autofocus />
            <x-input-error :messages="$errors->get('name')" class="mt-1" />
        </div>
        
        <!-- Email -->
        <div>
            <x-text-input
                id="email"
                class="w-full px-0 py-2 border-0 border-b-2 border-gray-200 focus:border-orange-500 focus:ring-0 rounded-none bg-transparent placeholder-gray-400 text-gray-700"
                type="email"
                name="email"
                placeholder="Email Address"
                :value="old('email')"
                required />
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>
        
        <!-- Password -->
        <div>
            <x-text-input
                id="password"
                class="w-full px-0 py-2 border-0 border-b-2 border-gray-200 focus:border-orange-500 focus:ring-0 rounded-none bg-transparent placeholder-gray-400 text-gray-700"
                type="password"
                name="password"
                placeholder="Password"
                required />
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>
        
        <!-- Confirm Password -->
        <div>
            <x-text-input
                id="password_confirmation"
                class="w-full px-0 py-2 border-0 border-b-2 border-gray-200 focus:border-orange-500 focus:ring-0 rounded-none bg-transparent placeholder-gray-400 text-gray-700"
                type="password"
                name="password_confirmation"
                placeholder="Password"
                required />
        </div>
        
        <!-- Remember Me -->
        <div class="flex items-center">
            <input
                id="remember_me"
                type="checkbox"
                name="remember"
                class="w-4 h-4 text-blue-900 border-gray-300 rounded focus:ring-blue-900 focus:ring-2">
            <label for="remember_me" class="ml-2 text-sm text-gray-600">
                Remember Me
            </label>
        </div>
        
        <!-- Submit Button -->
        <div class="pt-2">
            <button
                type="submit"
                class="w-full py-3 bg-blue-900 text-white font-semibold rounded-md hover:bg-blue-800 transition duration-200">
                Create Account
            </button>
        </div>
        
        <!-- Login Link -->
        <p class="text-center text-sm text-gray-600">
            Already Created?
            <a href="{{ route('login') }}" class="text-blue-900 font-semibold hover:underline">
                Login Here
            </a>
        </p>
        
        <!-- Divider -->
        <div class="relative py-2">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-200"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-2 bg-white text-gray-500">or</span>
            </div>
        </div>
        
        <!-- Social Login Buttons -->
        <div class="flex gap-3">
            <button
                type="button"
                class="flex-1 flex items-center justify-center gap-2 py-2.5 border border-gray-300 rounded-md hover:bg-gray-50 transition">
                <svg class="w-5 h-5" viewBox="0 0 24 24">
                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                </svg>
                <span class="text-sm font-medium text-gray-700">Sign In</span>
            </button>
            
            <button
                type="button"
                class="flex-1 flex items-center justify-center gap-2 py-2.5 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z"/>
                </svg>
                <span class="text-sm font-medium">Sign In</span>
            </button>
            
            <button
                type="button"
                class="flex-1 flex items-center justify-center gap-2 py-2.5 bg-gray-900 text-white rounded-md hover:bg-gray-800 transition">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17.05 20.28c-.98.95-2.05.8-3.08.35-1.09-.46-2.09-.48-3.24 0-1.44.62-2.2.44-3.06-.35C2.79 15.25 3.51 7.59 9.05 7.31c1.35.07 2.29.74 3.08.8 1.18-.24 2.31-.93 3.57-.84 1.51.12 2.65.72 3.4 1.8-3.12 1.87-2.38 5.98.48 7.13-.57 1.5-1.31 2.99-2.54 4.09l.01-.01zM12.03 7.25c-.15-2.23 1.66-4.07 3.74-4.25.29 2.58-2.34 4.5-3.74 4.25z"/>
                </svg>
                <span class="text-sm font-medium">Sign In</span>
            </button>
        </div>
        
        <!-- Terms -->
        <p class="text-xs text-center text-gray-500 pt-2">
            By continuing, you agree to the 
            <a href="#" class="text-blue-900 hover:underline">Terms of Service</a> 
            and 
            <a href="#" class="text-blue-900 hover:underline">Privacy Policy</a>
        </p>
    </form>
</x-guest-layout>