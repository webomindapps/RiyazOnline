<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <title>Riyaz Online | Admin Login</title>
</head>
<div class="relative flex min-h-screen items-center justify-center bg-gradient-to-br from-blue-200 to-purple-400">
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <div class="w-full max-w-96 rounded-lg bg-slate-900 p-10 text-sm text-indigo-300 sm:w-96 mt-18">
        <h1 class="mb-4 text-center text-3xl font-semibold text-white">Admin Login</h1>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-5 flex gap-3 rounded-full bg-[#333A5c] px-6 py-3">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4">
                    <path
                        d="M3 8L8.44992 11.6333C9.73295 12.4886 10.3745 12.9163 11.0678 13.0825C11.6806 13.2293 12.3194 13.2293 12.9322 13.0825C13.6255 12.9163 14.2671 12.4886 15.5501 11.6333L21 8M6.2 19H17.8C18.9201 19 19.4802 19 19.908 18.782C20.2843 18.5903 20.5903 18.2843 20.782 17.908C21 17.4802 21 16.9201 21 15.8V8.2C21 7.0799 21 6.51984 20.782 6.09202C20.5903 5.71569 20.2843 5.40973 19.908 5.21799C19.4802 5 18.9201 5 17.8 5H6.2C5.0799 5 4.51984 5 4.09202 5.21799C3.71569 5.40973 3.40973 5.71569 3.21799 6.09202C3 6.51984 3 7.07989 3 8.2V15.8C3 16.9201 3 17.4802 3.21799 17.908C3.40973 18.2843 3.71569 18.5903 4.09202 18.782C4.51984 19 5.07989 19 6.2 19Z"
                        stroke="#64748b" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
                <input type="text" placeholder="Email" name="email" value="{{ old('email') }}"
                    class="border-none outline-none" required />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
            <div class="mb-5 flex gap-3 rounded-full bg-[#333A5c] px-6 py-3">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4">
                    <path
                        d="M16.24 7.76C16.24 8.64 15.64 9.24 14.76 9.24C13.88 9.24 13.28 8.64 13.28 7.76C13.28 6.88 13.88 6.28 14.76 6.28C15.64 6.28 16.24 6.88 16.24 7.76ZM20.48 12C20.48 15.36 17.84 18 14.48 18H4V6H14.48C17.84 6 20.48 8.64 20.48 12ZM2.08 12C2.08 8.64 4.72 6 8.08 6H10V18H8.08C4.72 18 2.08 15.36 2.08 12Z"
                        stroke="#64748b" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
                <input type="password" placeholder="Password" name="password" class="border-none outline-none"
                    required />
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
            <!-- Remember Me -->
            <div class="block mb-4 ml-2">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox"
                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                    <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>
            <button
                class="w-full cursor-pointer rounded-full bg-gradient-to-r from-indigo-400 to-indigo-900 py-3 font-medium tracking-wide text-white">Login</button>
        </form>
    </div>
</div>
