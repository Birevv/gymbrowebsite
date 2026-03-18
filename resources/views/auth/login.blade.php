<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login GymBro</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen flex flex-col items-center justify-center bg-[#17110e] font-sans antialiased text-white">

    <div class="w-full max-w-[380px] px-6">
        
        <!-- Logo md/lg sizes -> smaller sizes to match image -->
        <div class="flex justify-center items-center gap-3 mb-10">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 2L22 12L12 22L2 12L12 2Z" fill="#ed8b32"/>
                <path d="M4 12L12 4V12H4Z" fill="#17110e"/>
                <path d="M4.5 12L12 4.5V10H6.5L4.5 12Z" fill="#cc7121"/>
            </svg>
            <span class="text-2xl font-black tracking-wider text-[#ed8b32] uppercase padding-left-2">GYMBRO</span>
        </div>

        <!-- Heading -->
        <div class="text-center mb-10 w-full" style="display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center;">
            <h1 class="text-3xl font-bold text-white mb-2" style="text-align: center;">Welcome Back</h1>
            <p class="text-gray-400 text-sm" style="text-align: center;">Ready to crush your goals?</p>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Username -->
            <div class="mb-5">
                <label class="block text-xs font-semibold text-gray-300 mb-2 ml-1">
                    Username
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <!-- User icon -->
                        <svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <!-- Note: input name is "email" for laravel default, but style is for username -->
                    <input type="text" name="email" value="{{ old('email') }}"
                        placeholder="Enter your username" required autofocus
                        class="w-full pl-11 pr-4 py-3.5 bg-[#110c0a] border border-[#2a211c] rounded-[24px] text-white placeholder-gray-600 text-[13px] focus:outline-none focus:border-[#ed8b32] focus:ring-1 focus:ring-[#ed8b32] transition-colors shadow-inner">
                </div>
                @error('email')
                    <p class="text-red-500 text-xs mt-1 ml-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-8">
                <div class="flex justify-between items-center mb-2 px-1">
                    <label class="block text-xs font-semibold text-gray-300">
                        Password
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-[11px] font-semibold text-[#ed8b32] hover:text-[#d97706] transition-colors">
                            Forgot password?
                        </a>
                    @endif
                </div>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <!-- Lock icon -->
                        <svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <input type="password" name="password"
                        placeholder="Enter your password" required
                        class="w-full pl-11 pr-4 py-3.5 bg-[#110c0a] border border-[#2a211c] rounded-[24px] text-white placeholder-gray-600 text-[13px] focus:outline-none focus:border-[#ed8b32] focus:ring-1 focus:ring-[#ed8b32] transition-colors shadow-inner">
                </div>
                @error('password')
                    <p class="text-red-500 text-xs mt-1 ml-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Button -->
            <button type="submit"
                class="w-full py-3.5 bg-[#eb8c34] text-white font-bold text-[15px] rounded-full transition-all hover:bg-[#d97706] shadow-[0_0px_25px_rgba(235,140,52,0.4)] hover:shadow-[0_0px_35px_rgba(235,140,52,0.5)]">
                Login
            </button>

        </form>

        <!-- Footer -->
        <p class="text-center mt-12 text-xs font-medium text-gray-400">
            New to the grind? 
            <a href="{{ route('register') }}" class="text-[#ed8b32] font-semibold hover:text-[#d97706] transition-colors ml-1">
                Start your journey
            </a>
        </p>

    </div>

</body>

</html>