
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tenants</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-slate-100 text-slate-800">

    <!-- Top Navbar -->
    <header class="bg-slate-900 text-white shadow">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">

            <div>
                <h1 class="text-xl font-bold">Super Admin Panel</h1>
                <p class="text-sm text-slate-400">Tenant Management</p>
            </div>

            <form method="POST" action="/logout">
                @csrf

                <button
                    type="submit"
                    class="rounded-lg bg-red-500 px-4 py-2 text-sm font-semibold text-white transition hover:bg-red-600"
                >
                    Logout
                </button>
            </form>

        </div>
    </header>


    <main class="max-w-7xl mx-auto px-6 py-8">

        <!-- Page Heading -->
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-slate-900">
                Tenants
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Manage all companies and create new tenant databases.
            </p>
        </div>


        <!-- Success Message -->
        @if (session('ok'))
            <div
                class="mb-6 rounded-xl border border-green-200 bg-green-50 px-5 py-4 text-green-700"
            >
                <div class="font-semibold">
                    Success
                </div>

                <div class="text-sm">
                    {{ session('ok') }}
                </div>
            </div>
        @endif


        <!-- Error Message -->
        @if ($errors->any())
            <div
                class="mb-6 rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-red-700"
            >
                <div class="font-semibold">
                    Something went wrong
                </div>

                <div class="text-sm">
                    {{ $errors->first() }}
                </div>
            </div>
        @endif


        <!-- Stats / Summary -->
        <div class="mb-8 grid gap-4 md:grid-cols-3">

            <div class="rounded-2xl bg-white p-5 shadow-sm border border-slate-200">
                <p class="text-sm font-medium text-slate-500">
                    Total Tenants
                </p>

                <p class="mt-2 text-3xl font-bold text-slate-900">
                    {{ $tenants->count() }}
                </p>
            </div>


            <div class="rounded-2xl bg-white p-5 shadow-sm border border-slate-200">
                <p class="text-sm font-medium text-slate-500">
                    Active Companies
                </p>

                <p class="mt-2 text-3xl font-bold text-slate-900">
                    {{ $tenants->count() }}
                </p>
            </div>


            <div class="rounded-2xl bg-white p-5 shadow-sm border border-slate-200">
                <p class="text-sm font-medium text-slate-500">
                    Environment
                </p>

                <p class="mt-2 text-lg font-bold text-indigo-600">
                    Multi-Tenant CRM
                </p>
            </div>

        </div>


        <div class="grid gap-8 xl:grid-cols-3">

            <!-- Tenant List -->
            <div class="xl:col-span-2">

                <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

                    <div class="flex items-center justify-between border-b border-slate-200 px-6 py-5">

                        <div>
                            <h3 class="text-lg font-bold text-slate-900">
                                Tenant List
                            </h3>

                            <p class="text-sm text-slate-500">
                                Registered companies in your SaaS platform.
                            </p>
                        </div>

                    </div>


                    <div class="overflow-x-auto">

                        <table class="w-full text-left">

                            <thead class="bg-slate-50 text-xs uppercase text-slate-500">
                                <tr>

                                    <th class="px-6 py-4 font-semibold">
                                        ID
                                    </th>

                                    <th class="px-6 py-4 font-semibold">
                                        Company
                                    </th>

                                    <th class="px-6 py-4 font-semibold">
                                        Domain
                                    </th>

                                    <th class="px-6 py-4 font-semibold">
                                        Database
                                    </th>

                                </tr>
                            </thead>


                            <tbody class="divide-y divide-slate-100">

                                @forelse ($tenants as $t)

                                    <tr class="transition hover:bg-slate-50">

                                        <td class="px-6 py-4">
                                            <span
                                                class="inline-flex h-8 min-w-8 items-center justify-center rounded-lg bg-slate-100 px-2 text-sm font-semibold text-slate-600"
                                            >
                                                {{ $t->id }}
                                            </span>
                                        </td>


                                        <td class="px-6 py-4">

                                            <div class="font-semibold text-slate-900">
                                                {{ $t->name }}
                                            </div>

                                            <div class="mt-1 text-xs text-slate-400">
                                                Tenant #{{ $t->id }}
                                            </div>

                                        </td>


                                        <td class="px-6 py-4">

                                            <a
                                                href="http://{{ $t->domain }}:8000/login"
                                                target="_blank"
                                                class="inline-flex items-center gap-2 font-medium text-indigo-600 hover:text-indigo-800 hover:underline"
                                            >
                                                {{ $t->domain }}

                                                <svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    class="h-4 w-4"
                                                    fill="none"
                                                    viewBox="0 0 24 24"
                                                    stroke="currentColor"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M14 3h7v7m0-7L10 14"
                                                    />
                                                </svg>
                                            </a>

                                        </td>


                                        <td class="px-6 py-4">

                                            <span
                                                class="rounded-lg bg-emerald-50 px-3 py-1.5 font-mono text-xs font-medium text-emerald-700"
                                            >
                                                {{ $t->db_name }}
                                            </span>

                                        </td>

                                    </tr>

                                @empty

                                    <tr>
                                        <td
                                            colspan="4"
                                            class="px-6 py-12 text-center"
                                        >

                                            <div class="text-lg font-semibold text-slate-700">
                                                No tenants found
                                            </div>

                                            <div class="mt-1 text-sm text-slate-400">
                                                Create your first tenant using the form.
                                            </div>

                                        </td>
                                    </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>


            <!-- Create Tenant Form -->
            <div>

                <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">

                    <div class="border-b border-slate-200 px-6 py-5">

                        <h3 class="text-lg font-bold text-slate-900">
                            Create New Tenant
                        </h3>

                        <p class="mt-1 text-sm text-slate-500">
                            Create company, domain and tenant admin.
                        </p>

                    </div>


                    <form
                        method="POST"
                        action="/tenants"
                        class="space-y-5 p-6"
                    >

                        @csrf


                        <!-- Company Name -->
                        <div>

                            <label
                                for="name"
                                class="mb-2 block text-sm font-semibold text-slate-700"
                            >
                                Company Name
                            </label>

                            <input
                                type="text"
                                id="name"
                                name="name"
                                value="{{ old('name') }}"
                                placeholder="Example: Initech"
                                required
                                class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition placeholder:text-slate-400 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100"
                            >

                        </div>


                        <!-- Subdomain -->
                        <div>

                            <label
                                for="subdomain"
                                class="mb-2 block text-sm font-semibold text-slate-700"
                            >
                                Subdomain
                            </label>

                            <div class="flex">

                                <input
                                    type="text"
                                    id="subdomain"
                                    name="subdomain"
                                    value="{{ old('subdomain') }}"
                                    placeholder="initech"
                                    required
                                    class="min-w-0 flex-1 rounded-l-xl border border-r-0 border-slate-300 px-4 py-3 text-sm outline-none transition placeholder:text-slate-400 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100"
                                >

                                <span
                                    class="flex items-center rounded-r-xl border border-slate-300 bg-slate-50 px-3 text-sm text-slate-500"
                                >
                                    .localhost
                                </span>

                            </div>

                        </div>


                        <!-- Admin Email -->
                        <div>

                            <label
                                for="admin_email"
                                class="mb-2 block text-sm font-semibold text-slate-700"
                            >
                                Admin Email
                            </label>

                            <input
                                type="email"
                                id="admin_email"
                                name="admin_email"
                                value="{{ old('admin_email') }}"
                                placeholder="admin@company.com"
                                required
                                class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition placeholder:text-slate-400 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100"
                            >

                        </div>


                        <!-- Admin Password -->
                        <div>

                            <label
                                for="admin_password"
                                class="mb-2 block text-sm font-semibold text-slate-700"
                            >
                                Admin Password
                            </label>

                            <input
                                type="password"
                                id="admin_password"
                                name="admin_password"
                                placeholder="Minimum 8 characters"
                                required
                                class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition placeholder:text-slate-400 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100"
                            >

                            <p class="mt-2 text-xs text-slate-400">
                                Password should contain at least 8 characters.
                            </p>

                        </div>


                        <!-- Submit Button -->
                        <button
                            type="submit"
                            class="w-full rounded-xl bg-indigo-600 px-5 py-3 font-semibold text-white shadow-sm transition hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-indigo-200"
                        >
                            Create Tenant
                        </button>

                    </form>

                </div>


                <!-- Information Card -->
                <div class="mt-6 rounded-2xl border border-blue-200 bg-blue-50 p-5">

                    <h4 class="font-semibold text-blue-900">
                        Tenant Provisioning
                    </h4>

                    <p class="mt-2 text-sm leading-6 text-blue-700">
                        Creating a tenant will provision the company information,
                        tenant domain, database configuration and administrator account.
                    </p>

                </div>

            </div>

        </div>

    </main>

</body>
</html>