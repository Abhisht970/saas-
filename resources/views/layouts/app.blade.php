<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        @yield('title', 'CRM')
    </title>
   <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}

    @yield('head')
</head>

<body class="bg-gray-100 text-gray-900">

    {{-- Navbar --}}
    <nav class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="h-16 flex items-center justify-between">

                {{-- Logo --}}
                <a href="{{ url('/dashboard') }}"
                   class="text-xl font-bold text-blue-600">
                    CRM
                </a>

                {{-- Navigation --}}
                <div class="flex items-center gap-6">

                    <a href="{{ url('/dashboard') }}"
                       class="text-sm font-medium text-gray-600 hover:text-blue-600">
                        Dashboard
                    </a>

                    <a href="{{ route('leads.index') }}"
                       class="text-sm font-medium text-gray-600 hover:text-blue-600">
                        Leads
                    </a>

                    <span class="text-sm text-gray-600">
                        {{ auth()->user()->name }}
                    </span>

                    <form method="POST" action="/logout">
                        @csrf

                        <button type="submit"
                                class="text-sm font-medium text-red-600 hover:text-red-800">
                            Logout
                        </button>
                    </form>

                </div>

            </div>

        </div>
    </nav>


    {{-- Page Content --}}
    <main>
        @yield('content')
    </main>


    @yield('scripts')

</body>

</html>
