
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

                    {{-- Dashboard --}}
                    <a href="{{ url('/dashboard') }}"
                       class="text-sm font-medium text-gray-600 hover:text-blue-600">
                        Dashboard
                    </a>


                    {{-- Leads Dropdown --}}
                    <div class="relative group">

                        <button
                            type="button"
                            class="flex items-center gap-1 text-sm font-medium text-gray-600 hover:text-blue-600"
                        >
                            Leads

                            <svg
                                class="w-4 h-4"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M19 9l-7 7-7-7"
                                />
                            </svg>
                        </button>


                        {{-- Leads Dropdown Menu --}}
                        <div
                            class="absolute left-0 top-full z-50 hidden w-48 pt-2 group-hover:block"
                        >

                            <div
                                class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-lg"
                            >

                                <a
                                    href="{{ route('leads.index') }}"
                                    class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 hover:text-blue-600"
                                >
                                    Leads
                                </a>


                                <a
                                    href="{{ route('leads.form') }}"
                                    class="block border-t border-gray-100 px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 hover:text-blue-600"
                                >
                                    Lead Fields
                                </a>

                            </div>

                        </div>

                    </div>


                    {{-- Accounts Dropdown --}}
                    <div class="relative group">

                        <button
                            type="button"
                            class="flex items-center gap-1 text-sm font-medium text-gray-600 hover:text-blue-600"
                        >
                            Accounts

                            <svg
                                class="w-4 h-4"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M19 9l-7 7-7-7"
                                />
                            </svg>
                        </button>


                        {{-- Accounts Dropdown Menu --}}
                        <div
                            class="absolute left-0 top-full z-50 hidden w-48 pt-2 group-hover:block"
                        >

                            <div
                                class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-lg"
                            >

                                <a
                                    href="{{ route('accounts.index') }}"
                                    class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 hover:text-blue-600"
                                >
                                    Accounts
                                </a>


                                <a
                                    href="{{ route('account-fields.index') }}"
                                    class="block border-t border-gray-100 px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 hover:text-blue-600"
                                >
                                    Account Fields
                                </a>

                            </div>

                        </div>

                    </div>





<li class="relative group">
    <button
        type="button"
        class="flex w-full items-center justify-between rounded-lg px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100"
    >
        <span>Pages</span>

        <svg
            class="h-4 w-4 transition-transform group-hover:rotate-180"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M19 9l-7 7-7-7"
            />
        </svg>
    </button>

    <div
        class="absolute left-0 z-50 mt-1 hidden w-56 rounded-lg border border-gray-200 bg-white py-2 shadow-lg group-hover:block"
    >
        <a
            href="{{ route('dynamic-objects.create') }}"
            class="block px-4 py-2 text-sm font-semibold text-blue-600 hover:bg-gray-50"
        >
            + Create Page
        </a>

        <div class="my-1 border-t border-gray-200"></div>

        @forelse($dynamicObjects as $object)

            <a
                href="{{ route('dynamic-records.index', $object->key) }}"
                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
            >
                {{ $object->plural_label ?? $object->name }}
            </a>

        @empty

            <div class="px-4 py-2 text-sm text-gray-400">
                No pages created
            </div>

        @endforelse
    </div>
</li>




                    {{-- Logged In User --}}
                    <span class="text-sm text-gray-600">
                        {{ auth()->user()->name }}
                    </span>


                    {{-- Logout --}}
                    <form method="POST" action="/logout">
                        @csrf

                        <button
                            type="submit"
                            class="text-sm font-medium text-red-600 hover:text-red-800"
                        >
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